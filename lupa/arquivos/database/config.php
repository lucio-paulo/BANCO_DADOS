<?php

// Configuration for database connection
if ($_SERVER['HTTP_HOST'] != 'localhost') {
    $host       = getenv('DB_HOST');
    $username   = getenv('DB_USERNAME');
    $password   = getenv('DB_PASSWORD');
    $db_name     = getenv('DB_DATABASE');
    $sslcert    = "ssl/DigiCertGlobalRootCA.crt.pem";
}else{
    $host       = '127.0.0.1';
    $username   = 'root';
    $password   = '';
    $db_name     = 'projeto';
    $sslcert    = "ssl/DigiCertGlobalRootCA.crt.pem";
}