<?php
/**
* Classe en charge de créer un widget pour les Blagues.
* @package eniBlagueCitation
* @version 0.6
* @since 0.2
* @author Denis - Stagiaires
*/
require_once(ENI_BLAGUE__PLUGIN_DIR.'class.EniBlague.php');


class EniBlague_Widget extends WP_Widget{
		function __construct(){
			load_plugin_textdomain('EniBlague');
			parent::__construct('EniBlague Widget',__('EniBlague Widget','EniBlague'),
			array('description' => __('Affiche les blagues ou les citations','EniBlague'))
			);
			if(is_active_widget(false,false,$this->id_base)){
				add_action('wp_head',array($this,'css'));
			}
		}
		
		function css(){
?>
<style type="text/css">
.a-stats{
	width: auto;
}

.a-stats a{
	background: #7CA821;
	background-image:-moz-linear-gradient(0% 100% 90deg,#5F8E14,#7CA821);
	background-image:-webkit-gradient(linear,0% 0,0% 100%,from(#7CA821),to(#5F8E14));
	border: 1px solid #5F8E14;
	border-radius:3px;
	color:#CFEA93;
	cursor:pointer;
	display:block;
	font-weight:normal;
	/*height:100%;*/
	-moz-border-radius:3px;
	-webkit-border-radius:3px;
	width:100%;
	padding:7px 0 8px;
	text-align:center;
	text-decoration:none;
}

.a-stats a:hover{
	text-decoration:none;	
	background-image:-moz-linear-gradient(0% 100% 90deg,#6F9C1B,#659417);
	background-image:-webkit-gradient(linear,0% 0,0% 100%,from(#659417),to(#6F9C1B));
}

.a-stats .count{
	color: #FFF;
	display:block;
	font-size:15px;
	line-height:16px;
	padding:0 13px;
	white-space: nowrap;
}
.oneline{
	display: inline-flex;
	width:100%;
}
#search-blague.search-field{
	font-size:0.8em;
}

.search-submit {
	padding:0;
}
</style>
<?php
	}//Fin fonction CSS
		
		function form($instance){
			if($instance && isset($instance['title'])){
				$title=$instance['title'];
			}else{
				$title = __('Liste des blagues ou citations de l\'ENI','EniBlague');
			}
			?>
			<p>
				<label for="<?php echo $this->get_field_id('title');?>">
				<?php esc_html_e('Title:','EniBlague');?>
				</label>
				<input class="widefat" id="<?php echo $this->get_field_id('title');?>"
				name="<?php echo $this->get_field_name('title');?>"
				type="text" value="<?php echo esc_attr($title);?>"
			</p>
<?php
		}
		
		function update($new_instance,$old_instance){
			$instance['title']=strip_tags($new_instance['title']);
			return $instance;
		}
		
		function widget($args,$instance){
			$count=nombreDeBlaguesCitationsTotal();
			if(! isset($instance['title'])){
				$instance['title']= __('Liste des blagues ou citations','EniBlague');
			}
			echo $args['before_widget'];
			if(!empty($instance['title'])){
				echo $args['before_title'];	
				echo esc_html($instance['title']);
				echo $args['after_title'];
			}
		?>
		<div class="a-stats">
			<a href="http://eni-ecole.fr" target="_blank" title="Nombre de blagues ou citations dans la BD">
				<?php printf( _n( '<strong class="count">%1$s blagues ou citations</strong> dans la base de données <br><strong>Réalisé par © ENI - Denis Sanchez</strong>', '<strong class="count">%1$s blagues ou citations</strong> dans la base de données <br><strong>Réalisé par © ENI - Denis Sanchez</strong>', $count , 'EniBlague'), number_format_i18n( $count,0 ) ); ?>
		</a>
		</div>
		<form role="search" method="get" class="search_form" action="#">
			<label for="search-blague">
				<span class="screen-reader-text">Recherche pour:</span>
			</label>
			<div class="oneline">
			<input type="search" id="search-blague" class="search-field" placeholder="Recherche une blague ou une citation"
			name="search-blague" title="Veuillez saisir un mot pour faire une recherche sur les blagues ou citations de l'ENI"
			/>
			<button type="submit" class="search-submit">
				<!-- <svg class="icon icon-search" aria-hidden="true" role="img">
					<use href="#icon-search" xlink:href="#icon-search"></use>
				</svg> -->
				<img src="<?php echo plugins_url( 'images/loupe.jpg', __FILE__ )?>" alt="Submit"/>
				<span class="screen-reader-text">Recherche</span>
			</button>
			<!-- <img src="<?php echo plugins_url( 'images/loupe.jpg', __FILE__ )?>" alt="Submit" onclick="document.forms['search-form'].submit();" /> -->
			</div>
		</form>
		<?php
			// $nomARechercher=$_REQUEST["search-blague"];
			// if(empty(trim($nomARechercher))){
			// 	$listEniBlague=getBlaguesCitationsList();
			// }else{
			// 	$listEniBlague=getBlagueCitationByNom($nomARechercher);
			// }
			if(isset($_REQUEST["search-blague"])) {
				$nomARechercher=$_REQUEST["search-blague"];
				$listEniBlague=getBlagueCitationByNom($nomARechercher);
			} else {
				$listEniBlague=getBlaguesCitationsList();
			}
			
			if(sizeof($listEniBlague)>0){
				foreach($listEniBlague as $blagueCitation)
				{
					$affichageBlagueCitation="<p><label>Nom de la blague ou de la citation:</label>".$blagueCitation->blague;
					$affichageBlagueCitation.="<br><label>Description:</label>".$blagueCitation->description;
					if(!empty(trim($blagueCitation->motscles))){
						$affichageBlagueCitation.="<br><label>Mots clés :</label>".$blagueCitation->motscles;
					}
					if(!empty(trim($blagueCitation->source))){
						$affichageBlagueCitation.="<br><label>Source :</label>".$blagueCitation->source;
					}
					$affichageBlagueCitation.="</p><hr>";
					print $affichageBlagueCitation;
				}
			}else{
				print("<p>Aucune blague ou citation correspondante. Veuillez relancer votre recherche !</p>");
			}
		
		
		echo $args['after_widget'];
		}//Fin de fonction widget
		
}//Fin class EniBlague_Widget

function eniBlagueCitation_register_widget(){
	register_widget('EniBlague_Widget');
}

add_action('widgets_init','eniBlagueCitation_register_widget');
?>