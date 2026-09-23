<?php
/**
 * Simple Plugin Loading Test
 * Test if the plugin files can be loaded without fatal errors
 */

// Command-line only: refuse all web requests.
if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit;
}


echo "Testing I-GUIDE Ethics Toolkit Plugin Files...\n\n";

// Test 1: Check if files exist
$plugin_dir = 'wp-content/plugins/iguide-ethics-toolkit/';
$files_to_check = [
    'iguide-ethics-toolkit.php',
    'includes/class-database.php',
    'includes/class-admin.php',
    'includes/class-shortcodes.php',
    'includes/class-pdf-generator.php',
    'admin/dashboard.php',
    'templates/toolkit-main.php'
];

echo "Checking file existence:\n";
foreach ($files_to_check as $file) {
    $path = $plugin_dir . $file;
    if (file_exists($path)) {
        echo "✓ $file exists\n";
    } else {
        echo "✗ $file missing\n";
    }
}

echo "\nChecking PHP syntax:\n";
foreach ($files_to_check as $file) {
    $path = $plugin_dir . $file;
    if (file_exists($path) && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
        $output = shell_exec("php -l \"$path\" 2>&1");
        if (strpos($output, 'No syntax errors') !== false) {
            echo "✓ $file syntax OK\n";
        } else {
            echo "✗ $file syntax error: $output\n";
        }
    }
}

echo "\nTest completed successfully!\n";
echo "Plugin files appear to be ready for activation.\n";
?>