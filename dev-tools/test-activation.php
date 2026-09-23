<?php
/**
 * Plugin Activation and Database Test
 * This will manually activate the plugin and create tables if needed
 */

// Command-line only: refuse all web requests.
if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit;
}


// Include WordPress
$wp_load_path = dirname(dirname(dirname(dirname(__DIR__)))) . '/wp-load.php';
if (file_exists($wp_load_path)) {
    require_once($wp_load_path);
    require_once(ABSPATH . 'wp-admin/includes/plugin.php');
} else {
    die('WordPress not found');
}

echo "I-GUIDE Ethics Toolkit - Activation Test\n";
echo "========================================\n\n";

// Check if plugin is active
if (is_plugin_active('iguide-ethics-toolkit/iguide-ethics-toolkit.php')) {
    echo "✓ Plugin is already active\n";
} else {
    echo "× Plugin is not active, attempting to activate...\n";

    $result = activate_plugin('iguide-ethics-toolkit/iguide-ethics-toolkit.php');
    if (is_wp_error($result)) {
        echo "✗ Activation failed: " . $result->get_error_message() . "\n";
        exit(1);
    } else {
        echo "✓ Plugin activated successfully\n";
    }
}

// Check if classes are loaded
echo "\nChecking class availability:\n";
echo "IDET_Database: " . (class_exists('IDET_Database') ? '✓' : '✗') . "\n";
echo "IDET_Admin: " . (class_exists('IDET_Admin') ? '✓' : '✗') . "\n";
echo "IDET_Shortcodes: " . (class_exists('IDET_Shortcodes') ? '✓' : '✗') . "\n";

// Check database tables
if (class_exists('IDET_Database')) {
    echo "\nChecking database tables:\n";
    global $wpdb;

    $tables = array(
        'idet_projects',
        'idet_rpmp',
        'idet_megaid',
        'idet_data_cards',
        'idet_model_cards'
    );

    foreach ($tables as $table) {
        $table_name = $wpdb->prefix . $table;
        $exists = $wpdb->get_var("SHOW TABLES LIKE '$table_name'");
        echo "$table: " . ($exists ? '✓' : '✗') . "\n";
    }

    // Create tables if they don't exist
    $database = new IDET_Database();
    echo "\nCreating/updating database tables...\n";
    $database->create_tables();
    echo "✓ Database tables processed\n";

    // Re-check tables
    echo "\nRe-checking database tables:\n";
    foreach ($tables as $table) {
        $table_name = $wpdb->prefix . $table;
        $exists = $wpdb->get_var("SHOW TABLES LIKE '$table_name'");
        echo "$table: " . ($exists ? '✓' : '✗') . "\n";
    }
}

// Test AJAX action registration
echo "\nChecking AJAX actions:\n";
$ajax_actions = array(
    'wp_ajax_idet_create_project',
    'wp_ajax_nopriv_idet_create_project'
);

foreach ($ajax_actions as $action) {
    $registered = has_action($action);
    echo "$action: " . ($registered ? '✓' : '✗') . "\n";
}

echo "\nTest completed!\n";
?>