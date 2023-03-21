<?php
$conn = mysqli_connect('localhost', 'maxiao', '&maxiao;', 'maxiao');

if (isset($_POST['email'])) {
    $sujet = $_POST['sujet'];
    $date = $_POST['date'];
    $niveau = $_POST['niveau'];
    $parcours = $_POST['parcours'];
    $organisme = $_POST['organisme'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $dumas = $_POST['dumas'];
    $archives = $_POST['archives'];
    $effectue = $_POST['effectue'];
    $id = $_POST['id'];

    // query to update data
    $result = mysqli_query($conn, "UPDATE offres SET sujet='$sujet', date='$date', niveau='$niveau', parcours='$parcours', organisme='$organisme', contact='$contact', email='$email', dumas='$dumas', archives='$archives', effectue='$effectue' WHERE id='$id'");
    if ($result) {
        return 'Enregistré !';
    }
}
?>