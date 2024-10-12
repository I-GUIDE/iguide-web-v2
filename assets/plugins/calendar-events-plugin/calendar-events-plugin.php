<?php
/*
Plugin Name: Calendar Events Plugin
Description: Display events on a calendar using shortcode [events_calendar].
Version: 1.6
Author: Nattapon Jaroenchai
*/

// Enqueue FullCalendar JavaScript and CSS
function calendar_events_enqueue_scripts() {
    wp_enqueue_script('fullcalendar-js', 'https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js', [], '6.1.8', true);
    wp_enqueue_style('fullcalendar-css', 'https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css', [], '6.1.8');
}
add_action('wp_enqueue_scripts', 'calendar_events_enqueue_scripts');

// Create the shortcode to display the calendar
function events_calendar_shortcode() {
    ob_start();
    ?>
    <style>
        #events-calendar a {
            text-decoration: none;
            color: black;
        }
        .calendar-toggle {
            margin-bottom: 10px;
        }
    </style>
    <div id="events-calendar"></div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('events-calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            aspectRatio: 2,
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },
            buttonText: {
                dayGridMonth: 'Monthly View',  // Custom label for the month view
                timeGridWeek: 'Weekly Schedule', // Custom label for the time grid week view
            },
            events: function(fetchInfo, successCallback, failureCallback) {
                // Fetch events from the backend
                fetch('<?php echo admin_url('admin-ajax.php?action=get_calendar_events'); ?>')
                .then(response => response.json())
                .then(events => {
                    successCallback(events);
                })
                .catch(error => {
                    console.error('Error fetching events:', error);
                    failureCallback(error);
                });
            },
            eventClick: function(info) {
                if (info.event.url) {
                    window.open(info.event.url, '_blank');
                    info.jsEvent.preventDefault();
                }
            },
            eventDidMount: function(info) {
                // Set the tooltip content
                info.el.setAttribute('title', info.event.title);
            }
        });

        // Render the calendar
        calendar.render();

        // Function to change the calendar view
        window.changeView = function(view) {
            calendar.changeView(view);
        };
    });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('events_calendar', 'events_calendar_shortcode');

// Fetch events for the calendar
function get_calendar_events() {
    $events = [];

    // Fetch news_events posts
    $news_args = [
        'post_type' => 'news_events',
        'posts_per_page' => -1,
        'tax_query' => [
            [
                'taxonomy' => 'news_cat',
                'field' => 'slug',
                'terms' => 'event',
            ],
        ],
        'meta_query' => [
            [
                'key' => 'start_date',
                'compare' => 'EXISTS',
            ],
            [
                'key' => 'end_date',
                'compare' => 'EXISTS',
            ],
        ],
    ];

    $news_query = new WP_Query($news_args);

    if ($news_query->have_posts()) {
        while ($news_query->have_posts()) {
            $news_query->the_post();

            $start_date = get_field('start_date');
            $end_date = get_field('end_date');
            $short_description = get_field('short_description');
            $external_link = get_field('external_link');
            $permalink = $external_link ? esc_url($external_link) : get_permalink();

            // Decode the title to convert HTML entities back to their original characters
            $title = html_entity_decode(get_the_title());
            $start_date_formatted = (new DateTime($start_date))->format('Y-m-d\TH:i:s');
            $end_date_formatted = (new DateTime($end_date))->format('Y-m-d\TH:i:s');

            $events[] = [
                'title' => $title,
                'start' => $start_date_formatted,
                'end' => $end_date_formatted,
                'url' => $permalink,
                'description' => $short_description,
                'backgroundColor' => '#38BFA9', // Set color for VCO
                'borderColor' => '#38BFA9'
            ];
        }
    }
    wp_reset_postdata();

    // Fetch VCO posts
    $vco_args = [
        'post_type' => 'vco',
        'posts_per_page' => -1,
        'meta_query' => [
            [
                'key' => 'vco_date_time',
                'compare' => 'EXISTS',
            ],
        ],
    ];

    $vco_query = new WP_Query($vco_args);

    if ($vco_query->have_posts()) {
        while ($vco_query->have_posts()) {
            $vco_query->the_post();

            $vco_date_time = get_post_meta(get_the_ID(), 'vco_date_time', true);
            $short_description = get_post_meta(get_the_ID(), 'short_description', true);
            $external_link = get_post_meta(get_the_ID(), 'external_link', true);
            $permalink = get_permalink();

            // Decode the title to convert HTML entities back to their original characters
            $title = html_entity_decode(get_the_title());
            $start_date_formatted = (new DateTime())->setTimestamp($vco_date_time)->format('Y-m-d\TH:i:s');
            $end_date_formatted = (new DateTime())->setTimestamp($vco_date_time + 3600)->format('Y-m-d\TH:i:s');

            $events[] = [
                'title' => "VCO: " . $title,
                'start' => $start_date_formatted,
                'end' => $end_date_formatted,
                'url' => $permalink,
                'description' => $short_description,
                'backgroundColor' => '#F28D35', // Set color for events
                'borderColor' => '#F28D35'
            ];
        }
    }
    wp_reset_postdata();

    // Return the combined events
    wp_send_json($events);
}
add_action('wp_ajax_get_calendar_events', 'get_calendar_events');
add_action('wp_ajax_nopriv_get_calendar_events', 'get_calendar_events');