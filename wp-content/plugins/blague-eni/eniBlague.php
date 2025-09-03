<?php
/**
* Classe en charge de créer une extension pour les Blagues.
* @package eniBlagueCitation
* @version 0.7
* @since 0.2
* @author Denis - Stagiaires
*/

/*
 * Plugin Name: ENI Blague & Citation
 * Plugin URI: https://eni-ecole.fr/plugin-wordpress-blagues-citations
 * Description: Permet d’afficher et d’administrer des blagues ou des citations (widget + page d’admin).
 * Author: Denis Sanchez – ENI Stagiaires
 * Author URI: https://eni-ecole.fr/
 * Version: 0.7.0
 * Requires at least: 6.0
 * Tested up to: 6.8.2
 * Requires PHP: 7.4
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: blague-eni
 * Domain Path: /languages
 * Update URI: false
 */
//Constante qui permet de récupérer le répertoire d'installation de mon plugin.
define ('ENI_BLAGUE__PLUGIN_DIR',plugin_dir_path(__FILE__));
require_once(ENI_BLAGUE__PLUGIN_DIR.'class.EniBlague.php');
require_once(ENI_BLAGUE__PLUGIN_DIR.'class.EniBlague-install.php');
require_once(ENI_BLAGUE__PLUGIN_DIR.'class.EniBlague-widget.php');
require_once(ENI_BLAGUE__PLUGIN_DIR.'class.EniBlague-admin.php');

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'ENI_BLAGUE_VERSION', '0.7.0' );
define( 'ENI_BLAGUE_FILE', __FILE__ );
define( 'ENI_BLAGUE_PATH', plugin_dir_path( __FILE__ ) );
define( 'ENI_BLAGUE_URL', plugin_dir_url( __FILE__ ) );

// i18n
add_action( 'plugins_loaded', function() {
    load_plugin_textdomain( 'blague-eni', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
} );

if(!class_exists("EniBlague")){
	class EniBlague{
		/*
		*Fonction qui permet lors de l'activation du plugin de créer la table blague dans la BD.
		*/
		function eniBlague_install(){
			global $wpdb;
            $charset_collate = $wpdb->get_charset_collate();
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
                update_option( 'eni_blague_db_version', ENI_BLAGUE_VERSION );
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
	//add_shortcode('EniBlagueList','eniBlagueAffichageList');
    add_action( 'init', function() {
        add_shortcode( 'eniblague_list', 'eniBlagueAffichageList' );   // recommandé (lowercase)
        add_shortcode( 'eniblaguelist', 'eniBlagueAffichageList' );   // alias
        add_shortcode( 'EniBlagueList', 'eniBlagueAffichageList' );   // legacy
        add_shortcode( 'ENIBlagueList', 'eniBlagueAffichageList' );   // legacy
    } );
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











