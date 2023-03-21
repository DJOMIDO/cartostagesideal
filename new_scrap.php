<?php
	// Connect to the database
	require_once('db_conn.php');
	
	// get webscraping results
	$dir = "/home/IdL/2021/maxiao/public_html/cartostagesideal/text_files";
	$i = 0;
	$niveau = "";
	$duree = "";
	
	if (is_dir($dir)) {
		$dh = opendir($dir);
		while (($file = readdir($dh)) !== false) {
			// get information from textfiles
			if (!is_dir($file)) {
				$hfic = fopen("$dir/$file", "r");
				$path = "text_files/$file";
				while ($ligne = fgets($hfic)) {
					if (strpos($ligne, "Titre: ") !== false) {
						$i = $i + 1;
						$nom = str_replace("Titre: ", "", $ligne);
						$nom = str_replace("'","''",$nom);
					}
					if (strpos($ligne, "Date: ") !== false) {
						$date = str_replace("Date: ", "", $ligne);
					}
					if (strpos($ligne, "Organisme: ") !== false) {
						$commanditaire = str_replace("Organisme: ", "", $ligne);
						$commanditaire = str_replace("'","''",$commanditaire);
					}
					if (strpos($ligne, "Lieu: ") !== false) {
						$lieu = str_replace("Lieu: ", "", $ligne);
						$lieu = str_replace("'","''",$lieu);
					}
					
					if (preg_match("/(?i)m1|master1|master 1|Master 1 ou 2|bac\+4|bac \+ 4|Bac \+4/", $ligne)) {
						if (strstr($niveau, "Master 1") == false) {
							$niveau = $niveau . "Master 1 ";
						}
					}
					if (preg_match('/(?i)m2|master2|master 2|Master 1 ou 2|bac\+5|bac \+ 5|Bac \+5/', $ligne)) {
						if (strstr($niveau, "Master 2") == false) {
							$niveau = $niveau . "Master 2 ";
						}
					}
					if (preg_match("/(?i)janvier|février|\bmars\b|avril|\bmai\b|\bjuin\b|juillet|août|septembre|octobre|novembre|décembre|january|february|\bmarch\b|april|\bmay\b|june|july|august|september|october|november|december/", $ligne)) {
						if (strstr($duree, $ligne) == false) {
							$duree = $duree . $ligne ;
						}
					}
				}
				$duree = str_replace("'","''",$duree);
				// write in the database
				$query = "SELECT * FROM offres WHERE sujet = '$nom'";
				$result = $db->query($query);
				if ($result->rowCount() == 0) {
					$query = "INSERT INTO `offres` (`id`, `sujet`, `organisme`, `duree`, `lieu`, `niveau`, `date`, `fichier`) VALUES ($i, '$nom', '$commanditaire', '$duree', '$lieu', '$niveau', '$date', '$path')";
					$db->exec($query);
					$query = "UPDATE `offres` SET `fichier` = CONCAT(SUBSTRING_INDEX(REPLACE(`fichier`, 'text_files', 'fichier_html'), '.', 1), '.html') WHERE `fichier` LIKE '%.txt' AND `fichier` LIKE 'text_files%'";
					$db->exec($query);
					// $query = "UPDATE `offres` SET `fichier` = REPLACE (`fichier`, 'text_files', 'fichier_html') WHERE `fichier` LIKE 'text_files%'";
					// $db->exec($query);
					// $query = "UPDATE `offres` SET `fichier` = CONCAT(SUBSTRING_INDEX (`fichier`, '.', 1), '.html') WHERE `fichier` LIKE '%.txt'";
					// $db->exec($query);
				}
			}
		}
	}
	
	// displays the results from newest to oldest on the html page
	$newoffre = "SELECT * FROM `offres` WHERE `archives` = 0 and `effectue` = 0 ORDER BY `date` DESC";
	$stmt = $db->prepare($newoffre);
	$stmt->execute();
	$data = $stmt->fetchAll();
	
	echo "<div class='text-center my-3'> <div class = 'text-white'> <h4> Voici la liste des offres actuelles :</h4></div></div>";
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
					echo "</dd>";
					echo "</dl>";
				echo "</div>";
			echo "</div>";
		echo "</div>";                                
	}
	
?>