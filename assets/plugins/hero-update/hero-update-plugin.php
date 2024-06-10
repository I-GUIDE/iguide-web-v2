<?php
/*
Plugin Name: Hero Update Plugin
Description: A plugin to create a custom post type "hero_update" with image and URL attributes and predefined dropdown options.
Version: 1.09
Author: Nattapon Jaroenchai
*/

// Register Custom Post Type
function create_hero_update_post_type() {
    $labels = array(
        'name'                  => _x( 'Hero Updates', 'Post Type General Name', 'text_domain' ),
        'singular_name'         => _x( 'Hero Update', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'             => __( 'Hero Updates', 'text_domain' ),
        'name_admin_bar'        => __( 'Hero Update', 'text_domain' ),
    );
    $args = array(
        'label'                 => __( 'Hero Update', 'text_domain' ),
        'supports'              => array( 'title', 'thumbnail' ),
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
    );
    register_post_type( 'hero_update', $args );
}
add_action( 'init', 'create_hero_update_post_type', 0 );

// Enqueue ACF if it's not already active
function enqueue_acf() {
    if (!class_exists('ACF')) {
        // Enqueue ACF plugin or provide a message to install it
        add_action('admin_notices', function() {
            echo '<div class="error"><p>Advanced Custom Fields plugin is required for Hero Update Plugin. Please install and activate it.</p></div>';
        });
    }
}
add_action('admin_enqueue_scripts', 'enqueue_acf');

// Add ACF fields for hero_update
function add_acf_fields() {
    if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_hero_update',
        'title' => 'Hero Update Fields',
        'fields' => array(
            array(
                'key' => 'field_hero_image',
                'label' => 'Hero Image',
                'name' => 'hero_image',
                'type' => 'image',
                'return_format' => 'url',
                'preview_size' => 'medium',
                'library' => 'all',
            ),
            array(
                'key' => 'field_hero_url',
                'label' => 'Hero URL',
                'name' => 'hero_url',
                'type' => 'url',
            ),
            array(
                'key' => 'field_hero_section',
                'label' => 'Hero Section',
                'name' => 'hero_section',
                'type' => 'select',
                'choices' => array(
                    'map' => 'Map',
                    'connect' => 'Connect',
                    'discover' => 'Discover',
                ),
                'default_value' => 'map',
                'allow_null' => 0,
                'multiple' => 0,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'hero_update',
                ),
            ),
        ),
    ));

    endif;
}
add_action('acf/init', 'add_acf_fields');

// Display the hero_section column in the admin list
function add_hero_update_columns($columns) {
    $columns['hero_section'] = __('Hero Section', 'text_domain');
    return $columns;
}
add_filter('manage_hero_update_posts_columns', 'add_hero_update_columns');

function display_hero_update_columns($column, $post_id) {
    if ($column == 'hero_section') {
        $hero_section = get_field('hero_section', $post_id);
        echo esc_html($hero_section);
    }
}
add_action('manage_hero_update_posts_custom_column', 'display_hero_update_columns', 10, 2);

// Shortcode to display Hero Updates by section
function display_hero_updates_by_section($atts) {
    $atts = shortcode_atts(
        array(
            'section' => 'map',
        ), 
        $atts,
        'hero_updates'
    );
    
    $args = array(
        'post_type' => 'hero_update',
        'posts_per_page' => 4,
        'meta_query' => array(
            array(
                'key' => 'hero_section',
                'value' => $atts['section'],
                'compare' => 'LIKE',
            ),
        ),
        'orderby' => 'date',
        'order' => 'DESC',
    );
    $query = new WP_Query($args);
    
    if ($query->have_posts()) {
        $output = '<div class="md:tw-grid md:tw-grid-cols-7 md:tw-gap-5 lg:tw-gap-7 tw-grid-rows-[min-content_min-content]">';
        $i = 1;
        while ($query->have_posts()) {
            $query->the_post();
            $hero_image = get_field('hero_image');
            $hero_url = get_field('hero_url');
            $title = get_the_title();
            $delay_class = 'animate__delay-' . $i . 's';
            
            if ($i == 1) {
                $output .= '<div class="animate tw-col-span-2 tw-row-span-2 tw-self-start ' . $delay_class . '">
                                <div class="tab-card tw-max-h-[15em] md:tw-max-h-max tw-mx-10 tw-mb-5 md:tw-m-0 md:tw-max-h-nonetw-relative md:tw-mt-10 tw-rounded-lg tw-drop-shadow-md  tw-overflow-hidden">
                                    <a class="stretched-link" href="' . esc_url($hero_url) . '" target="_blank"></a>
                                    <img class="object-cover tw-h-full tw-w-full" src="' . esc_url($hero_image) . '" alt="">
                                    <h1 class="tw-absolute tw-text-white tw-bottom-0 tw-font-semibold tw-px-3 tw-pb-2">' . esc_html($title) . '</h1>
                                </div>
                            </div>';
            } elseif ($i == 4) {
                $output .= '<div class="animate tw-col-start-6 tw-col-span-2 tw-self-start tw-row-start-1 tw-row-span-2 tw-relative md:tw-mt-20  ' . $delay_class . '">
                                <div class="tab-card tw-max-h-[15em] md:tw-max-h-max tw-mx-10 tw-mb-5 tw-hidden md:tw-flex md:tw-m-0 md:tw-max-h-nonetw-rounded-lg tw-overflow-hidden tw-drop-shadow-md">
                                    <a class="stretched-link" href="' . esc_url($hero_url) . '" target="_blank"></a>
                                    <img class="object-cover tw-h-full tw-w-full" src="' . esc_url($hero_image) . '" alt="">
                                    <h1 class="tw-absolute tw-text-white tw-bottom-0 tw-font-semibold tw-px-3 tw-pb-2">' . esc_html($title) . '</h1>
                                </div>
                            </div>';
            } else {
                $output .= '<div class="animate tw-col-start-3 tw-col-end-6 tw-self-start tw-relative' . $delay_class . '">
                                <div class="tab-card tw-h-[170px] lg:tw-h-[200px] xl:tw-h-[15em] tw-mx-10 tw-mb-5 md:tw-m-0 tw-drop-shadow-md tw-rounded-lg tw-overflow-hidden">
                                    <a class="stretched-link" href="' . esc_url($hero_url) . '" target="_blank"></a>
                                    <img class="object-cover tw-w-full tw-h-full" src="' . esc_url($hero_image) . '" alt="">
                                    <h1 class="tw-absolute tw-text-white tw-bottom-0 tw-font-semibold tw-px-3 tw-pb-2">' . esc_html($title) . '</h1>
                                </div>
                            </div>';
            }
            
            $i++;
        }
        $output .= '</div>';
        wp_reset_postdata();
        return $output;
    } else {
        return '<p>No hero updates found for this section.</p>';
    }
}
add_shortcode('hero_updates', 'display_hero_updates_by_section');

// Enqueue jQuery UI and custom script
function hero_update_enqueue_scripts() {
    global $pagenow;
    if ($pagenow == 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] == 'hero_update') {
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script('hero-update-ordering', plugin_dir_url(__FILE__) . 'hero-update-ordering.js', array('jquery-ui-sortable'), '', true);
        wp_localize_script('hero-update-ordering', 'heroUpdateAjax', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('hero-update-ordering-nonce'),
        ));
    }
}
add_action('admin_enqueue_scripts', 'hero_update_enqueue_scripts');

// Handle the reorder Ajax request
function hero_update_reorder() {
    check_ajax_referer('hero-update-ordering-nonce', 'nonce');
    
    if (isset($_POST['order'])) {
        $order = $_POST['order'];
        foreach ($order as $menu_order => $post_id) {
            $post_id = intval(str_replace('post-', '', $post_id));
            wp_update_post(array(
                'ID' => $post_id,
                'menu_order' => $menu_order
            ));
        }
        wp_send_json_success();
    } else {
        wp_send_json_error();
    }
}
add_action('wp_ajax_hero_update_reorder', 'hero_update_reorder');
