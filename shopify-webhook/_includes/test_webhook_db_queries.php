<?php 
    include 'db_open.php';
    include 'webhook_db_queries.php';

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
    echo " ".insertAssetForUserID(377498,'DEMD-202102',1);
?>