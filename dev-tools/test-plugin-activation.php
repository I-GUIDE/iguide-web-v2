<?php
/**
 * Plugin Activation Test Script
 * Run this directly to test plugin activation without WordPress admin
 */

// Command-line only: refuse all web requests.
if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit;
}


// Change to the WordPress root directory
$wp_root = dirname(dirname(dirname(dirname(__DIR__))));
require_once($wp_root . '/wp-config.php');
require_once($wp_root . '/wp-admin/includes/plugin.php');

echo "Testing I-GUIDE Ethics Toolkit Plugin Activation...\n\n";

$plugin_file = 'iguide-ethics-toolkit/iguide-ethics-toolkit.php';

// Check if plugin file exists
if (!file_exists(WP_PLUGIN_DIR . '/' . $plugin_file)) {
    echo "ERROR: Plugin file not found at " . WP_PLUGIN_DIR . '/' . $plugin_file . "\n";
    exit(1);
}

echo "Plugin file found.\n";

// Try to activate the plugin
$result = activate_plugin($plugin_file);

if (is_wp_error($result)) {
    echo "ERROR: Plugin activation failed with error: " . $result->get_error_message() . "\n";
    exit(1);
}

echo "Plugin activated successfully!\n";

// Test if the main class exists
if (class_exists('IDET_Main')) {
    echo "Main plugin class loaded successfully.\n";
} else {
    echo "WARNING: Main plugin class not found.\n";
}

// Test database component
if (class_exists('IDET_Database')) {
    echo "Database class loaded successfully.\n";
    $db = new IDET_Database();
    echo "Database class instantiated successfully.\n";
} else {
    echo "WARNING: Database class not found.\n";
}

echo "\nActivation test completed.\n";
?>