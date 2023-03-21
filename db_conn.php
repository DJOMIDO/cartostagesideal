<?php

$db_host = "localhost";
$db_user = "maxiao";
$db_password = "&maxiao;";
$db_name = "maxiao";

try {
    $db = new PDO("mysql:host={$db_host};dbname={$db_name}", $db_user, $db_password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOEXCEPTION $e) {
    $e->getMessage();
}

?>