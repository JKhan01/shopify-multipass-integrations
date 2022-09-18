<?php 

    function getProductBySKUQuery($sku){
        $query = "select productsTypeID, title, sku from skuMaint where sku='".$sku."'";

        return $query;
    }

    function getLatestProductBySKUQuery($sku){
        $query = "select productsTypeID, title, sku from skuMaint where sku like '%".$sku."%' and year=".date('Y',time())." and
         unit=(select max(unit) from skuMaint where sku like '%".$sku."%' and year=".date('Y',time()).")";

        return $query;
    }

    function getUserIdByEmailQuery($user_email){
        $query = "select usersID from usersEmails where emailAddress='".$user_email."' limit 1";

        return $query;
    }

    function getUserAssetsByUserID($user_id,$sku){
        $query = "select * from assetsHistory where usersID=".$user_id." and sku='".$sku."'";

        return $query;
    }

    function insertAssetForUserID($user_id,$sku,$product_type){
        $query = "insert into assetsHistory (`utc_timestamp`, `productsTypeID`,`sku`,`shopifyOrder`,`usersID`) values ";
        $query = $query."(utc_timestamp(),".$product_type.",'".$sku."','Y',".$user_id.")";

        return $query;
    }

    function updateAssetForUserID($user_id,$sku){
        $query = "update assetsHistory set `utc_timestamp`=utc_timestamp(),shopifyOrder='Y' where usersID=".$user_id." and sku='".$sku."'";
        
        return $query;
    }
?>