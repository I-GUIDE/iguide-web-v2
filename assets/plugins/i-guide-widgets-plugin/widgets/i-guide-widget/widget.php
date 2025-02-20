<?php

if (!class_exists('SiteOrigin_Widget')) return;

class I_Guide_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'i-guide-widget',
            __('I-GUIDE Widget', 'i-guide-widget-text-domain'),
            array(
                'description' => __('A simple widget for SiteOrigin Page Builder in I-GUIDE.', 'i-guide-widget-text-domain'),
            ),
            array(),
            array(
                'text' => array(
                    'type'    => 'text',
                    'label'   => __('Enter your message:', 'i-guide-widget-text-domain'),
                    'default' => 'Hello from I-GUIDE Widget!',
                ),
            ),
            plugin_dir_path(__FILE__)
        );
    }

    function get_template_name($instance) {
        return 'template';
    }

    function get_template_dir($instance) {
        return plugin_dir_path(__FILE__) . 'tpl/';
    }
}

// Register the widget
siteorigin_widget_register('i-guide-widget', __FILE__, 'I_Guide_Widget');
