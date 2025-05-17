<?php
// Connect to the database
require_once('db_conn.php');

// Define the SQL query
$sql = "SELECT id, sujet, date, niveau, parcours, organisme, contact, email, dumas, archives, effectue FROM offres ORDER BY date DESC";

// Execute the query
$result = $db->query($sql);

// Fetch the results as an array of associative arrays
$internships = $result->fetchAll(PDO::FETCH_ASSOC);

// Close the database connection
$db = null;
?>

<div class="container-fluid u-gestion">
    <div class="table-responsive">
        <table class="table table-light table-striped table-hover align-middle caption-top" id="updateTable"
            method="POST">
            <caption class="text-center text-white fs-3 fw-bolder">Toutes les offres de stage disponibles dans la
                base de
                données...</caption>
            <thead>
                <tr>
                    <th scope="col">Sujet</th>
                    <th scope="col">Date</th>
                    <th scope="col">Niveau d'études</th>
                    <th scope="col">Parcours</th>
                    <th scope="col">Organisme</th>
                    <th scope="col">Contact</th>
                    <th scope="col">E-Mail</th>
                    <th scope="col">Dumas</th>
                    <th scope="col">Archivage</th>
                    <th scope="col">Effectué</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop through the array and display each internship as a row in the table -->
                <?php foreach ($internships as $internship): ?>
                    <tr id="<?php echo $internship['id']; ?>">
                        <td data-target="sujet">
                            <?php echo $internship['sujet']; ?>
                        </td>
                        <td data-target="date">
                            <?php echo $internship['date']; ?>
                        </td>
                        <td data-target="niveau">
                            <?php echo $internship['niveau']; ?>
                        </td>
                        <td data-target="parcours">
                            <?php echo $internship['parcours']; ?>
                        </td>
                        <td data-target="organisme">
                            <?php echo $internship['organisme']; ?>
                        </td>
                        <td data-target="contact">
                            <?php echo $internship['contact']; ?>
                        </td>
                        <td data-target="email">
                            <a href="mailto:?to=<?php echo $internship['email']; ?>" target="_blank">
                                <?php echo $internship['email']; ?>
                            </a>
                        </td>
                        <td data-target="dumas">
                            <a href="<?php echo $internship['dumas']; ?>" target="_blank">
                                <?php echo $internship['dumas']; ?>
                            </a>
                        </td>
                        <td data-target="archives">
                            <?php echo $internship['archives']; ?>
                        </td>
                        <td data-target="effectue">
                            <?php echo $internship['effectue']; ?>
                        </td>
                        <td>
                            <a href="#updateModal" data-role="update" data-id="<?php echo $internship['id']; ?>">MaJ</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Mise à jour</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="recipient-name" class="col-form-label">Sujet :</label>
                    <input type="text" class="form-control" id="sujet">
                </div>
                <div class="form-group mb-3">
                    <label for="message-text" class="col-form-label">Date :</label>
                    <input class="form-control" id="date"></input>
                </div>
                <div class="form-group mb-3">
                    <label for="message-text" class="col-form-label">Niveau :</label>
                    <input class="form-control" id="niveau"></input>
                </div>
                <div class="form-group mb-3">
                    <label for="message-text" class="col-form-label">Parcours :</label>
                    <input class="form-control" id="parcours"></input>
                </div>
                <div class="form-group mb-3">
                    <label for="message-text" class="col-form-label">Organisme :</label>
                    <input class="form-control" id="organisme"></input>
                </div>
                <div class="form-group mb-3">
                    <label for="message-text" class="col-form-label">Contact :</label>
                    <input class="form-control" id="contact"></input>
                </div>
                <div class="form-group mb-3">
                    <label for="message-text" class="col-form-label">Email :</label>
                    <input class="form-control" id="email"></input>
                </div>
                <div class="form-group mb-3">
                    <label for="message-text" class="col-form-label">Dumas :</label>
                    <input class="form-control" id="dumas"></input>
                </div>
                <div class="form-group mb-3">
                    <label for="message-text" class="form-check-label">Archives :</label>
                    <input type="checkbox" class="form-check-input" name="Archives" id="archives" value="1"></input>
                </div>
                <div class="form-group mb-3">
                    <label for="message-text" class="form-check-label">Effectue :</label>
                    <input type="checkbox" class="form-check-input" name="Effectue" id="effectue" value="1"></input>
                </div>
                <input type="hidden" id="offreID" class="form-control">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary float-start" data-bs-dismiss="modal">Fermer</button>
                <a href="#" id="valider" type="button" class="btn btn-primary float-end">Valider</a>
            </div>
        </div>
    </div>
</div>