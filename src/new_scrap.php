<?php
// Connect to the database
require_once('db_conn.php');

// Get the directory paths
require_once('config.php');

$i = 0;
$niveau = "";
$duree = "";

// Scan the text files directory
if (is_dir(TEXT_FILES_PATH)) {
    $dh = opendir(TEXT_FILES_PATH);
    while (($file = readdir($dh)) !== false) {
        // Process only non-directory files
        if (!is_dir($file)) {
            $hfic = fopen(TEXT_FILES_PATH . "/$file", "r");
            $path = "text_files/$file";
            while ($ligne = fgets($hfic)) {
                if (strpos($ligne, "Titre: ") !== false) {
                    $i = $i + 1;
                    $nom = str_replace("Titre: ", "", trim($ligne));
                    $nom = str_replace("'", "''", $nom);
                }
                if (strpos($ligne, "Date: ") !== false) {
                    $date = str_replace("Date: ", "", trim($ligne));
                }
                if (strpos($ligne, "Organisme: ") !== false) {
                    $commanditaire = str_replace("Organisme: ", "", trim($ligne));
                    $commanditaire = str_replace("'", "''", $commanditaire);
                }
                if (strpos($ligne, "Lieu: ") !== false) {
                    $lieu = str_replace("Lieu: ", "", trim($ligne));
                    $lieu = str_replace("'", "''", $lieu);
                }
                if (preg_match("/(?i)m1|master1|master 1|Master 1 ou 2|bac\+4|bac \+ 4|Bac \+4/", $ligne)) {
                    if (strstr($niveau, "Master 1") == false) {
                        $niveau = "Master 1";
                    }
                }
                if (preg_match('/(?i)m2|master2|master 2|Master 1 ou 2|bac\+5|bac \+ 5|Bac \+5/', $ligne)) {
                    if (strstr($niveau, "Master 2") == false) {
                        $niveau = "Master 2";
                    }
                }
                if (preg_match("/(?i)janvier|fvrier|\bmars\b|avril|\bmai\b|\bjuin\b|juillet|aot|septembre|octobre|novembre|dcembre|january|february|\bmarch\b|april|\bmay\b|june|july|august|september|october|november|december/", $ligne)) {
                    if (strstr($duree, $ligne) == false) {
                        $duree = str_replace("'", "''", trim($ligne));
                    }
                }
            }
            fclose($hfic);

            // Default values for missing fields
            $parcours = "Non spécifié";
            $description = "Aucune description";
            $critere = "Non spécifié";
            $contact = "Non spécifié";
            $email = "contact@example.com";
            $gratification = "Non précisé";
            $dumas = "Aucun";
            $archives = 0;
            $effectue = 0;

            // Check if the offer already exists
            $query = "SELECT * FROM offres WHERE sujet = '$nom'";
            $result = $db->query($query);

            if ($result->rowCount() == 0) {
                // Insert the new offer
                $query = "INSERT INTO offres (sujet, organisme, duree, niveau, parcours, lieu, fichier, description, critere, contact, email, gratification, date, dumas, archives, effectue) 
                          VALUES ('$nom', '$commanditaire', '$duree', '$niveau', '$parcours', '$lieu', '$path', '$description', '$critere', '$contact', '$email', '$gratification', '$date', '$dumas', $archives, $effectue)";
                $db->exec($query);
            }
        }
    }
}

// Fetch and display the results from the database
$newoffre = "SELECT * FROM offres WHERE archives = 0 AND effectue = 0 ORDER BY date DESC";
$stmt = $db->prepare($newoffre);
$stmt->execute();
$data = $stmt->fetchAll();

echo "<div class='text-center my-3'><div class='text-white'><h4>Voici la liste des offres actuelles :</h4></div></div>";

foreach ($data as $row) {
    echo "<div class='card' id='resultat'>";
    echo "<div class='card-header' style='text-align: left; display: flex; align-items: center;' id='nom_stage'>";
    echo "<h4>";
    echo "<a href='{$row['fichier']}' class='text-dark' data-bs-toggle='collapse' data-bs-target='#info_stage{$row['id']}' aria-expanded='false' aria-controls='info_stage' role='button'>{$row['organisme']}, {$row['lieu']}</a>";
    echo "</h4>";
    echo "</div>";

    echo "<div id='info_stage{$row['id']}' class='collapse' data-bs-toggle='collapse'>";
    echo "<div class='card-body'>";
    echo "<dl class='row'>";
    echo "<dt class='col-sm-3' id='date'><h5>{$row['date']}</h5></dt>";
    echo "<dd class='col-sm-9'><strong>Sujet :</strong> {$row['sujet']}<br><strong>Niveau d'études :</strong> {$row['niveau']}<br>";
    if ($row['description']) {
        echo "<strong>Description :</strong> {$row['description']}<br>";
    }
    if ($row['contact']) {
        echo "<strong>Contact :</strong> {$row['contact']}<br>";
    }
    if ($row['email']) {
        echo "<a href='mailto:{$row['email']}'>{$row['email']}</a><br>";
    }
    if ($row['fichier']) {
        echo "<a href='{$row['fichier']}'>Lien de l'offre</a><br>";
    }
    echo "</dd>";
    echo "</dl>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
}

?>
