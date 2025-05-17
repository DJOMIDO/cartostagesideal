<?php

// Connect to the database
require_once "db_conn.php";
session_start();

// Retrieve the data from the form
$username = trim($_POST['usrname']);
$email = trim($_POST['usremail']);
$password = trim($_POST['usrpassword']);

try {
    // 查询用户数据
    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username AND email = :email");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // 直接比对明文密码
        if ($password === $result['password']) {
            // 登录成功
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['logged_in'] = true;
            echo "success";
        } else {
            echo "Mauvais nom d'utilisateur ou mot de passe";
        }
    } else {
        echo "Mauvais nom d'utilisateur ou adresse e-mail";
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
