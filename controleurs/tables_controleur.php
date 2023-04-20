<?php 

$message_liste = "";
$message_details = "";

/***********************************/
/* Gestion de la liste des tables */
/***********************************/

$tables = get_tables();

if($tables == null || count($tables) == 0) {
	$message_liste = "Aucune table n'a été trouvée dans la base de données !";
}


/***********************************/
/* Gestion du détail d'une table   */
/***********************************/

if(isset($_POST['boutonAfficher'])) {
	
	$type_vue = mysqli_real_escape_string($connexion, trim($_POST['typeVue']));
	$nom_table = mysqli_real_escape_string($connexion, trim($_POST['nomTable']));
	
	$resultats = get_infos($type_vue, $nom_table);
	if($resultats == null){
		$message_details = "Aucune information disponible sur $type_vue de $nom_table !";
	}else{
		if($type_vue == 'data' && count($resultats) == 0){
			$message_details = "La table $nom_table est vide!";
		}
	}
}

?>
