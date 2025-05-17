<?php
// Connect to the database
require_once('db_conn.php');

// Function to sanitize and prepare input data
function sanitizeInput($input) {
    return !empty($input) ? "%" . trim(addslashes($input)) . "%" : null;
}

// Retrieve and sanitize user input
$recherche = sanitizeInput($_POST['recherche'] ?? '');
$lieu = sanitizeInput($_POST['lieu'] ?? '');
$duree = sanitizeInput($_POST['duree'] ?? '');
$niveau = sanitizeInput($_POST['niveau'] ?? '');

try {
    // Construct the base query
    $query = "SELECT * FROM offres WHERE archives = 0 AND effectue = 0";
    $params = [];

    // Add conditions based on user input
    if ($recherche) {
        $query .= " AND LOWER(sujet) LIKE LOWER(:recherche)";
        $params[':recherche'] = $recherche;
    }
    if ($lieu) {
        $query .= " AND LOWER(lieu) LIKE LOWER(:lieu)";
        $params[':lieu'] = $lieu;
    }
    if ($duree) {
        $query .= " AND LOWER(duree) LIKE LOWER(:duree)";
        $params[':duree'] = $duree;
    }
    if ($niveau) {
        $query .= " AND LOWER(niveau) LIKE LOWER(:niveau)";
        $params[':niveau'] = $niveau;
    }

    // Add ordering by date
    $query .= " ORDER BY date DESC";

    // Prepare and execute the query
    $stmt = $db->prepare($query);
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Display the results
    if (count($data) > 0) {
        echo "<div class='text-center my-3'><div class='text-white'><h4>Voici les résultats de votre recherche :</h4></div></div>";
        foreach ($data as $row) {
            echo "<div class='card' id='resultat'>";
            echo "<div class='card-header' style='text-align: left; display: flex; align-items: center;' id='nom_stage'>";
            echo "<h4>";
            echo "<a href='#info_stage" . htmlspecialchars($row['id']) . "' class='text-dark' data-bs-toggle='collapse' aria-expanded='false' aria-controls='info_stage" . htmlspecialchars($row['id']) . "' role='button'>";
            echo htmlspecialchars($row['organisme']) . ", " . htmlspecialchars($row['lieu']);
            echo "</a></h4></div>";

            echo "<div id='info_stage" . htmlspecialchars($row['id']) . "' class='collapse'>";
            echo "<div class='card-body'>";
            echo "<dl class='row'>";
            echo "<dt class='col-sm-3' id='date'><h5>" . htmlspecialchars($row['date']) . "</h5></dt>";
            echo "<dd class='col-sm-9'><strong>Sujet :</strong> " . htmlspecialchars($row['sujet']) . "<br>";
            echo "<strong>Niveau d'études :</strong> " . htmlspecialchars($row['niveau']) . "<br>";

            if (!empty($row['description'])) {
                echo "<strong>Description :</strong> " . htmlspecialchars($row['description']) . "<br>";
            }
            if (!empty($row['contact'])) {
                echo "<strong>Contact :</strong> " . htmlspecialchars($row['contact']) . "<br>";
            }
            if (!empty($row['email'])) {
                echo "<a href='mailto:" . htmlspecialchars($row['email']) . "'>" . htmlspecialchars($row['email']) . "</a> <br>";
            }
            if (!empty($row['fichier'])) {
                echo "<a href='" . htmlspecialchars($row['fichier']) . "'>Lien de l'offre</a> <br>";
            }
            echo "</dd>";
            echo "</dl>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<div class='card' id='resultat'>";
        echo "<div class='card-header' style='text-align: left; display: flex; align-items: center;' id='nom_stage'>";
        echo "<h4>Aucun résultat trouvé</h4>";
        echo "</div>";
        echo "</div>";
    }
} catch (PDOException $e) {
    echo "<div class='alert alert-danger' role='alert'>Erreur lors de la recherche : " . htmlspecialchars($e->getMessage()) . "</div>";
}
?>
