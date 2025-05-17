<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['username'] != "admin") {
    if (!headers_sent()) {
        echo "L'accès à cette page est réservé aux administrateurs.";
        exit;
    }
}

$title = "Publier - CartoStages IDéaL";
$content_file = "publier_content.php";
include "template.php";
?>