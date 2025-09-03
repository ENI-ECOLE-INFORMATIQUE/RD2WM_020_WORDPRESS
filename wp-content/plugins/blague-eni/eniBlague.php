<?php
/**
* Classe en charge de créer une extension pour les Blagues.
* @package eniBlagueCitation
* @version 0.6
* @since 0.2
* @author Denis - Stagiaires
*/

/*
 Plugin Name: Eni Blague Citation TEST
 Plugin URI: http://eni-ecole.fr/plugin-wordpress-blagues-ciations
 Description: Permet de fournir une liste de blagues ou de citations en fonction d'un mot clé. Rajouter dans votre page le shortcode <strong>[EniBlagueList]</strong> pour afficher la liste de toutes les blagues ou citations présentes en base de données.
 Author: Denis Sanchez - ENI Stagiaires
 Version:0.6
 Author URI: http://eni-ecole.fr/denis
 License:GPLv2 or later
 Text Domain: ENI
*/
//Constante qui permet de récupérer le répertoire d'installation de mon plugin.
define ('ENI_BLAGUE__PLUGIN_DIR',plugin_dir_path(__FILE__));
require_once(ENI_BLAGUE__PLUGIN_DIR.'class.EniBlague.php');
require_once(ENI_BLAGUE__PLUGIN_DIR.'class.EniBlague-install.php');
require_once(ENI_BLAGUE__PLUGIN_DIR.'class.EniBlague-widget.php');
require_once(ENI_BLAGUE__PLUGIN_DIR.'class.EniBlague-admin.php');

if(!class_exists("EniBlague")){
	class EniBlague{
		/*
		*Fonction qui permet lors de l'activation du plugin de créer la table blague dans la BD.
		*/
		function eniBlague_install(){
			global $wpdb;
			$table_eniBlague=$wpdb->prefix.'eniBlague';
			if($wpdb->get_var("SHOW TABLES LIKE '$table_eniBlague'")!=$table_eniBlague){
				$sql="CREATE TABLE $table_eniBlague (
				id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
				blague TEXT NOT NULL,
				description TEXT NOT NULL,
				motscles TEXT,
				source TEXT
				)ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
				require_once(ABSPATH.'wp-admin/includes/upgrade.php');
				//Fonction dbDelta présente dans le fichier upgrade.php
				dbDelta($sql);
				
				eniBlague_install_BD($table_eniBlague);
			}
		}
		
		/*
		* Fonction qui permet de supprimer la table blague dans la BD.
		*/
		function eniBlague_uninstall(){
			global $wpdb;
			$table_eniBlague=$wpdb->prefix.'eniBlague';
			if($wpdb->get_var("SHOW TABLES LIKE '$table_eniBlague'")==$table_eniBlague){
				$sql ="DROP TABLE '$table_eniBlague'";
				$wpdb->query($sql);
			}
		}
	}//Fin de classe
}//Fin de if

if(class_exists("EniBlague")){
	$inst_EniBlague = new EniBlague();
	//Ajout d'un shortcode pour ajouter dans une page ou un article la liste des blagues présentes dans la BD.
	add_shortcode('EniBlagueList','eniBlagueAffichageList');
}

if(isset($inst_EniBlague)){
	register_activation_hook(__FILE__, array($inst_EniBlague,'eniBlague_install'));
	register_deactivation_hook(__FILE__, array($inst_EniBlague,'eniBlague_uninstall'));
}

/*
Fonction qui retourne la liste de toutes les blagues ou citations.
Utile pour le shortcode EniBlagueList.
*/
function eniBlagueAffichageList(){
	$affichageBlague="<h2>Eni Blagues ou Citations</h2>";
	$listEniBlague = getBlaguesCitationsList();
	if(sizeof($listEniBlague)>0){
		foreach($listEniBlague as $blague){
			$affichageBlague.="<p class=\"labelBlague\"><label>Blague ou Citation:</label>".$blague->blague;
			$affichageBlague.="<br><label>Description:</label>".$blague->description;
			if(!empty(trim($blague->motscles))){
				$affichageBlague.="<br><label>Mots clés:</label>".$blague->motscles;	
			}
			if(!empty(trim($blague->source))){
				$affichageBlague.="<br><label>Source:</label>".$blague->source;	
			}
			$affichageBlague.="</p><hr>";
		}
	}else{
		$affichageBlague.="<p>La blague ou la citation correspondante à votre recherche n'a pas été trouvée.<br>
		N'hésitez pas à nous envoyer un message pour essayer de la rajouter.<br>
		Vous pouvez aussi essayer un synonyme et relancer la recherche.</p>";
	}
	return $affichageBlague;
}
?>











