<?php
// Connect to the database
require_once('db_conn.php');

try {
    // Retrieve internship data from database
    $query = "SELECT sujet, organisme, niveau, parcours, contact, email, lieu, lat, lng FROM offres WHERE archives = 0 AND effectue = 0";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $internships = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des données : " . $e->getMessage();
    exit;
}
?>

<div id="mapid" style="height: 80vh;">Chargement de la carte...</div>

<script>
    // Check if Leaflet library is loaded
    if (typeof L === 'undefined') {
        alert("Erreur : La bibliothèque Leaflet n'a pas été chargée correctement !");
    } else {
        // Map initialization with default center (France)
        var mymap = L.map("mapid").setView([46.603354, 1.888334], 6);

        // Add OpenStreetMap tile layer
        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 18,
        }).addTo(mymap);

        // Retrieve internship data from PHP
        var internships = <?= json_encode($internships) ?>;

        // Check if internship data exists and is not empty
        if (Array.isArray(internships) && internships.length > 0) {
            internships.forEach(function (internship) {
                if (internship.lat && internship.lng) {
                    // Create marker with popup
                    var marker = L.marker([parseFloat(internship.lat), parseFloat(internship.lng)]).addTo(mymap);
                    var popupContent = "<strong>" + internship.sujet + "</strong><br>" +
                        "Organisme: " + internship.organisme + "<br>" +
                        "Niveau: " + internship.niveau + "<br>" +
                        "Parcours: " + internship.parcours + "<br>" +
                        "Contact: " + internship.contact + "<br>" +
                        "Email: <a href='mailto:" + internship.email + "'>" + internship.email + "</a>";
                    marker.bindPopup(popupContent);
                } else {
                    console.warn("Coordonnées manquantes pour : " + internship.sujet);
                }
            });
        } else {
            console.warn("Aucune donnée de stage disponible.");
        }
    }
</script>
