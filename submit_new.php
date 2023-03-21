<?php
// Connect to the database
require_once('db_conn.php');

// Get the form data in a POST request
$level = $_POST['level'];
$type = $_POST['type'];
$sujet = $_POST['sujet'];
$duree = $_POST['duree'];
$lieu = $_POST['lieu'];
$organisme = $_POST['organisme'];
$contact = $_POST['contact'];
$email = $_POST['email'];
$gratification = isset($_POST['gratification']) ? $_POST['gratification'] : null;
$description = $_POST['description'];
$critere = $_POST['critere'];
$date = $_POST['date'];

// Check if all required fields are filled in
if (empty($level) || empty($type) || empty($sujet) || empty($duree) || empty($lieu) || empty($organisme) || empty($contact) || empty($description) || empty($date)) {
    echo 'Veuillez remplir tous les champs obligatoires !';
    exit;
}

// Prepare SQL statements and execute them
$sql = "INSERT INTO offres (niveau, parcours, sujet, duree, lieu, organisme, contact, email, gratification, description, critere, date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $db->prepare($sql);
$stmt->bindValue(1, $level);
$stmt->bindValue(2, $type);
$stmt->bindValue(3, $sujet);
$stmt->bindValue(4, $duree);
$stmt->bindValue(5, $lieu);
$stmt->bindValue(6, $organisme);
$stmt->bindValue(7, $contact);
$stmt->bindValue(8, $email);
$stmt->bindValue(9, $gratification);
$stmt->bindValue(10, $description);
$stmt->bindValue(11, $critere);
$stmt->bindValue(12, $date);

try {
    $stmt->execute();
    $id = $db->lastInsertId();
    $response = array("status" => "success", "message" => "Félicitations, ces informations ont été enregistrées avec succès ID: " . $id);
} catch (Exception $e) {
    $response = array("status" => "error", "message" => "Error: " . $e->getMessage());
}

header('Content-Type: application/json');
echo json_encode($response);


// Close the database connection
$stmt->closeCursor();
$conn = null;

?>