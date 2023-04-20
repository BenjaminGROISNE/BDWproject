<?php
/* Page principale dont le contenu s'adaptera dynamiquement*/
session_start();                      // démarre ou reprend une session
/* Gestion de l'affichage des erreurs */
ini_set('display_errors', 1);         
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL); 

/* Inclusion des fichiers contenant : ...  */          
require('inc/config-bd.php');  /* ... la configuration de connexion à la base de données */
require('inc/includes.php');   /* ... les constantes et variables globales */
require('modele/modele.php');  /* ... la définition du modèle */

/* Création de la connexion ( initiatilisation de la variable globale $connexion )*/
open_connection_DB(); 
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    
    <!-- le titre du document, qui apparait dans l'onglet du navigateur -->
    <title>BDWebAdmin</title>
    
    <!-- lien vers le style CSS externe  -->
    <link href="css/style.css" rel="stylesheet" media="all" type="text/css">
    
    <!-- lien vers une image favicon (qui apparaitra dans l'onglet du navigateur) -->
    <link rel="shortcut icon" type="image/x-icon" href="img/bd.png" />
</head>
<body>
    <?php 

    /* Inclusion de la partie Entête (Header)*/
    include('static/header.php');
    
    /* Inclusion du menu*/
	include('static/menu.php'); 
	?>
	

    <!-- Définition du bloc proncipal -->
     	
		<main class="main_div">
		<?php
		/* Initialisation du contrôleur et le de vue par défaut */
		$controleur = 'accueil_controleur.php';
		$vue = 'accueil_vue.php'; 
		
		/* Affectation du controleur et de la vue souhaités */
		if(isset($_GET['page'])) {
			// récupération du paramètre 'page' dans l'URL
			$nomPage = $_GET['page'];
			// construction des noms de con,trôleur et de vue
			$controleur = $nomPage . '_controleur.php';
			$vue = $nomPage . '_vue.php';
		}
		/* Inclusion du contrôleur et de la vue courante */
		include('controleurs/' . $controleur);
		include('vues/' . $vue );
		?>
		</main>

    <?php
    /* Inclusion de la partie Pied de page*/ 
    include('static/footer.php'); 
    ?>
</body>
</html>
