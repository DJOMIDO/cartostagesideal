<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Automatic detection of page title -->
    <title>
        <?php echo $title; ?>
    </title>

    <!-- Main CSS File -->
    <link rel="stylesheet" type="text/css" href="styles/style.css">

    <!-- Vendor CSS File -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.css"
        integrity="sha512-FA9cIbtlP61W0PRtX36P6CGRy0vZs0C2Uw26Q1cMmj3xwhftftymr0sj8/YeezDnRwL9wtWw8ZwtCiTDXlXGjQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.locatecontrol/dist/L.Control.Locate.min.css" />

    <!-- Google Fonts -->

</head>

<body>

    <!-- Automatic detection of active page -->
    <?php
    $current_page = "index";
    $request_uri = $_SERVER['REQUEST_URI'];
    if (strpos($request_uri, "carte") !== false) {
        $current_page = "carte";
    } elseif (strpos($request_uri, "recherche") !== false) {
        $current_page = "recherche";
    } elseif (strpos($request_uri, "publier") !== false) {
        $current_page = "publier";
    } elseif (strpos($request_uri, "gestion") !== false) {
        $current_page = "gestion";
    } elseif (strpos($request_uri, "reseau") !== false) {
        $current_page = "reseau";
    } elseif (strpos($request_uri, "faq") !== false) {
        $current_page = "faq";
    }
    ?>

    <header>

        <!-- Navbar -->
        <div class="px-3 py-2 navbar-light u-nav">

            <div class="container">

                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">

                    <!-- Logo -->
                    <a href="index.php"
                        class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none">
                        <img src="images/logo.svg" alt="Logo" style="width:134px; height:85px;">
                    </a>

                    <!-- Nav links -->
                    <ul class="nav col-12 col-lg-auto me-lg-auto my-2 justify-content-center my-md-0">

                        <li>
                            <a href="index.php"
                                class="nav-link <?php echo ($current_page == 'index') ? 'active' : ''; ?>">
                                Accueil
                            </a>
                        </li>

                        <li>
                            <a href="carte.php"
                                class="nav-link <?php echo ($current_page == 'carte') ? 'active' : ''; ?>">
                                Carte
                            </a>
                        </li>

                        <li>
                            <a href="recherche.php"
                                class="nav-link <?php echo ($current_page == 'recherche') ? 'active' : ''; ?>">
                                Recherche
                            </a>
                        </li>

                        <li style="<?php if (!isset($_SESSION['username']) || $_SESSION['username'] != "admin") {
                            echo 'display:none';
                        } ?>">
                            <a href="publier.php" onclick="checkUser()"
                                class="nav-link <?php echo ($current_page == 'publier') ? 'active' : ''; ?>">
                                Publier
                            </a>
                        </li>

                        <li style="<?php if (!isset($_SESSION['username']) || $_SESSION['username'] != "admin") {
                            echo 'display:none';
                        } ?>">
                            <a href="gestion.php"
                                class="nav-link <?php echo ($current_page == 'gestion') ? 'active' : ''; ?>">
                                Gestion
                            </a>
                        </li>

                        <li>
                            <a href="reseau.php"
                                class="nav-link <?php echo ($current_page == 'reseau') ? 'active' : ''; ?>">
                                Réseaux IDL
                            </a>
                        </li>

                        <li>
                            <a href="faq.php" class="nav-link <?php echo ($current_page == 'faq') ? 'active' : ''; ?>">
                                À propos
                            </a>
                        </li>

                    </ul>

                    <!-- To open tabbed Connexion/Inscription Modal -->
                    <div class="text-center">
                        <?php if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) { ?>
                            <a type="button" class="btn btn-outline-dark me-2" id="loginBtn" data-bs-toggle="modal"
                                data-bs-target="#loginModal">Connexion</a>
                        </div>

                    <?php } else { ?>
                        <div class="logged">
                            <div class="d-inline-block"><span style="color: #1e2d4d;">Bienvenue,</span>
                                <span style="color: #e84f10;">
                                    <?= $_SESSION['username'] ?>
                                    <br>
                                </span>
                            </div>
                            <div class="dropdown text-end d-inline-block">
                                <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle"
                                    id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="images/network.png" alt="avatar" width="40" height="40"
                                        class="rounded-circle">
                                </a>
                                <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
                                    <li style="<?php if (!isset($_SESSION['username']) || $_SESSION['username'] != "admin") {
                                        echo 'display:none';
                                    } ?>">
                                        <a class="dropdown-item" href="publier.php" style="color: #1e2d4d;">Publier une
                                            offre</a>
                                        <hr class="dropdown-divider">
                                        <a class="dropdown-item" href="gestion.php" style="color: #1e2d4d;">Gérer les
                                            offres</a>
                                    </li>
                                    <li style="<?php if (!isset($_SESSION['username']) || $_SESSION['username'] != "admin") {
                                        echo 'display:none';
                                    } ?>">
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="logout.php" style="color: #e84f10;">Déconnexion</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    <?php } ?>

                </div>

            </div>

        </div>

    </header>

    <!-- Tabbed Connexion/Inscription Modal -->
    <div class="modal-container u-modal">

        <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel"
            aria-hidden="false">

            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content">

                    <!-- Modal body -->
                    <div class="modal-body">

                        <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">

                            <li class="nav-item">
                                <a class="nav-link active" id="login-tab" data-toggle="tab" href="#login" role="tab"
                                    aria-controls="login" aria-selected="true"><span>
                                        <h4>Connexion</h4>
                                    </span></a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="register-tab" data-toggle="tab" href="#register" role="tab"
                                    aria-controls="register" aria-selected="false"><span>
                                        <h4>Inscription</h4>
                                    </span></a>
                            </li>

                        </ul>

                        <div class="tab-content" id="myTabContent">

                            <!-- Signup -->
                            <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">

                                <form id="registrationForm" method="POST" action="">

                                    <div class="form-group my-3">
                                        <label for="Username">Nom d'utilisateur :</label>
                                        <input type="text" class="form-control" id="Username" name="username"
                                            required />
                                    </div>

                                    <div class="form-group my-3">
                                        <label for="Email">E-Mail :</label>
                                        <input type="email" class="form-control" id="Email" name="email" required />
                                    </div>

                                    <div class="form-group my-3">
                                        <label for="email_confirm">Confirmer votre adresse E-Mail :</label>
                                        <input type="email" class="form-control" id="Email_confirm" name="email_confirm"
                                            required />
                                    </div>

                                    <div class="form-group my-3">
                                        <label for="Password">Mot de passe :</label>
                                        <input type="password" class="form-control" id="Password" name="password"
                                            required />
                                    </div>

                                    <div class="form-group my-3">
                                        <label for="Password_confirm">Confirmer le mot de
                                            passe :</label>
                                        <input type="password" class="form-control" id="Password_confirm"
                                            name="password_confirm" required />
                                    </div>

                                    <div style="text-align:center">
                                        <input type="submit" class="btn btn-primary my-3 mx-auto" id="register_submit"
                                            value="S'inscrire" />
                                    </div>

                                    <div class="form-group my-3">
                                        <div id="message" class="message"></div>
                                    </div>

                                </form>

                            </div>

                            <!-- Login -->
                            <div class="tab-pane fade show active" id="login" role="tabpanel"
                                aria-labelledby="login-tab">

                                <form id="loginForm" method="POST" action="">

                                    <div class="form-group my-3">
                                        <label for="User">Nom d'utilisateur :</label>
                                        <input type="text" class="form-control" id="User" name="user" required />
                                    </div>

                                    <div class="form-group my-3">
                                        <label for="email">E-Mail :</label>
                                        <input type="email" class="form-control" id="Uemail" name="uemail" required />
                                    </div>

                                    <div class="form-group my-3">
                                        <label for="password">Mot de passe :</label>
                                        <input type="password" class="form-control" id="Upassword" name="upassword"
                                            required />
                                    </div>

                                    <div style="text-align:center">
                                        <label for="submit"></label>
                                        <input type="submit" class="btn btn-primary my-3 mx-auto" id="login_submit"
                                            value="Se connecter" />
                                    </div>

                                    <div class="form-group my-3">
                                        <div id="message" class="message"></div>
                                    </div>

                                </form>

                            </div>

                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Content -->
    <?php include $content_file; ?>

    <div class="footer-padding">

        <!-- Footer -->
        <footer class="footer">

            <div class="container">

                <div class="row justify-content-center">
                    <div class="col-md-12 text-center my-3">
                        <a href="index.php" class="logo"><img src="images/logo_white.svg" alt="Logo"
                                style="width:134px; height:85px;"></a>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-md-12 text-center text-white">
                        <p class="copyright">
                            Copyright &copy; 2023 Florine HECQUET & Xiao MA<br>
                            CartoStages IDéaL a été realisé
                            dans le cadre d'un projet professionnel du Master IdL 2021 - 2023
                        </p>
                    </div>
                </div>

            </div>

        </footer>

    </div>

    <!-- Main JS File -->
    <!-- Vendor JS Files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.js"
        integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
        integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
        integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet.locatecontrol/dist/L.Control.Locate.min.js"></script>

</body>

<script>
    // JavaScript to handle switching between login and register forms
    $(document).ready(function () {
        $('#loginModal').on('shown.bs.modal', function () {
            $('#email').trigger('focus')
        });
        $("#myTab a").click(function (e) {
            e.preventDefault();
            $(this).tab("show");
        });
    });

    // JavaScript to handle switching between new offer and archive forms
    $(document).ready(function () {
        // Handle tab click events
        $('a[data-toggle="tab"]').on('click', function (e) {
            e.preventDefault();
            $(this).tab('show');
        });
    });

    // JavaScript to handle new internship offer form submission
    $(document).ready(function () {
        $('#envoyer_nouvelle').on('click', function (e) {
            e.preventDefault();

            // Get form data
            var formData = $('#new-internship-form').serialize();
            // Get the selected radio value
            var level = $('input[name="level"]:checked').val();
            var type = $('input[name="type"]:checked').val();
            var gratification = $('input[name="gratification"]:checked').val();

            // Add the selected radio value to the formData
            formData += '&level=' + encodeURIComponent(level);
            formData += '&type=' + encodeURIComponent(type);
            // If gratification is selected, add it to the formData
            if (gratification) {
                formData += '&gratification=' + gratification;
            }

            // Sending AJAX requests
            $.ajax({
                type: 'POST',
                url: 'submit_new.php',
                data: formData,
                success: function (response) {
                    // Processing Success Response
                    console.log(response);
                    if (response.status === 'success') {
                        $('#message').html(response.message);
                        alert(response.message);
                        $('#new-internship-form')[0].reset();
                    } else {
                        $('#message').html(response.message);
                        alert(response.message);
                    }
                },
                error: function (error) {
                    // Handling error responses
                    console.log(error);
                    $('#message').html(error);
                    alert("Votre demande a échoué, veuillez réessayer plus tard.");
                }
            });
        });
    });

    // JavaScript to handle completed internship offer form submission
    $(document).ready(function () {
        $('#envoyer_effectue').on('click', function (e) {
            e.preventDefault();

            // Get form data
            var formData = $('#completed-internship-form').serialize();
            // Get the selected radio value
            var level = $('input[name="level"]:checked').val();
            var type = $('input[name="type"]:checked').val();

            // Add the selected radio value to the formData
            formData += '&level=' + encodeURIComponent(level);
            formData += '&type=' + encodeURIComponent(type);

            // Sending AJAX requests
            $.ajax({
                type: 'POST',
                url: 'submit_passed.php',
                data: formData,
                success: function (response) {
                    // Processing Success Response
                    console.log(response);
                    if (response.status === 'success') {
                        $('#message').html(response.message);
                        alert(response.message);
                        $('#completed-internship-form')[0].reset();
                    } else {
                        $('#message').html(response.message);
                        alert(response.message);
                    }
                },
                error: function (error) {
                    // Handling error responses
                    console.log(error);
                    $('#message').html(error);
                    alert("Votre demande a échoué, veuillez réessayer plus tard.");
                }
            });
        });
    });

    // login form submission
    $(document).on("click", "#login_submit", function (e) {
        e.preventDefault();

        var user = $("#User").val();
        var email = $("#Uemail").val();
        var password = $("#Upassword").val();

        if (user == "") {
            alert("Veuillez saisir votre nom d'utilisateur !");
        } else if (email == "") {
            alert("Veuillez saisir votre adresse e-mail !");
        } else if (password == "") {
            alert("Veuillez saisir votre mot de passe !");
        } else {
            $.ajax({
                url: "login.php",
                type: "POST",
                data: {
                    usrname: user,
                    usremail: email,
                    usrpassword: password
                },
                success: function (response) {
                    if (response === "success") {
                        $("#message").html(response);
                        //alert("La connexion est réussie !");
                        location.reload();
                    } else {
                        alert("Erreur : " + response);
                    }
                }
            });

            $("#loginForm")[0].reset();
        }
    });

    // register form submission
    $(document).on("click", "#register_submit", function (e) {
        e.preventDefault();

        var username = $("#Username").val();
        var email = $("#Email").val();
        var emailConfirm = $("#Email_confirm").val();
        var password = $("#Password").val();
        var passwordConfirm = $("#Password_confirm").val();

        if (username == "") {
            alert("Veuillez saisir un nom d'utilisateur !");
        } else if (email == "") {
            alert("Veuillez saisir une adresse e-mail !");
        } else if (emailConfirm == "") {
            alert("Veuillez comfirmer votre adresse e-mail !");
        } else if (email != emailConfirm) {
            alert("Les adresses e-mail ne correspondent pas !" + email + " " + emailConfirm);
        } else if (password == "") {
            alert("Veuillez saisir un mot de passe !");
        } else if (passwordConfirm == "") {
            alert("Veuillez comfirmer votre mot de passe !");
        } else if (password != passwordConfirm) {
            alert("Les mots de passe ne correspondent pas !");
        } else {
            $.ajax({
                url: "signup.php",
                type: "POST",
                data: {
                    newusername: username,
                    newemail: email,
                    newpassword: password
                },
                success: function (response) {
                    if (response === "success") {
                        alert("Inscription réussie et vous serez connecté automatiquement !");
                        location.reload();
                    } else {
                        alert("Erreur : " + response);
                    }
                }
            });

            $("#registrationForm")[0].reset();
        }
    });

    // update submission form
    $(document).ready(function () {

        var id;
        // append values into input fields
        $(document).on('click', 'a[data-role=update]', function () {
            id = $(this).data('id');
            var sujet = $('#' + id).children('td[data-target=sujet]').text();
            var date = $('#' + id).children('td[data-target=date]').text();
            var niveau = $('#' + id).children('td[data-target=niveau]').text();
            var parcours = $('#' + id).children('td[data-target=parcours]').text();
            var organisme = $('#' + id).children('td[data-target=organisme]').text();
            var contact = $('#' + id).children('td[data-target=contact]').text();
            var email = $('#' + id).children('td[data-target=email]').text();
            var dumas = $('#' + id).children('td[data-target=dumas]').text();
            var archives = $('#' + id).find('td[data-target=archives] input[type=checkbox]').prop('checked') ? 1 : 0;
            var effectue = $('#' + id).find('td[data-target=effectue] input[type=checkbox]').prop('checked') ? 1 : 0;

            $('#sujet').val(sujet.trim());
            $('#date').val(date.trim());
            $('#niveau').val(niveau.trim());
            $('#parcours').val(parcours.trim());
            $('#organisme').val(organisme.trim());
            $('#contact').val(contact.trim());
            $('#email').val(email.trim());
            $('#dumas').val(dumas.trim());
            $('#archives').prop('checked', archives == '1');
            $('#effectue').prop('checked', effectue == '1');
            $('#offreId').val(id);
            $('#updateModal').modal('toggle');
        });

        // now create event to get data from fields and update in database

        $('#valider').click(function () {

            var sujet = $('#sujet').val();
            var date = $('#date').val();
            var niveau = $('#niveau').val();
            var parcours = $('#parcours').val();
            var organisme = $('#organisme').val();
            var contact = $('#contact').val();
            var email = $('#email').val();
            var dumas = $('#dumas').val();
            var archives = $('#archives').prop('checked') ? 1 : 0;
            var effectue = $('#effectue').prop('checked') ? 1 : 0;
            console.log(effectue);

            $.ajax({
                url: 'update.php',
                method: 'POST',
                data: {
                    sujet: sujet, date: date, niveau: niveau, parcours: parcours, organisme: organisme, contact: contact, email: email, dumas: dumas, archives: archives, effectue: effectue, id: id
                },
                success: function (response) {
                    console.log(response);
                    alert('Mise à jour réussie ！');
                    $('#updateModal').modal('hide');
                    location.reload();
                }

            })

        });
    });

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
    //var internships = < ?= json_encode($internships) ?>;
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

</html>