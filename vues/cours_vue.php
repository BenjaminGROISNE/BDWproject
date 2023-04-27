<?php
$fonda=$_SESSION['fondateur'];
$idEcole = $_SESSION['idecole'];
$idEmp=mysqli_query($connexion, 'SELECT DISTINCT idEmp FROM travaille WHERE idEcole="'.$idEcole.'"');
$idEmp=mysqli_fetch_assoc($idEmp);
$liste_cours = mysqli_query($connexion, 'SELECT C.Libelle, C.Age, C.code FROM Cours C JOIN delivre D ON D.codeCours=C.code AND D.idEc="' . $idEcole . '"');
$cours = mysqli_fetch_all($liste_cours, MYSQLI_ASSOC);

echo '<form method="post">';
echo '<label for="liste_cours">Sélectionnez le cours :</label>';
echo '<select id="liste_cours" name="liste_cours">';

foreach ($cours as $row) {
    echo '<option value="' . $row['code'] . '">' . $row['Libelle'] . '</option>';
}

echo '</select>';
echo '<button type="submit" name="submitcours">Valider</button>';
echo '</form>';

if (isset($_POST['submitcours'])) {
    $code = $_POST['liste_cours'];
    $_SESSION['code']=$code;
    $query = 'SELECT Age FROM Cours WHERE code="' . $code . '"';
    $result = mysqli_query($connexion, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $age = $row['Age'];
        echo "Age: " . $age;
    } else {
        echo "Erreur: le cours sélectionné n'a pas d'âge spécifié.";
    }

    echo '<form method="post">';
    echo '<button type="submit" name="supprCours">SupprimerCours</button>';
    echo '</form>';
}
if(isset($_POST['supprCours'])) {
    $code=$_SESSION['code'];
    $query = "DELETE FROM delivre WHERE codeCours='" . $code . "' AND idEc='" . $idEcole . "'";
    $result = mysqli_query($connexion, $query);
    if ($result) {
        echo "Le cours a été supprimé avec succès.";
    } else {
        echo "Erreur lors de la suppression du cours.";
    }
}


echo '<form method="post">';
echo '<label for="libelle">Libellé :</label>';
echo '<input type="text" id="libelle" name="libelle">';
echo '<label for="age">Âge :</label>';
echo '<input type="text" id="age" name="age">';
echo '<button type="submit" name="ajoutCours">Ajouter Cours</button>';
echo '</form>';

// Si le formulaire est soumis, traiter les données
if (isset($_POST['ajoutCours'])) {
    // Récupérer les valeurs soumises
    $libelle = $_POST['libelle'];
    $age = $_POST['age'];

    // Ajouter le cours à la base de données
    $query = 'INSERT INTO Cours (Libelle, Age) VALUES ("' . $libelle . '", "' . $age . '")';
    $result = mysqli_query($connexion, $query);
  /*  
        if ($result) {
            // Si l'ajout a réussi, ajouter la ligne correspondante à la table delivre
            $code = mysqli_insert_id($connexion);
            $query = 'INSERT INTO delivre (codeCours,idEmploye, idEc,annee) VALUES ("' . $code . '","' . $idEmp . '", "' . $idEcole . '",2001)';
            $result = mysqli_query($connexion, $query);
            
            if ($result) {
                echo "Le cours a été ajouté avec succès.";
            } else {
                echo "Erreur lors de l'ajout de la ligne correspondante à la table delivre : " . mysqli_error($connexion);
            }
        } else {
            echo "Erreur lors de l'ajout du cours à la table Cours : " . mysqli_error($connexion);
        }
        */
    }


?>