<?php

    include '_includes/db_open.php';
    include '_includes/webhook_secret_key.php';
    include '_includes/webhook_db_queries.php';    

    if ($_SERVER['REQUEST_METHOD'] === 'GET'){
        
        echo"This is Shopify Webhook Data Post Endpoint ";
        echo"\n".$connection_flag;

        error_log("\n".date("Y-m-d h:i:s",time())." Get Request Handling",3,'_includes/error.log');

        
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

            $result_user_id = $conn->query(getUserIdByEmailQuery($customer_email));
            if ($result_user_id->num_rows>0){
                // $row = $result_user_id -> fetch_assoc();
                while ($row = $result_user_id -> fetch_assoc()){
                    $user_id = $row["usersID"];
                    error_log("\n".date("Y-m-d h:i:s",time())." Fetched User ID: ".$user_id,3,'_includes/error.log');
                    
                }

                foreach ($skus as $sku) {
                    $result_product_details = $conn->query(getProductBySKUQuery($sku));

                    if ($result_product_details->num_rows>0){
                        while ($row = $result_product_details -> fetch_assoc()){
                            $product_id = $row["productsTypeID"];
                            error_log("\n".date("Y-m-d h:i:s",time())." Fetched Product Data: ".$row["productsTypeID"].",".$row["sku"].",".$row["title"],3,'_includes/error.log');
                            if ($product_id === "3"){
                                // Subscription Logic Comes Here
                                $sku_latest = "";
                                $result_sku_latest = $conn->query(getLatestProductBySKUQuery('DEMD'));
                                if ($result_sku_latest->num_rows>0){
                                    while ($row = $result_sku_latest -> fetch_assoc()) {
                                        $sku_latest = $row["sku"];
                                        $product_id_latest = $row["productsTypeID"];
                                    }

                                    // Update the Asset History Table for Subscription SKU

                                    $result_asset_sub = $conn->query(getUserAssetsByUserID($user_id,$sku));
                                    if ($result_asset_sub->num_rows>0){
                                        if ($conn -> query(updateSubscriptionAssetForUserID($user_id,$sku)) === TRUE){
                                            error_log("\n".date("Y-m-d h:i:s",time())." Assets Table Updated for Subscription SKU Successfully.");
                                        }else{
                                            error_log("\n".date("Y-m-d h:i:s",time())." Failed to update subscription entry into Assets Table.");
                                        }
                                    }else{
                                        if (conn -> query(insertSubscriptionAssetForUserID($user_id,$sku,$product_id)) === TRUE){
                                            error_log("\n".date("Y-m-d h:i:s",time())." Assets Table Updated for Subscription SKU Successfully.");
                                        }else{
                                            error_log("\n".date("Y-m-d h:i:s",time())." Failed to insert subscription entry into Assets Table.");
                                        }
                                    }

                                    $result_asset_issue = $conn->query(getUserAssetsByUserID($user_id,$sku_latest));
                                    if ($result_asset_issue->num_rows>0){
                                        $conn->query(updateAssetForUserID($user_id,$sku_latest));
                                    }else{
                                        $conn->query(insertAssetForUserID($user_id,$sku_latest,$product_id_latest));
                                    }



                                }

                                
                            }else{
                                // Standard order based assetsHistory table update comes here

                                $result_asset = $conn->query(getUserAssetsByUserID($user_id,$sku));
                                if ($result_asset->num_rows>0){
                                    // Call to update query
                                    if ($conn->query(updateAssetForUserID($user_id,$sku)) === TRUE){
                                        error_log("\n".date("Y-m-d h:i:s",time())." Assets Table Updated Successfully.");
                                    }else{
                                        error_log("\n".date("Y-m-d h:i:s",time())." Failed to update entry into Assets Table.");
                                    }
                                }else{
                                    // Call to insert query
                                    if ($conn->query(insertAssetForUserID($user_id,$sku,$product_id)) === TRUE){
                                        error_log("\n".date("Y-m-d h:i:s",time())." Assets Table Updated Successfully.");
                                    }else{
                                        error_log("\n".date("Y-m-d h:i:s",time())." Failed to insert entry into Assets Table.");
                                    }
                                }

                            }
                        }
                    }

                }
                
            }else{
                error_log("\n".date("Y-m-d h:i:s",time()).' Failed to verify User Email. DB Updated Terminated',3,'_includes/error.log');    
            }



            http_response_code(200);    
            
        }else{
            
            error_log("\n".date("Y-m-d h:i:s",time()).' Failed to verify Webhook',3,'_includes/error.log');
            http_response_code(401);
        }

        
        
        
        
    }
    
    $conn->close();
    $connection_flag=false;

?>