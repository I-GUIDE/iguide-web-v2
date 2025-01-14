<?php
/**
 * Plugin Name: Custom Notification Plugin
 * Description: Adds customizable multiple notification messages using Notify.js and CMB2.
 * Version: 1.9
 * Author: Nattapon Jaroenchai
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Include CMB2 if available or deactivate the plugin
if (file_exists(plugin_dir_path(__FILE__) . 'cmb2/init.php')) {
    require_once plugin_dir_path(__FILE__) . 'cmb2/init.php';
} else {
    add_action('admin_notices', function() {
        echo '<div class="notice notice-error"><p>CMB2 library not found. Please install CMB2 for the Custom Notification Plugin to work.</p></div>';
    });
    return;
}

// Enqueue Notify.js and custom scripts
function notification_plugin_enqueue_scripts() {
    wp_enqueue_script('notifyjs', 'https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'notification_plugin_enqueue_scripts');

// Add multiple notification messages to the site via Notify.js
function display_notification_messages() {
    $options = get_option('notification_plugin_options');
    $messages = isset($options['notification_plugin_messages']) ? $options['notification_plugin_messages'] : [];

    if (is_array($messages)) {
        echo '<script>jQuery(document).ready(function($) {';
        foreach ($messages as $message) {
            if ($message['enabled'] === 'yes') {
                echo '$.notify("' . esc_js(trim($message['text'])) . '", {
                        className: "' . esc_js($message['type']) . '",
                        position: "' . esc_js($message['position']) . '"
                    });';
            }
        }
        echo '});</script>';
    }
}
add_action('wp_footer', 'display_notification_messages');

// Create CMB2 top-level menu settings page with repeatable fields
function notification_plugin_register_settings_page() {
    $cmb = new_cmb2_box(array(
        'id' => 'notification_plugin_settings',
        'title' => __('Notification Settings', 'cmb2'),
        'object_types' => array('options-page'),
        'option_key' => 'notification_plugin_options',
        'capability' => 'manage_options',
        'menu_title' => 'Notification Settings',
        'position' => 2
    ));

    $group_field_id = $cmb->add_field(array(
        'id' => 'notification_plugin_messages',
        'type' => 'group',
        'description' => __('Add multiple notification messages.', 'cmb2'),
        'options' => array(
            'group_title' => __('Message {#}', 'cmb2'),
            'add_button' => __('Add Another Message', 'cmb2'),
            'remove_button' => __('Remove Message', 'cmb2'),
            'sortable' => true
        )
    ));

    $cmb->add_group_field($group_field_id, array(
        'name' => __('Notification Text', 'cmb2'),
        'id' => 'text',
        'type' => 'wysiwyg',
        'options' => array(
            'textarea_rows' => 5,
            'media_buttons' => true
        )
    ));

    $cmb->add_group_field($group_field_id, array(
        'name' => __('Enable Notification', 'cmb2'),
        'id' => 'enabled',
        'type' => 'select',
        'options' => array(
            'yes' => __('Yes', 'cmb2'),
            'no' => __('No', 'cmb2')
        )
    ));

    $cmb->add_group_field($group_field_id, array(
        'name' => __('Notification Type', 'cmb2'),
        'id' => 'type',
        'type' => 'select',
        'options' => array(
            'success' => __('Success', 'cmb2'),
            'info' => __('Info', 'cmb2'),
            'warning' => __('Warning', 'cmb2'),
            'error' => __('Error', 'cmb2')
        )
    ));

    $cmb->add_group_field($group_field_id, array(
        'name' => __('Notification Position', 'cmb2'),
        'id' => 'position',
        'type' => 'select',
        'options' => array(
            'top left' => __('Top Left', 'cmb2'),
            'top right' => __('Top Right', 'cmb2'),
            'bottom left' => __('Bottom Left', 'cmb2'),
            'bottom right' => __('Bottom Right', 'cmb2')
        )
    ));
}
add_action('cmb2_admin_init', 'notification_plugin_register_settings_page');

function notification_plugin_get_options() {
    return get_option('notification_plugin_options');
}
?>
