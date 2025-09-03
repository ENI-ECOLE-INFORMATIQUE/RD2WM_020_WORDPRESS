<?php
/**
* Classe en charge de mettre en place des fonctions pour la base de données pour les blagues ou les citations.
* @package eniBlagueCitation
* @version 0.6
* @since 0.2
* @author Denis - Stagiaires
*/

/**
* Retourne le nombre total de blagues ou de citations présentes dans la base de données.
* @return nombre de blagues.
*/
function nombreDeBlaguesCitationsTotal(){
	//Variable globale de wordpress pour utiliser une connexion a la base de données.
	global $wpdb;
	$table_eniBlague=$wpdb->prefix.'eniBlague';
	
	$sql = $wpdb->prepare("SELECT count(blague) as count FROM ".$table_eniBlague,"");
	$countBlague=$wpdb->get_results($sql);
	return $countBlague[0]->count;
	
}

/**
* Retourne la liste des blagues ou des citations présentes dans la BD.
* @return list contenant les blagues ou les citations.
*/
function getBlaguesCitationsList(){
	global $wpdb;
	$table_eniBlague=$wpdb->prefix.'eniBlague';
	$sql = $wpdb->prepare("SELECT * FROM ".$table_eniBlague,"");
	$blaguesCitationsList = $wpdb->get_results($sql);
	return $blaguesCitationsList;
}
/**
* Retourne une blague ou une citation en fonction de son id.
* @param id identifiant de la blague.
* @return blague
*/
function getBlagueCitationById($id){
	global $wpdb;
	$table_eniBlague=$wpdb->prefix.'eniBlague';
	$sql = $wpdb->prepare("SELECT * FROM ".$table_eniBlague." WHERE id=%d LIMIT 1",$id);
	$blagueCitation = $wpdb->get_results($sql);
	return $blagueCitation;
}

/**
* Retourne une blague ou une citation en fonction du nom de la blague.
* Ce nom sera cherché dans la colonne blague, description ou motscles.
* @param nom nom de la blague.
* @return list contenant les blagues ou les citations.
*/
function getBlagueCitationByNom($nom){
	global $wpdb;
	$table_eniBlague=$wpdb->prefix.'eniBlague';
	$nom="%".$nom."%";
	$sql = $wpdb->prepare("SELECT * FROM ".$table_eniBlague." WHERE blague like '%s' or description like '%s' or motscles like '%s'",$nom,$nom,$nom);
	$eniBlaguesCitationsList = $wpdb->get_results($sql);
	return $eniBlaguesCitationsList;
}

/**
* Insere une blague ou une citation dans la BD.
* @param blague nom de la blague.
* @param description
* @param motscles
* @param source
* @return  booleen pour savoir s'il y a eu une insertion.
*/
function insertBlagueCitation($blague,$description,$motscles,$source){
	global $wpdb;
	$table_eniBlague=$wpdb->prefix.'eniBlague';
	$sql = $wpdb->prepare("INSERT INTO ".$table_eniBlague." (blague,description,motscles,source) VALUES (%s,%s,%s,%s)",
	$blague,$description,$motscles,$source);
	$wpdb->query($sql);
	if(!$sql) $insertEniBlague = false;
	else $insertEniBlague = true;
	return $insertEniBlague;
}

/**
* Modifie une blague ou une citation dans la BD en fonction de son id.
* @param id identifiant de la blague à modifier.
* @param blague nom de la blague.
* @param description
* @param motscles
* @param source
* @return  booleen pour savoir s'il y a eu une mise à jour.
*/
function updateBlagueCitation($id,$blague,$description,$motscles,$source){
	global $wpdb;
	$table_eniBlague=$wpdb->prefix.'eniBlague';
	$sql = $wpdb->prepare("UPDATE ".$table_eniBlague." SET blague=%s,description=%s,motscles=%s,source=%s WHERE id=%d ",
	$blague,$description,$motscles,$source,$id);
	$wpdb->query($sql);
	if(!$sql) $updateEniBlague = false;
	else $updateEniBlague = true;
	return $updateEniBlague;
}

/**
* Supprime une blague ou une citation dans la BD en fonction de son id.
* @param id identifiant de la blague à supprimer.
* @return  booleen pour savoir s'il y a eu une suppression.
*/
function deleteBlagueCitation($id){
	global $wpdb;
	$table_eniBlague=$wpdb->prefix.'eniBlague';
	$sql = $wpdb->prepare("DELETE FROM ".$table_eniBlague." WHERE id=%d LIMIT 1",$id);
	$mapDelete=$wpdb->query($sql);
	if(!$sql) $mapDelete = false;
	else $mapDelete = true;
	return $mapDelete;
}
?>







