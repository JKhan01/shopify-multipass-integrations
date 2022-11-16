<?php 
    include 'db_open.php';
    include 'webhook_db_queries.php';
    include 'Users.php';
    include 'Address.php';
    include 'Email.php';
    include 'Phone.php';

    // Test User ID Fetch
    // $result_user_id = $conn->query(getUserIdByEmailQuery('JASON@CRUPPERCONSULTING.COM'));

    // if ($result_user_id->num_rows>0){
    //     // $row = $result_user_id -> fetch_assoc();
    //     while ($row = $result_user_id -> fetch_assoc()){
    //         $user_id = $row["usersID"];
    //         echo gettype($user_id);
    //         echo "\nFetched User ID: ".$row["usersID"];
    //     }
    // }

    // // Test Asset History Fetch
    // $result_assets = $conn->query(getUserAssetsByUserID(216448,'TMET'));

    // if ($result_assets->num_rows>0){
    //     while ($row = $result_assets -> fetch_assoc()){
    //         echo "\nFetched Assets Data: ".$row["assetsHistoryID"].",".$row["sku"].",".$row["usersID"];
    //     }
    // }

    // // Test Fetch Product ID based on SKU.

    // $result_product_details = $conn->query(getProductBySKUQuery('DEMD'));

    // if ($result_product_details->num_rows>0){
    //     while ($row = $result_product_details -> fetch_assoc()){
    //         echo "\nFetched Product Data: ".$row["productsTypeID"].",".$row["sku"].",".$row["title"];
    //     }
    // }

    // echo "\n".getLatestProductBySKUQuery('DEMD');

    // $result_product_details = $conn->query(getLatestProductBySKUQuery('DEMD'));

    // if ($result_product_details->num_rows>0){
    //     while ($row = $result_product_details -> fetch_assoc()){
    //         echo "\nFetched Product Data: ".$row["productsTypeID"].",".$row["sku"].",".$row["title"];
    //     }
    // }

    echo '\r\n'.updateSubscriptionAssetForUserID(377498,'DEMD-202102');
    echo " ".insertSubscriptionAssetForUserID(377498,'DEMD-202102',1);
    echo " ".updateAssetForUserID(377498,'DEMD-202102');
    echo " ".insertAssetForUserID(377498,'DEMD-202102',1)."\r\n";

    $user = new Users();
    $user->set_first_name("Test");
    $user->set_last_name("ABC");
    $user->set_company("Deloitte");
    
    echo " ".insertShopifyUserDetails($user)."\r\n";


    $address = new Address();
    $address->setUser_id(12345);
    $address->setAddress_type(1);
    $address->setAddress_1("Hello Hello");
    $address->setAddress_2("Test Test");
    $address->setCity("Navi Mumbai");
    $address->setState("Maharashtra");
    $address->setZip('312423');
    $address->setCountry("India");
    $address->setIs_international(1);
    $address->setIs_default(1);

    echo " ".insertShopifyUserAddress($address)."\r\n";

    $email = new Email();
    $email->setUsersID(9989);
    $email->setEmailAddress("godaddy69@abc.com");
    $email->setEmailsTypeID(1);
    $email->setIsDefault(1);
    $email->setOptIn(1);

    echo " ".insertShopifyUserEmail($email)."\r\n";

    $phone = new Phone();
    $phone->setUserID(9899);
    $phone->setPhoneTypeID(1);
    $phone->setPhoneNumber("983-341-2172");
    $phone->setIsDefault(0);

    echo " ".insertShopifyUserPhone($phone)."\r\n";

?>