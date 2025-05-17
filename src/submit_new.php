<?php
// Connect to the database
require_once('db_conn.php');

// Get the form data in a POST request
$level = isset($_POST['level']) ? $_POST['level'] : '';
$type = isset($_POST['type']) ? $_POST['type'] : '';
$sujet = isset($_POST['sujet']) ? $_POST['sujet'] : '';
$duree = isset($_POST['duree']) ? $_POST['duree'] : '';
$lieu = isset($_POST['lieu']) ? $_POST['lieu'] : '';
$organisme = isset($_POST['organisme']) ? $_POST['organisme'] : '';
$contact = isset($_POST['contact']) ? $_POST['contact'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$gratification = isset($_POST['gratification']) ? $_POST['gratification'] : null;
$description = isset($_POST['description']) ? $_POST['description'] : '';
$critere = isset($_POST['critere']) ? $_POST['critere'] : '';
$date = isset($_POST['date']) ? $_POST['date'] : date('Y-m-d');
$fichier = isset($_POST['fichier']) ? $_POST['fichier'] : 'default.pdf';
$dumas = isset($_POST['dumas']) ? $_POST['dumas'] : 'N/A';
$archives = isset($_POST['archives']) ? 1 : 0;
$effectue = isset($_POST['effectue']) ? 1 : 0;

// Check if all required fields are filled in
if (empty($level) || empty($type) || empty($sujet) || empty($duree) || empty($lieu) || empty($organisme) || empty($contact) || empty($description) || empty($date)) {
    $response = array("status" => "error", "message" => "Veuillez remplir tous les champs obligatoires !");
    echo json_encode($response);
    exit;
}

try {
    // Prepare SQL statement
    $sql = "INSERT INTO offres 
        (niveau, parcours, sujet, duree, lieu, organisme, contact, email, gratification, description, critere, date, fichier, dumas, archives, effectue) 
        VALUES 
        (:niveau, :parcours, :sujet, :duree, :lieu, :organisme, :contact, :email, :gratification, :description, :critere, :date, :fichier, :dumas, :archives, :effectue)";
    
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':niveau', $level);
    $stmt->bindParam(':parcours', $type);
    $stmt->bindParam(':sujet', $sujet);
    $stmt->bindParam(':duree', $duree);
    $stmt->bindParam(':lieu', $lieu);
    $stmt->bindParam(':organisme', $organisme);
    $stmt->bindParam(':contact', $contact);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':gratification', $gratification);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':critere', $critere);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':fichier', $fichier);
    $stmt->bindParam(':dumas', $dumas);
    $stmt->bindParam(':archives', $archives);
    $stmt->bindParam(':effectue', $effectue);
    
    // Execute the statement
    $stmt->execute();
    $id = $db->lastInsertId();
    $response = array("status" => "success", "message" => "Félicitations, l'offre a été enregistrée avec succès, ID: " . $id);
} catch (PDOException $e) {
    $response = array("status" => "error", "message" => "Erreur : " . $e->getMessage());
}

header('Content-Type: application/json');
echo json_encode($response);

// Close the database connection
$stmt->closeCursor();
$db = null;
?>
