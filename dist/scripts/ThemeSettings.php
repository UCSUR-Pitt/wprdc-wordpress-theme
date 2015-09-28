<?php
/**
 * Custom WPRDC Theme Settings Admin Page
 *
 * @package WordPress
 * @subpackage WPRDC
 */
class ThemeSettings {

    /**
     * Creates the 'Theme Settings' Menu Item under 'Appearance'
     */
    function __construct() {
        add_submenu_page(
            'themes.php', 'Theme Settings', 'Theme Settings', 'manage_options',
            'theme-settings', array($this, 'theme_settings_page')
        );
    }

    /**
     * Easily create form input[type=text] elements
     *
     * @param string $label
     * @param string $option
     * @param string $placeholder
     * @param int $size
     * @since WPRDC 0.1
     */
    function theme_settings_form_text($label, $option, $placeholder='', $size=25) {
        ?>
        <tr valign="top">
            <th scope="row">
                <label for="<?php echo "settings[{$option}]"; ?>"><?php echo $label; ?>:</label>
            </th>
            <td>
                <input type="text"
                       value="<?php echo get_option('wprdc_theme_setting_' .$option); ?>"
                       name="<?php echo "settings[{$option}]"; ?>"
                       size="<?php echo $size; ?>"
                       placeholder="<?php echo $placeholder; ?>"
                    />
            </td>
        </tr>
        <?php
    }

    /**
     * Easily create form textarea elements
     *
     * @param string $label
     * @param string $option
     * @param string $placeholder
     * @since WPRDC. 0.1
     */
    function theme_settings_form_textarea($label, $option, $placeholder='') {
        ?>
        <tr valign="top">
            <th scope="row">
                <label for="<?php echo "settings[{$option}]"; ?>"><?php echo $label; ?>:</label>
            </th>
            <td>
                <textarea
                    rows="10"
                    cols="100"
                    name="<?php echo "settings[{$option}]"; ?>"
                    placeholder="<?php echo $placeholder; ?>"><?php echo get_option('wprdc_theme_setting_' .$option); ?></textarea>
            </td>
        </tr>
        <?php
    }

    /**
     * Load the Theme Settings Page's HTML/Submit Page
     */
    function theme_settings_page() {
        if (!current_user_can('manage_options')) {
            wp_die('You do not have sufficient permissions to access this page.');
        } else {
            if (isset($_POST["update_settings"])) {
                $this->save_theme_settings_page();
            } else {
                $this->theme_settings_page_form();
            }
        }
    }

    /**
     * Load the Theme Settings Page's HTML
     */
    function theme_settings_page_form() { ?>
        <br><h1>Theme Settings</h1><hr>
        <form method="POST" action="">
            <h3>Basic Information:</h3>
            <input type="hidden" name="update_settings" value="Y" />
            <?php wp_nonce_field('theme-settings','security'); ?>

            <h2>Basic Information:</h2>
            <table class="form-table">
                <?php $this->theme_settings_form_text('Twitter Username','twitter','WPRDC',25); ?>
                <?php $this->theme_settings_form_text('Facebook Username','facebook','WPRDC',25); ?>
                <?php $this->theme_settings_form_text('GitHub Username','github','UCSUR-Pitt',25); ?>
                <?php $this->theme_settings_form_text('Google Analytics Code','google','UA-0000000-1',25); ?>
                <?php $this->theme_settings_form_text('CKAN URL','ckan','http://data.wprdc.org',55); ?>
                <?php $this->theme_settings_form_textarea('About Snippet in Footer:','about','Lorem Ipsum...'); ?>
            </table>

            <h2>Twitter API:</h2>
            <table class="form-table">
                <?php $this->theme_settings_form_text('Access Token','twitter_at','',55); ?>
                <?php $this->theme_settings_form_text('Access Token Secret','twitter_ats','',55); ?>
                <?php $this->theme_settings_form_text('Consumer Key','twitter_ck','',55); ?>
                <?php $this->theme_settings_form_text('Consumer Secret','twitter_cs','',55); ?>
            </table>

            <h2>MailChimp API:</h2>
            <table class="form-table">
                <?php $this->theme_settings_form_text('API Key','mailchimp_api','abc123abc123abc123abc123abc123',55); ?>
                <?php $this->theme_settings_form_text('List ID','mailchimp_list','b1234346',55); ?>
            </table>
            <p>
                <input type="submit" value="Save Settings" class="button-primary"/>
            </p>
        </form>
   <?php }

    /**
     * Updates the WP Options with the POSTed Data
     */
    function save_theme_settings_page() {
        $response = 'An error has occurred. Please try again.';
        if(isset($_POST['security'])) {
            if (wp_verify_nonce($_POST['security'], 'theme-settings')) {

                foreach($_POST['settings'] as $setting => $value) {
                    update_option('wprdc_theme_setting_'.$setting, esc_attr($value), 'yes');
                }

                //delete possible tweets from cache since we are updating the user
                wincache_ucache_delete('tweets');

                $response = 'Settings successfully saved!';
            }
        }

        //output response ?>
        <h3><?php echo $response; ?></h3>
        <a href="#" onClick="window.location.reload()">Go Back</a>
   <?php }
}