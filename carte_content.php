<?php
//Connect to the database
require_once('db_conn.php');

// Define the SQL query
$sql = "SELECT * FROM offres WHERE archives = 1 ORDER BY date DESC";

// Execute the query
$result = $db->query($sql);

// Fetch the results as an array of associative arrays
$internships = $result->fetchAll(PDO::FETCH_ASSOC);

function getLatLong($address)
{
    $client_id = "e6Qx7sPyr4ACE8HFFuS9enqo-WrSvQY2WmObpxwyCQE";
    $url = "https://nominatim.openstreetmap.org/search?format=json&q=" . urlencode($address) . "&limit=1&addressdetails=1&client_id=" . $client_id;
    $opts = array(
        'http' => array(
            'method' => 'GET',
            'header' => "User-Agent: My PHP Script\r\n"
        )
    );
    $context = stream_context_create($opts);
    $response = file_get_contents($url, false, $context);
    $data = json_decode($response);
    if (!empty($data)) {
        return array(
            'lat' => $data[0]->lat,
            'lng' => $data[0]->lon
        );
    }
    return null;
}

// Loop through each internship and add lat/long data
foreach ($internships as &$internship) {
    $address = $internship['lieu']; // Use the organization name as the address
    $latlng = getLatLong($address);
    if ($latlng != null) {
        $internship['lat'] = $latlng['lat'];
        $internship['lng'] = $latlng['lng'];
    }
}

// Close the database connection
$db = null;
?>

<style>
    #mapid {
        min-height: 80vh;
    }
</style>

<div id="mapid">
</div>

<script>
    // Map
    var mymap = L.map("mapid").setView([45.195076, 5.768331], 13);

    // Add positioning controls
    L.control
        .locate({
            icon: "fa fa-location-arrow",
            position: "bottomright",
            flyTo: true,
            cacheLocation: true,
            drawCircle: false,
            follow: false,
            setView: "untilPan",
            keepCurrentZoomLevel: false,
            showPopup: false,
            strings: {
                title: "Show my location",
                metersUnit: "meters",
                feetUnit: "feet",
                popup: "You are within {distance} {unit} from this point",
                outsideMapBoundsMsg: "You seem located outside the boundaries of the map",
            },
        })
        .addTo(mymap);

    // Set the default center point of the map layer
    var address = "621 avenue Centrale, 38400 Saint-Martin-d'Hères, France";
    var url =
        "https://nominatim.openstreetmap.org/search?format=json&q=" + address;
    fetch(url)
        .then((response) => response.json())
        .then((data) => {
            var latlng = [data[0].lat, data[0].lon];
            mymap.setView(latlng, 13);
        })
        .catch((error) => {
            console.error("Error:", error);
        });

    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution:
            'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
        maxZoom: 18,
    }).addTo(mymap);

    // Loop through each internship and add a marker with a popup
    var internships = <?= json_encode($internships) ?>;
    internships.forEach(function (internship) {
        if (internship.lat && internship.lng) { // Only add markers for internships with lat/long data
            var marker = L.marker([internship.lat, internship.lng]).addTo(mymap);
            var popupContent = "<strong>" + internship.sujet + "</strong><br>" +
                "Organisme: " + internship.organisme + "<br>" +
                "Niveau: " + internship.niveau + "<br>" +
                "Parcours: " + internship.parcours + "<br>" +
                "Contact: " + internship.contact + "<br>" +
                "Email: " + internship.email;
            marker.bindPopup(popupContent);
        }
    });
</script>