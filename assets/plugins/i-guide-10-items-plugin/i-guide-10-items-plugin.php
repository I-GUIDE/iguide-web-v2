<?php
/**
 * Plugin Name: i-guide-10-items-plugin
 * Plugin URI:  https://example.com
 * Description: Creates a top-level "10 Items" menu with options and a custom post type for content.
 * Version:     1.4
 * Author:      Nattapon Jaroenchai
 * Author URI:  https://example.com
 * Text Domain: i-guide-10-items-plugin
 * License:     GPL2
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Centralized items and content types
function iguide10_get_items() {
    return array(
        'iguide_platform'                     => 'I-GUIDE Platform',
        'spatial_ai_challenge'                => 'Spatial AI Challenge',
        'virtual_consulting_offices'          => 'Virtual Consulting Offices (VCOs)',
        'iguide_summer_schools'               => 'I-GUIDE Summer Schools',
        'convergence_curriculum'              => 'Convergence Curriculum',
        'aging_dam_infrastructure'            => 'Aging Dam Infrastructure',
        'geospatial_knowledge_hypercube'      => 'Geospatial Knowledge Hypercube',
        'extreme_events_resilience'           => 'Extreme Events & Disaster Resilience',
        'robust_geospatial_data_science'      => 'Robust Geospatial Data Science',
        'telecoupling_cross_scale_sustainability' => 'Telecoupling and Cross-scale Understanding of Sustainability',
    );
}

function iguide10_get_content_types() {
    return array(
        'platform_content' => 'Platform Content',
        'vco'              => 'VCO',
        'webinar'          => 'Webinar',
        'publication'      => 'Recent Publications',
        'iguide_team_meeting' => 'I-GUIDE Team Meeting',
        'resource'         => 'Resource',
        'in_the_news'      => 'In the News',
        'presentation'     => 'Presentation',
        'other'            => 'Other',
    );
}

/**
 * 1. Load CMB2 if not already loaded
 */
if ( ! defined( 'CMB2_LOADED' ) ) {
    require_once plugin_dir_path( __FILE__ ) . 'cmb2/init.php';
}

/**
 * 2. Create the top-level menu "10 Items"
 */
add_action( 'admin_menu', 'iguide10_add_main_menu' );
function iguide10_add_main_menu() {
    add_menu_page(
        __( '10 Items', 'i-guide-10-items-plugin' ),
        __( '10 Items', 'i-guide-10-items-plugin' ),
        'manage_options',
        'iguide10_main_menu',
        'iguide10_main_menu_callback',
        'dashicons-images-alt2',
        4
    );
}

function iguide10_main_menu_callback() {
    wp_safe_redirect( admin_url( 'admin.php?page=iguide10_options' ) );
    exit;
}

/**
 * 3. Register Settings for "Items Description" Page
 */
add_action( 'admin_init', 'iguide10_register_settings' );
function iguide10_register_settings() {
    register_setting( 'iguide10_options', 'iguide10_options' );
}

add_action( 'cmb2_admin_init', 'iguide10_register_options_page' );
function iguide10_register_options_page() {
    $cmb_options = new_cmb2_box( array(
        'id'           => 'iguide10_options_page',
        'title'        => __( 'Items Description', 'i-guide-10-items-plugin' ),
        'object_types' => array( 'options-page' ),
        'option_key'   => 'iguide10_options',
        'parent_slug'  => 'iguide10_main_menu',
        'capability'   => 'manage_options',
        'menu_title'   => __( 'Items Description', 'i-guide-10-items-plugin' ),
    ) );

    $cmb_options->add_field( array(
        'name' => 'Description',
        'desc' => 'Manage the short descriptions for each of the 10 items.',
        'id'   => 'iguide10_description_title',
        'type' => 'title',
    ) );

    $items = iguide10_get_items();
    foreach ( $items as $key => $title ) {
        $cmb_options->add_field( array(
            'name'    => $title,
            'id'      => $key,
            'type'    => 'wysiwyg',
            'options' => array( 'media_buttons' => true, 'teeny' => false ),
        ) );
    }
}

/**
 * 4. Register "Items Contents" Custom Post Type
 */
add_action( 'init', 'iguide10_register_custom_post_type' );
function iguide10_register_custom_post_type() {
    register_post_type( 'iguide10_content', array(
        'labels'        => array( 'name' => 'Items Contents', 'singular_name' => 'Item Content' ),
        'public'        => true,
        'has_archive'   => false,
        'rewrite'       => array( 'slug' => 'item-content' ),
        'show_in_menu'  => 'iguide10_main_menu',
        'supports'      => array( 'title' ),
        'menu_position' => null,
        'menu_icon'     => 'dashicons-list-view',
    ) );
}

/**
 * 5. Add Meta Fields to "Items Contents"
 */
add_action( 'cmb2_admin_init', 'iguide10_register_content_metabox' );
function iguide10_register_content_metabox() {
    $cmb = new_cmb2_box( array(
        'id'           => 'iguide10_content_metabox',
        'title'        => 'Item Content Details',
        'object_types' => array( 'iguide10_content' ),
    ) );

    $cmb->add_field( array( 'name' => 'Text for Display', 'id' => 'iguide10_text_for_display', 'type' => 'text' ) );

    $cmb->add_field( array( 'name' => 'Content URL', 'id' => 'iguide10_content_url', 'type' => 'text_url' ) );

    $cmb->add_field( array( 'name' => 'Display Content?', 'id' => 'iguide10_display_content', 'type' => 'checkbox', 'default' => 'on' ) );

    $cmb->add_field( array(
        'name'    => 'Content Type',
        'id'      => 'iguide10_content_type',
        'type'    => 'multicheck',
        'options' => iguide10_get_content_types(),
    ) );

    $cmb->add_field( array(
        'name'    => 'Belongs to Item',
        'id'      => 'iguide10_content_belongs_to',
        'type'    => 'multicheck',
        'options' => iguide10_get_items(),
    ) );
}

/**
 * 6. Add Custom Columns to Admin List Page
 */
add_filter( 'manage_iguide10_content_posts_columns', function ( $columns ) {
    unset( $columns['date'] );
    $columns['iguide10_content_type'] = 'Content Type';
    $columns['iguide10_belongs_to']    = 'Belongs to Item';
    $columns['iguide10_display']       = 'Display Content?';
    return $columns;
} );

/**
 * Populate custom columns with data.
 */
add_action( 'manage_iguide10_content_posts_custom_column', 'iguide10_render_content_columns', 10, 2 );
function iguide10_render_content_columns( $column, $post_id ) {
    if ( $column === 'iguide10_content_type' ) {
        $content_types = get_post_meta( $post_id, 'iguide10_content_type', true );
        $content_type_names = array_map( function( $type ) {
            $types = iguide10_get_content_types();
            return $types[$type] ?? $type;
        }, $content_types );
        echo is_array( $content_type_names ) ? implode( ', ', $content_type_names ) : '—';
    }

    if ( $column === 'iguide10_belongs_to' ) {
        $belongs_to = get_post_meta( $post_id, 'iguide10_content_belongs_to', true );
        $item_names = array_map( function( $item ) {
            $items = iguide10_get_items();
            return $items[$item] ?? $item;
        }, $belongs_to );
        echo is_array( $item_names ) ? implode( ', ', $item_names ) : '—';
    }

    if ( $column === 'iguide10_display' ) {
        $display = get_post_meta( $post_id, 'iguide10_display_content', true );
        echo $display === 'on' ? '<strong style="color:green;">Yes</strong>' : '<strong style="color:red;">No</strong>';
    }
}

/**
 * Enqueue Font Awesome for the carousel.
 */
function iguide10_enqueue_font_awesome() {
    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css' );
}
add_action( 'wp_enqueue_scripts', 'iguide10_enqueue_font_awesome' );

/**
 * Shortcode: [iguide10_carousel]
 * Description: Displays the "Happening in I-GUIDE" carousel with items and associated content.
 */
add_shortcode('iguide10_carousel', 'iguide10_display_carousel');
add_shortcode('iguide-10-items-w-link-icon', 'iguide10_display_carousel_with_link_icon');

function iguide10_display_carousel() {
    $options = get_option('iguide10_options', []);
    $items = iguide10_get_items();
    $content_types = iguide10_get_content_types();
    
    // Assign specific colors for content types
    $content_type_colors = array(
        '#0F5C98', // rgb(15, 92, 152)
        '#2FA9A3', // rgb(47, 169, 163)
        '#63853A', // rgb(99, 133, 58)
        '#9ECDA2', // rgb(158, 205, 162)
        '#F18149', // rgb(241, 129, 73)
        '#E7B52F', // rgb(231, 181, 47)
    );

    // Assign relevant icons for each item
    $item_icons = array(
        'aging_dam_infrastructure'            => 'fa-solid fa-water',
        'convergence_curriculum'              => 'fa-solid fa-book',
        'extreme_events_resilience'           => 'fa-solid fa-exclamation-triangle',
        'robust_geospatial_data_science'      => 'fa-solid fa-globe',
        'geospatial_knowledge_hypercube'      => 'fa-solid fa-cube',
        'iguide_platform'                     => 'fa-solid fa-desktop',
        'spatial_ai_challenge'                => 'fa-solid fa-robot',
        'iguide_summer_schools'               => 'fa-solid fa-school',
        'telecoupling_cross_scale_sustainability' => 'fa-solid fa-recycle',
        'virtual_consulting_offices'          => 'fa-solid fa-comments',
    );
    
    // Get content items
    $args = array(
        'post_type'      => 'iguide10_content',
        'posts_per_page' => -1,
        'meta_query'     => array(
            array(
                'key'     => 'iguide10_display_content',
                'value'   => 'on',
                'compare' => '='
            )
        )
    );
    $query = new WP_Query($args);
    $content_items = [];

    while ($query->have_posts()) {
        $query->the_post();
        $content_type = get_post_meta(get_the_ID(), 'iguide10_content_type', true);
        $belongs_to = get_post_meta(get_the_ID(), 'iguide10_content_belongs_to', true);
        
        if (is_array($belongs_to)) {
            foreach ($belongs_to as $belong) {
                if (!isset($content_items[$belong])) {
                    $content_items[$belong] = [];
                }
                foreach ($content_type as $type) {
                    if (!isset($content_items[$belong][$type])) {
                        $content_items[$belong][$type] = [];
                    }
                    $url = get_post_meta(get_the_ID(), 'iguide10_content_url', true);
                    $text = esc_html(get_post_meta(get_the_ID(), 'iguide10_text_for_display', true) ?: get_the_title());
                    $content_items[$belong][$type][] = $url ? '<a href="' . esc_url($url) . '" target="_blank">' . $text . '</a>' : $text;
                }
            }
        }
    }
    wp_reset_postdata();

    ob_start();
    ?>
    <div id="iguide-carousel">
        <div id="iguide-left-panel">
            <ul>
                <?php 
                $color_count = count($content_type_colors);
                $index = 0;
                foreach ($items as $key => $title): 
                    $color = $content_type_colors[$index % $color_count];
                    $index++;
                ?>
                    <li class="iguide-item <?php echo $key === array_key_first($items) ? 'active' : ''; ?>" data-key="<?php echo esc_attr($key); ?>" style="--item-color: <?php echo esc_attr($color); ?>;">
                        <span class="iguide-icon"><i class="<?php echo esc_attr($item_icons[$key]); ?>"></i></span>
                        <span class="iguide-title"> <?php echo esc_html($title); ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div id="iguide-content">
            <h2 id="iguide-title"></h2>
            <p id="iguide-description"></p>
            <div id="iguide-links"></div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const items = <?php echo json_encode($items); ?>;
            const contentItems = <?php echo json_encode($content_items); ?>;
            const descriptions = <?php echo json_encode($options); ?>;
            const contentTypes = <?php echo json_encode($content_types); ?>;
            const contentTypeColors = <?php echo json_encode($content_type_colors); ?>;
            const listItems = document.querySelectorAll(".iguide-item");
            const titleDisplay = document.getElementById("iguide-title");
            const descriptionDisplay = document.getElementById("iguide-description");
            const linksDisplay = document.getElementById("iguide-links");

            function updateContent(key) {
                titleDisplay.innerText = items[key];
                descriptionDisplay.innerHTML = descriptions[key] || "";
                linksDisplay.innerHTML = "";
                
                if (contentItems[key]) {
                    let colorIndex = 0;
                    for (const type in contentItems[key]) {
                        if (contentItems[key][type].length > 0) {
                            let typeHTML = ``;
                            if (contentItems[key][type].length === 1) {
                                typeHTML += `<p><strong style="color:${contentTypeColors[colorIndex % contentTypeColors.length]};">${contentTypes[type]}:</strong>`;
                                typeHTML += ` ${contentItems[key][type][0]}</p>`;
                            } else {
                                typeHTML += `<p><strong style="color:${contentTypeColors[colorIndex % contentTypeColors.length]};">${contentTypes[type]}:</strong>`;
                                typeHTML += `<ul>`;
                                contentItems[key][type].forEach(content => {
                                    typeHTML += `<li>${content}</li>`;
                                });
                                typeHTML += `</ul></p>`;
                            }
                            linksDisplay.innerHTML += typeHTML;
                            colorIndex++;
                        }
                    }
                }
            }
            
            listItems.forEach((item, index) => {
                item.addEventListener("click", function() {
                    document.querySelectorAll(".iguide-item").forEach(el => el.classList.remove("active"));
                    item.classList.add("active");
                    updateContent(item.dataset.key);
                    currentIndex = index; // Update currentIndex to the clicked item
                    clearInterval(autoplayInterval); // Clear the existing interval
                    setTimeout(() => {
                        clearInterval(autoplayInterval); // Clear any existing interval before setting a new one
                        autoplayInterval = setInterval(autoplayCarousel, 5000); // Restart autoplay after 4 seconds
                    }, 4000);
                });
            });
            
            updateContent(Object.keys(items)[0]);

            // Autoplay functionality
            let currentIndex = 0;
            const totalItems = listItems.length;

            function autoplayCarousel() {
                currentIndex = (currentIndex + 1) % totalItems;
                listItems[currentIndex].click();
            }

            let autoplayInterval = setInterval(autoplayCarousel, 5000); // Change slide every 5 seconds
        });
    </script>

    <style>
        #iguide-carousel {
            display: flex;
            padding: 20px 0px;
        }
        #iguide-left-panel {
            width: 30%;
            border-right: 2px solid #ddd;
        }
        #iguide-left-panel ul {
            list-style: none;
            padding: 0;
        }
        .iguide-item {
            display: flex;
            align-items: center;
            padding: 10px;
            cursor: pointer;
            background-color: white; /* White background for inactive items */
        }
        .iguide-item.active {
            font-weight: bold;
            color: black;
            background-color: var(--item-color); /* Normal hue for active items */
        }
        .iguide-icon {
            margin-right: 10px;
        }
        #iguide-content {
            flex: 1;
            padding: 0 20px;
        }
        #iguide-title {
            font-size: 24px;
            font-weight: bold;
        }
        #iguide-links p {
            margin: 5px 0 0;
        }
        #iguide-links ul {
            list-style: disc;
            padding-left: 20px;
        }
    </style>
    <?php
    return ob_get_clean();
}

function iguide10_display_carousel_with_link_icon() {
    $options = get_option('iguide10_options', []);
    $items = iguide10_get_items();
    $content_types = iguide10_get_content_types();
    
    // Assign specific colors for content types
    $content_type_colors = array(
        '#0F5C98', // rgb(15, 92, 152)
        '#2FA9A3', // rgb(47, 169, 163)
        '#63853A', // rgb(99, 133, 58)
        '#9ECDA2', // rgb(158, 205, 162)
        '#F18149', // rgb(241, 129, 73)
        '#E7B52F', // rgb(231, 181, 47)
    );

    // Assign relevant icons for each item
    $item_icons = array(
        'aging_dam_infrastructure'            => 'fa-solid fa-water',
        'convergence_curriculum'              => 'fa-solid fa-book',
        'extreme_events_resilience'           => 'fa-solid fa-exclamation-triangle',
        'robust_geospatial_data_science'      => 'fa-solid fa-globe',
        'geospatial_knowledge_hypercube'      => 'fa-solid fa-cube',
        'iguide_platform'                     => 'fa-solid fa-desktop',
        'spatial_ai_challenge'                => 'fa-solid fa-robot',
        'iguide_summer_schools'               => 'fa-solid fa-school',
        'telecoupling_cross_scale_sustainability' => 'fa-solid fa-recycle',
        'virtual_consulting_offices'          => 'fa-solid fa-comments',
    );
    
    // Get content items
    $args = array(
        'post_type'      => 'iguide10_content',
        'posts_per_page' => -1,
        'meta_query'     => array(
            array(
                'key'     => 'iguide10_display_content',
                'value'   => 'on',
                'compare' => '='
            )
        )
    );
    $query = new WP_Query($args);
    $content_items = [];

    while ($query->have_posts()) {
        $query->the_post();
        $content_type = get_post_meta(get_the_ID(), 'iguide10_content_type', true);
        $belongs_to = get_post_meta(get_the_ID(), 'iguide10_content_belongs_to', true);
        
        if (is_array($belongs_to)) {
            foreach ($belongs_to as $belong) {
                if (!isset($content_items[$belong])) {
                    $content_items[$belong] = [];
                }
                foreach ($content_type as $type) {
                    if (!isset($content_items[$belong][$type])) {
                        $content_items[$belong][$type] = [];
                    }
                    $url = get_post_meta(get_the_ID(), 'iguide10_content_url', true);
                    $text = esc_html(get_post_meta(get_the_ID(), 'iguide10_text_for_display', true) ?: get_the_title());
                    $content_items[$belong][$type][] = $url ? $text . ' <a href="' . esc_url($url) . '" target="_blank"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>' : $text;
                }
            }
        }
    }
    wp_reset_postdata();

    ob_start();
    ?>
    <div id="iguide-carousel">
        <div id="iguide-left-panel">
            <ul>
                <?php 
                $color_count = count($content_type_colors);
                $index = 0;
                foreach ($items as $key => $title): 
                    $color = $content_type_colors[$index % $color_count];
                    $index++;
                ?>
                    <li class="iguide-item <?php echo $key === array_key_first($items) ? 'active' : ''; ?>" data-key="<?php echo esc_attr($key); ?>" style="--item-color: <?php echo esc_attr($color); ?>;">
                        <span class="iguide-icon"><i class="<?php echo esc_attr($item_icons[$key]); ?>"></i></span>
                        <span class="iguide-title"> <?php echo esc_html($title); ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div id="iguide-content">
            <h2 id="iguide-title"></h2>
            <p id="iguide-description"></p>
            <div id="iguide-links"></div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const items = <?php echo json_encode($items); ?>;
            const contentItems = <?php echo json_encode($content_items); ?>;
            const descriptions = <?php echo json_encode($options); ?>;
            const contentTypes = <?php echo json_encode($content_types); ?>;
            const contentTypeColors = <?php echo json_encode($content_type_colors); ?>;
            const listItems = document.querySelectorAll(".iguide-item");
            const titleDisplay = document.getElementById("iguide-title");
            const descriptionDisplay = document.getElementById("iguide-description");
            const linksDisplay = document.getElementById("iguide-links");

            function updateContent(key) {
                titleDisplay.innerText = items[key];
                descriptionDisplay.innerHTML = descriptions[key] || "";
                linksDisplay.innerHTML = "";
                
                if (contentItems[key]) {
                    let colorIndex = 0;
                    for (const type in contentItems[key]) {
                        if (contentItems[key][type].length > 0) {
                            let typeHTML = ``;
                            if (contentItems[key][type].length === 1) {
                                typeHTML += `<p><strong style="color:${contentTypeColors[colorIndex % contentTypeColors.length]};">${contentTypes[type]}:</strong>`;
                                typeHTML += ` ${contentItems[key][type][0]}</p>`;
                            } else {
                                typeHTML += `<p><strong style="color:${contentTypeColors[colorIndex % contentTypeColors.length]};">${contentTypes[type]}:</strong>`;
                                typeHTML += `<ul>`;
                                contentItems[key][type].forEach(content => {
                                    typeHTML += `<li>${content}</li>`;
                                });
                                typeHTML += `</ul></p>`;
                            }
                            linksDisplay.innerHTML += typeHTML;
                            colorIndex++;
                        }
                    }
                }
            }
            
            listItems.forEach((item, index) => {
                item.addEventListener("click", function() {
                    document.querySelectorAll(".iguide-item").forEach(el => el.classList.remove("active"));
                    item.classList.add("active");
                    updateContent(item.dataset.key);
                    currentIndex = index; // Update currentIndex to the clicked item
                    clearInterval(autoplayInterval); // Clear the existing interval
                    setTimeout(() => {
                        clearInterval(autoplayInterval); // Clear any existing interval before setting a new one
                        autoplayInterval = setInterval(autoplayCarousel, 5000); // Restart autoplay after 4 seconds
                    }, 4000);
                });
            });
            
            updateContent(Object.keys(items)[0]);

            // Autoplay functionality
            let currentIndex = 0;
            const totalItems = listItems.length;

            function autoplayCarousel() {
                currentIndex = (currentIndex + 1) % totalItems;
                listItems[currentIndex].click();
            }

            let autoplayInterval = setInterval(autoplayCarousel, 5000); // Change slide every 5 seconds
        });
    </script>

    <style>
        #iguide-carousel {
            display: flex;
            padding: 20px 0px;
        }
        #iguide-left-panel {
            width: 30%;
            border-right: 2px solid #ddd;
        }
        #iguide-left-panel ul {
            list-style: none;
            padding: 0;
        }
        .iguide-item {
            display: flex;
            align-items: center;
            padding: 10px;
            cursor: pointer;
            background-color: white; /* White background for inactive items */
        }
        .iguide-item.active {
            font-weight: bold;
            color: black;
            background-color: var(--item-color); /* Normal hue for active items */
        }
        .iguide-icon {
            margin-right: 10px;
        }
        #iguide-content {
            flex: 1;
            padding: 0 20px;
        }
        #iguide-title {
            font-size: 24px;
            font-weight: bold;
        }
        #iguide-links p {
            margin: 5px 0 0;
        }
        #iguide-links ul {
            list-style: disc;
            padding-left: 20px;
        }
    </style>
    <?php
    return ob_get_clean();
}

function iguide10_get_frontier_content($key) {
    $options = get_option('iguide10_options', []);
    $items = iguide10_get_items();
    $content_types = iguide10_get_content_types();

    if (!isset($items[$key])) {
        return '<p>No content available for this frontier.</p>';
    }

    // Retrieve the description
    $description = $options[$key] ?? '';

    // Get related content items
    $args = array(
        'post_type'      => 'iguide10_content',
        'posts_per_page' => -1,
        'meta_query'     => array(
            array(
                'key'     => 'iguide10_display_content',
                'value'   => 'on',
                'compare' => '='
            ),
            array(
                'key'     => 'iguide10_content_belongs_to',
                'value'   => $key,
                'compare' => 'LIKE'
            )
        )
    );

    $query = new WP_Query($args);
    $content_items = [];

    while ($query->have_posts()) {
        $query->the_post();
        $content_type = get_post_meta(get_the_ID(), 'iguide10_content_type', true);
        $url = get_post_meta(get_the_ID(), 'iguide10_content_url', true);
        $text = esc_html(get_post_meta(get_the_ID(), 'iguide10_text_for_display', true) ?: get_the_title());

        if (!empty($content_type) && is_array($content_type)) {
            foreach ($content_type as $type) {
                if (!isset($content_items[$type])) {
                    $content_items[$type] = [];
                }
                $content_items[$type][] = $url
                    ? $text . ' <a href="' . esc_url($url) . '" target="_blank"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>'
                    : $text;
            }
        }
    }
    wp_reset_postdata();

    // Build the output
    $output = '<p>' . wp_kses_post($description) . '</p>';

    if (!empty($content_items)) {
        foreach ($content_items as $type => $contents) {
            $type_name = $content_types[$type] ?? ucfirst($type);
            $output .= '<h4>' . esc_html($type_name) . '</h4>';
            $output .= '<ul>';
            foreach ($contents as $content) {
                $output .= '<li>' . $content . '</li>';
            }
            $output .= '</ul>';
        }
    }

    return $output;
}


?>