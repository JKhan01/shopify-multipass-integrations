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
        $query = "update assetsHistory set `utc_timestamp`=utc_timestamp(),shopifyOrder='Y' where assetsHistoryID=(select assetsHistoryID from assetsHistory where usersID=".$user_id." and sku='".$sku."')";
        
        return $query;
    }

    function insertSubscriptionAssetForUserID($user_id,$sku,$product_type){
        $startYear = date('Y',time());
        $startMonth = date('m',time());
        $endMonth = $startMonth - 1;
        $endYear = (int)date('Y',time());
        $endYear += 1;
        $endYearString = $endYear."-".$endMonth;
        $startYearString = $startYear."-".$startMonth;
        $query = "insert into assetsHistory (`utc_timestamp`, `productsTypeID`,`sku`,`shopifyOrder`,`usersID`, `expirationFrom`, `expirationTo`) values ";
        $query = $query."(utc_timestamp(),".$product_type.",'".$sku."','Y',".$user_id.",'".$startYearString."','".$endYearString."')";

        return $query;
    }

    function updateSubscriptionAssetForUserID($user_id,$sku){
        $startYear = date('Y',time());
        $startMonth = date('m',time());
        $endMonth = $startMonth - 1;
        $endYear = (int)date('Y',time());
        $endYear += 1;
        $endYearString = $endYear."-".$endMonth;
        $startYearString = $startYear."-".$startMonth;
        $query = "update assetsHistory set `utc_timestamp`=utc_timestamp(),shopifyOrder='Y', expirationFrom='".$startYearString."', expirationTo='".$endYearString."'  where assetsHistoryID=(select assetsHistoryID from assetsHistory where usersID=".$user_id." and sku='".$sku."')";
        
        return $query;
    }

    function insertMembershipAssetForUserID($user_id,$sku,$product_type){
        $startYear = date('Y',time());
        $startMonth = date('m',time());
        $endMonth = $startMonth - 1;
        $endYear = (int)date('Y',time());
        $endYear += 1;
        $endYearString = $endYear."-".$endMonth;
        $startYearString = $startYear."-".$startMonth;
        $query = "insert into assetsHistory (`utc_timestamp`, `productsTypeID`,`sku`,`shopifyOrder`,`usersID`, `expirationFrom`, `expirationTo`) values ";
        $query = $query."(utc_timestamp(),".$product_type.",'".$sku."','Y',".$user_id.",'".$startYearString."','".$endYearString."')";

        return $query;
    }

    function updateMembershipAssetForUserID($user_id,$sku){
        $startYear = date('Y',time());
        $startMonth = date('m',time());
        $endMonth = $startMonth - 1;
        $endYear = (int)date('Y',time());
        $endYear += 1;
        $endYearString = $endYear."-".$endMonth;
        $startYearString = $startYear."-".$startMonth;
        $query = "update assetsHistory set `utc_timestamp`=utc_timestamp(),shopifyOrder='Y', expirationFrom='".$startYearString."', expirationTo='".$endYearString."'  where assetsHistoryID=(select assetsHistoryID from assetsHistory where usersID=".$user_id." and sku='".$sku."')";
        
        return $query;
    }

    function insertShopifyUserDetails($user){
        $query = "insert into users (`firstname`,`lastname`,`company`,`password`,`passwordexpires`,`isActive`,`isDeleted`) values (";
        $query = $query."'".$user->get_first_name()."','".$user->get_last_name()."','".$user->get_company()."','".$user->get_password()."',str_to_date('";
        $query = $query.$user->get_password_expires()."','%Y-%m-%d'),".$user->get_is_active().",".$user->get_is_deleted().")";

        return $query;
    }

    function getMaxUserID(){
        $query = "select LAST_INSERT_ID()";
        return $query;
    }

    function insertShopifyUserAddress($address){

        $query = "insert into usersAddresses
        (
        `usersID`,
        `addressTypeID`,
        `address1`,
        `address2`,
        `city`,
        `state`,
        `zip`,
        `country`,
        `isInternational`,
        `isDefault`)
        values
        (".$address->getUser_id().","
        .$address->getAddress_type().",'".$address->getAddress_1()."','".$address->getAddress_1()."','".$address->getCity()."','".
        $address->getState()."','".$address->getZip()."','".$address->getCountry()."',".$address->getIs_international().",".$address->getIs_default().")";

        return $query;

    }

    function insertShopifyUserEmail($email){
        $query = "insert into usersEmails
        (
        `usersID`,
        `emailsTypeID`,
        `emailAddress`,
        `isDefault`,
        `optIn`)
        values(".$email->getUsersID().",".$email->getEmailsTypeID().",'".$email->getEmailAddress()."',".$email->getIsDefault().",".$email->getOptIn().")";

        return $query;
    }

    function insertShopifyUserPhone($phone){

        $query = "insert into usersPhones
        (
        `usersID`,
        `phonesTypeID`,
        `phoneNumber`,
        `isDefault`)
        values
        (".$phone->getUserID().",".$phone->getPhoneTypeID().",'".$phone->getPhoneNumber()."',".$phone->getIsDefault().")";

        return $query;

    }
?>