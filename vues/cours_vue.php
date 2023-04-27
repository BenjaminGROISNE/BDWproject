<?php
$idEcole = $_SESSION['idecole'];
$liste_cours = mysqli_query($connexion, 'SELECT C.Libelle,C.Age,C.code FROM Cours C JOIN delivre D ON D.codeCours=C.code AND D.idEc="' . $idEcole . '"');
$cours = mysqli_fetch_all($liste_cours, MYSQLI_ASSOC);

echo '<form method="post">';
echo '<label for="liste_cours">Sélectionnez le cours :</label>';
echo '<select id="liste_cours" name="liste_cours">';

foreach ($cours as $row) {
    echo '<option value="' . $row['Libelle'] . '">' . $row['Libelle'] . '</option>';
}

echo '</select>';
echo '<button type="submit" name="submitcours">Valider</button>';
echo '</form>';

if (isset($_POST['submitcours'])) {
    $cours = $_POST['liste_cours'];
    $query = 'SELECT Age FROM Cours WHERE Libelle="' . $cours . '"';
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

if (isset($_POST['supprCours'])) {
    $code = '';
    foreach ($cours as $row) {
        if ($row['Libelle'] == $_POST['liste_cours']) {
            $code = $row['code'];
            break;
        }
    }
    if (!empty($code)) {
        $query = 'DELETE FROM delivre WHERE codeCours="' . $code . '" AND idEc="' . $idEcole . '" ';
        $result = mysqli_query($connexion, $query);
        if ($result) {
            echo "Le cours a été supprimé avec succès.";
        } else {
            echo "Erreur lors de la suppression du cours.";
        }
    }
}
?>