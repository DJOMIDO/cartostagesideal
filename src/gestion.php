<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['username'] != "admin") {
    if (!headers_sent()) {
        echo "L'accs  cette page est rserv aux administrateurs.";
        exit;
    }
}

$title = "Gestion - CartoStages IDéaL";
$content_file = "gestion_content.php";
include "template.php";
?>