<?php
	// Connect to the database
	require_once('db_conn.php');
	
	// retrieval of data entered and management of different spellings
	$recherche = addslashes("%" . $_POST['recherche']. "%");
	$lieu = addslashes("%" . $_POST['lieu']. "%");
	$duree = addslashes("%" . $_POST['duree']. "%");
	$niveau = addslashes("%" . $_POST['niveau']. "%");
	
	// preparation of the request
	$query = "SELECT * FROM offres ";
	$where = "";
	
	// checking for empty fields and creating the query accordingly
	if(!empty($recherche)){
		$where = "WHERE `sujet` LIKE '$recherche'";
	} else {
		$where = "";
	}
	if(!empty($lieu)){
		if(!empty($where)){
			$where = $where . " AND `lieu` LIKE '$lieu'";
		} else {
			$where = $where . "WHERE `lieu` LIKE '$lieu'";
		}
	}
	if(!empty($duree)){
		if(!empty($where)){
			$where = $where . " AND `duree` LIKE '$duree'";
		} else {
			$where = $where . "WHERE `duree` LIKE '$duree'";
		}
	}
	if(!empty($niveau)){
		if(!empty($where)){
			$where = $where . " AND `niveau` LIKE '$niveau'";
		} else {
			$where = $where . "WHERE `niveau` LIKE '$niveau'";
		}
	}
	$query .= $where;
	$query .= " AND `Archives` = 0 AND `effectue` = 0 ORDER BY `date` DESC";
	
	$stmt = $db->prepare($query);
	
	// checking the values ​​present in the variables
	if ($recherche != "") {
		$stmt->bindParam('$recherche', $recherche);
		} else {
		echo "Erreur : Echec de l'appel à bindParam pour :recherche\n";
	}
	
	if ($lieu != "") {
		$stmt->bindParam('$lieu', $lieu);
		} else {
		echo "Erreur : Echec de l'appel à bindParam pour :lieu\n";
	}

	if ($duree != "") {
		$stmt->bindParam('$duree', $duree);
		} else {
		echo "Erreur : Echec de l'appel à bindParam pour :duree\n";
	}

	if ($niveau != "") {
		$stmt->bindParam('$niveau', $niveau);
		} else {
		echo "Erreur : Echec de l'appel à bindParam pour :niveau\n";
	}
	
	// query execution
	// echo "Requête : " . $stmt->queryString . PHP_EOL;
	$stmt->execute();
	$data = $stmt->fetchAll();
	
	// display of results
	if (count($data) > 0){
	
		echo "<div class='text-center my-3'> <div class = 'text-white'> <h4> Voici les résultats de votre recherche :</h4></div></div>";
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
						echo "<dd class='col-sm-9'><strong>Sujet :</strong> ".$row['sujet']. "<br> <strong>Niveau d'études :</strong> " .$row['niveau']. "<br>";
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
						echo "</dd>";
						echo "</dl>";
					echo "</div>";
				echo "</div>";
			echo "</div>"; 
		} 
	} else {
		echo "<div class='card' id = 'resultat'>";
			echo "<div class='card-header' style='text-align: left; display: flex; align-items: center;' id='nom_stage'>";
				echo "<h4>Aucun résultat trouvé</h4>";
			echo "</div>";
		echo "</div>";
	}	
	
?>