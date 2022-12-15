<?php

    include '_includes/db_open.php';
    include '_includes/webhook_secret_key.php';
    include '_includes/webhook_db_queries.php';
    include '_includes/Users.php';
    include '_includes/Address.php';
    include '_includes/Email.php';
    include '_includes/Phone.php';    

    if ($_SERVER['REQUEST_METHOD'] === 'GET'){
        
        echo"This is Shopify Webhook Data Post Endpoint ";
        echo"\n".$connection_flag;

        error_log("\n".date("Y-m-d h:i:s",time())." Get Request Handling",3,'_includes/error.log');
        http_response_code(200);
        $conn->close();
        $connection_flag=false;
        
    }elseif($_SERVER['REQUEST_METHOD'] === 'POST'){
        
        
        $hmac_header = $_SERVER['HTTP_X_SHOPIFY_HMAC_SHA256'];

        
        
        $webhook_data = file_get_contents("php://input");
        $calculated_hmac = base64_encode(hash_hmac('sha256',$webhook_data, $webhook_secret, true));
        $verified = hash_equals($hmac_header,$calculated_hmac);

        error_log("\n".date("Y-m-d h:i:s",time())." Post Request Handling",3,'_includes/error.log');

        error_log("\n".date("Y-m-d h:i:s ",time())."Request Header: ".$hmac_header,3,'_includes/error.log');
        error_log("\n".date("Y-m-d h:i:s ",time())."Payload Data: ".$webhook_data,3,'_includes/error.log');
        error_log("\n".date("Y-m-d h:i:s ",time())."Computed HMAC: ".$calculated_hmac,3,'_includes/error.log');
        

        if ($verified){
            
            error_log("\n".date("Y-m-d h:i:s",time()).' Webhook verified',3,'_includes/error.log');
            
            $webhook_data = json_decode($webhook_data,1);

            $customer_email = $webhook_data["email"];
            $line_items = $webhook_data["line_items"];

            $skus = [];
            $skuList = [];

            foreach($line_items as $line_item){
                array_push($skus,$line_item["sku"]);
            }
            
            error_log("\n".date("Y-m-d h:i:s",time()).' customer email: '.$customer_email,3,'_includes/error.log');
            error_log("\n".date("Y-m-d h:i:s",time()).' SKUs: '.implode(",",$skus),3,'_includes/error.log');

            $user_id = "";
            $result_user_id = $conn->query(getUserIdByEmailQuery($customer_email));
            if ($result_user_id->num_rows>0){
                // $row = $result_user_id -> fetch_assoc();
                error_log("\n".date("Y-m-d h:i:s",time()).' User Email verified. DB Update for order to start',3,'_includes/error.log');
                while ($row = $result_user_id -> fetch_assoc()){
                    $user_id = $row["usersID"];
                    error_log("\n".date("Y-m-d h:i:s",time())." Fetched User ID: ".$user_id,3,'_includes/error.log');
                    
                }
            }
            else{
                error_log("\n".date("Y-m-d h:i:s",time()).' Failed to verify User Email. New user needs to be created before DB Update for order.',3,'_includes/error.log');
                
                $first_name = $webhook_data["billing_address"]["first_name"];
                $last_name = $webhook_data["billing_address"]["last_name"];
                $company = $webhook_data["billing_address"]["company"];
                
                $user = new Users();
                $user->set_first_name($first_name);
                $user->set_last_name($last_name);
                $user->set_company($company);

                if ($conn->query(insertShopifyUserDetails($user)) === TRUE){
                    error_log("\n".date("Y-m-d h:i:s",time()).' Entry into Users Table Successful. Address and COntact details pending to be added.',3,'_includes/error.log');
                    $latest_insert_id = $conn->query(getMaxUserID());
                    if ($latest_insert_id->num_rows>0){
                        while ($row = $latest_insert_id -> fetch_assoc()){
                            $user_id = $row["user_id"];
                        }
                        
                    }
                    
                    // Insert Address Details.

                    $address_1 = $webhook_data["billing_address"]["address1"];
                    $address_2 = $webhook_data["billing_address"]["address2"];
                    // $address_2 = $address_2==null?"":$address_2;

                    $city = $webhook_data["billing_address"]["city"];
                    $state = $webhook_data["billing_address"]["province"];
                    $country = $webhook_data["billing_address"]["country"];
                    $zip = $webhook_data["billing_address"]["zip"];

                    $is_international = $country === "United States"? 0:1;

                    $address = new Address();
                    $address->setUser_id($user_id);
                    $address->setAddress_1($address_1);
                    $address->setAddress_2($address_2);
                    $address->setCity($city);
                    $address->setState($state);
                    $address->setZip($zip);
                    $address->setCountry($country);
                    $address->setIs_international($is_international);
                    $address->setIs_default(1);

                    if ($conn->query(insertShopifyUserAddress($address)) === TRUE){
                        error_log("\n".date("Y-m-d h:i:s",time()).' Entry into Users Address Table Successful. Contact details pending to be added.',3,'_includes/error.log');
                    }else{
                        error_log("\n".date("Y-m-d h:i:s",time()).' Failed to add details into User Address Table',3,'_includes/error.log');
                    }

                    // Insert Email Details.
                    $email = new Email();
                    $email->setUsersID($user_id);
                    $email->setEmailAddress($customer_email);

                    if ($conn->query(insertShopifyUserEmail($email)) === TRUE){
                        error_log("\n".date("Y-m-d h:i:s",time()).' Entry into Users Email Table Successful. Phone details pending to be added.',3,'_includes/error.log');
                    }else{
                        error_log("\n".date("Y-m-d h:i:s",time()).' Failed to add details into User Email Table',3,'_includes/error.log');
                    }

                    // Insert Phone Details.
                    $phone_number = $webhook_data["billing_address"]["phone"];
                    $phone = new Phone();
                    $phone->setUserID($user_id);
                    $phone->setPhoneNumber($phone_number);

                    if ($conn->query(insertShopifyUserPhone($phone)) === TRUE){
                        error_log("\n".date("Y-m-d h:i:s",time()).' Entry into Users Phone Table Successful.',3,'_includes/error.log');
                    }else{
                        error_log("\n".date("Y-m-d h:i:s",time()).' Failed to add details into User Phone Table',3,'_includes/error.log');
                    }
                }else{
                    error_log("\n".date("Y-m-d h:i:s",time()).' Failed to add User details into User Table. Order Details Update will fail',3,'_includes/error.log');
                }
                
            }
            
            $check_user_id_validity = $user_id!==""? TRUE:FALSE;
            if ($check_user_id_validity){
                foreach ($skus as $sku) {
                    $result_product_details = $conn->query(getProductBySKUQuery($sku));

                    if ($result_product_details->num_rows>0){
                        while ($row = $result_product_details -> fetch_assoc()){
                            $product_id = $row["productsTypeID"];
                            $product_sku = $row["sku"];
                            error_log("\n".date("Y-m-d h:i:s",time())." Fetched Product Data: ".$row["productsTypeID"].",".$row["sku"].",".$row["title"],3,'_includes/error.log');
                            if ($product_id === "3"){
                                // Subscription Logic Comes Here
                                error_log("\n".date("Y-m-d h:i:s",time())." Making Entry for Subscription Transaction",3,'_includes/error.log');
                                $sku_latest = "";
                                $result_sku_latest = $conn->query(getLatestProductBySKUQuery($product_sku));
                                if ($result_sku_latest->num_rows>0){
                                    while ($row = $result_sku_latest -> fetch_assoc()) {
                                        $sku_latest = $row["sku"];
                                        $product_id_latest = $row["productsTypeID"];
                                    }
                                    
                                    error_log("\n".date("Y-m-d h:i:s",time())." Latest Issue Details: SKU- ".$sku_latest,3,'_includes/error.log');
                                    // Update the Asset History Table for Subscription SKU

                                    $result_asset_sub = $conn->query(getUserAssetsByUserID($user_id,$sku));
                                    if ($result_asset_sub->num_rows>0){
                                        if ($conn -> query(updateSubscriptionAssetForUserID($user_id,$sku)) === TRUE){
                                            error_log("\n".date("Y-m-d h:i:s",time())." Assets Table Updated for Subscription SKU Successfully.",3,'_includes/error.log');
                                        }else{
                                            error_log("\n".date("Y-m-d h:i:s",time())." Failed to update subscription entry into Assets Table.",3,'_includes/error.log');
                                        }
                                    }else{
                                        if ($conn -> query(insertSubscriptionAssetForUserID($user_id,$sku,$product_id)) === TRUE){
                                            error_log("\n".date("Y-m-d h:i:s",time())." Assets Table Updated for Subscription SKU Successfully.",3,'_includes/error.log');
                                        }else{
                                            error_log("\n".date("Y-m-d h:i:s",time())." Failed to insert subscription entry into Assets Table.",3,'_includes/error.log');
                                        }
                                    }

                                    $result_asset_issue = $conn->query(getUserAssetsByUserID($user_id,$sku_latest));
                                    if ($result_asset_issue->num_rows>0){
                                        if ($conn->query(updateAssetForUserID($user_id,$sku_latest)) === TRUE){
                                            error_log("\n".date("Y-m-d h:i:s",time())." Assets Table Updated Successfully.",3,'_includes/error.log');
                                        }else{
                                            error_log("\n".date("Y-m-d h:i:s",time())." Failed to update entry into Assets Table.",3,'_includes/error.log');
                                        }
                                    }else{
                                        if ($conn->query(insertAssetForUserID($user_id,$sku_latest,$product_id_latest)) === TRUE){
                                            error_log("\n".date("Y-m-d h:i:s",time())." Assets Table Updated Successfully.",3,'_includes/error.log');
                                        }else{
                                            error_log("\n".date("Y-m-d h:i:s",time())." Failed to insert entry into Assets Table.",3,'_includes/error.log');
                                        }
                                    }



                                }

                                
                            }else if ($product_id==="4"){
                                // Membership Update in Assets History
                                error_log("\n".date("Y-m-d h:i:s",time())." Making Entry for membership Transaction",3,'_includes/error.log');
                                $result_asset_member = $conn->query(getUserAssetsByUserID($user_id,$sku));
                                if ($result_asset_member->num_rows>0){
                                    if ($conn -> query(updateMembershipAssetForUserID($user_id,$sku)) === TRUE){
                                        error_log("\n".date("Y-m-d h:i:s",time())." Assets Table Updated for Membership SKU Successfully.",3,'_includes/error.log');
                                    }else{
                                        error_log("\n".date("Y-m-d h:i:s",time())." Failed to update subscription entry into Assets Table.",3,'_includes/error.log');
                                    }
                                }else{
                                    if ($conn -> query(insertMembershipAssetForUserID($user_id,$sku,$product_id)) === TRUE){
                                        error_log("\n".date("Y-m-d h:i:s",time())." Assets Table Updated for New Membership SKU Successfully.",3,'_includes/error.log');
                                    }else{
                                        error_log("\n".date("Y-m-d h:i:s",time())." Failed to insert subscription entry into Assets Table.",3,'_includes/error.log');
                                    }
                                }
                            }else{
                                // Standard order based assetsHistory table update comes here
                                error_log("\n".date("Y-m-d h:i:s",time())." Making Entry for single issue magazine/book",3,'_includes/error.log');
                                $result_asset = $conn->query(getUserAssetsByUserID($user_id,$sku));
                                if ($result_asset->num_rows>0){
                                    // Call to update query
                                    if ($conn->query(updateAssetForUserID($user_id,$sku)) === TRUE){
                                        error_log("\n".date("Y-m-d h:i:s",time())." Assets Table Updated Successfully.",3,'_includes/error.log');
                                    }else{
                                        error_log("\n".date("Y-m-d h:i:s",time())." Failed to update entry into Assets Table.",3,'_includes/error.log');
                                    }
                                }else{
                                    // Call to insert query
                                    if ($conn->query(insertAssetForUserID($user_id,$sku,$product_id)) === TRUE){
                                        error_log("\n".date("Y-m-d h:i:s",time())." Assets Table Updated Successfully.",3,'_includes/error.log');
                                    }else{
                                        error_log("\n".date("Y-m-d h:i:s",time())." Failed to insert entry into Assets Table.",3,'_includes/error.log');
                                    }
                                }

                            }
                        }
                    }else{
                        error_log("\n".date("Y-m-d h:i:s",time()).' No Entry exists for the SKU obtained from Webhook Payload in the Database. Order Updates will not be made in tables.',3,'_includes/error.log');        
                    }
                    
                }
            }else{
                error_log("\n".date("Y-m-d h:i:s",time()).' User ID Failed to obtain due to a possible issue with the DB server. Order Updates Cancelled',3,'_includes/error.log');
            }


            $conn->close();
            $connection_flag=false;
            http_response_code(200);    
            
        }else{
            
            $conn->close();
            $connection_flag=false;
            error_log("\n".date("Y-m-d h:i:s",time()).' Failed to verify Webhook',3,'_includes/error.log');
            http_response_code(401);
        }

        
        
        
        
    }
    


?>