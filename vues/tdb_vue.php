<?php
 if(isset($_POST['submitFond'])) {
   
    // Récupération de l'ID de l'école de danse sélectionnée
    $nom_responsable = $_POST['select_responsable'];
    $resultat_id = mysqli_query($connexion, "SELECT idEcole FROM Ecole_De_Danse WHERE NomFondateur = '$nom_responsable'");
    $ecole_id = mysqli_fetch_assoc($resultat_id)['idEcole'];
    $_SESSION['idecole']=$ecole_id;
    $_SESSION['fondateur']=$nom_responsable;
    // Récupération des données de l'école de danse sélectionnée
    $resultat_ecole = mysqli_query($connexion, "SELECT * FROM Ecole_De_Danse E JOIN Adresse A ON E.idAdresse = A.idAdresse WHERE E.idEcole = $ecole_id");
    $ecole = mysqli_fetch_assoc($resultat_ecole);

    // Récupération des employés de l'école de danse sélectionnée
    $resultat_employes = mysqli_query($connexion, "SELECT DISTINCT E.nom, E.prenom FROM Employe E JOIN travaille T ON E.idEmp = T.idEmp WHERE T.idEcole = $ecole_id");
    $liste_cours = mysqli_query($connexion,"SELECT C.Libelle,C.Age FROM Cours C JOIN delivre D ON D.codeCours=C.code AND D.idEc=$ecole_id");


         echo '<a href="index.php?page=tdb&page=info">Modifier InfoEcole </a>';
         echo '<a href="index.php?page=tdb&page=cours">Modifier Cours </a>';
         echo '<a href="index.php?page=tdb&page=ajoutEcole">ajouter Ecole </a>';

    //récupération de la liste de cours 
    echo '<ul>';
    echo '<p>Cours proposés :</p>';
    while ($cours = mysqli_fetch_assoc($liste_cours)) {
        echo '<li>' . $cours['Libelle'] . '</li>';
    }
    echo '</ul>';
    // Affichage du nom et de l'adresse de l'école
    echo '<div style="display: flex;">';
    echo '<div style="width: 50%;">';
    echo '<h3>' . $ecole['NomEcole'] . '</h3>';

    echo '<p><b>Adresse :</b></p>';
    echo '<p>' . $ecole['NumeroVoie'] . ' ' . $ecole['Rue'] . '</p>';
    echo '<p>' . $ecole['Code_Postal'] . ' ' . $ecole['Ville'] . '</p>';
    echo '</div>';
 
    // Affichage de la liste des employés de l'école de danse
    echo '<div style="width: 50%;">';
    echo '<p><b>Liste des employés :</b></p>';
    echo '<ul>';
    while($employe = mysqli_fetch_assoc($resultat_employes)) {
        echo '<li>' . $employe['prenom'] . ' ' . $employe['nom'] . '</li>';
    }
    echo '</ul>';
    echo '</div>';
    echo '</div>';

    // Récupération du nombre d'adhérents pour les 3 dernières années
    $annee_actuelle = date('Y');
    $annee_min = $annee_actuelle - 2;
    $nombre_adherents = array();

    for ($annee = $annee_actuelle; $annee >= $annee_min; $annee--) {
        $resultat_adherents = mysqli_query($connexion, "SELECT COUNT(*) as nombre_adherents FROM Adherent WHERE numEcole = $ecole_id AND anneeAdhesion = $annee");
        $adherents = mysqli_fetch_assoc($resultat_adherents);
        $nombre_adherents[$annee] = $adherents['nombre_adherents'];
    }

    // Affichage des résultats
    foreach ($nombre_adherents as $annee => $nombre) {
        echo '<p>Le nombre d\'adhérents pour l\'année ' . $annee . ' est : ' . $nombre . '</p>';
    }
}

if (isset($_POST['submitFond'])){
    echo '</form>';
    echo'  <form method="post" action="index.php?page=tdb">';
    echo ' <label for="SupprEcole">SupprimerEcole :</label>';
    echo  '<input type="submit" name="SupprEcole" value="SupprEcole">';
    echo '</form>';
}

?>

