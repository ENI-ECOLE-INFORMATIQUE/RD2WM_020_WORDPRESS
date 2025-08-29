<!doctype html>
<html lang="<?php language_attributes();?>">
<head>
    <meta charset="<?php bloginfo('charset');?>">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php wp_head();?>
</head>
<body <?php body_class();?>>
    <?php wp_body_open(); ?>
    <header class="header">
        <a href="<?php echo home_url('/'); ?>">
            <img src="<?php echo get_template_directory_uri(); ?>/img/logo-eni.png" alt="logo ENI">
        </a>
        <?php wp_nav_menu(array('theme_location' => 'main')); ?>

    </header>
<?php
    if(function_exists('fil_ariane')){
        echo "<div class=fil_ariane>".fil_ariane()."</div>";
    }
?>


