<!-- Post -->
<div class="u-publier">

    <div class="card-container container">

        <div class="row">

            <div class="col-12 my-3">

                <div class="card my-3" id="publiercard">

                    <div class="card-header">

                        <ul class="nav nav-tabs card-header-tabs justify-content-center">

                            <li class="nav-item">
                                <a class="nav-link active" href="#new-internship-tab" data-toggle="tab" onclick="openTab(event, 'new-internship-tab')"><span>
                                        <h4>Nouvelle offre</h4>
                                    </span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#archived-internships-tab" data-toggle="tab" onclick="openTab(event, 'archived-internships-tab')"><span>
                                        <h4>Stages effectués</h4>
                                    </span>
                                </a>
                            </li>

                        </ul>

                    </div>

                    <div class="card-body">

                        <div class="tab-content">

                            <div class="tab-pane active" id="new-internship-tab">

                                <form id="new-internship-form">

                                    <div class="form-group my-3">
                                        <label for="level">Niveau d'étude * :</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="level" id="M1"
                                                value="Master 1" required>
                                            <label class="form-check-label" for="M1">M1</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="level" id="M2"
                                                value="Master 2" required>
                                            <label class="form-check-label" for="M2">M2</label>
                                        </div>
                                    </div>


                                    <div class="form-group my-3">

                                        <label for="type">Parcours * : </label>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="type" id="Recherche"
                                                value="Recherche" required>
                                            <label class="form-check-label" for="recherche">Recherche</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="type" id="Professionnel"
                                                value="Professionnel" required>
                                            <label class="form-check-label" for="professionnel">Professionnel</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="type" id="Unspecified"
                                                value="Recherche/Professionnel" required>
                                            <label class="form-check-label" for="unspecified">Non spécifié</label>
                                        </div>
                                    </div>

                                    <div class="form-group my-3">
                                        <label for="sujet">Sujet du stage * : </label>
                                        <input type="text" class="form-control" name="sujet" id="Sujet" required>
                                    </div>

                                    <div class="form-group my-3">
                                        <label for="duree">Durée * : </label>
                                        <input type="text" class="form-control" name="duree" id="Duree" required>
                                    </div>

                                    <div class="form-group my-3">
                                        <label for="lieu">Lieu * : </label>
                                        <input type="text" class="form-control" name="lieu" id="Lieu" required>
                                    </div>

                                    <div class="form-group my-3">
                                        <label for="organisme">Organisme * : </label>
                                        <input type="text" class="form-control" name="organisme" id="Organisme"
                                            required>
                                    </div>

                                    <div class="form-group my-3">
                                        <label for="contact">Contact * : </label>
                                        <input type="text" class="form-control" name="contact" id="Contact" required>
                                    </div>

                                    <div class="form-group my-3">
                                        <label for="email">Email : </label>
                                        <input type="email" class="form-control" name="email" id="Email">
                                    </div>

                                    <div class="form-group my-3">

                                        <label for="gratification">Gratifié : </label>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gratification" id="Oui"
                                                value="Gratifié">
                                            <label class="form-check-label" for="oui">Oui</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gratification" id="Non"
                                                value="Non gratifié">
                                            <label class="form-check-label" for="non">Non</label>
                                        </div>

                                    </div>

                                    <div class="form-group my-3">
                                        <label for="detail-du-stage">Détail du stage * : </label>
                                        <textarea class="form-control" name="description" id="Description" rows="3"
                                            required></textarea>
                                    </div>

                                    <div class="form-group my-3">
                                        <label for="profil-souhaite">Profil souhaité : </label>
                                        <textarea class="form-control" name="critere" id="Critere" rows="3"></textarea>
                                    </div>

                                    <div class="form-group my-3">
                                        <label for="date">Date de publication de l'offre * : </label>
                                        <input type="date" class="form-control" name="date" id="Date" rows="3" required>
                                    </div>

                                    <div class="my-3" style="text-align:center">
                                        <input type="submit" class="btn btn-primary" value="Envoyer"
                                            id="envoyer_nouvelle" />
                                    </div>

                                    <div class="form-group my-3">
                                        <div id="message" class="message"></div>
                                    </div>

                                </form>

                            </div>

                            <div class="tab-pane" id="archived-internships-tab">

                                <form id="completed-internship-form">

                                    <div class="form-group my-3">

                                        <label for="level">Niveau d'étude * : </label>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="level" id="M1"
                                                value="Master 1" required>
                                            <label class="form-check-label" for="M1">M1</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="level" id="M2"
                                                value="Master 2" required>
                                            <label class="form-check-label" for="M2">M2</label>
                                        </div>

                                    </div>

                                    <div class="form-group my-3">

                                        <label for="type">Parcours * : </label>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="type" id="Recherche"
                                                value="Recherche" required>
                                            <label class="form-check-label" for="Recherche">Recherche</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="type" id="Professionnel"
                                                value="Professionnel" required>
                                            <label class="form-check-label" for="Professionnel">Professionnel</label>
                                        </div>

                                    </div>

                                    <div class="form-group my-3">
                                        <label for="sujet">Sujet du stage * : </label>
                                        <input type="text" class="form-control" name="sujet" id="Sujet" required>
                                    </div>

                                    <div class="form-group my-3">
                                        <label for="duree">Durée * :</label>
                                        <input type="text" class="form-control" name="duree" id="Duree" required>
                                    </div>

                                    <div class="form-group my-3">
                                        <label for="lieu">Lieu * : </label>
                                        <input type="text" class="form-control" name="lieu" id="Lieu" required>
                                    </div>

                                    <div class="form-group my-3">
                                        <label for="organisme">Organisme * : </label>
                                        <input type="text" class="form-control" name="organisme" id="Organisme"
                                            required>
                                    </div>

                                    <div class="form-group my-3">
                                        <label for="contact">Contact * : </label>
                                        <input type="text" class="form-control" name="contact" id="Contact" required>
                                    </div>

                                    <div class="form-group my-3">
                                        <label for="email">Email * : </label>
                                        <input type="email" class="form-control" name="email" id="Email" required>
                                    </div>

                                    <div class="form-group my-3">
                                        <label for="détail-du-stage">Détail du stage * : </label>
                                        <textarea class="form-control" name="description" id="Description" rows="3"
                                            required></textarea>
                                    </div>

                                    <div class="form-group my-3">
                                        <label for="dumas">Lien vers Dumas : </label>
                                        <input type="text" class="form-control" name="dumas" id="Dumas">
                                    </div>

                                    <div class="form-group my-3">
                                        <label for="date">Date de publication de l'offre * : </label>
                                        <input type="date" class="form-control" id="Date" name="date" rows="3" required>
                                    </div>

                                    <div class="my-3" style="text-align:center">
                                        <input type="submit" class="btn btn-primary" value="Envoyer"
                                            id="envoyer_effectue" />
                                    </div>

                                    <div class="form-group my-3">
                                        <div id="message" class="message"></div>
                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>