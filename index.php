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
	
	<?php


		// Récupération des noms des responsables d'école de danse depuis la base de données
		$resultat = mysqli_query($connexion, "SELECT NomFondateur FROM Ecole_De_Danse ORDER BY NomFondateur ASC");

		// Création de la liste déroulante contenant les noms des responsables d'école de danse triés par ordre alphabétique
		echo '<label for="select_responsable">Sélectionnez votre nom :</label>';
		echo '<select id="select_responsable" name="select_responsable">';
		while ($row = mysqli_fetch_array($resultat)) {
			echo '<option value="' . $row['NomFondateur'] . '">' . $row['NomFondateur'] . '</option>';
		}
		echo '</select>';

		 // Récupération des données de l'école de danse sélectionnée
		 $nom_responsable = $_POST['NomFondateur'];
		 $resultat = mysqli_query($connexion, "SELECT * FROM Ecole_De_Danse WHERE NomFondateur = '$nom_responsable'");
		 $ecole = mysqli_fetch_assoc($resultat);
	 
		 // Affichage des informations de l'école de danse
		 echo '<h1>' . $ecole['NomEcole'] . '</h1>';
		 echo '<p>Adresse : ' . $ecole['Adresse'] . '</p>';
	 
		 // Récupération et affichage de la liste des employés de l'école
		 $resultat = mysqli_query($connexion, "SELECT e.nom, e.prenom 
		 FROM Employe e 
		 JOIN travaille t ON e.idEmp = t.idEmp 
		 JOIN Ecole_De_Danse ed ON t.idEcole = ed.idEcole 
		 WHERE ed.NomEcole = 'NomEcole';");

		 echo '<h2>Liste des employés :</h2>';
		 echo '<ul>';
		 while ($employe = mysqli_fetch_assoc($resultat)) {
			 echo '<li>' . $employe['nom'] . ' ' . $employe['prenom'] . '</li>';
		 }
		 echo '</ul>';
	 

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
