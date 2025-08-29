<?php
//Ajoute automatiquement la balise title à chacune de mes pages et articles
//récupérer depuis son titre.
add_theme_support('title-tag');

//Ajouter la possibilité de mettre une image mise en avant dans les articles et les pages.
add_theme_support('post-thumbnails');

//Déclarer ma css
function register_fichier_css(){
    wp_enqueue_style('mafonction-style',get_stylesheet_uri(),array(),'1.0');
}

add_action('wp_enqueue_scripts','register_fichier_css');

//Permet d'enregistrer les emplacements du menu
register_nav_menus(
    array('main'=>'Menu principal',
        'footer'=>'Bas de page',
    )
);


/*
Création d'une fonction pour faire un fil d'ariane.
*/

function fil_ariane()
{
    global $post;
    //Permet de savoir si on est sur la page d'accueil.
    if (!is_home()) {
        $fil = "Vous êtes ici : ";
        $fil .= '<a href="' . get_bloginfo('wpurl') . '">';
        $fil .= get_bloginfo('name');
        $fil .= '</a> >';

        $parents = array_reverse(get_ancestors($post->ID, 'page'));
        foreach ($parents as $parent) {
            $fil .= '<a href="' . get_permalink($parent) . '">';
            $fil .= get_the_title($parent);
            $fil .= '</a> >';
        }
        $fil .= $post->post_title;
    }
    return $fil;
}

