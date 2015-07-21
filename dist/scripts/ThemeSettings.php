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
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">
                        <label for="settings[twitter]">Twitter Username:</label>
                    </th>
                    <td>
                        <span>https://twitter.com/</span>
                        <input type="text" value="<?php echo get_option('wprdc_theme_setting_twitter'); ?>" name="settings[twitter]" size="25" placeholder="WPRDC" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="settings[facebook]">Facebook Username:</label>
                    </th>
                    <td>
                        <span>https://facebook.com/</span>
                        <input type="text" value="<?php echo get_option('wprdc_theme_setting_facebook'); ?>" name="settings[facebook]" size="25" placeholder="WPRDC" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="settings[github]">GitHub Username:</label>
                    </th>
                    <td>
                        <span>https://github.com/</span>
                        <input type="text" value="<?php echo get_option('wprdc_theme_setting_github'); ?>" name="settings[github]" size="25" placeholder="UCSUR-Pitt" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="settings[google]">Google Analytics Code:</label>
                    </th>
                    <td>
                        <input type="text" value="<?php echo get_option('wprdc_theme_setting_google'); ?>" name="settings[google]" size="25" placeholder="UA-0000000-1" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="settings[ckan]">CKAN URL:</label>
                    </th>
                    <td>
                        <input type="text" value="<?php echo get_option('wprdc_theme_setting_ckan'); ?>" name="settings[ckan]" size="25" placeholder="http://data.wprdc.org" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="settings[about]">About Snippet in Footer:</label>
                    </th>
                    <td>
                        <textarea name="settings[about]" rows="10" cols="100" placeholder="Bacon ipsum dolor amet salami fatback landjaeger, jerky bacon jowl venison shank short loin ham pastrami ham hock. Chuck strip steak cow capicola drumstick salami prosciutto short ribs shankle jowl pancetta tail pork loin. Sausage chicken pork belly, brisket ground round venison bacon fatback turducken tri-tip jowl t-bone tongue. Bacon tongue tail filet mignon."><?php echo esc_attr(get_option('wprdc_theme_setting_about')); ?></textarea>
                    </td>
                </tr>
            </table>
            <h3>Twitter API:</h3>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">
                        <label for="settings[twitter_at]">Access Token:</label>
                    </th>
                    <td>
                        <input type="text" value="<?php echo get_option('wprdc_theme_setting_twitter_at'); ?>" name="settings[twitter_at]" size="100" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="settings[twitter_ats]">Access Token Secret:</label>
                    </th>
                    <td>
                        <input type="text" value="<?php echo get_option('wprdc_theme_setting_twitter_ats'); ?>" name="settings[twitter_ats]" size="100" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="settings[twitter_ck]">Consumer Key:</label>
                    </th>
                    <td>
                        <input type="text" value="<?php echo get_option('wprdc_theme_setting_twitter_ck'); ?>" name="settings[twitter_ck]" size="100" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="settings[twitter_cs]">Consumer Secret:</label>
                    </th>
                    <td>
                        <input type="text" value="<?php echo get_option('wprdc_theme_setting_twitter_cs'); ?>" name="settings[twitter_cs]" size="100" />
                    </td>
                </tr>
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
        foreach($_POST['settings'] as $setting => $value) {
            update_option('wprdc_theme_setting_'.$setting, esc_attr($value), 'yes');
        }

        //delete possible tweets from cache since we are updating the user
        wincache_ucache_delete('tweets');

        //output response ?>
        <h3>Settings saved successfully!</h3>
        <a href="#" onClick="window.location.reload()">Go Back</a>
   <?php }
}