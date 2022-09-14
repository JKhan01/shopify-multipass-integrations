<?php 
    $username='u886168621_wrprod';
    $hostname='151.106.124.201';
    $database='u886168621_wrprod';
    $password='Reset123!';

    $conn = new mysqli($hostname,$username,$password,$database);

    $connection_flag = false;

    if ($conn->connect_error) {
        echo "Connection failed: " . $conn->connect_error;
    }else{
        echo "Connected successfully";
        $connection_flag = true;
    }
    
?>