<?php

// Connect to the database
require_once "db_conn.php";
session_start();

if (isset($_POST["newusername"]) && isset($_POST["newemail"]) && isset($_POST["newpassword"])) {
    $username = $_POST["newusername"];
    $email = $_POST["newemail"];
    $password = $_POST["newpassword"];

    try {
        // 检查用户名和邮箱是否已存在
        $checkUser = $db->prepare("SELECT * FROM users WHERE username = :uname OR email = :uemail");
        $checkUser->bindParam(":uname", $username);
        $checkUser->bindParam(":uemail", $email);
        $checkUser->execute();
        $userExists = $checkUser->fetch(PDO::FETCH_ASSOC);

        if ($userExists) {
            if ($userExists['username'] == $username) {
                echo "Le nom d'utilisateur existe déjà.";
            } else {
                echo "Cette adresse email a été déjà utilisée.";
            }
        } else {
            // 直接插入明文密码
            $stmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (:uname, :uemail, :upassword)");
            $stmt->bindParam(":uname", $username);
            $stmt->bindParam(":uemail", $email);
            $stmt->bindParam(":upassword", $password);

            if ($stmt->execute()) {
                $_SESSION['username'] = $username;
                $_SESSION['logged_in'] = true;
                echo "success";
            } else {
                echo "Erreur lors de l'inscription.";
            }
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>
