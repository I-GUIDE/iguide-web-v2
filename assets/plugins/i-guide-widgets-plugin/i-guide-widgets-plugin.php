<?php
/**
 * Plugin Name: I-GUIDE Widgets Plugin
 * Plugin URI:  http://example.com
 * Description: A SiteOrigin widget plugin for I-GUIDE, including multiple widgets.
 * Version:     1.26
 * Author:      Nattapon Jaroenchai
 * Author URI:  http://example.com
 * License:     GPL2
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Load all widgets dynamically
function i_guide_widgets_load()
{
    $widgets_dir = plugin_dir_path(__FILE__) . 'widgets/';
    foreach (glob($widgets_dir . '*/widget.php') as $widget_file) {
        error_log("Loading: " . $widget_file);
        require_once $widget_file;
    }
}
add_action('plugins_loaded', 'i_guide_widgets_load');