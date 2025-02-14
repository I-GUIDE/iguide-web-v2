<?php
/**
 * Plugin Name: i-guide-10-items-plugin
 * Plugin URI:  https://example.com
 * Description: Creates a single "10 Items" options page with 10 separate CMB2 fields.
 * Version:     1.2
 * Author:      Nattapon Jaroenchai
 * Author URI:  https://example.com
 * Text Domain: i-guide-10-items-plugin
 * License:     GPL2
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * 1. Load CMB2 if not already loaded
 */
if ( ! defined( 'CMB2_LOADED' ) ) {
    require_once plugin_dir_path( __FILE__ ) . 'cmb2/init.php';
}

/**
 * 2. Register Settings to Ensure Data Saves
 */
add_action( 'admin_init', 'iguide10_register_settings' );
function iguide10_register_settings() {
    register_setting( 'iguide10_options', 'iguide10_options' );
}

/**
 * 3. Enqueue Font Awesome for Icons
 */
add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css' );
});

/**
 * 4. Create the "10 Items" Options Page with One Save Button
 */
add_action( 'cmb2_admin_init', 'iguide10_register_options_page' );
function iguide10_register_options_page() {
    $cmb_options = new_cmb2_box( array(
        'id'           => 'iguide10_options_page',
        'title'        => __( '10 Items', 'i-guide-10-items-plugin' ),
        'object_types' => array( 'options-page' ), 
        'option_key'   => 'iguide10_options', 
        'menu_title'   => __( '10 Items', 'i-guide-10-items-plugin' ),
        'position'     => 4,
    ) );

    $cmb_options->add_field( array(
        'name' => 'Description',
        'desc' => 'Manage your 10 items from here.',
        'id'   => 'iguide10_description',
        'type' => 'title',
    ) );

    $boxes = iguide10_get_boxes();

    foreach ( $boxes as $box ) {
        $cmb_options->add_field( array(
            'name'    => $box['title'],
            'id'      => $box['field_id'],
            'type'    => 'wysiwyg',
            'options' => array(
                'media_buttons' => true,
                'teeny'         => false,
            ),
        ) );
    }
}

/**
 * 5. Define the 10 Meta Box Configurations
 */
function iguide10_get_boxes() {
    return array(
        array( 'title' => 'Aging Dams Infrastructure', 'field_id' => 'aging_dams_infrastructure' ),
        array( 'title' => 'Convergence Curriculum', 'field_id' => 'convergence_curriculum' ),
        array( 'title' => 'Extreme Events & Disaster Resilience', 'field_id' => 'extreme_events_resilience' ),
        array( 'title' => 'Robust Data Science Research', 'field_id' => 'robust_data_science' ),
        array( 'title' => 'Geospatial Knowledge Hypercube', 'field_id' => 'geospatial_knowledge_hypercube' ),
        array( 'title' => 'I-GUIDE Platform', 'field_id' => 'iguide_platform' ),
        array( 'title' => 'Spatial AI Challenge', 'field_id' => 'spatial_ai_challenge' ),
        array( 'title' => 'Summer Schools', 'field_id' => 'summer_schools' ),
        array( 'title' => 'Telecoupling & Sustainability', 'field_id' => 'telecoupling_sustainability' ),
        array( 'title' => 'Virtual Consulting Offices (VCOs)', 'field_id' => 'virtual_consulting_offices' ),
    );
}

/**
 * 6. Display the Carousel Using a Shortcode
 */
add_shortcode( 'iguide10_carousel', 'iguide10_display_carousel' );

function iguide10_display_carousel() {
    $options = get_option( 'iguide10_options', array() );

    // Define items with Font Awesome icons
    $items = array(
        'aging_dams_infrastructure'       => array( 'title' => 'Aging Dams Infrastructure', 'icon' => 'fa-solid fa-industry' ),
        'convergence_curriculum'          => array( 'title' => 'Convergence Curriculum', 'icon' => 'fa-solid fa-graduation-cap' ),
        'extreme_events_resilience'       => array( 'title' => 'Extreme Events & Disaster Resilience', 'icon' => 'fa-solid fa-exclamation-triangle' ),
        'robust_data_science'             => array( 'title' => 'Robust Data Science Research', 'icon' => 'fa-solid fa-flask' ),
        'geospatial_knowledge_hypercube'  => array( 'title' => 'Geospatial Knowledge Hypercube', 'icon' => 'fa-solid fa-globe' ),
        'iguide_platform'                 => array( 'title' => 'I-GUIDE Platform', 'icon' => 'fa-solid fa-laptop-code' ),
        'spatial_ai_challenge'            => array( 'title' => 'Spatial AI Challenge', 'icon' => 'fa-solid fa-brain' ),
        'summer_schools'                  => array( 'title' => 'Summer Schools', 'icon' => 'fa-solid fa-school' ),
        'telecoupling_sustainability'     => array( 'title' => 'Telecoupling & Sustainability', 'icon' => 'fa-solid fa-leaf' ),
        'virtual_consulting_offices'      => array( 'title' => 'Virtual Consulting Offices (VCOs)', 'icon' => 'fa-solid fa-headset' ),
    );

    ob_start();
    ?>
    <div id="iguide-carousel">
        <div id="iguide-left-panel">
            <ul>
                <?php foreach ( $items as $key => $item ) : ?>
                    <li data-key="<?php echo esc_attr( $key ); ?>" class="iguide-item">
                        <span class="iguide-icon"><i class="<?php echo esc_attr( $item['icon'] ); ?>"></i></span>
                        <span class="iguide-title"><?php echo esc_html( $item['title'] ); ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div id="iguide-content">
            <div id="iguide-display">
                <div id="iguide-large-icon"></div>
                <h2 id="iguide-title"></h2>
                <p id="iguide-description"></p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const items = <?php echo json_encode($items); ?>;
            const descriptions = <?php echo json_encode($options); ?>;
            const listItems = document.querySelectorAll(".iguide-item");
            const iconDisplay = document.getElementById("iguide-large-icon");
            const titleDisplay = document.getElementById("iguide-title");
            const descriptionDisplay = document.getElementById("iguide-description");

            let currentIndex = 0;
            let autoPlayInterval;
            let userInteraction = false;
            const autoPlayDelay = 5000; // Auto-play delay (4 seconds)

            function updateContent(index) {
                const keys = Object.keys(items);
                const key = keys[index];

                if (items[key]) {
                    iconDisplay.innerHTML = `<i class="${items[key].icon}"></i>`;
                    titleDisplay.innerHTML = items[key].title;
                    descriptionDisplay.innerHTML = descriptions[key] || "No description available.";

                    document.querySelectorAll(".iguide-item").forEach(el => el.classList.remove("active"));
                    listItems[index].classList.add("active");
                }
            }

            function startAutoPlay() {
                clearInterval(autoPlayInterval); // Ensure no duplicate intervals
                autoPlayInterval = setInterval(() => {
                    if (!userInteraction) {
                        currentIndex = (currentIndex + 1) % listItems.length;
                        updateContent(currentIndex);
                    }
                }, autoPlayDelay);
            }

            function resetAutoPlay() {
                userInteraction = true;
                clearInterval(autoPlayInterval); // Clear existing interval
                setTimeout(() => {
                    userInteraction = false;
                    startAutoPlay(); // Restart auto-play after 5 seconds of inactivity
                }, 5000);
            }

            listItems.forEach((item, index) => {
                item.addEventListener("click", function() {
                    currentIndex = index;
                    updateContent(index);
                    resetAutoPlay(); // Reset and restart auto-play after delay
                });
            });

            // Initialize with the first item
            if (listItems.length > 0) {
                updateContent(0);
                startAutoPlay();
            }
        });
    </script>

<style>
        #iguide-carousel {
            display: flex;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            /* box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); */
            width: 100%;
            margin: auto;
        }

        #iguide-left-panel {
            width: 25%;
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
            font-size: 16px;
            transition: background 0.3s;
        }

        .iguide-item:hover {
            background: #f3f3f3;
        }

        .iguide-item.active {
            font-weight: bold;
            color: #008000;
        }

        .iguide-icon {
            font-size: 24px;
            margin-right: 10px;
        }

        #iguide-content {
            flex: 1;
            text-align: center;
            padding: 20px;
        }

        #iguide-large-icon {
            font-size: 80px;
            margin-bottom: 10px;
        }

        #iguide-title {
            font-size: 24px;
            font-weight: bold;
            color: #008000;
        }

        #iguide-description {
            font-size: 16px;
        }
    </style>
    <?php
    return ob_get_clean();
}
