<?php

// Connect to the database
require_once "db_conn.php";

// Start a session
session_start();

if (isset($_POST["newusername"]) && isset($_POST["newemail"]) && isset($_POST["newpassword"])) {
    $username = $_POST["newusername"];
    $email = $_POST["newemail"];
    $password = password_hash($_POST["newpassword"], PASSWORD_DEFAULT);

    // Check if the username or email already exists in the database
    $checkUsername = $db->prepare("SELECT * FROM cartostages_users WHERE username=:uname");
    $checkUsername->bindParam(":uname", $username);
    $checkUsername->execute();
    $usernameExists = $checkUsername->fetch(PDO::FETCH_ASSOC);

    $checkEmail = $db->prepare("SELECT * FROM cartostages_users WHERE email=:uemail");
    $checkEmail->bindParam(":uemail", $email);
    $checkEmail->execute();
    $emailExists = $checkEmail->fetch(PDO::FETCH_ASSOC);

    // If the username or email already exists, show an error message
    if ($usernameExists || $emailExists) {
        if ($usernameExists) {
            echo 'Le nom d\'utilisateur existe déjà.';
        } else if ($emailExists) {
            echo 'Cette adresse email a été déjà utilisée.';
        }
    } else {
        // If the username and email are unique, insert the new user into the database
        $stmt = $db->prepare("INSERT INTO cartostages_users(username,
													 email, 
													 password)
												VALUES
												    (:uname,
													 :uemail,
													 :upassword)");
        $stmt->bindParam(":uname", $username);
        $stmt->bindParam(":uemail", $email);
        $stmt->bindParam(":upassword", $password);

        if ($stmt->execute()) {
            // If the user was inserted into the database successfully, set the session variables
            $_SESSION['username'] = $username;
            $_SESSION['logged_in'] = true;

            // Hash the password before storing it in the session
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $_SESSION['password'] = $hashedPassword;

            echo "success";
        } else {
            $error = $stmt->errorInfo();
            echo "Error: " . $error[2];
        }

    }
}
?>