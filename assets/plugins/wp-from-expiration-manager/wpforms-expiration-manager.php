<?php
/**
 * Plugin Name: WPForms Expiration Manager
 * Description: Allows administrators to set expiration dates for WPForms and display custom messages upon expiration.
 * Version: 1.0.0
 * Author: Your Name
 * Text Domain: wpforms-expiration-manager
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Include the main plugin class.
require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpforms-expiration-manager.php';

// Initialize the plugin.
function wpforms_expiration_manager_init() {
    $instance = WPForms_Expiration_Manager::get_instance();
}
add_action( 'plugins_loaded', 'wpforms_expiration_manager_init' );
