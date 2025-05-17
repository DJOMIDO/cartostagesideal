<?php
// Connect to the database
require_once('db_conn.php');

// Get the form data from the POST request
$level = isset($_POST['level']) ? $_POST['level'] : '';
$type = isset($_POST['type']) ? $_POST['type'] : '';
$sujet = isset($_POST['sujet']) ? $_POST['sujet'] : '';
$duree = isset($_POST['duree']) ? $_POST['duree'] : '';
$lieu = isset($_POST['lieu']) ? $_POST['lieu'] : '';
$organisme = isset($_POST['organisme']) ? $_POST['organisme'] : '';
$contact = isset($_POST['contact']) ? $_POST['contact'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$description = isset($_POST['description']) ? $_POST['description'] : '';
$dumas = isset($_POST['dumas']) ? $_POST['dumas'] : 'N/A';
$date = isset($_POST['date']) ? $_POST['date'] : date('Y-m-d');
$fichier = isset($_POST['fichier']) ? $_POST['fichier'] : 'default.pdf';
$gratification = isset($_POST['gratification']) ? $_POST['gratification'] : null;
$critere = isset($_POST['critere']) ? $_POST['critere'] : '';
$archives = isset($_POST['archives']) ? 1 : 0;
$effectue = 1; // 固定为已完成

// Check if all required fields are filled in
if (empty($level) || empty($type) || empty($sujet) || empty($duree) || empty($lieu) || empty($organisme) || empty($contact) || empty($description) || empty($date)) {
    $response = array("status" => "error", "message" => "Veuillez remplir tous les champs obligatoires !");
    echo json_encode($response);
    exit;
}

try {
    // Prepare the SQL statement
    $sql = "INSERT INTO offres 
        (niveau, parcours, sujet, duree, lieu, organisme, contact, email, description, dumas, date, effectue, fichier, gratification, critere, archives) 
        VALUES 
        (:niveau, :parcours, :sujet, :duree, :lieu, :organisme, :contact, :email, :description, :dumas, :date, :effectue, :fichier, :gratification, :critere, :archives)";
    
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':niveau', $level);
    $stmt->bindParam(':parcours', $type);
    $stmt->bindParam(':sujet', $sujet);
    $stmt->bindParam(':duree', $duree);
    $stmt->bindParam(':lieu', $lieu);
    $stmt->bindParam(':organisme', $organisme);
    $stmt->bindParam(':contact', $contact);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':dumas', $dumas);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':effectue', $effectue);
    $stmt->bindParam(':fichier', $fichier);
    $stmt->bindParam(':gratification', $gratification);
    $stmt->bindParam(':critere', $critere);
    $stmt->bindParam(':archives', $archives);

    // Execute the statement
    $stmt->execute();
    $id = $db->lastInsertId();
    $response = array("status" => "success", "message" => "Félicitations, l'offre complétée a été enregistrée avec succès, ID: " . $id);
} catch (PDOException $e) {
    $response = array("status" => "error", "message" => "Erreur : " . $e->getMessage());
}

header('Content-Type: application/json');
echo json_encode($response);

// Close the database connection
$stmt->closeCursor();
$db = null;
?>
