<?php
    // Insérer la nouvelle adresse

  if (isset($_POST['NumeroVoie']) && isset($_POST['Rue']) && isset($_POST['Ville']) && isset($_POST['Code_Postal']) && isset($_POST['nomEcole']) && isset($_POST['nomFondateur'])) {
    $NumeroVoie = $_POST['NumeroVoie'];
    $Rue = $_POST['Rue'];
    $Ville = $_POST['Ville'];
    $Code_Postal = $_POST['Code_Postal'];
    $nomEcole = $_POST['nomEcole'];
    $nomFondateur = $_POST['nomFondateur'];
    
    //INSERE et vérifie que l'adresse n'est pas déjà présente
    $query = 'INSERT INTO Adresse(NumeroVoie, Rue, Ville, Code_Postal)
    SELECT DISTINCT "'.$NumeroVoie.'", "'.$Rue.'", "'.$Ville.'", "'.$Code_Postal.'"
    FROM Adresse
    WHERE NOT EXISTS (
        SELECT 1
       FROM Adresse
       WHERE NumeroVoie="'.$NumeroVoie.'" AND Rue="'.$Rue.'" AND Ville="'.$Ville.'" AND Code_Postal="'.$Code_Postal.'"
    )';
        
    $result = mysqli_query($connexion, $query);
   
   if ($result) {
        $idAdresse = mysqli_insert_id($connexion);
        echo $idAdresse;
        
        $query='INSERT INTO Ecole_De_Danse(NomEcole,NomFondateur,idFede,idAdresse) SELECT DISTINCT "'.$nomEcole.'","'.$nomFondateur.'",1,"'.$idAdresse.'"
        FROM Ecole_De_Danse
        WHERE NOT EXISTS (
            SELECT 1
              FROM Ecole_De_Danse
              WHERE NomEcole="'.$nomEcole.'" AND NomFondateur="'.$nomFondateur.'" AND idFede=1 AND idAdresse="'.$idAdresse.'"
           )';
        
        $result2 = mysqli_query($connexion, $query);
        
        if ($result2) {
            echo 'L\'école de danse a été ajoutée avec succès !';
        } else {
            echo 'Impossible d\'ajouter l\'école de danse.';
        }
   } else {
       echo 'Cette adresse est déjà présente dans la base de données.';
   }
}
?> 