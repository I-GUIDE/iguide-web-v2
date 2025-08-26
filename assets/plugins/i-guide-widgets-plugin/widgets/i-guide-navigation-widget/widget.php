<?php

if (!class_exists('SiteOrigin_Widget'))
    return;

class I_Guide_Navigation_Widget extends SiteOrigin_Widget
{

    function __construct()
    {
        parent::__construct(
            'i-guide-navigation-widget',
            __('I-GUIDE Navigation Widget', 'i-guide-navigation-text-domain'),
            array(
                'description' => __('A navigation widget for SiteOrigin Page Builder in I-GUIDE.', 'i-guide-navigation-text-domain'),
            ),
            array(),
            array(
                'text' => array(
                    'type' => 'tinymce',
                    'label' => __('Text', 'i-guide-navigation-text-domain'),
                    'default' => '',
                    'description' => __('Enter the navigation text or description.', 'i-guide-navigation-text-domain'),
                ),
                'buttons' => array(
                    'type' => 'repeater',
                    'label' => __('Navigation Buttons', 'i-guide-navigation-text-domain'),
                    'item_name' => __('Button', 'i-guide-navigation-text-domain'),
                    'fields' => array(
                        'button_text' => array(
                            'type' => 'text',
                            'label' => __('Button Text', 'i-guide-navigation-text-domain'),
                        ),
                        'button_url' => array(
                            'type' => 'text',
                            'label' => __('Button URL', 'i-guide-navigation-text-domain'),
                            'default' => '',
                            'description' => __('Enter the URL for the button.', 'i-guide-navigation-text-domain'),
                        ),
                        'button_style' => array(
                            'type' => 'select',
                            'label' => __('Button Style', 'i-guide-navigation-text-domain'),
                            'default' => 'primary',
                            'options' => array(
                                'primary' => __('Primary (Blue)', 'i-guide-navigation-text-domain'),
                                'warning' => __('Warning (Yellow)', 'i-guide-navigation-text-domain'),
                            ),
                            'description' => __('Choose the button style.', 'i-guide-navigation-text-domain'),
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
        $template_file = plugin_dir_path(__FILE__) . 'templates/template.php';
        if (file_exists($template_file)) {
            include $template_file;
        } else {
            echo "<p style='color: red;'>Error: Template file not found!</p>";
        }
    }
}

siteorigin_widget_register('i-guide-navigation-widget', __FILE__, 'I_Guide_Navigation_Widget');
