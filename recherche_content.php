<script type="text/javascript" src="jquery-3.6.0.min.js"></script>
<?php
// Connect to the database
require_once('db_conn.php');

// Define the SQL query
$sql = "SELECT sujet, date, niveau, parcours, organisme, contact, email, lieu, description FROM offres";

// Execute the query
$result = $db->query($sql);

// Fetch the results as an array of associative arrays
$internships = $result->fetchAll(PDO::FETCH_ASSOC);

// Calculate the total number of internships
$total_internships = count($internships);

// Set the maximum number of internships to display per page
$internships_per_page = 5;

// Calculate the total number of pages
$total_pages = ceil($total_internships / $internships_per_page);

// Get the current page number from the query string
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculate the index of the first internship to display on the current page
$first_index = ($current_page - 1) * $internships_per_page;

// Slice the internships array to only include the internships for the current page
$internships_on_page = array_slice($internships, $first_index, $internships_per_page);

// Close the database connection
$db = null;
?>

<!-- Search -->
<div class="search">

    <div class="container search-container justify-content-center">

        <div class="row d-flex">

            <div class="col-12">

                <div class="card p-3 py-4 text-center">

                    <h5>L'accès aux informations sur les stages est maintenant plus efficace et plus simple !</h5>
                    <div class="row g-3 mt-2">

                        <div class="col-md-3">

                            <div class="dropdown">

                                <button class="btn btn-secondary btn-lg dropdown-toggle" type="button"
                                    id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    Catégorie
                                </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                    <li>
                                        <a class="dropdown-item" name="flexRadioDefault" role="button"
                                            id="flexRadioDefault1" data-bs-toggle="collapse" data-bs-target="#showSeria"
											aria-expanded="false" aria-controls="showSeria">Offres du
                                            moment</a>
                                    </li>
                                    <hr class="dropdown-divider">
                                    <li>
                                        <a class="dropdown-item" name="flexRadioDefault" role="button"
                                            id="flexRadioDefault2" data-bs-toggle="collapse" data-bs-target="#archives"
											aria-expanded="false" aria-controls="archives">Stages
                                            effectués</a>
                                    </li>

                                </ul>

                            </div>

                        </div>

                        <div class="col-md-6">
                            <input type="text" id="recherche" name="recherche" class="form-control form-control-lg" placeholder="Recherche...">
                        </div>

                        <div class="col-md-3">
                        <button id="search" class="btn btn-secondary btn-lg btn-block" data-bs-toggle="collapse" data-bs-target="#here" role="button"
										aria-expanded="false" aria-controls="here"><i
										class="fa-solid fa-magnifying-glass"></i></button>
                        </div>

                        <div class="col-md-12">
                            <button class="btn btn-secondary btn-lg" type="button" id="delete">
                                Réinitialiser
                            </button>
						</div>

                    </div>

                    <div class="mt-3">

                        <a data-bs-toggle="collapse" data-bs-target="#collapseExample" role="button"
                            aria-expanded="false" aria-controls="collapseExample" class="advanced">
                            Plus de filtres... <i class="fa-solid fa-angle-down"></i>
                        </a>

                        <div class="collapse my-3" id="collapseExample">

                            <div class="card card-body">

                                <div class="row">

                                    <div class="col-md-4">
                                        <input type="text" id="lieu" name="lieu" class="form-control" placeholder="Lieu...">
                                    </div>

                                    <div class="col-md-4">
                                        <input type="text" id="duree" name="duree" class="form-control" placeholder="Durée ou mois...">
                                    </div>

                                    <div class="col-md-4">
                                        <input type="text" id="niveau" name="niveau" class="form-control" placeholder="Année d'études...">
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="col col-sm col-md" id="showSeria">
					<script>
					// displays data from the database corresponding to the current offers scraped and entered manually
						$("#flexRadioDefault1").click(function(){
							$.ajax({
								url: "new_scrap.php",
								success: function (data) {
									$("#showSeria").html(data);
									console.log("Result PHP : " + data);
								},
							});
						});
					</script>
				</div>
				
				<div class="col col-sm col-md" id="archives">
					<script>
					// displays the data from the database corresponding to the internships carried out
						$("#flexRadioDefault2").click(function(){
							$.ajax({
								url: "update2.php",
								success: function(data){
									$("#archives").html(data);
									console.log("Result PHP : " + data);
								}
							});
						});
					</script>
				</div>

                <div class="col col-sm col-md" id="here">
					<script>
					// manages research
					$("#search").click(function(){
						// avoid multiple clicks
						if ($(this).data("clicked")){
							return;
						}
						$(this).data("clicked",true);
						$.ajax({
							url: "search.php",
							method: "post",
							data: { 
									recherche: $("#recherche").val(), 
									lieu: $("input[name='lieu']").val(), 
									duree: $("input[name='duree']").val(), 
									niveau: $("input[name='niveau']").val() 
								},
							success: function(data){
								$("#here").html(data);
								console.log(data);
								$("#search").data("clicked",false);
							},
						});
					});
					</script>
				</div>

				<script>
					// search reset
					$("#delete").click(function(){
						// avoid multiple clicks
						if ($(this).data("clicked")){
							return;
						}
						$(this).data("clicked",true);
						$("#recherche").val("");
						$("input[name='lieu']").val("");
						$("input[name='duree']").val("");
						$("input[name='niveau']").val("");
						$("#here").text("");
						$("#showSeria").text("");
						$("#archives").text("");
						$("#delete").data("clicked",false);
					});
				</script>

            </div>

        </div>

    </div>

</div>