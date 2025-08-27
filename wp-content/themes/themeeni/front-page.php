<?php get_header();?>
<!--<h1><?php the_title();?></h1>-->
<main id="primary" checked="site-main">
    <?php
        $accueilCinemaQuery = new WP_Query([
           'post_type' => 'post', //Nous recherchons des articles
            'tax_query'=>array(
                    'relation'=>'OR',
                array(
                        'taxonomy'=>'category',
                        'field'=>'slug',
                        'terms'=>'cinema'
                ),
                array(
                        'taxonomy'=>'category',
                        'field'=>'slug',
                        'terms'=>'les-indiscrets'
                ),
            )     ,//faisant partie de la catégorie cinema et les-indiscrets
            'tag'=>'',//Possibilité d'affiné la requete en filtrant avec un tag.
            'orderby'=>'date',//Nous les classons par date de publication.
            'order'=>'DESC', //Classement antéchronologique.
            'post_per_page'=>3 // On limite à 3.
        ]);
    ?>
    <?php the_content();?>
    <h2>Les x derniers articles de la catégorie "Cinéma et les indiscrets"</h2>
    <?php if($accueilCinemaQuery->have_posts()) {
        while($accueilCinemaQuery->have_posts()) {
            $accueilCinemaQuery->the_post();
        ?>
    <div class="post">
        <h2><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
        <a href="<?php the_permalink();?>"><?php the_post_thumbnail('medium');?></a>
        <p><?php the_excerpt();?></p>
    </div>
    <?php
        }
        /*Restaurer les données d'articles originales*/
        wp_reset_postdata();
    }else{
        //Pas d'articles trouvés
        echo '<p>Aucun article trouvé.</p>';
    }
                ?>
</main>
<!-- #main -->
<?php get_footer();?>
