<?php
/**
 * Plugin Name: VCO Plugin
 * Description: A plugin to manage VCO events with multiple speakers.
 * Version: 1.6
 * Author: Nattapon Jaroenchai
 * Text Domain: vco-plugin
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register Custom Post Type: VCO
 */
function vco_register_custom_post_type() {
    $labels = array(
        'name'                  => _x( 'VCOs', 'Post Type General Name', 'vco-plugin' ),
        'singular_name'         => _x( 'VCO', 'Post Type Singular Name', 'vco-plugin' ),
        'menu_name'             => __( 'VCOs', 'vco-plugin' ),
        'name_admin_bar'        => __( 'VCO', 'vco-plugin' ),
        'archives'              => __( 'VCO Archives', 'vco-plugin' ),
        'attributes'            => __( 'VCO Attributes', 'vco-plugin' ),
        'parent_item_colon'     => __( 'Parent VCO:', 'vco-plugin' ),
        'all_items'             => __( 'All VCOs', 'vco-plugin' ),
        'add_new_item'          => __( 'Add New VCO', 'vco-plugin' ),
        'add_new'               => __( 'Add New', 'vco-plugin' ),
        'new_item'              => __( 'New VCO', 'vco-plugin' ),
        'edit_item'             => __( 'Edit VCO', 'vco-plugin' ),
        'update_item'           => __( 'Update VCO', 'vco-plugin' ),
        'view_item'             => __( 'View VCO', 'vco-plugin' ),
        'view_items'            => __( 'View VCOs', 'vco-plugin' ),
        'search_items'          => __( 'Search VCO', 'vco-plugin' ),
        'not_found'             => __( 'Not found', 'vco-plugin' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'vco-plugin' ),
        'featured_image'        => __( 'Featured Image', 'vco-plugin' ),
        'set_featured_image'    => __( 'Set featured image', 'vco-plugin' ),
        'remove_featured_image' => __( 'Remove featured image', 'vco-plugin' ),
        'use_featured_image'    => __( 'Use as featured image', 'vco-plugin' ),
        'insert_into_item'      => __( 'Insert into VCO', 'vco-plugin' ),
        'uploaded_to_this_item' => __( 'Uploaded to this VCO', 'vco-plugin' ),
        'items_list'            => __( 'VCOs list', 'vco-plugin' ),
        'items_list_navigation' => __( 'VCOs list navigation', 'vco-plugin' ),
        'filter_items_list'     => __( 'Filter VCOs list', 'vco-plugin' ),
    );

    $args = array(
        'label'                 => __( 'VCO', 'vco-plugin' ),
        'description'           => __( 'Virtual Conference Organizer', 'vco-plugin' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'thumbnail' ),
        'taxonomies'            => array(),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-calendar',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        // 'has_archive'           => true,
        // 'rewrite'               => array( 'slug' => 'vco' ),
        'has_archive'        => 'i-guide-vco', // Updated archive slug
        'rewrite'            => array( 'slug' => 'i-guide-vco' ), // Updated post type slug
    );
    register_post_type( 'vco', $args );
}
add_action( 'init', 'vco_register_custom_post_type' );

/**
 * Flush rewrite rules on activation.
 */
function vco_rewrite_flush() {
    vco_register_custom_post_type();
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'vco_rewrite_flush' );

/**
 * Include CMB2 Library.
 */
if ( file_exists( plugin_dir_path( __FILE__ ) . 'cmb2/init.php' ) ) {
    require_once plugin_dir_path( __FILE__ ) . 'cmb2/init.php';
}

/**
 * Register Metaboxes using CMB2.
 */
function vco_register_metaboxes() {

    // Main metabox for VCO details
    $cmb = new_cmb2_box( array(
        'id'            => 'vco_details_metabox',
        'title'         => __( 'VCO Details', 'vco-plugin' ),
        'object_types'  => array( 'vco' ),
    ) );

    // Date and time of the VCO
    $cmb->add_field( array(
        'name' => __( 'Date and Time', 'vco-plugin' ),
        'id'   => 'vco_date_time',
        'type' => 'text_datetime_timestamp',
    ) );

    // Registration link
    $cmb->add_field( array(
        'name' => __( 'Registration Link', 'vco-plugin' ),
        'id'   => 'vco_registration_link',
        'type' => 'text_url',
    ) );

    // Abstract
    $cmb->add_field( array(
        'name' => __( 'Abstract', 'vco-plugin' ),
        'id'   => 'vco_abstract',
        'type' => 'wysiwyg',
    ) );

    // **Add the new Embedded Video Code field**
    $cmb->add_field( array(
        'name' => __( 'Embedded Video Code', 'vco-plugin' ),
        'id'   => 'vco_embedded_video',
        'type' => 'textarea_code',
        'description' => __( 'Paste the embedded video code here (e.g., YouTube embed code).', 'vco-plugin' ),
        'sanitization_cb' => false, // We'll handle sanitization during output
    ) );

    // Speakers (repeatable group)
    $group_field_id = $cmb->add_field( array(
        'id'          => 'vco_speakers',
        'type'        => 'group',
        'description' => __( 'Add speakers for this VCO', 'vco-plugin' ),
        'options'     => array(
            'group_title'   => __( 'Speaker {#}', 'vco-plugin' ),
            'add_button'    => __( 'Add Another Speaker', 'vco-plugin' ),
            'remove_button' => __( 'Remove Speaker', 'vco-plugin' ),
            'sortable'      => true,
        ),
    ) );

    // Speaker Name
    $cmb->add_group_field( $group_field_id, array(
        'name' => __( 'Name', 'vco-plugin' ),
        'id'   => 'name',
        'type' => 'text',
    ) );

    // Speaker Affiliation
    $cmb->add_group_field( $group_field_id, array(
        'name' => __( 'Affiliation', 'vco-plugin' ),
        'id'   => 'affiliation',
        'type' => 'text',
    ) );

    // Speaker Photo
    $cmb->add_group_field( $group_field_id, array(
        'name' => __( 'Photo', 'vco-plugin' ),
        'id'   => 'photo',
        'type' => 'file',
    ) );

    // Speaker Bio
    $cmb->add_group_field( $group_field_id, array(
        'name' => __( 'Bio', 'vco-plugin' ),
        'id'   => 'bio',
        'type' => 'wysiwyg',
        'options' => array(
            'media_buttons' => false,
            'textarea_rows' => 5,
        ),
    ) );

}
add_action( 'cmb2_admin_init', 'vco_register_metaboxes' );

/**
 * Enqueue Styles for the VCO Archive Page.
 */
function vco_enqueue_styles() {
    if ( is_post_type_archive( 'vco' ) || is_singular( 'vco' ) ) {
        wp_enqueue_style( 'vco-styles', plugin_dir_url( __FILE__ ) . 'css/vco-styles.css' );
    }
}
add_action( 'wp_enqueue_scripts', 'vco_enqueue_styles' );

/**
 * Modify the title of the VCO Archive Page.
 */
function vco_archive_title_tag( $title ) {
    if ( is_post_type_archive( 'vco' ) ) {
        $title['title'] = 'I-GUIDE Virtual Consulting Office';
    }
    return $title;
}
add_filter( 'document_title_parts', 'vco_archive_title_tag' );


/**
 * Modify the content on the VCO Archive Page.
 */
function vco_modify_archive_content( $content ) {
    if ( is_post_type_archive( 'vco' ) && in_the_loop() && is_main_query() ) {
        global $post;

        // Get meta values
        $date_time = get_post_meta( $post->ID, 'vco_date_time', true );
        $speakers  = get_post_meta( $post->ID, 'vco_speakers', true );

        $output = '';

        // Display date and time
        if ( $date_time ) {
            $output .= '<p><strong>Date and Time:</strong> ' . date( 'F j, Y g:i a', $date_time ) . '</p>';
        }

        // Display speakers
        if ( ! empty( $speakers ) ) {
            $output .= '<h4>Speakers:</h4>';
            $output .= '<ul>';
            foreach ( $speakers as $speaker ) {
                $name = isset( $speaker['name'] ) ? $speaker['name'] : '';
                $affiliation = isset( $speaker['affiliation'] ) ? $speaker['affiliation'] : '';
                $output .= '<li>' . esc_html( $name ) . ' - ' . esc_html( $affiliation ) . '</li>';
            }
            $output .= '</ul>';
        }

        return $content . $output;
    }

    return $content;
}
add_filter( 'the_excerpt', 'vco_modify_archive_content' );

/**
 * Modify the content on the Single VCO Page.
 */
function vco_modify_single_content( $content ) {
    if ( is_singular( 'vco' ) && in_the_loop() && is_main_query() ) {
        global $post;

        // Get meta values
        $date_time = get_post_meta( $post->ID, 'vco_date_time', true );
        $registration_link = get_post_meta( $post->ID, 'vco_registration_link', true );
        $abstract = get_post_meta( $post->ID, 'vco_abstract', true );
        $speakers = get_post_meta( $post->ID, 'vco_speakers', true );

        $output = '';

        // Display date and time
        if ( $date_time ) {
            $output .= '<p><strong>Date and Time:</strong> ' . date( 'F j, Y g:i a', $date_time ) . '</p>';
        }

        // Display registration link
        if ( $registration_link ) {
            $output .= '<p><a href="' . esc_url( $registration_link ) . '" target="_blank">Register Here</a></p>';
        }

        // Display abstract
        if ( $abstract ) {
            $output .= '<h3>Abstract</h3>';
            $output .= wpautop( $abstract );
        }

        // Display speakers
        if ( ! empty( $speakers ) ) {
            $output .= '<h3>Speakers</h3>';
            foreach ( $speakers as $speaker ) {
                $name = isset( $speaker['name'] ) ? $speaker['name'] : '';
                $affiliation = isset( $speaker['affiliation'] ) ? $speaker['affiliation'] : '';
                $photo = isset( $speaker['photo_id'] ) ? wp_get_attachment_url( $speaker['photo_id'] ) : '';
                $bio = isset( $speaker['bio'] ) ? $speaker['bio'] : '';

                $output .= '<div class="vco-speaker">';
                if ( $photo ) {
                    $output .= '<img src="' . esc_url( $photo ) . '" alt="' . esc_attr( $name ) . '" style="max-width:150px;"/>';
                }
                $output .= '<h4>' . esc_html( $name ) . '</h4>';
                $output .= '<p><em>' . esc_html( $affiliation ) . '</em></p>';
                if ( $bio ) {
                    $output .= wpautop( $bio );
                }
                $output .= '</div>';
            }
        }

        return $content . $output;
    }

    return $content;
}
add_filter( 'the_content', 'vco_modify_single_content' );


/**
 * Add custom columns to VCO admin list table.
 */
function vco_custom_columns( $columns ) {
    // Save the date column
    $date = $columns['date'];
    unset( $columns['date'] );

    // Insert our custom columns
    $columns['vco_date'] = __( 'Date', 'vco-plugin' );

    // Add back the date column at the end
    $columns['date'] = $date;

    return $columns;
}
add_filter( 'manage_vco_posts_columns', 'vco_custom_columns' );


/**
 * Populate custom columns with data.
 */
function vco_custom_column_content( $column_name, $post_id ) {
    if ( $column_name == 'vco_date' ) {
        $date_time = get_post_meta( $post_id, 'vco_date_time', true );
        if ( $date_time ) {
            echo date_i18n( 'F j, Y g:i a', $date_time );
        } else {
            echo __( 'N/A', 'vco-plugin' );
        }
    }
}
add_action( 'manage_vco_posts_custom_column', 'vco_custom_column_content', 10, 2 );



/**
 * Template loader for VCO post type.
 */
function vco_template_loader( $template ) {
    if ( is_singular( 'vco' ) ) {
        // Check for single template in theme
        $theme_template = locate_template( array( 'single-vco.php' ) );
        if ( $theme_template ) {
            return $theme_template;
        } else {
            // Use plugin template
            return plugin_dir_path( __FILE__ ) . 'templates/single-vco.php';
        }
    }

    if ( is_post_type_archive( 'vco' ) ) {
        // Check for archive template in theme
        $theme_template = locate_template( array( 'archive-vco.php' ) );
        if ( $theme_template ) {
            return $theme_template;
        } else {
            // Use plugin template
            return plugin_dir_path( __FILE__ ) . 'templates/archive-vco.php';
        }
    }

    return $template;
}
add_filter( 'template_include', 'vco_template_loader' );
