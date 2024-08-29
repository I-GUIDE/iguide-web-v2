<?php

// function redirect_news_events_to_external_url() {
    
//     if ( is_singular('news_events') ) {
        
//         // Get the external URL from the ACF field 'external_link'
//         $external_url = get_field("external_link");

//         // Check if the external URL is set and not empty
//         if ( $external_url ) {
//             // Debugging: Log that we are about to redirect
//             error_log('Redirecting to: ' . $external_url);

//             // Redirect to the external URL
//             wp_redirect( esc_url_raw( $external_url ), 301 );
//             exit; // Ensure that the script stops after the redirect
//         }
//     }
// }
// add_action( 'template_redirect', 'redirect_news_events_to_external_url', 0 );

function redirect_platform_page() {
    // Check if the current page slug is 'platform'
    if (is_page('platform')) {
        // Perform the redirect to the desired URL
        wp_redirect('https://platform.i-guide.io', 301); 
        exit;
    }
}
add_action('template_redirect', 'redirect_platform_page');

function enqueue_slideshow_styles() {
    if (is_front_page() || is_home()) {
        wp_enqueue_style('slideshow-css', get_template_directory_uri() . '/assets/css/slideshow.css', array(), '1.0', 'all');
        wp_enqueue_style('platform-section-css', get_template_directory_uri() . '/assets/css/platform.css', array(), '1.0', 'all');
    }
}
add_action('wp_enqueue_scripts', 'enqueue_slideshow_styles',9999);

function enqueue_custom_scripts() {
    // Check if it's not the homepage or the front page
    if (!is_front_page() && !is_home()) {
        // Enqueue the script
        wp_enqueue_script('navigation-js', get_template_directory_uri() . '/assets/js/navigation.js', array(), null, true);
    } else {
        // Enqueue the script
        wp_enqueue_script('projects-js', get_template_directory_uri() . '/assets/js/projects.js', array(), null, true);
    }
}

add_action('wp_enqueue_scripts', 'enqueue_custom_scripts',9999);

//Hide admin bar from front-end

function admin_bar_check() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return false;
    }

    return true;
}
add_filter('show_admin_bar', 'admin_bar_check');

register_nav_menus(
    array(
        'primary-menu' => __('Primary Menu'),
        'secondary-menu' => __('Secondary Menu'),
    )
);

function iguide_custom_styles() {
    $custom_page_array = array('council-of-geospatial-leaders','leadership', 'team-members', 'convergence', 'ai', 'coreci', 'education', 'engagement', 'evaluation','iguide-data-and-computation-resources');
    if (is_page($custom_page_array) ) { // Replace 'your-page-slug' with the slug of the page you want to add the CSS to
        wp_enqueue_style('iguide-custom-style', get_stylesheet_directory_uri() . '/assets/css/page.css');
    }
}
add_action('wp_enqueue_scripts', 'iguide_custom_styles');

function my_post_time_ago() {
    $post_time = get_the_time('U');
    $elapsed_time = human_time_diff($post_time, current_time('U'));

    echo 'Posted ' . $elapsed_time . ' ago';
}

function is_localhost() {
		
    // set the array for testing the local environment
    $whitelist = array( '127.0.0.1', '::1' );
    
    // check if the server is in the array
    if ( in_array( $_SERVER['REMOTE_ADDR'], $whitelist ) ) {
        
        // this is a local environment
        return true;
        
    }
    
}

function acf_add_allowed_iframe_tag( $tags, $context ) {
    if ( $context === 'acf' ) {
        $tags['iframe'] = array(
            'src'             => true,
            'height'          => true,
            'width'           => true,
            'frameborder'     => true,
            'allowfullscreen' => true,
        );
    }

    return $tags;
}
add_filter( 'wp_kses_allowed_html', 'acf_add_allowed_iframe_tag', 10, 2 );


function get_page_ID_by_slug($slug)
{
    $page = get_page_by_path($slug);
    if ($page) {
        return (int) $page->ID;
    } else {
        return null;
    }
}


/**
 * Return whether the current page is a child of $id
 *
 * Note: this function must be run after the `wp` hook.
 * Otherwise, the WP_Post object is not set up, and
 * is_page() will return false.
 *
 * @param  int  $id The post ID of the parent page
 * @return bool     Whether the current page is a child page of $id
 */
function is_child_of( $id ) {
    return ( is_page() && $id === get_post()->post_parent );
}

/**
 * Return HTTP URL for current page after adding the given query string
 * @param string $query [optional] query string
 * @return string
 */
function create_url($query = null)
{
    $result = get_page_link();

    if ($query) {
        $result .= '?' . $query;
    }

    return $result;
}


/**
 * Append and return new query
 * @param array $args Array with new key value pairs
 * @return string
 */
function create_query($args)
{
    $query = $_SERVER["QUERY_STRING"];

    if (!$query) {
        // No query string
        return http_build_query($args);
    } else {
        $result = array();

        parse_str($query, $result);

        foreach ($args as $key => $value) {
            $result[$key] = $value;
        }

        $query = http_build_query($result);
        return $query;
    }
}


function get_link_by_slug($slug, $type = 'post')
{
    $post = get_page_by_path($slug, OBJECT, $type);
    return get_permalink($post->ID);
}

function get_current_month_events($start_date, $timezone = 'America/Chicago', $maxResults = 5)
{
    $configurations = get_page_ID_by_slug('configuration');
    $cid = get_field('IGUIDE_CALENDAR_ID', $configurations);
    $api_key = get_field('CALENDAR_API_KEY', $configurations);

    $timeMin = date_format($start_date, DateTime::RFC3339);

    $endpoint = "https://www.googleapis.com/calendar/v3/calendars/$cid/events";

    $query = http_build_query(array(
        "key" => $api_key,
        "showDeleted" => "false",
        "singleEvents" => "true",
        "orderBy" => "startTime",
        "timeMin" => $timeMin,
        "timeZone" => $timezone,
        "maxResults" => $maxResults
    ));

    $url = $endpoint . "?" . $query;
    // print_r($url);

    $cURL = curl_init();
    curl_setopt($cURL, CURLOPT_URL, $url);
    curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($cURL);
    curl_close($cURL);

    return json_decode($response);
}

