<?php
/*
Plugin Name: Responsive Calendar Events Plugin
Description: Display events on a responsive calendar using shortcode [events_calendar].
Version: 1.70
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
        .fc-toolbar-title-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .fc-toolbar-title {
            text-align: center;
        }
        .calendar-subtitle {
            text-align: center;
            font-size: 14px;
            color: #666;
            margin-top: 2px;
            margin: 0 !important;
            padding: 0 !important;
        }
        @media (max-width: 768px) {
            #events-calendar {
                font-size: 12px;  /* Adjust font size for mobile */
            }
            .fc-toolbar.fc-header-toolbar {
                display: flex;
                flex-direction: column;  /* Stack buttons vertically on small screens */
                align-items: flex-start;
            }
            .fc .fc-toolbar-title {
                font-size: 16px;  /* Reduce title size */
            }
            .fc-prev-button, .fc-next-button, .fc-today-button {
                font-size: 12px;  /* Adjust button size */
            }
        }
    </style>
    <div id="events-calendar"></div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('events-calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            aspectRatio: window.innerWidth > 768 ? 2 : 1.5, // Adjust aspect ratio for responsiveness
            initialView: window.innerWidth > 768 ? 'dayGridMonth' : 'listWeek',  // Use different view on mobile
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,listWeek'
            },
            buttonText: {
                today: 'Today',
                dayGridMonth: 'Monthly',  // Custom label for the month view
                listWeek: 'List'  // Custom label for the list week view
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
            },
            windowResize: function(view) {
                // Adjust the view and aspect ratio dynamically when resizing
                if (window.innerWidth < 768) {
                    calendar.changeView('listWeek'); // Use list view for mobile
                    calendar.setOption('aspectRatio', 1.5);  // Adjust aspect ratio for mobile
                } else {
                    calendar.changeView('dayGridMonth'); // Use grid month for larger screens
                    calendar.setOption('aspectRatio', 2);
                }
            }
        });

        // Render the calendar
        calendar.render();

        // Insert subtitle () below title
        const toolbarTitleEl = document.querySelector('.fc-toolbar-title');
        if (toolbarTitleEl) {
            const subtitleEl = document.createElement('p');
            subtitleEl.className = 'calendar-subtitle';
            subtitleEl.textContent = '(All times indicated are Central time)';
            toolbarTitleEl.parentNode.insertBefore(subtitleEl, toolbarTitleEl.nextSibling);
        }
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

            // Decode the title and convert to FullCalendar-compatible date format
            $title = html_entity_decode(get_the_title());
            $start_date_formatted = (new DateTime($start_date))->format('Y-m-d\TH:i:s');
            $end_date_formatted = (new DateTime($end_date))->format('Y-m-d\TH:i:s');

            // Determine if the event is an all-day event
            $all_day = ($start_date === $end_date);

            $events[] = [
                'title' => $title,
                'start' => $start_date_formatted,
                'end' => $end_date_formatted,
                'allDay' => $all_day,  // Set allDay to true if start and end are the same
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

            // Decode the title and format dates
            $title = html_entity_decode(get_the_title());
            $start_date_formatted = (new DateTime())->setTimestamp($vco_date_time)->format('Y-m-d\TH:i:s');
            $end_date_formatted = (new DateTime())->setTimestamp($vco_date_time + 3600)->format('Y-m-d\TH:i:s');

            // Set allDay to true if start and end date/times match
            $all_day = ($start_date_formatted === $end_date_formatted);

            // Get VCO Category and modify the title accordingly
            $vco_categories = wp_get_post_terms(get_the_ID(), 'vco_category', array('fields' => 'slugs'));

            if (in_array('vco', $vco_categories)) {
                $title_prefix = "VCO: ";
            } elseif (in_array('webinar', $vco_categories)) {
                $title_prefix = "Webinar: ";
            } else {
                $title_prefix = "Event: "; // Fallback title for other categories
            }

            $events[] = [
                'title' => $title_prefix . $title,
                'start' => $start_date_formatted,
                'end' => $end_date_formatted,
                'allDay' => $all_day,  // Set to true if it's an all-day event
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