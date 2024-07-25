<?php
/**
 * Plugin Name: Slideshow Plugin
 * Description: A plugin to create a slideshow post type with ACF fields.
 * Version: 1.04
 * Author: Nattapon Jaroenchai
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Register custom post type
function sp_register_slideshow_post_type() {
    $labels = array(
        'name'                  => 'Slideshows',
        'singular_name'         => 'Slideshow',
        'menu_name'             => 'Slideshows',
        'name_admin_bar'        => 'Slideshow',
        'add_new'               => 'Add New',
        'add_new_item'          => 'Add New Slideshow',
        'new_item'              => 'New Slideshow',
        'edit_item'             => 'Edit Slideshow',
        'view_item'             => 'View Slideshow',
        'all_items'             => 'All Slideshows',
        'search_items'          => 'Search Slideshows',
        'not_found'             => 'No slideshows found.',
        'not_found_in_trash'    => 'No slideshows found in Trash.',
    );

    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'show_in_menu'          => true,
        'supports'              => array( 'title' ),
        'has_archive'           => true,
        'rewrite'               => array( 'slug' => 'slideshows' ),
        'show_in_rest'          => true,
        'menu_position'         => 20,
        'menu_icon'             => 'dashicons-images-alt2',
    );

    register_post_type( 'slideshow', $args );
}

add_action( 'init', 'sp_register_slideshow_post_type' );

// ACF fields registration
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
    'key' => 'group_slideshow_fields',
    'title' => 'Slideshow Fields',
    'fields' => array(
        array(
            'key' => 'field_image',
            'label' => 'Image',
            'name' => 'image',
            'type' => 'image',
            'return_format' => 'url',
            'preview_size' => 'medium',
            'library' => 'all',
        ),
        array(
            'key' => 'field_description',
            'label' => 'Description',
            'name' => 'description',
            'type' => 'textarea',
        ),
        array(
            'key' => 'field_url',
            'label' => 'URL',
            'name' => 'url',
            'type' => 'url',
        ),
        array(
            'key' => 'field_internal_post',
            'label' => 'Internal Post',
            'name' => 'internal_post',
            'type' => 'post_object',
            'post_type' => array('news_events', 'pltf_notebook', 'page'),
            'return_format' => 'id',
            'ui' => 1,
        ),
        array(
            'key' => 'field_active',
            'label' => 'Active',
            'name' => 'active',
            'type' => 'true_false',
            'ui' => 1,
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'slideshow',
            ),
        ),
    ),
));

endif;

// Display the active slideshows
function sp_display_active_slideshows() {
    $args = array(
        'post_type' => 'slideshow',
        'meta_key' => 'active',
        'meta_value' => '1',
        'orderby' => 'menu_order',
        'order' => 'ASC',
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        echo '<div id="slideshow-carousel" class="carousel slide" data-bs-ride="carousel">';
        
        // Carousel Indicators
        echo '<div class="carousel-indicators">';
        $slide_count = 0;
        while ($query->have_posts()) {
            $query->the_post();
            echo '<button type="button" data-bs-target="#slideshow-carousel" data-bs-slide-to="' . $slide_count . '" class="' . ($slide_count === 0 ? 'active' : '') . '" aria-current="' . ($slide_count === 0 ? 'true' : 'false') . '" aria-label="Slide ' . ($slide_count + 1) . '"></button>';
            $slide_count++;
        }
        echo '</div>';

        // Carousel Items
        echo '<div class="carousel-inner">';
        $slide_count = 0;
        while ($query->have_posts()) {
            $query->the_post();
            $image = get_field('image');
            $description = get_field('description');
            $external_url = get_field('url');
            $internal_post = get_field('internal_post');
            $url = $external_url ? $external_url : ($internal_post ? get_permalink($internal_post) : '#');

            echo '<div class="carousel-item ' . ($slide_count === 0 ? 'active' : '') . '" style="background-image: url(' . esc_url($image) . '); background-size: cover; background-position: center;">';
            echo '<div class="carousel-caption d-none d-md-block">';
            echo '<h1>' . esc_html(get_the_title()) . '</h1>';
            echo '<p>' . esc_html($description) . '</p>';
            echo '<a href="' . esc_url($url) . '" class="btn btn-primary">Learn More</a>';
            echo '</div></div>';

            $slide_count++;
        }

        echo '</div>';
        echo '<button class="carousel-control-prev" type="button" data-bs-target="#slideshow-carousel" data-bs-slide="prev">';
        echo '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
        echo '<span class="visually-hidden">Previous</span>';
        echo '</button>';
        echo '<button class="carousel-control-next" type="button" data-bs-target="#slideshow-carousel" data-bs-slide="next">';
        echo '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
        echo '<span class="visually-hidden">Next</span>';
        echo '</button>';
        echo '</div>';
    }

    wp_reset_postdata();
}

add_shortcode('active_slideshows', 'sp_display_active_slideshows');

// Add custom columns to the admin list table
function sp_add_custom_columns($columns) {
    $columns['active'] = __('Active');
    return $columns;
}
add_filter('manage_slideshow_posts_columns', 'sp_add_custom_columns');

function sp_custom_columns_content($column, $post_id) {
    if ($column == 'active') {
        $active = get_post_meta($post_id, 'active', true);
        echo '<input type="checkbox" class="sp-active-toggle" data-post-id="' . $post_id . '" ' . checked($active, 1, false) . ' />';
    }
}
add_action('manage_slideshow_posts_custom_column', 'sp_custom_columns_content', 10, 2);


function sp_enqueue_admin_scripts() {
    wp_enqueue_script('jquery-ui-sortable');
    wp_enqueue_script('sp-admin-script', plugin_dir_url(__FILE__) . 'admin-script.js', array('jquery'), null, true);
    wp_localize_script('sp-admin-script', 'spAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('slideshow-ordering-nonce'),
    ));
    wp_localize_script('sp-admin-script', 'spAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('slideshow-active-status-nonce'),
    ));
}
add_action('admin_enqueue_scripts', 'sp_enqueue_admin_scripts', 9999);

/**
 * Handle the reorder AJAX request for slideshows.
 */
function slideshow_update_reorder() {
    check_ajax_referer('slideshow-ordering-nonce', 'nonce');

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
add_action('wp_ajax_slideshow_update_reorder', 'slideshow_update_reorder');

function sp_toggle_active_status() {
    check_ajax_referer('slideshow-active-status-nonce', 'nonce');

    if (isset($_POST['post_id']) && isset($_POST['active'])) {
        $post_id = intval($_POST['post_id']);
        $active = intval($_POST['active']);
        update_post_meta($post_id, 'active', $active);

        wp_send_json_success();
    } else {
        wp_send_json_error();
    }
}
add_action('wp_ajax_slideshow_toggle_active', 'sp_toggle_active_status');
