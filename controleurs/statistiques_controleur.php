<?php 
$message = "";

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
?>
