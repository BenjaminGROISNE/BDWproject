   <?php
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
    echo ' <label for="nomFondateur">NomFondateur:</label>';
    echo '<input type="text" id="nomFondateur" name="nomFondateur" required>';
    echo ' <br><br>';
    echo ' <label for="nomEcole">NomEcole :</label>';
    echo '<input type="text" id="nomEcole" name="nomEcole" required>';
    echo ' <br><br>';

    echo  '<input type="submit" value="Valider">';
  echo '</form>';


  ?>