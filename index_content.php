<!--Main layout-->
<section class="bg-image sec1"
    style="background-image: url(images/bg1.jpg); background-size: cover; background-position: center;">
    <div class="container text-white text-center"
        style="display: flex; align-items: center; justify-content: center; height: 100%; flex-direction: column;">
        <p class="fs-1 lh-base">Vous cherchez un stage ?
            <br>
            &
            <br>
            <span class="fw-bold">
                Vos stages de rêve sont ici.
            </span>
        </p>
        <p class="fs-4 fst-italic">Ce site est là pour vous aider à affiner vos recherches, à vous renseigner et à vous
            mettre
            en relation avec
            un réseau en IdL</p>
        <a type="button" href="#sec2" class="btn btn-outline-primary btn-lg rounded-pill">C'EST PARTI</a>
    </div>
</section>

<section class="container-fluid bg-image sec2" id="sec2"
    style="background-image: url(images/bg2.jpg); background-size: cover; background-position: center;">
    <div class="container">
        <div class="row row-cols-1 row-cols-md-2">
            <!-- Carte -->
            <div class="col">
                <div class="card justify-content-center align-items-center u-dark">
                    <div class="card-header my-3">
                        <div class="icon">
                            <img src="images/map.png" style="height: 70px; width: 70px;">
                        </div>
                    </div>
                    <div class="card-body text-white" style="text-align:center">
                        <h4 class="card-title">CARTE</h4>
                        <p class="card-text">Les offres de stage autour de moi</p>
                    </div>
                    <div class="card-footer">
                        <a href="carte.php" class="btn">
                            <img src="images/arrow.png" style="width: 60px;">
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recherche -->
            <div class="col">
                <div class="card justify-content-center align-items-center u-light">
                    <div class="card-header my-3">
                        <div class="icon">
                            <img src="images/search.png" style="height: 70px; width: 70px;">
                        </div>
                    </div>
                    <div class="card-body text-white" style="text-align:center">
                        <h4 class="card-title">RECHERCHE</h4>
                        <p class="card-text">Trouve-moi mon coup de cœur </p>
                    </div>
                    <div class="card-footer">
                        <a href="recherche.php" class="btn">
                            <img src="images/arrow.png" style="width: 60px;">
                        </a>
                    </div>
                </div>
            </div>

            <!-- Publier -->
            <div class="col" style="<?php if (!isset($_SESSION['username']) || $_SESSION['username'] != "admin") {
                echo 'display:none';
            } ?>">
                <div class="card justify-content-center align-items-center u-light">
                    <div class="card-header my-3">
                        <div class="icon">
                            <img src="images/plus.png" style="height: 70px; width: 70px;">
                        </div>
                    </div>
                    <div class="card-body text-white" style="text-align:center">
                        <h4 class="card-title">PUBLIER</h4>
                        <p class="card-text">Une offre à partager, c'est ici</p>
                    </div>
                    <div class="card-footer">
                        <a href="publier.php" class="btn" onclick="checkLogin()">
                            <img src="images/arrow.png" style="width: 60px;">
                        </a>
                    </div>
                </div>
            </div>

            <!-- Réseau Talien -->
            <div class="col">
                <div class="card justify-content-center align-items-center u-dark">
                    <div class="card-header my-3">
                        <div class="icon">
                            <img src="images/network.png" style="height: 70px; width: 70px;">
                        </div>
                    </div>
                    <div class="card-body text-white" style="text-align:center">
                        <h4 class="card-title">RÉSEAUX IDL</h4>
                        <p class="card-text">Besoin d'informations sur un stage</p>
                    </div>
                    <div class="card-footer">
                        <a href="reseau.php" class="btn">
                            <img src="images/arrow.png" style="width: 60px;">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-image sec3"
    style="background-image: url(images/bg1.jpg); background-size: cover; background-position: center;">
    <div class="container text-white text-center"
        style="display: flex; align-items: center; justify-content: center; height: 100%; flex-direction: column;">
        <p class="fs-1 lh-base">Comment CartoStages IDéaL fonctionne ?
        </p>
        <p class="fs-4"> Choisissez votre mode de recherche favori, consultez les offres qui vous
            correspondent, postulez !
            Accédez aux précédents mémoires et rapports de stages, et à des informations utiles sur les anciens stages
            réalisés.
            Connectez-vous pour publier une nouvelle offre de stage.
        </p>
        <a type="button" href="faq.php" class="btn btn-outline-primary btn-lg rounded-pill">EN SAVOIR PLUS</a>
    </div>
</section>