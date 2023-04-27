<?php
    // Vérifier si l'identifiant de l'école a été spécifié
    echo'  <form method="post" action="">';
    echo ' <label for="NumeroVoie">Numéro et voie :</label>';
    echo '<input type="text" id="NumeroVoie" name="NumeroVoie" required>';
    echo ' <br><br>';

    echo '<label for="Rue">Rue :</label>';
    echo ' <input type="text" id="Rue" name="Rue" required>';
    echo '<br><br>';
    
    echo ' <label for="Ville">Ville :</label>';
    echo '<input type="text" id="Ville" name="Ville" required>';
    echo '<br><br>';
    
    echo' <label for="Code_Postal">Code Postal :</label>';
    echo ' <input type="text" id="Code_Postal" name="Code_Postal" required>';
    echo ' <br><br>';
    
    echo ' <label for="Pays">Pays :</label>';
    echo '<input type="text" id="Pays" name="Pays" required>';
    echo ' <br><br>';
    echo  '<input type="submit" value="Valider">';
  echo '</form>';

  echo'  <form method="post" action="">';
    echo ' <label for="nomFondateur">NomFondateur:</label>';
    echo '<input type="text" id="nomFondateur" name="nomFondateur" required>';
    echo ' <br><br>';
    echo  '<input type="submit" value="Valider">';
    
  echo '</form>';
  echo'  <form method="post" action="">';
  echo ' <label for="nomEcole">NomEcole :</label>';
  echo '<input type="text" id="nomEcole" name="nomEcole" required>';
  echo ' <br><br>';
  echo  '<input type="submit" value="Valider">';
  echo '</form>';
  
  $id_ecole = $_SESSION['idecole'];

  if (isset($_POST['nomEcole'])){
    $nameEcole=$_POST['nomEcole'];
    echo $nameEcole;
    $query = 'UPDATE Ecole_De_Danse E SET E.NomEcole="'.$nameEcole.'" WHERE E.idEcole="'.$id_ecole.'"';

    $result = mysqli_query($connexion, $query);
  }

  if (isset($_POST['nomFondateur'])){
    $nameFondateur=$_POST['nomFondateur'];
    echo $nameFondateur;
    $query = 'UPDATE Ecole_De_Danse E SET E.NomFondateur="'.$nameFondateur.'" WHERE E.idEcole="'.$id_ecole.'"';

    $result = mysqli_query($connexion, $query);
  }

  if (isset($_POST['NumeroVoie']) && isset($_POST['Rue']) && isset($_POST['Ville']) && isset($_POST['Code_Postal']) && isset($_POST['Pays'])) {
    $NumeroVoie = $_POST['NumeroVoie'];
    $Rue = $_POST['Rue'];
    $Ville = $_POST['Ville'];
    $Code_Postal = $_POST['Code_Postal'];
    $Pays = $_POST['Pays'];
    
    echo $NumeroVoie ;
    echo $Rue;
    echo $Ville;
    echo $Code_Postal;
    echo $Pays ;
    echo $id_ecole ;
    
    $query = 'UPDATE Adresse A JOIN Ecole_De_Danse E ON A.idAdresse=E.idAdresse SET A.NumeroVoie="'.$NumeroVoie.'", A.Rue="'.$Rue.'", A.Ville="'.$Ville.'", A.Code_Postal="'.$Code_Postal.'", A.Pays="'.$Pays.'" WHERE E.idEcole="'.$id_ecole.'"';
    $result = mysqli_query($connexion, $query);

    // Vérifier si la mise à jour a réussi
    if ($result) {
        echo "L'adresse a été mise à jour avec succès.";
    } else {
        echo "Une erreur est survenue lors de la mise à jour de l'adresse.";
        echo mysqli_error($connexion);
    }
  }
?>