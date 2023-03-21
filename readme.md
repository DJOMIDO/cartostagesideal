# CartoStages IDéaL

## L'URL : http://i3l.univ-grenoble-alpes.fr/~maxiao/cartostagesideal
## ID et mot de passe Admin :
### Login : admin
### Email : admin@cartostages.com
### Mdp : 123456
## Outils utilisés
### Front-end
Bootstrap 5.0.2
FontAwesome 6.2.1
Leaflet 1.9.3
OpenStreetMap
jQuery 3.6.3

### Back-end
PHP 8.2
Python 3.9.6
phpMyAdmin 5.2.1
## Struture du site
------ readme.md
------ text_files (Fichiers textutels sortant du webscrapeur)
------------ Linkedin0.txt
------------ Linkedin1.txt
------------ Linkedin_.txt
------------ Stage1.txt
------------ Stage2.txt
------------ Stage_.txt
------ fichier_html (Affichage des offres de stage plus propre)
------------ Linkedin0.html
------------ Linkedin1.html
------------ Linkedin_.html
------------ Stage1.html
------------ Stage2.html
------------ Stage_.html
------ images (Les images utilisées dans ce projet)
------------ logo.svg
------------ logo_white.svg
------------ map.png
------------ search.png
------------ plus.png
------------ network.png
------------ arrow.png
------------ bg1.png
------------ bg2.png
------------ discord.png
------------ linkedin.png
------------ facebook.png
------ styles (CSS général)
------------ style.css
------ template.php (Fichier contenant les éléments communs 'hearder' et 'footer')
------ index.php (Page d'accueil du site)
------ index_content.php (Page contenant les contenus de la page Index)
------ carte.php (Page de carte intéractive du site)
------ carte_content.php (Page contenant les contenus de la page Carte)
------ recherche.php (Page de la recherche des offres de stage du site)
------ recherche_content.php (Page contenant les contenus de la page Recherche)
------ publier.php (Page de la publication de nouvelle offre de stage et stage effectué par l'administrateur)
------ publier_content.php (Page contenant les contenus de la page Publier)
------ gestion.php (Page servant à mettre à jours des stages par l'administrateur)
------ gestion_content.php (Page contenant les contenus de la page Gestion)
------ reseau.php (Page affichant l'accès aux réseaux sociaux de Master IdL)
------ reseau_content.php (Page contenant les contenus de la page Réseaux)
------ faq.php (Page de foire aux questions / nous contacter 'non fonctionnel' du site)
------ faq_content.php (Page contenant les contenus de la page Faq)
------ db_conn.php (Fichier PHP pour la connexion à la base de données)
------ signup.php (Fichier PHP pour l'inscription des utilisateurs)
------ login.php (Fichier PHP pour la connexion des utilisateurs)
------ logout.php (Fichier PHP pour la déconnexion)
------ search.php (Ficher PHP pour la recherche statique)
------ new_scrap.php (Fichier PHP pour extraire des informations des fichiers text et les enregistrer dans la base de données, et requêter les offres actuelles)
------ submit_new.php (Ficher PHP pour l'enregistrement manuel des nouvelles offres de stage)
------ submit_passed.php (Ficher PHP pour l'enregistrement manuel des stages effectués)
------ update.php (Ficher PHP pour la mise à jour des stages depuis la page Gestion)
------ update2.php (Ficher PHP pour l'affichage des stages effectué sur la page Recherche)
------ webscrapeur.py (Fichier Python qui récupère les offres de stages depuis plusieurs sources : LinkedIn, http://w3.erss.univ-tlse2.fr/membre/tanguy/offres.html, Indeed 'non fonctionnel')

