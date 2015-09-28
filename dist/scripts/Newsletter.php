<?php
include_once('MailChimp.php');

/**
 * Create a Hook to be used for AJAX calls using 'newsletter_register' action
 *
 * @package WordPress
 * @subpackage WPRDC
 * @since WPRDC 0.1
 * @link https://codex.wordpress.org/AJAX_in_Plugins
 */
function newsletter_register_callback()
{

    if (!check_ajax_referer('newsletter-register', '_wpnonce', false)) {
        header("HTTP/1.1 403 Forbidden");
        exit;
    }

    if (!isset($_POST['email']) || empty($_POST['email'])) {
        header("HTTP/1.1 400 Bad Request");
        exit;
    } else {
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            header("HTTP/1.1 400 Bad Request");
            exit;
        }
    }

    $api_key = get_option('wprdc_theme_setting_mailchimp_api', '');
    $list = get_option('wprdc_theme_setting_mailchimp_list', '');

    $MailChimp = new MailChimp($api_key);
    $result = $MailChimp->post('lists/' . $list . '/members', array(
        'email_address' => $_POST['email'],
        'status' => 'pending',
        'merge_fields' => array('FNAME' => '', 'LNAME' => '')
    ));

    if($result['status'] == '400') {
        $response = array(
            'title' => 'Email Already Found!',
            'lead'  => 'Have you confirmed your email address?',
            'text'  => 'This email address appears to have already signed up for the newsletter. You need to confirm your email address before receiving any emails from us.'
        );
    } else {
        $response = array(
            'title' => 'Success!',
            'lead'  => 'Thank you for signing up to our newsletter.',
            'text'  => 'Before you can being receiving emails, you\'ll need to <strong>confirm your email address</strong>. A confirmation link has been sent to the email you\'ve signed up with.<br><br>You can manage your subscription from every email you receive through this mailing list. Simply click on the "Manage your Subscription" link at the bottom of the message.'
        );
    }

    header('Content-type: application/json;');
    echo json_encode($response);
    exit;

}
add_action('wp_ajax_newsletter_register', 'newsletter_register_callback');