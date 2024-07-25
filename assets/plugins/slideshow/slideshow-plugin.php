<?php
/**
 * Plugin Name: Slideshow Plugin
 * Description: A plugin to create a slideshow post type with ACF fields.
 * Version: 1.02
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
        'supports'              => array( 'title', 'thumbnail' ),
        'has_archive'           => true,
        'rewrite'               => array( 'slug' => 'slideshows' ),
        'show_in_rest'          => true,
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
        'order' => 'ASC'
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
            echo '<div class="carousel-caption d-none d-md-block" style="z-index:1000;">';
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
