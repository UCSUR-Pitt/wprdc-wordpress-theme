<?php
/**
 * Header Template
 *
 * @package WordPress
 * @subpackage WPRDC
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo get_bloginfo('description'); ?></title>
    <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/assets/img/favicon.png?v=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css"/>
    <script src="<?php echo get_template_directory_uri(); ?>/assets/js/modernizr.js"></script>
    <?php wp_enqueue_script('jquery'); ?>
</head>
    <?php wp_head(); ?>
<body>
<!-- Header Bar -->
<div id="header">
    <nav class="top-bar" data-topbar role="navigation">
        <ul class="title-area">
            <li class="name">
                <h1>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/small-logo.png" alt="Small WPRDC Logo"/>
                    </a>
                </h1>
            </li>
            <li class="toggle-topbar menu-icon"><a href="#"><span></span></a></li>
        </ul>
        <section class="top-bar-section">
            <?php
            if (has_nav_menu('main-navigation')) {
                wp_nav_menu(array(
                    'container' => false,                           // remove nav container
                    'menu' => '',                                    // menu name
                    'menu_class' => 'right',                        // adding custom nav class
                    'theme_location' => 'main-navigation',          // where it's located in the theme
                    'depth' => 2,                                   // limit the depth of the nav
                    'walker' => new ThemeWalker()
                ));
            }
            ?>
        </section>
    </nav>
</div>

<!-- Main Content -->
<div id="main-content-wrapper">