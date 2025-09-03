<?php
/**
* Classe en charge de mettre en place des fonctions pour la base de données pour les blagues.
* @package eniBlagueCitation
* @version 0.6
* @since 0.3
* @author Denis - Stagiaires
*/
require_once(ENI_BLAGUE__PLUGIN_DIR . 'class.EniBlague-biographie.php' );
if(!class_exists("ENIBlagueAdmin")){
	class ENIBlagueAdmin{
 
	    function __construct(){
	        //Ajout d'une feuille de style dans le back office pour gérer la page admin blague
            wp_register_style('eni_blague_css',plugins_url('css/admin-eni-blague.css',__FILE__));
            wp_enqueue_style('eni_blague_css');
 
            //Ajout d'un script javascript pour gérer les erreurs
            wp_enqueue_script('eni_blague_js', plugins_url('js/admin-eni-blague.js',__FILE__),array('jquery'));
        }
 
		public static function eniBlagueMenu(){
			if(function_exists('add_options_page')){
				add_options_page('ENIBlague','ENI Blague Citation Administration','administrator','ENIBlague',array('ENIBlagueAdmin','ENIBlaguePageContent'));
			}
		}	
		/**
		* Fonction en charge d'ajouter les entrées au menu pour le plugin.
		*/
		public static function register_ENIBlagueAdminMenu(){
			/*le titre de la page : ‘MyBookCase’
		le titre du menu : ‘MyBookCase’
		le niveau d’autorisation utilisateur pour voir le menu : ‘manage_options’
		le nom référence du menu : ‘lcrc_mybookcase’
		la fonction d’affiche de la page :’ ‘
		l’icône du menu : ‘ ‘
		la position dans l’interface d’administration : 30 pour être entre les commentaires (25) et la barre de séparation (59)	*/
		   add_menu_page('ENI Blague Citation Admin', 'ENI Blague Citation Admin', 'manage_options', 'ENIBlagueAdminMenu', array('ENIBlagueAdmin','ENIBlaguePageContent'), 'dashicons-heart', 80);
			//add_submenu_page( string $parent_slug, string $page_title, string $menu_title, string $capability, string $menu_slug, callable $function = '' )
		   add_submenu_page('ENIBlagueAdminMenu', 'Toutes les blagues ou citations', 'Toutes les blagues ou citations', 'manage_options', 'ENIBlagueAdminMenuTous',array('ENIBlagueAdmin','ENIBlaguePageTous'));
		   add_submenu_page('ENIBlagueAdminMenu', 'Ajouter une blague ou une citation', 'Ajouter une blague ou une citation', 'manage_options', 'ENIBlagueAdminMenuAjout',array('ENIBlagueAdmin','ENIBlaguePageAjout'));
		   add_submenu_page('ENIBlagueAdminMenu', 'Modifier une blague ou une citation', 'Modifier une blague ou une citation', 'manage_options', 'ENIBlagueAdminMenuEdit',array('ENIBlagueAdmin','ENIBlaguePageEdit'));
		}
		/**
		* Fonction en charge de mettre le texte d'explication du plugin
		*/
		public static function eniBlaguePageContent(){
			$affichage="<div class=\"wrap\">";
			$affichage.="<img src=".plugins_url( 'images/blague.jpg', __FILE__ )." width=\"160\"  alt=\"Blague\" title=\"blague\" style=\"float:left;margin:10px;\">";
			$affichage.="<h2>ENI Blagues Citations Administration</h2>";
			$affichage.="<h3>Installation et utilisation</h3>";
			$affichage.="<div>
				Pour utiliser l'extension :
<ul>
<li>1. Télécharger le dossier de l'extension dans le repertoire wp-content/plugins.</li>
<li>2. Activer l'extension</li>
<li>3. Utiliser le shortcode : <input type=\"text\" value=\"[ENIBlagueList]\" readonly=\"readonly\"/></li>
<li>4. Vous pouvez aussi ajouter le widget ENI Blague Citation qui permet de faire une recherche sur un mot clé et de retourner la liste des blagues ou des citations correspondantes à ce mot clé</li>
</ul>
</div>
<div>Pour en savoir plus je vous invite à aller faire un tour sur le site suivant: <a href=\"http://eni-ecole.fr/plugin-wordpress-blagues-citations-eni/\" target=\"_blank\">http://eni-ecole.fr/plugin-wordpress-blagues-citations-eni</a></div>
<hr>
<h3 style=\"clear:both;\">Objectif du plugin :</h3>
<p>Permet de fournir une liste de blagues ou de citations </p>
 
			<h3>Liste des blagues ou des citations disponibles :</h3>
<p>Cette liste est complétée et mise à jour réguliérement.</p>
 
			<h3>Fonctionnement du plugin :</h3>
<p>Vous cherchez une blague, une citation spécifique ? 
<p><u>Par exemple :</u> toto, carambar, politique, enfant, etc</p>
<p>Tapez un mot-clé plutôt qu’une expression entière.</p>
<p><u>Exemple :</u> si vous entrez : “douleur genoux” –> aucun résultat mais si vous entrez “douleur” ou bien “genou” vous obtiendrez des résultats</p>
 
			<p>
<ul>
<li>1. Saisir un mot clé dans le moteur de recherche</li>
<li>2. Lancer la recherche</li>
<li>3. Le plugin vous fournit une liste de blagues ou de citation en fonction du mot clé recherché s’il en possède un.</li>
</ul>
</p>
<hr>
<h3>Contribution au plugin</h3>
<p>Si vous voulez contribuer au plugin ou nous aider à rajouter des nouvelles blagues ou citations, je vous invite à nous envoyer un mail à l'adresse suivante: <a href=\"mailto:dsanchez@eni-ecole.fr\">dsanchez@eni-ecole.fr</a> avec vos nom prenom et email et un fichier au format csv séparé par ; sous la forme suivante:</p>
<p><b>nomBlagueCitation;description;motscles;source</b></p>
<p>Exemple pour une blague:</p>
<p>NOM De la Blague;blague à toto;toto;blague carambar 2018
</p>
<br>
<p>Merci à vous en espérant que ce plugin vous sera utile au quotidien</p>
<br>
 
			";
 
			if(class_exists("ENIBlagueBiographie")){
				$instENIBlagueBiographie= new ENIBlagueBiographie();
				$affichage.=$instENIBlagueBiographie->eniBlagueBio();
			}
			echo $affichage;
 
		}
		/**
		* Fonction en charge d'afficher dans le back office d'administration du plugin la page qui permet la liste 
		* de l'ensemble des blagues ou citations présentes dans la BD.
		*/
		public static function eniBlaguePageTous(){
			$affichage="<div class=\"wrap\">";
			$affichage.="<img src=".plugins_url( 'images/blague.jpg', __FILE__ )." width=\"160\"  alt=\"Blague\" title=\"blague\" style=\"float:left;margin:10px;\">";
			$affichage.="<h2>ENI Blagues Citations Administration</h2>";
			$affichage.="<h3>Liste des blagues ou citations</h3><div class=\"blockAffichage\">";
 
			if(isset($_GET['action']) && $_GET['action']=='deleteBlagueCitation'){
			    $idASuppr=$_POST['blague-id'];
			    $affichage.="<h1>Suppression id n° ".$idASuppr." effectuée !</h1>";
			    deleteBlagueCitation($idASuppr);
            }
			//Récupération de la liste des blagues présentes dans la base de données.
			$listEniBlague=getBlaguesCitationsList();
			if(sizeof($listEniBlague)>0){
				foreach($listEniBlague as $blagueCitation)
				{
					$affichageBlagueCitation="<fieldset class=\"blagueFieldset\">";
                    $affichageBlagueCitation.="<legend>".$blagueCitation->blague."</legend>";
                    $affichageBlagueCitation.="<p>
<label class=\"adminlabel\"><strong>Nom de la blague ou de la citation:</strong></label>
<span class=\"search-field\">".$blagueCitation->blague."</span></p>";
					$affichageBlagueCitation.="<p><label class=\"adminlabel\"><strong>Description:</strong>
</label>".$blagueCitation->description."</p>";
					if(!empty(trim($blagueCitation->motscles))){
						$affichageBlagueCitation.="<p><label class=\"adminlabel\"><strong>Mots clés :</strong></label>".$blagueCitation->motscles."</p>";
					}
					if(!empty(trim($blagueCitation->source))){
						$affichageBlagueCitation.="<p><label class=\"adminlabel\"><strong>Source :</strong></label>".$blagueCitation->source."</p>";
					}
					$affichageBlagueCitation.="<div class=\"bouton\">";
                    $affichageBlagueCitation.="<form action=\"?page=ENIBlagueAdminMenuEdit\" method=\"post\">";
                    $affichageBlagueCitation.="<input type=\"hidden\" name=\"blague-id\" value=\"".$blagueCitation->id."\" />";
                    $affichageBlagueCitation.="<input type=\"submit\" name=\"bt-editer\" id=\"bt-editer\" value=\"Editer\" />";
                    $affichageBlagueCitation.="</form>";
 
                    $affichageBlagueCitation.="<form action=\"?page=ENIBlagueAdminMenuTous&action=deleteBlagueCitation\" method=\"post\">";
                    $affichageBlagueCitation.="<input type=\"hidden\" name=\"blague-id\" value=\"".$blagueCitation->id."\" />";
                    $affichageBlagueCitation.="<input type=\"submit\" name=\"bt-supprimer\" id=\"bt-supprimer\" value=\"Supprimer\" />";
                    $affichageBlagueCitation.="</form>";
 
                    $affichageBlagueCitation.="</div>";
 
                    $affichageBlagueCitation.="</fieldset>";
					$affichage.= $affichageBlagueCitation;
				}
			}else{
				$affichage.="<p>Aucune blague ou citation présente dans la base de données !</p>";
			}
            $affichage.="</div>";
			echo $affichage;
		}
		/**
		* Fonction en charge d'afficher dans le back office d'administration du plugin la page qui permet l'ajout 
		* d'une blague ou d'une citation et l'enregistrer dans la BD.
		*/
		public static function eniBlaguePageAjout(){
			$affichage="<div class=\"wrap\">";
			$affichage.="<img src=".plugins_url( 'images/blague.jpg', __FILE__ )." width=\"160\"  alt=\"Blague\" title=\"blague\" style=\"float:left;margin:10px;\">";
			$affichage.="<h2>ENI Blagues Citations Administration</h2>";
			$affichage.="<h3>Ajout d'une blague ou d'une citation</h3>";
 
			if(	isset($_GET['action']) && $_GET['action']=='createBlague'){
			    $affichage.="Ajout d'une blague ou d'une citation";
                $affichage.=ajoutFormulaireBlagueCitation(0,null);
            }else{
                $affichage.="Veuillez remplir les champs suivant pour ajouter une blague ou une citation";
                $affichage.=ajoutFormulaireBlagueCitation(0,null);
            }
			echo $affichage;
		}
 
		public static function eniBlaguePageEdit(){
            $affichage="<div class=\"wrap\">";
            $affichage.="<img src=".plugins_url( 'images/blague.jpg', __FILE__ )." width=\"160\"  
            alt=\"Blague\" title=\"blague\" style=\"float:left;margin:10px;\">";
            $affichage.="<h2>ENI Blagues Citations Administration</h2>";
            $affichage.="<h3>Modification d'une blague ou d'une citation</h3>";
            $affichage.="Veuillez remplir les champs suivants pour modifier une blague ou une citation.";
            $modif=1;
			if(isset($_POST['blague-id'])){
            $idAModif=$_POST['blague-id'];
			}else{
				$idAModif="";
			}
            if(isset($_GET['action']) && $_GET['action']=='editBlague'){
                $blague=trim($_POST['ajout-nomBlague']);
                $description=trim($_POST['ajout-descriptionBlague']);
                $motscles=trim($_POST['ajout-motsclesBlague']);
                $source=trim($_POST['ajout-sourceBlague']);
                if($idAModif!=null){
                    updateBlagueCitation($idAModif,$blague,$description,$motscles,$source);
                    $affichage.="<h1>Modification id n° ".$idAModif." effectuée !</h1>";
                }else if(($blague!='')&&($description!='')){
                    $affichage.="<p class=\"ajoutSuccess\">Ajout réalisé avec succès !</p>";
                    insertBlagueCitation($blague,$description,$motscles,$source);
                }
            }
            $blagueAModif=getBlagueCitationById($idAModif);
			if(isset($blagueAModif[0])){
				$affichage.=ajoutFormulaireBlagueCitation($modif,$blagueAModif[0]);
			}else{
				$affichage.= "<p>Aucune blague sélectionnée à modifier</p>";
			}
            echo $affichage;
        }
	}
}
 
			//function insertBlagueCitation($blague,$description,$motscles,$source){
		function ajoutFormulaireBlagueCitation($modif,$blagueAModif){
			$idBlagueCitation = "";
			$blague="";
			$description="";
			$motscles="";
			$source="";
			if($blagueAModif!=null){
			    $idBlagueCitation=$blagueAModif->id;
			    $blague=$blagueAModif->blague;
			    $description=$blagueAModif->description;
			    $motscles=$blagueAModif->motscles;
			    $source=$blagueAModif->source;
            }else{
				if(isset($_POST['ajout-nomBlague'])&&isset($_POST['ajout-descriptionBlague'])
&&isset($_POST['ajout-motsclesBlague'])&&isset($_POST['ajout-sourceBlague'])){
					$blague=trim($_POST['ajout-nomBlague']);
					$description=trim($_POST['ajout-descriptionBlague']);
					$motscles=trim($_POST['ajout-motsclesBlague']);
					$source=trim($_POST['ajout-sourceBlague']);
				}
            }
			if($modif==1){
			    $legend="Modifier une blague ou une citation";
			    $form="<form action=\"?page=ENIBlagueAdminMenuEdit&action=editBlague\" method=\"post\">";
			    $btForm="Modifier";
			    $btFormTitle="Modifier une citation ou une blague";
            }else{
                $legend="Ajouter une blague ou une citation";
                $form="<form action=\"?page=ENIBlagueAdminMenuAjout&action=createBlague\" method=\"post\">";
                $btForm="Ajouter";
                $btFormTitle="Ajouter une citation ou une blague";
            }
			//Cf heredoc
			$str = <<<EOD
<div class="newBloc">
            $form
<fieldset class="blagueFieldset">
<legend>$legend</legend>
<input type="hidden" name="blague-id" value="$idBlagueCitation">
<p id="Mg-nomBlague-error" class="msgErreur">Entrez le nom de la blague ou de la citation, svp !</p>
<p>
<label for="ajout-nomBlague" class="adminlabel">Nom *:</label>
<input type="text" id="ajout-nomBlague" class="search-field" 
				placeholder="Ajouter le nom de la blague ou de la citation" value="$blague" name="ajout-nomBlague" 
				title="Veuillez saisir le nom de la blague ou de la citation"/>
</p>
<p id="Mg-descriptionBlague-error" class="msgErreur">Entrez la description de la blague ou de la citation, svp !</p>
<p>
<label for="ajout-descriptionBlague" class="adminlabel">Description *:</label>
<textarea id="ajout-descriptionBlague" cols="15" rows="15" class="search-field" 
				    placeholder="Ajouter la description de la blague ou de la citation" 
				    name="ajout-descriptionBlague" 
				    title="Veuillez saisir la description de la blague ou de la citation">$description</textarea>
</p>
<p id="Mg-motscles-error" class="msgErreur">Entrez des mots clés séparés par \"-\", svp!</p>
<p>
<label for="ajout-motsclesBlague" class="adminlabel">Mots clés:</label>
<input type="text" id="ajout-motsclesBlague" class="search-field" 
				    placeholder="Ajouter des mots clés séparés par -" 
				    value="$motscles" 
				    name="ajout-motsclesBlague" 
				    title="Ajouter des mots clés séparés par -"/>
</p>
<p id="Mg-sourceBlague-error" class="msgErreur">Entrez la source de la blague ou de la citation, svp!</p>
<p>
<label for="ajout-sourceBlague" class="adminlabel">Source :</label>
<input type="text" id="ajout-sourceBlague" class="search-field" 
				    placeholder="Source" value="$source" name="ajout-sourceBlague" 
				    title="Source"/>
</p>
<p class="center">
<input type="button" id="ajouterBlague" name="ajouterBlague" class="input-submit" value="$btForm" title="$btFormTitle"/>
</p>
</fieldset>
<small>* champs obligatoires</small>
</form>
</div>
EOD;
			//Attention de bien mettre EOD en début de ligne avec rien avant.Sinon probleme possible Cf doc heredoc.
			if(($modif!=1)&&($blague!='')&&($description!='')){
                $message="<p class=\"ajoutSuccess\">Ajout réalisé avec succès !</p>";
                insertBlagueCitation($blague,$description,$motscles,$source);
                $affich=$message.$str;
            }else{
			    $affich=$str;
            }
			return $affich;
		}	
 
if(class_exists("ENIBlagueAdmin")){
	$instENIBlagueAdmin= new ENIBlagueAdmin();
}
if(isset($instENIBlagueAdmin)){
	add_action('admin_menu',array($instENIBlagueAdmin,'register_ENIBlagueAdminMenu'));
}
 
?>