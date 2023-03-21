<?php
	// Connect to the database
	require_once('db_conn.php');
	
	// displays the results from newest to oldest on the html page
	$archive = "SELECT * FROM `offres` WHERE `effectue` = 1 and `archives` = 0 ORDER BY `date` DESC";
	$stmt = $db->prepare($archive);
	$stmt->execute();
	$data = $stmt->fetchAll();
	
	echo "<div class='text-center my-3'> <div class = 'text-white'> <h4> Voici la liste des stages effectués :</h4></div></div>";
	foreach ($data as $row){
		echo "<div class='card' id = 'resultat'>";
			echo "<div class='card-header' style='text-align: left; display: flex; align-items: center;' id='nom_stage'>";
			echo "<h4>";
			echo "<a href='" .$row['id']."' class = 'text-dark' data-bs-toggle='collapse' data-bs-target='#info_stage" .$row['id']."' aria-expanded='false' aria-controls='info_stage' role='button'>".$row['organisme']. ", " .$row['lieu']."</a>";
			echo "</h4>";
			echo "</div>";

			echo "<div id='info_stage" .$row['id']."' class='collapse' data-bs-toggle='collapse'>";
				echo "<div class='card-body'>";
					echo "<dl class='row'>";
					echo "<dt class='col-sm-3' id = 'date'> <h5>".$row['date']."</h5></dt>";
					echo "<dd class='col-sm-9'> <strong>Sujet :</strong> ".$row['sujet']. "<br> <strong>Niveau d'études :</strong> " .$row['niveau']. "<br>";
					if ($row['description']){
						echo "<strong>Description :</strong> " .$row['description']. "<br>";
					}
					if ($row['contact']){
						echo "<strong>Contact :</strong> " .$row['contact']. "<br>";
					}
					if ($row['email']){
						echo "<a href='mailto:?to={$row['email']}'>{$row['email']}</a> <br>";
					} 
					if ($row['fichier']){
						echo "<a href='{$row['fichier']}'>Lien de l'offre</a> <br>";
					} 
					if ($row['dumas']){
						echo "<a href='{$row['dumas']}'>{$row['dumas']}</a>";
					}
					echo "</dd>";
					echo "</dl>";
				echo "</div>";
			echo "</div>";
		echo "</div>";                                
	}

?>