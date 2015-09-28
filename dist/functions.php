<?php
/**
 * Theme Initialization and Setup
 */
function theme_init() {
    // Register Custom Navigation Menu
    register_nav_menu('main-navigation', __('Main Navigation', 'wprdc'));
    if(!get_option('wprdc_theme_setup_ran')) {
        // Create Theme's Default Pages
        create_default_pages_for_theme();
        // Add Option for Theme Initialized
        add_option('wprdc_theme_setup_ran', "true");
    }

    // Allow Thumbnails/Featured Images
    add_theme_support( 'post-thumbnails' );

    // Add Custom JS in Footer
    wp_enqueue_script('jquery');
    wp_enqueue_script('foundation', get_template_directory_uri() . '/assets/js/foundation.min.js', array('jquery'), '5.0', true);
    wp_enqueue_script('wprdc', get_template_directory_uri() . '/assets/js/app.js', array('jquery'), '0.0.1', true);
}
add_action( 'after_setup_theme', 'theme_init' );

/**
 * Create Default Wordpress Pages for Theme: About, Terms, Privacy, Contact
 */
function create_default_pages_for_theme() {
    $pages = array(
        'about' => array(
            'post_name'     => 'about',
            'post_title'    => 'About',
            'post_content'  => '',
            'post_excerpt'  => '',
            'post_type'     => 'page',
            'post_status'   => 'publish'
        ),
        'contact' => array(
            'post_name'     => 'contact',
            'post_title'    => 'Contact',
            'post_content'  => '',
            'post_excerpt'  => '',
            'post_type'     => 'page',
            'post_status'   => 'publish'
        ),
        'terms' => array(
            'post_name'     => 'terms-of-use',
            'post_title'    => 'Terms of Use',
            'post_content'  => '',
            'post_excerpt'  => '',
            'post_type'     => 'page',
            'post_status'   => 'publish'
        ),
        'privacy' => array(
            'post_name'     => 'privacy-policy',
            'post_title'    => 'Privacy Policy',
            'post_content'  => '',
            'post_excerpt'  => '',
            'post_type'     => 'page',
            'post_status'   => 'publish'
        )
    );
    foreach ($pages as $page) {
        wp_insert_post($page);
    }
}

/**
 * Create Theme's Custom Settings Page
 *
 * @see /scripts/ThemeSettings.php
 */
function theme_settings_add_page() {
    require get_template_directory() . '/scripts/ThemeSettings.php';
    new ThemeSettings();
}
add_action('admin_menu', 'theme_settings_add_page');

/**
 * Temporary enables PHP errors on a single page for enhanced debugging.
 */
function enable_php_errors()
{
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}
enable_php_errors();

/**
 * Retrieve a response from the CKAN API using the GET method
 *
 * @param string $url API URL to retrieve
 * @param array $args Optional. Request Arguments. Default empty array.
 * @return object|bool The response object or false if the status code was not 200.
 */
function ckan_api_get($url, $args = array())
{
    $cache_key = $url;
    if( !wincache_ucache_exists($cache_key) )
    {
        $ckan_url = get_option('wprdc_theme_setting_ckan', 'http://opendata.ucsur.pitt.edu/data');
        $url = esc_url_raw($ckan_url . '/api/3/' . $url);
        $response = wp_remote_get($url, $args);
        $body = json_decode(wp_remote_retrieve_body($response));

        if (wp_remote_retrieve_response_code($response) === 200)
            if (isset($body->result))
                $result = $body->result;
            else
                $result = $body;
        else
            $result = false;

        wincache_ucache_set($cache_key,$result,1800);
    }

    return wincache_ucache_get($cache_key);
}

/**
 * Return the CKAN URL for Absolute Links
 *
 * @param string $url The extra bit of CKAN URL
 * @return string The absolute CKAN url
 */
function ckan_url($url = '')
{
    $ckan_url = get_option('wprdc_theme_setting_ckan', 'http://opendata.ucsur.pitt.edu/data');
    $url = esc_url($ckan_url . '/' . $url);
    return $url;
}


/**
 * Enable Twitter API script to be accessed on scripts
 */
require get_template_directory() . '/scripts/Twitter.php';

/**
 * Enable ThemeWalker script to be accessed on scripts
 */
require get_template_directory() . '/scripts/ThemeWalker.php';


/**
 * Enable Newsletter script to be accessed via AJAX
 */
require get_template_directory() . '/scripts/Newsletter.php';