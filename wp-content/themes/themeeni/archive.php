<?php get_header(); ?>
    <h1>Le Mag</h1>
    <?php if(have_posts()) : while(have_posts()) : the_post(); ?>
        <article class="post">
            <h2><?php the_title();?></h2>
            <?php   the_post_thumbnail('medium'); ?>
            <p class="post_meta">
                Publié le <?php the_time(get_option('date_format'));?>
                Par <?php the_author();?> . <?php comments_number();?>
            </p>
            <?php the_excerpt();?>
            <p>
                <a href="<?php the_permalink();?>" class="post_link">Lire la suite</a>
            </p>
        </article>
    <?php endwhile; endif;?>
<?php the_posts_pagination();?>

<?php get_footer(); ?>