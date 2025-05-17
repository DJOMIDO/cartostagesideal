<?php
// Connect to the database
require_once('db_conn.php');

/**
 * Generates a single internship card in HTML format.
 *
 * @param array $row Associative array containing internship data.
 * @return string The HTML representation of the internship card.
 */
function generateCard($row) {
    $html = "<div class='card' id='resultat'>";
    $html .= "<div class='card-header' style='text-align: left; display: flex; align-items: center;' id='nom_stage'>";
    $html .= "<h4>";
    $html .= "<a href='#info_stage" . htmlspecialchars($row['id']) . "' class='text-dark' data-bs-toggle='collapse' aria-expanded='false' aria-controls='info_stage" . htmlspecialchars($row['id']) . "' role='button'>";
    $html .= htmlspecialchars($row['organisme']) . ", " . htmlspecialchars($row['lieu']);
    $html .= "</a></h4></div>";

    $html .= "<div id='info_stage" . htmlspecialchars($row['id']) . "' class='collapse'>";
    $html .= "<div class='card-body'>";
    $html .= "<dl class='row'>";
    $html .= "<dt class='col-sm-3' id='date'><h5>" . htmlspecialchars($row['date']) . "</h5></dt>";
    $html .= "<dd class='col-sm-9'><strong>Sujet :</strong> " . htmlspecialchars($row['sujet']) . "<br>";
    $html .= "<strong>Niveau d'études :</strong> " . htmlspecialchars($row['niveau']) . "<br>";

    if (!empty($row['description'])) {
        $html .= "<strong>Description :</strong> " . htmlspecialchars($row['description']) . "<br>";
    }
    if (!empty($row['contact'])) {
        $html .= "<strong>Contact :</strong> " . htmlspecialchars($row['contact']) . "<br>";
    }
    if (!empty($row['email'])) {
        $html .= "<a href='mailto:" . htmlspecialchars($row['email']) . "'>" . htmlspecialchars($row['email']) . "</a><br>";
    }
    if (!empty($row['fichier'])) {
        $html .= "<a href='" . htmlspecialchars($row['fichier']) . "'>Lien de l'offre</a><br>";
    }
    if (!empty($row['dumas'])) {
        $html .= "<a href='" . htmlspecialchars($row['dumas']) . "'>" . htmlspecialchars($row['dumas']) . "</a>";
    }

    $html .= "</dd></dl></div></div></div>";
    return $html;
}

try {
    // Query to fetch completed internships
    $archive = "SELECT * FROM `offres` WHERE `effectue` = 1 AND `archives` = 0 ORDER BY `date` DESC";
    $stmt = $db->prepare($archive);
    $stmt->execute();
    $data = $stmt->fetchAll();

    echo "<div class='text-center my-3'><div class='text-white'><h4>Voici la liste des stages effectués :</h4></div></div>";

    // Loop through the result set and display each internship card
    foreach ($data as $row) {
        echo generateCard($row);
    }
} catch (PDOException $e) {
    echo "<div class='alert alert-danger' role='alert'>Erreur de récupération des données : " . htmlspecialchars($e->getMessage()) . "</div>";
}
?>
