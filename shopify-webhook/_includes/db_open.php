<?php 
    $username='<user-name>';
    $hostname='<host-server-name>';
    $database='<database-name>';
    $password='<password>';

    $conn = new mysqli($hostname,$username,$password,$database);

    $connection_flag = false;

    if ($conn->connect_error) {
        echo "Connection failed: " . $conn->connect_error;
    }else{
        echo "Connected successfully";
        $connection_flag = true;
    }
    
?>