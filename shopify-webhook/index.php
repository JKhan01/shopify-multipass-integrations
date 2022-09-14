<?php

    include '_includes/db_open.php';
    // include '_includes/webhook_secret_key.php';
    $webhook_secret = 'f784faa63aa3bc628137c1ece9211e1b75a1928ec7b30ca158512e0b3d8b2f79';

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
        error_log("\n".date("Y-m-d h:i:s ",time())."Computed HMAC: "$calculated_hmac,3,'_includes/error.log');
        

        if ($verified){
            
            error_log("\n".date("Y-m-d h:i:s",time()).' Webhook verified',3,'_includes/error.log');
            
            
            
            
        }else{
            
            error_log("\n".date("Y-m-d h:i:s",time()).' Failed to verify Webhook',3,'_includes/error.log');
            
        }

        http_response_code(200);
        
        
        
    }
    
    $conn->close();
    $connection_flag=false;

?>