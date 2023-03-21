<?php

// Connect to the database
require_once "db_conn.php";

session_start();

// Retrieve the data from the form
$username = $_POST['usrname'];
$email = $_POST['usremail'];
$password = $_POST['usrpassword'];

// Prepare and execute the query to retrieve the user data
$query = "SELECT * FROM cartostages_users WHERE username = '$username' AND email = '$email'";
$stmt = $db->prepare($query);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    // If the user exists, retrieve the hashed password from the database
    $hashed_password = $result['password'];

    // Verify the entered password against the hashed password
    if (password_verify($password, $hashed_password)) {
        // If the passwords match, log the user in
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['logged_in'] = true;

        echo "success";
    } else {
        // If the passwords don't match, return an error
        echo "Mauvais nom d'utilisateur ou mot de passe";
    }
} else {
    // If the user doesn't exist, return an error
    echo "Mauvais nom d'utilisateur ou adresse e-mail";
}

?>