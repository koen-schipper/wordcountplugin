<?php
/*
* Plugin Name: Word Count Plugin
* Description: Word Count Plugin
* Version: 1.0
* Author: Koen Schipper
* Author URI: http://www.koenschipper.com
* License: GPL2
*/

class WordCountAndTimePlugin {
    function __construct() {
        add_action('admin_menu', array($this, 'adminPage'));
        add_action('admin_init', array($this, 'settings'));
    }

    function adminPage() {
        add_options_page(
            'Word Count Settings',
            'Word Count',
            'manage_options',
            'word-count-settings',
            array($this, 'ourHTML')
        );
    }

    function ourHTML() { ?>
        <div class="wrap">
            <h1>Word Count Settings</h1>
            <form action="options.php" method="POST">
                <?php
                settings_fields('wordcountplugin');
                do_settings_sections('word-count-settings');
                submit_button();
                ?>
            </form>
        </div>
    <?php }

    function settings() {
        add_settings_section(
            'wcp_first_section',
            null,
            null,
            'word-count-settings'
        );

        add_settings_field('wcp_location', 'Display Location', array($this, 'locationHTML'), 'word-count-settings', 'wcp_first_section');
        register_setting('wordcountplugin', 'wcp_location', array('sanitize_callback' => 'sanitize_text_field', 'default' => '0'));

        add_settings_field('wcp_headline', 'Heading Text', array($this, 'headlineHTML'), 'word-count-settings', 'wcp_first_section');
        register_setting('wordcountplugin', 'wcp_headline', array('sanitize_callback' => 'sanitize_text_field', 'default' => 'Post Statistics'));

        add_settings_field('wcp_wordcount', 'Word Count', array($this, 'checkboxHTML'), 'word-count-settings', 'wcp_first_section', array('theName' => 'wcp_wordcount'));
        register_setting('wordcountplugin', 'wcp_wordcount', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1'));

        add_settings_field('wcp_charcount', 'Character Count', array($this, 'checkboxHTML'), 'word-count-settings', 'wcp_first_section', array('theName' => 'wcp_charcount'));
        register_setting('wordcountplugin', 'wcp_charcount', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1'));

        add_settings_field('wcp_readtime', 'Read Time', array($this, 'checkboxHTML'), 'word-count-settings', 'wcp_first_section', array('theName' => 'wcp_readtime'));
        register_setting('wordcountplugin', 'wcp_readtime', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1'));
    }

    function locationHTML() { ?>
        <select name="wcp_location">
            <option value="0" <?php selected(get_option('wcp_location'), 0); ?>>Beginning of post</option>
            <option value="1" <?php selected(get_option('wcp_location'), 1); ?>>End of post</option>
        </select>
    <?php }

    function headlineHTML() { ?>
        <input type="text" name="wcp_headline" value="<?= esc_attr(get_option('wcp_headline')) ?>">
    <?php }

    function checkboxHTML($args) { ?>
        <input type="checkbox" name="<?= $args['theName'] ?>" value="1" <?php checked(get_option($args['theName']), '1'); ?>>
<?php }
}

$wordCountAndTimePlugin = new WordCountAndTimePlugin();
