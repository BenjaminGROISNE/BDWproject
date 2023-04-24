
<?php
// Récupération des noms des responsables d'école de danse depuis la base de données
$resultat = mysqli_query($connexion, "SELECT NomFondateur FROM Ecole_De_Danse ORDER BY NomFondateur ASC");
 // Création du formulaire avec la liste déroulante contenant les noms des responsables d'école de danse triés par ordre alphabétique
 echo '<form method="post">';
 echo '<label for="select_responsable">Sélectionnez votre nom :</label>';
 echo '<select id="select_responsable" name="select_responsable">';

 while ($row = mysqli_fetch_array($resultat)) {
     echo '<option value="' . $row['NomFondateur'] . '">' . $row['NomFondateur'] . '</option>';
 }
 
 echo '</select>';
 echo '<button type="submit" name="submitFond">Valider</button>';
 echo '</form>';
?>

