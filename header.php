<!doctype html>
<html lang="de">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?php echo get_bloginfo( 'description' ); ?>" />
    <link rel="stylesheet" href="<?php echo get_bloginfo('template_directory'); ?>/css/styles.css">
    <link rel="stylesheet" href="<?php echo get_bloginfo('template_directory'); ?>/css/ubuntu-font.css">
    <link rel="stylesheet" href="<?php echo get_bloginfo('template_directory'); ?>/css/fontawesome-all.css">
    <title><?php echo get_bloginfo( 'name' ); ?></title>
    <?php wp_head(); ?>
</head>

<body>
    <nav id="menu">
    <label for="show-menu" class="show-menu">Menü anzeigen</label>
    <input type="checkbox" id="show-menu" role="button">    
    <?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?>
    </nav> 
    <div id="wrapper">
		<nav id="breadcrumbs">
			<?php if (function_exists('breadcrumbs')) breadcrumbs(); ?>
		</nav>