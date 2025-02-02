<?php
/*
Plugin Name: i-guide-search-plugin
Description: This plugin was created for the I-GUIDE website by Nattapon Jaroenchai. It adds a search icon to the navigation bar that triggers a popup search form, supports configurable search settings for post types, and displays a custom search results page with contextual snippets and keyword highlighting.
Version: 1.0
Author: Nattapon Jaroenchai
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/* --------------------------------------------------------------------------
   Enqueue Scripts and Styles
   -------------------------------------------------------------------------- */
function igsp_enqueue_scripts() {
    // Enqueue the CSS file.
    wp_enqueue_style( 'igsp-style', plugin_dir_url( __FILE__ ) . 'css/csp-style.css' );
    // Enqueue the JS file (depends on jQuery).
    wp_enqueue_script( 'igsp-script', plugin_dir_url( __FILE__ ) . 'js/csp-script.js', array('jquery'), null, true );
}
add_action( 'wp_enqueue_scripts', 'igsp_enqueue_scripts' );


/**
 * Override the search template with the plugin's template.
 *
 * @param string $template The path to the template.
 * @return string Modified template path.
 */
function igsp_template_include( $template ) {
    if ( is_search() ) {
        // Path to the search template inside the plugin.
        $plugin_template = plugin_dir_path( __FILE__ ) . 'templates/search.php';
        if ( file_exists( $plugin_template ) ) {
            return $plugin_template;
        }
    }
    return $template;
}
add_filter( 'template_include', 'igsp_template_include' );

/* --------------------------------------------------------------------------
   Add Search Icon to Navigation Menu
   -------------------------------------------------------------------------- */
// This filter appends a search icon to the menu assigned to the "primary" location.
function igsp_add_search_icon_to_nav( $items, $args ) {
    // Check if either the theme_location is 'primary' or the menu slug/name is 'primary-menu'
    if ( ( isset( $args->theme_location ) && $args->theme_location === 'primary' )
         || ( isset( $args->menu ) && $args->menu === 'primary-menu' ) ) {
        // Append the search icon list item.
        $items .= '<li class="igsp-search-icon">
                    <a href="#" id="csp-search-toggle">
                        <i class="dashicons dashicons-search"></i>
                    </a>
                   </li>';
    }
    return $items;
}
add_filter( 'wp_nav_menu_items', 'igsp_add_search_icon_to_nav', 10, 2 );

/* --------------------------------------------------------------------------
   Output the Popup Search Form in the Footer
   -------------------------------------------------------------------------- */
function igsp_search_popup() {
    ?>
    <div id="csp-search-popup" class="csp-search-popup">
        <div class="csp-search-popup-inner">
            <!-- Removed the close icon markup -->
            <form role="search" method="get" id="csp-searchform" class="csp-searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <label class="screen-reader-text" for="csp-search-input">Search for:</label>
                <input type="search" id="csp-search-input" class="search-field" placeholder="Search …" value="" name="s">
                <button type="submit" id="csp-search-submit">
                    <span class="screen-reader-text">Search</span>
                    <i class="dashicons dashicons-search"></i>
                </button>
            </form>
            <!-- Instructional text below the search box -->
            <p class="csp-search-instructions">
                Type the key word and press ENTER to search. Press ESC to close.
            </p>
        </div>
    </div>
    <?php
}
add_action( 'wp_footer', 'igsp_search_popup' );

/* --------------------------------------------------------------------------
   Modify the Search Query to Include Selected Post Types
   -------------------------------------------------------------------------- */
function igsp_modify_search_query( $query ) {
    if ( $query->is_search() && $query->is_main_query() && ! is_admin() ) {
        // Retrieve the post types selected in the admin settings.
        $post_types = get_option( 'csp_search_post_types', array( 'post' ) );
        if ( ! empty( $post_types ) ) {
            $query->set( 'post_type', $post_types );
        }
    }
}
add_action( 'pre_get_posts', 'igsp_modify_search_query' );

/* --------------------------------------------------------------------------
   Admin Settings Page: Register and Add Settings
   -------------------------------------------------------------------------- */
// Register the setting that stores our selected post types.
function igsp_register_settings() {
    register_setting( 'csp_settings_group', 'csp_search_post_types', 'csp_sanitize_post_types' );
}
add_action( 'admin_init', 'igsp_register_settings' );

// Sanitize the array of post types.
function csp_sanitize_post_types( $input ) {
    $output = array();
    if ( is_array( $input ) ) {
        foreach ( $input as $post_type ) {
            $output[] = sanitize_text_field( $post_type );
        }
    }
    return $output;
}

// Add the settings page under the Settings menu.
function igsp_add_settings_page() {
    add_options_page(
        'Content Search Settings',    // Page title.
        'Content Search',             // Menu title.
        'manage_options',             // Capability.
        'csp-settings',               // Menu slug.
        'igsp_settings_page'          // Callback to display the page.
    );
}
add_action( 'admin_menu', 'igsp_add_settings_page' );

// The settings page HTML.
function igsp_settings_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    ?>
    <div class="wrap">
        <h1>Content Search Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields( 'csp_settings_group' ); ?>
            <?php do_settings_sections( 'csp_settings_group' ); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Post Types to Search</th>
                    <td>
                        <?php
                        // Get the saved post types (default to "post").
                        $selected_post_types = get_option( 'csp_search_post_types', array( 'post' ) );
                        // Get all public post types.
                        $post_types = get_post_types( array( 'public' => true ), 'objects' );
                        foreach ( $post_types as $post_type ) {
                            ?>
                            <label style="display:block; margin-bottom: 4px;">
                                <input type="checkbox" name="csp_search_post_types[]" value="<?php echo esc_attr( $post_type->name ); ?>" <?php checked( in_array( $post_type->name, $selected_post_types ) ); ?>>
                                <?php echo esc_html( $post_type->label ); ?>
                            </label>
                            <?php
                        }
                        ?>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
