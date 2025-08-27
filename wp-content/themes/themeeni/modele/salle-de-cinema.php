<?php
/*
 Template Name: Salle de cinéma
 */
get_header();
?>
<?php if(have_posts()): while(have_posts()): the_post(); ?>
<h1><?php the_title();?></h1>
<?php the_post_thumbnail();?>
<?php the_content();?>
<?php the_field('salle_de_cinema_a_quimper');?>
    <?php $imageId=get_field('photo_salle_de_cinema_quimper');
    $size='medium';
    if($imageId){
        echo wp_get_attachment_image( $imageId, $size );
    }
    ?>

    <?php the_field('salle_de_cinema_a_rennes');?>
    <?php $imageId=get_field('photo_salle_de_cinema_rennes');
    $size='medium';
    if($imageId){
        echo wp_get_attachment_image( $imageId, $size );
    }
    ?>

<?php endwhile; endif;?>
<?php get_footer();?>


