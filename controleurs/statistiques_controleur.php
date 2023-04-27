<?php 
$message = "";
echo'<link href="css/style.css" rel="stylesheet" media="all" type="text/css">';
// recupération de la liste des tables
$stats = get_statistiques();

if($stats == null || count($stats) == 0) {
	$message .= "Aucune statistique n'est disponible!";
}
else{
	$nbTables = 0;
	$nbTuples = 0;

	 foreach($stats as $s) {
		
	 	$nbTables++;
	 	$nbTuples += intval($s['table_rows']);

	 	$stats = array('nbTables' => $nbTables, 'nbTuples' => $nbTuples );
	 	}
}

$query = "SELECT 
COUNT(DISTINCT Federation.IdFede) AS nbFed, 
COUNT(DISTINCT CASE WHEN Comite.Niveau = 'reg' THEN Comite.idComite END) AS nbCR, 
COUNT(DISTINCT CASE WHEN Comite.Niveau = 'dept' THEN Comite.idComite END) AS nbCD
FROM 
Federation 
LEFT JOIN Ecole_De_Danse ON Federation.IdFede = Ecole_De_Danse.IdFede 
LEFT JOIN Comite ON Federation.IdFede = Comite.IdFede";
$result = mysqli_query($connexion, $query);

if ($result) {
	echo '<ul class="stats-list">';
	$result_stats = mysqli_fetch_assoc($result);
	echo '<li>Number of Federations: ' . $result_stats['nbFed'] . '</li>';
	echo '<li>Number of Regional Committees: ' . $result_stats['nbCR'] . '</li>';
	echo '<li>Number of Departmental Committees: ' . $result_stats['nbCD'] . '</li>';
	echo '</ul>';
}

$query = "SELECT 
   CASE 
      WHEN Adresse.Code_Postal LIKE '97%' THEN LEFT(Adresse.Code_Postal, 3) 
      ELSE LEFT(Adresse.Code_Postal, 2) 
   END AS Code_Departement, 
   COUNT(DISTINCT Ecole_De_Danse.IdEcole) AS Nb_Ecoles
FROM 
   Ecole_De_Danse 
   INNER JOIN Adresse ON Ecole_De_Danse.idAdresse = Adresse.idAdresse 
GROUP BY 
   Code_Departement";

$result = mysqli_query($connexion, $query);

if ($result) {
    echo '<table>';
    echo '<tr><th>Département</th><th>Nombre d\'écoles de danse</th></tr>';

    while ($row = mysqli_fetch_array($result)) {
        echo '<tr>';
        echo '<td>' . $row['Code_Departement'] . '</td>';
        echo '<td>' . $row['Nb_Ecoles'] . '</td>';
        echo '</tr>';
    }

    echo '</table>';
}

if ($result) {
	echo '<ul class="stats-list">';
	while ($result_stats = mysqli_fetch_assoc($result)) {
		echo '<li>Number of Dance Schools in Department ' . $result_stats['Code_Departement'] . ': ' . $result_stats['Nb_Ecoles'] . '</li>';
	}
	echo '</ul>';
} 

// Requête SQL
$query = "SELECT Libelle
FROM Comite
WHERE Niveau = 'reg' AND IdFede = (SELECT IdFede FROM Federation WHERE Nom = 'Fédération Française de Danse')
ORDER BY Libelle DESC";

$result = mysqli_query($connexion, $query);

if ($result) {
    echo '<form method="post" >';
    echo '<label for="select_region">Liste des regions:</label>';
    echo '<select id="select_region" name="select_region">';

    while ($row = mysqli_fetch_array($result)) {
        echo '<option value="' . $row['Libelle'] . '">' . $row['Libelle'] . '</option>';
    }

    echo '</select>';
    echo '</form>';
}
?>
