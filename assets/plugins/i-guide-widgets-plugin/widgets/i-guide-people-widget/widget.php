<?php
if (!class_exists('SiteOrigin_Widget'))
    return;

class I_Guide_People_Widget extends SiteOrigin_Widget
{
    function __construct()
    {
        parent::__construct(
            'i-guide-people-widget',
            __('I-GUIDE People Widget', 'i-guide-people-text-domain'),
            array(
                'description' => __('A widget to display people cards for I-GUIDE.', 'i-guide-people-text-domain'),
                'groups' => array('i-guide-widgets' => __('I-GUIDE Widgets', 'i-guide-people-text-domain')),
            ),
            array(),
            array(
                'people' => array(
                    'type' => 'repeater',
                    'label' => __('People', 'i-guide-people-text-domain'),
                    'item_name' => __('Person', 'i-guide-people-text-domain'),
                    'item_label' => array(
                        'selector' => "[name*='name']",
                        'update_event' => 'change',
                        'value_method' => 'val',
                    ),
                    'fields' => array(
                        'image' => array(
                            'type' => 'media',
                            'label' => __('Image', 'i-guide-people-text-domain'),
                            'choose' => __('Choose image', 'i-guide-people-text-domain'),
                            'update' => __('Set image', 'i-guide-people-text-domain'),
                            'library' => 'image',
                        ),
                        'name' => array(
                            'type' => 'text',
                            'label' => __('Name', 'i-guide-people-text-domain'),
                        ),
                        'affiliation' => array(
                            'type' => 'text',
                            'label' => __('Affiliation', 'i-guide-people-text-domain'),
                        ),
                        'position' => array(
                            'type' => 'text',
                            'label' => __('Position', 'i-guide-people-text-domain'),
                        ),
                        'profile_url' => array(
                            'type' => 'text',
                            'label' => __('Profile URL', 'i-guide-people-text-domain'),
                            'description' => __('Optional: Link the image to a profile page.', 'i-guide-people-text-domain'),
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
    public function initialize()
    {
        wp_enqueue_style('iguide-custom-style', get_stylesheet_directory_uri() . '/assets/css/page.css');
    }
}
siteorigin_widget_register('i-guide-people-widget', __FILE__, 'I_Guide_People_Widget');