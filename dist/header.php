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
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo get_bloginfo('description'); ?></title>
    <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/assets/img/favicon.png?v=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato"/>
    <link href='https://fonts.googleapis.com/css?family=Titillium+Web' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css"/>
    <script src="<?php echo get_template_directory_uri(); ?>/assets/js/modernizr.js"></script>
    <link rel="stylesheet" href="http://libs.cartocdn.com/cartodb.js/v3/3.15/themes/css/cartodb.css"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>
<?php wp_head(); ?>
<body>

<div class="name scroll-to-top">
    <a href="#">Back to Menu</a>
</div>

<!-- Header Bar -->
<div id="header">
    <div class="sticky">
        <nav class="top-bar" data-topbar role="navigation">
            <ul class="title-area">
                <li class="name">
                    <h1>
                        <a id="top-title" href="<?php echo esc_url(home_url('/')); ?>">
                            <span class=top-title id="title1">wp</span><span class=top-title id="title2">rdc</span>
                        </a>
                    </h1>
                </li>
            </ul>
            <section class="top-bar-section">
                <?php
                if (has_nav_menu('main-navigation')) {
                    wp_nav_menu(array(
                        'container' => false,                           // remove nav container
                        'menu' => '',                                    // menu name
                        'menu_class' => 'right',                        // adding custom nav class
                        'theme_location' => 'main-navigation',          // where it's located in the theme
                        'depth' => 3,                                   // limit the depth of the nav
                        'walker' => new ThemeWalker()
                    ));
                }
                ?>
            </section>
        </nav>
    </div>
</div>

<!-- Main Content -->
<div id="main-content-wrapper">