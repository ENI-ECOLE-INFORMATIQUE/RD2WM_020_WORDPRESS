<!-- ---------------------------------------------------------
* Page d'accueil du plugin dans l'admin 
* + Formulaire de création d'une carte
* ------------------------------------------------------------ 
-->
<?php
// Tableau des erreurs
$aErrors = ["empty_ko" => "Tous les champs sont obligatoires.",
            "cre_ok" => "La carte a été ajoutée.",
            "cre_ko" => "L'ajout de la carte a échoué.",
            "del_ok" => "La carte a été supprimée.",           
            "tech_ko" => "Une erreur technique ou de sécurité est survenue."           
];
?>

<?php wp_nonce_field('create_map_action', 'create_map_nonce'); ?>
<div class="wrap">   
    <h2>My OpenStreetMap</h2>
</div>
<!-- Menu à onglets de l'admin du plugin -->
<div id="menumap">
    <ul>
	   <!-- l'onglet 'Créer une carte' prend par défaut la classe CSS 'active' (fond noir) -->
       <li id="active">Créer une carte</li>
	   <?php
	   // Liste des cartes
       $mapList = $this->osm_getMapList(); 
     
       // Une carte = un onglet dans le menu 
       if ($mapList) 
       {
          foreach ($mapList as $m) 
          {
             $href = "?page=my-osm/my-osm.php&map=".$m->id;
	         echo "<li><a href='".$href."'>".$m->titre."</a></li>\n";
          }
       }
       ?>       
</ul>
</div><!--fin #menumap-->
<div id="contentmap">     

    <?php     
    // Affichage des erreurs + vérif. qu'elles existent bien dans le tableau
    if (isset($_GET["msg"]) && array_key_exists($_GET["msg"], $aErrors)) 
    { 
        // si finit par 'ok' = texte vert, si par 'ko' = texte rouge    
        // substr(chaine, -2) extrait les 2 derniers caractères, ici soit 'ok' soit 'ko'
        $color = substr($_GET["msg"], -2);
        echo"<div class='msg-".$color."'>".$aErrors[$_GET["msg"]]."</div>\n";   
    }    
    ?>

    <?php if (isset($_GET['msg'])) : ?>
        <div class="notice notice-<?php echo ($_GET['msg'] === 'cre_ok') ? 'success' : 'error'; ?>">
            <p>
                <?php
                switch ($_GET['msg']) {
                    case 'cre_ok':
                        echo '✅ Carte créée avec succès.';
                        break;
                    case 'cre_ko':
                        echo '❌ Erreur lors de la création de la carte.';
                        break;
                    case 'empty_ko':
                        echo '⚠️ Tous les champs sont obligatoires.';
                        break;
                }
                ?>
            </p>
        </div>
    <?php endif; ?>

    <h3 class="title" >Créez une carte :</h3> 
    <form action="?page=my-osm/my-osm.php&action=createmap" method="post">
        <?php
         //crée un champ nonce sécurisé
        wp_nonce_field('createmap','create_map_nonce');
        ?>
        <p id="Mg-title-error" style="color:red;display:none;">Entrez un titre, svp</p>
        <p><label for="Mg-title">Titre* :</label><br><input type="text" id="Mg-title" name="Mg-title"></p>
            
        <p id="Mg-latitude-error" style="color:red;display:none;">Entrez une latitude, svp</p>    
        <p><label for="Mg-latitude">Latitude* :</label><br><input type="text" id="Mg-latitude" name="Mg-latitude"></p>
            
        <p id="Mg-longitude-error" style="color:red;display:none;">Entrez une longitude, svp</p>     
        <p><label for="Mg-longitude">Longitude* :</label><br><input type="text" id="Mg-longitude" name="Mg-longitude"></p>
              
        <p><input type="button" class="button button-primary" id="bt-map" value="Enregistrer"></p> 
        <small>* champs obligatoires</small>    
    </form>
    
    <div>
    <p><strong>Exemples :</strong></p>
    <ul>
        <li>Nantes : 47.218371 / -1.553621</li>
        <li>Paris : 48.8534 / 2.3488</li>
        <li>Rennes : 48.117266 / -1.6777926</li>
    </ul>
    </div>
    
</div><!--fin #contentmap-->