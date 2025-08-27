<?php

if (!class_exists('SiteOrigin_Widget'))
    return;

class I_Guide_Timeline_Widget extends SiteOrigin_Widget
{

    function __construct()
    {
        parent::__construct(
            'i-guide-timeline-widget',
            __('I-GUIDE Timeline Widget', 'i-guide-timeline-text-domain'),
            array(
                'description' => __('A timeline widget for SiteOrigin Page Builder in I-GUIDE.', 'i-guide-timeline-text-domain'),
            ),
            array(),
            array(
                'title' => array(
                    'type' => 'text',
                    'label' => __('Timeline Title', 'i-guide-timeline-text-domain'),
                    'default' => 'Important Events',
                    'description' => __('Enter the title for the timeline.', 'i-guide-timeline-text-domain'),
                ),
                'events' => array(
                    'type' => 'repeater',
                    'label' => __('Timeline Events', 'i-guide-timeline-text-domain'),
                    'item_name' => __('Event', 'i-guide-timeline-text-domain'),
                    'item_label' => array(
                        'selector' => "[name*='title']",
                        'update_event' => 'change',
                        'value_method' => 'val',
                    ),
                    'fields' => array(
                        'title' => array(
                            'type' => 'text',
                            'label' => __('Title', 'i-guide-timeline-text-domain'),
                        ),
                        'description' => array(
                            'type' => 'textarea',
                            'label' => __('Description', 'i-guide-timeline-text-domain'),
                        ),
                        'date' => array(
                            'type' => 'text', // Keep it as a text field
                            'label' => __('Event Date (Format: YYYY-MM-DD)', 'i-guide-timeline-text-domain'),
                            'default' => '',
                            'description' => __('Please enter the date in YYYY-MM-DD format (e.g., 2024-10-15).', 'i-guide-timeline-text-domain'),
                        ),
                    ),
                ),
            ),
            plugin_dir_path(__FILE__)
        );
    }

    function get_template_name($instance)
    {
        return 'template';
    }

    function get_template_dir($instance)
    {
        return plugin_dir_path(__FILE__) . 'templates/';
    }

    function widget($args, $instance)
    {

        // ✅ Force loading template.php manually
        $template_file = plugin_dir_path(__FILE__) . 'templates/template.php';

        if (file_exists($template_file)) {
            include $template_file;
        } else {
            echo "<p style='color: red;'>Error: Template file not found!</p>";
        }
    }

}

// ✅ Register the widget
siteorigin_widget_register('i-guide-timeline-widget', __FILE__, 'I_Guide_Timeline_Widget');