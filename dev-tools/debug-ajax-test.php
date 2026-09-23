<?php
/**
 * AJAX Debug Test for I-GUIDE Ethics Toolkit
 * Add this to functions.php temporarily to test AJAX responses
 */

// Only load from within WordPress; block direct access.
if (!defined('ABSPATH')) {
    http_response_code(403);
    exit;
}

// Test AJAX endpoint (logged-in users only; no nopriv hook)
add_action('wp_ajax_idet_debug_test', 'idet_debug_test_callback');

function idet_debug_test_callback()
{
    // Restrict debug output to administrators
    if (!current_user_can('manage_options')) {
        wp_send_json_error('Forbidden', 403);
    }

    // Test basic WordPress functions
    $response = array(
        'wordpress_loaded' => function_exists('wp_send_json_success'),
        'database_class' => class_exists('IDET_Database'),
        'shortcodes_class' => class_exists('IDET_Shortcodes'),
        'admin_class' => class_exists('IDET_Admin'),
        'user_logged_in' => is_user_logged_in(),
        'current_user' => get_current_user_id(),
        'nonce_valid' => wp_verify_nonce($_POST['nonce'], 'idet_frontend_nonce'),
        'post_data' => $_POST
    );

    // Test database
    if (class_exists('IDET_Database')) {
        global $wpdb;
        $table_exists = $wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}idet_projects'");
        $response['projects_table_exists'] = !empty($table_exists);

        if (!empty($table_exists)) {
            $response['projects_count'] = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}idet_projects");
        }
    }

    wp_send_json_success($response);
}

// Test function that can be called from JavaScript
?>
<script>
    function testAjax() {
        const formData = new FormData();
        formData.append('action', 'idet_debug_test');
        formData.append('nonce', idet_ajax.nonce);
        formData.append('test_title', 'Debug Test Project');

        console.log('Testing AJAX...', {
            ajax_url: idet_ajax.ajax_url,
            nonce: idet_ajax.nonce
        });

        fetch(idet_ajax.ajax_url, {
            method: 'POST',
            body: formData
        })
            .then(response => {
                console.log('Response status:', response.status);
                return response.text();
            })
            .then(text => {
                console.log('Raw response:', text);
                try {
                    const json = JSON.parse(text);
                    console.log('Parsed JSON:', json);
                } catch (e) {
                    console.error('JSON parse error:', e);
                    console.log('Response is not JSON:', text);
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
            });
    }

    // Run test when page loads
    window.addEventListener('load', function () {
        if (typeof idet_ajax !== 'undefined') {
            console.log('IDET AJAX object loaded:', idet_ajax);
            // Uncomment to run automatic test:
            // testAjax();
        } else {
            console.error('IDET AJAX object not found');
        }
    });
</script>