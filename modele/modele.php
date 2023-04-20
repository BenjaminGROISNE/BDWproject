<?php 

/*
Structure de données permettant de manipuler une base de données :
- Gestion de la connexion
----> Connexion et déconnexion à la base
- Accès au dictionnaire
----> Liste des tables et statistiques
- Informations (structure et contenu) d'une table
----> Schéma et instances d'une table
- Traitement de requêtes
----> Schéma et instances résultant d'une requête de sélection
*/



////////////////////////////////////////////////////////////////////////
///////    Gestion de la connxeion   ///////////////////////////////////
////////////////////////////////////////////////////////////////////////

/**
 * Initialise la connexion à la base de données courante (spécifiée selon constante 
	globale SERVEUR, UTILISATEUR, MOTDEPASSE, BDD)			
 */
function open_connection_DB() {
	global $connexion;

	$connexion = mysqli_connect(SERVEUR, UTILISATEUR, MOTDEPASSE, BDD);
	if (mysqli_connect_errno()) {
	    printf("Échec de la connexion : %s\n", mysqli_connect_error());
	    exit();
	}
}

/**
 *  	Ferme la connexion courante
 * */
function close_connection_DB() {
	global $connexion;

	mysqli_close($connexion);

}


////////////////////////////////////////////////////////////////////////
///////   Accès au dictionnaire       ///////////////////////////////////
////////////////////////////////////////////////////////////////////////

/**
 *  Retourne la liste des tables définies dans la base de données courantes
 * */
function get_tables() {
	global $connexion;

	$requete = "SELECT table_name FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA LIKE '". BDD ."'";

	$res = mysqli_query($connexion, $requete);
	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);
	return $instances;
}


/**
 *  Retourne les statistiques sur la base de données courante
 * */
function get_statistiques() {
	global $connexion;

	$requete = "SELECT table_name, table_rows FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA LIKE '". BDD ."'";
	$res = mysqli_query($connexion, $requete);
	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);
	return $instances;
}

////////////////////////////////////////////////////////////////////////
///////    Informations (structure et contenu) d'une table    //////////
////////////////////////////////////////////////////////////////////////

/**
 *  Retourne le détail des infos sur une table
 * */
function get_infos( $typeVue, $nomTable ) {
	global $connexion;

	switch ( $typeVue) {
		case 'schema': return get_infos_schema( $nomTable ); break;
		case 'data': return get_infos_instances( $nomTable ); break;
		default: return null; 
	}
}

/**
 * Retourne le détail sur le schéma de la table
*/
function get_infos_schema( $nomTable ) {
	global $connexion;

	// récupération des informations sur la table (schema + instance)
	$requete = "SELECT * FROM $nomTable";
	$res = mysqli_query($connexion, $requete);

	// construction du schéma qui sera composé du nom de l'attribut et de son type	
	$schema = array( array( 'nom' => 'nom_attribut' ), array( 'nom' => 'type_attribut' ) , array('nom' => 'clé')) ;

	// récupération des valeurs associées au nom et au type des attributs
	$metadonnees = mysqli_fetch_fields($res);

	$infos_att = array();
	foreach( $metadonnees as $att ){
		//var_dump($att);

 		$is_in_pk = ($att->flags & MYSQLI_PRI_KEY_FLAG)?'PK':'';
 		$type = convertir_type($att->{'type'});

		array_push( $infos_att , array( 'nom' => $att->{'name'}, 'type' => $type , 'cle' => $is_in_pk) );	
	}

	return array('schema'=> $schema , 'instances'=> $infos_att);

}

/**
 * Retourne les instances de la table
*/
function get_infos_instances( $nomTable ) {
	global $connexion;

	// récupération des informations sur la table (schema + instance)
	$requete = "SELECT * FROM $nomTable";  
 	$res = mysqli_query($connexion, $requete);  

 	// extraction des informations sur le schéma à partir du résultat précédent
	$infos_atts = mysqli_fetch_fields($res); 

	// filtrage des information du schéma pour ne garder que le nom de l'attribut
	$schema = array();
	foreach( $infos_atts as $att ){
		array_push( $schema , array( 'nom' => $att->{'name'} ) ); // syntaxe objet permettant de récupérer la propriété 'name' du de l'objet descriptif de l'attribut courant
	}

	// récupération des données (instances) de la table
	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);

	// renvoi d'un tableau contenant les informations sur le schéma (nom d'attribut) et les n-uplets
	return array('schema'=> $schema , 'instances'=> $instances);

}


function convertir_type( $code ){
	switch( $code ){
		case 1 : return 'BOOL/TINYINT';
		case 2 : return 'SMALLINT';
		case 3 : return 'INTEGER';
		case 4 : return 'FLOAT';
		case 5 : return 'DOUBLE';
		case 7 : return 'TIMESTAMP';
		case 8 : return 'BIGINT/SERIAL';
		case 9 : return 'MEDIUMINT';
		case 10 : return 'DATE';
		case 11 : return 'TIME';
		case 12 : return 'DATETIME';
		case 13 : return 'YEAR';
		case 16 : return 'BIT';
		case 246 : return 'DECIMAL/NUMERIC/FIXED';
		case 252 : return 'BLOB/TEXT';
		case 253 : return 'VARCHAR/VARBINARY';
		case 254 : return 'CHAR/SET/ENUM/BINARY';
		default : return '?';
	}

}

////////////////////////////////////////////////////////////////////////
///////    Traitement de requêtes                             //////////
////////////////////////////////////////////////////////////////////////

/**
 * Retourne le résultat (schéma et instances) de la requ$ete $requete
 * */
function executer_une_requete( $requete ) {
	
	//TODO
	global $connexion;

	// récupération des informations sur la table (schema + instance)
 	$res = mysqli_query($connexion, $requete);  
	
	if(!$res) {
		// query failed, return error message
		return array('erreur'=> mysqli_error($connexion));
	}

 	// extraction des informations sur le schéma à partir du résultat précédent
	$infos_atts = mysqli_fetch_fields($res); 

	// filtrage des information du schéma pour ne garder que le nom de l'attribut
	$schema = array();
	foreach( $infos_atts as $att ){
		array_push( $schema , array( 'nom' => $att->{'name'} ) ); // syntaxe objet permettant de récupérer la propriété 'name' du de l'objet descriptif de l'attribut courant
	}

	// récupération des données (instances) de la table
	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);

	if(count($instances) == 0) {
		// no result, return message
		return array('message'=> 'Aucun résultat.');
	}

	// renvoi d'un tableau contenant les informations sur le schéma (nom d'attribut) et les n-uplets
	return array('schema'=> $schema , 'instances'=> $instances);
}


?>
