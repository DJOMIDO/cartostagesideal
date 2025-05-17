<?php

$db_host = "db";           // Docker 
$db_user = "user";         // Docker Compose 
$db_password = "password"; // Docker Compose 
$db_name = "cartostages";  // Docker Compose 

// 
$debug_mode = getenv('DEBUG_MODE');

try {
    $db = new PDO("mysql:host={$db_host};dbname={$db_name}", $db_user, $db_password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if ($debug_mode === 'true') {
        echo "Database connection successful!";
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
