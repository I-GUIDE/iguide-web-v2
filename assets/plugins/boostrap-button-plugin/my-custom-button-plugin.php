<?php
/**
 * Plugin Name: Bootstrap Button Plugin
 * Description: Adds a button to the WordPress text editor to easily insert Bootstrap-styled buttons.
 * Version: 1.05
 * Author: Nattapon Jaroenchai
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Enqueue the TinyMCE plugin for all instances
add_action('admin_init', 'my_custom_button_enqueue');

function my_custom_button_enqueue() {
    // Register TinyMCE plugin script
    add_filter('mce_external_plugins', 'my_custom_button_plugin');
    add_filter('mce_buttons', 'my_custom_button_register_button');
    
    // Add Bootstrap CSS to TinyMCE
    add_filter('mce_css', 'my_custom_button_add_bootstrap');
}

// Register the TinyMCE plugin script
function my_custom_button_plugin($plugin_array) {
    $plugin_array['my_custom_button'] = plugin_dir_url(__FILE__) . 'tinymce-button.js';
    return $plugin_array;
}

// Add the custom button to the editor toolbar
function my_custom_button_register_button($buttons) {
    array_push($buttons, 'my_custom_button');
    return $buttons;
}

// Add Bootstrap CSS to TinyMCE
function my_custom_button_add_bootstrap($mce_css) {

    // URL to Bootstrap CSS (use CDN or local file)
    $bootstrap_css_url = 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css';

    // Append Bootstrap CSS to the editor styles
    if (!empty($mce_css)) {
        $mce_css .= ',';
    }
    $mce_css .= $bootstrap_css_url;
    return $mce_css;
}
