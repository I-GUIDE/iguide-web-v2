<?php
get_header();
// define( 'WP_DEBUG', true );
?>

<style>
    .calendar {
        display: flex;
        flex-flow: column;
    }

    .calendar .header .month-year {
        font-size: 20px;
        font-weight: bold;
        color: #636e73;
        /* padding: 20px 0; */
    }

    .calendar .days {
        display: flex;
        flex-flow: wrap;
    }

    .calendar .days .day_name {
        width: calc(100% / 7);
        border-right: 1px solid #2c7aca;
        padding: 20px;
        text-transform: uppercase;
        font-size: 12px;
        font-weight: bold;
        color: #818589;
        color: #fff;
        background-color: #448cd6;
    }

    .calendar .days .day_name:nth-child(7) {
        border: none;
    }

    .calendar .days .day_num {
        display: flex;
        flex-flow: column;
        width: calc(100% / 7);
        border-right: 1px solid #e6e9ea;
        border-bottom: 1px solid #e6e9ea;
        padding: 15px;
        font-weight: bold;
        color: #7c878d;
        cursor: pointer;
        min-height: 100px;
    }

    .calendar .days .day_num span {
        display: inline-flex;
        width: 30px;
        font-size: 14px;
    }

    .calendar .days .day_num .event {
        margin-top: 10px;
        font-weight: 500;
        font-size: 14px;
        padding: 3px 6px;
        border-radius: 4px;
        /* background-color: #f7c30d; */
        background-color: #168a92;
        color: #fff;
        word-wrap: break-word;
    }

    .calendar .days .day_num:nth-child(7n+1) {
        border-left: 1px solid #e6e9ea;
    }

    .calendar .days .day_num:hover {
        background-color: #fdfdfd;
    }

    .calendar .days .day_num.ignore {
        background-color: #fdfdfd;
        color: #ced2d4;
        cursor: inherit;
    }

    .calendar .days .day_num.selected {
        background-color: #f1f2f3;
        cursor: inherit;
    }
</style>

<div class="page-title tw-w-full tw-block  tw-relative tw--mt-[200px] tw-pt-[200px]" >
        <div class="tw-container tw-mx-auto tw-px-4 tw-h-min-[200px] tw-pb-[80px] tw-pt-12">
            <div class="tw-border-l-8 tw-pl-3 tw-border-ig-orange tw-text-white tw-font-semibold tw-text-2xl">
                <h1>I-GUIDE Project Events</h1>
            </div>
            <!-- <p class="tw-text-light tw-text-sm tw-text-white tw-pt-2 tw-pl-5"><?php my_post_time_ago(); ?></p> -->
        </div>
        
        <div class="custom-shape-divider-bottom-1675786129">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"
                preserveAspectRatio="none">
                <path d="M1200 120L0 16.48 0 0 1200 0 1200 120z" class="shape-fill"></path>
            </svg>
        </div>
    </div>

    
    <div class="page-content tw-w-full tw-flex tw-relative tw-bg-white tw-mt-5 tw-mb-16">
        <div class="tw-container tw-mx-auto tw-px-4 tw-py-6">

    <?php

    $timezone = "America/Chicago";
    date_default_timezone_set($timezone);

    /*************** CALENDAR CLASS *********************/

    class Calendar
    {

        private $active_year, $active_month, $active_day;
        private $events = [];

        // check for null
        public function __construct($date = null)
        {
            if (isset($_GET['CAL_YEAR'])) {
                $this->active_year = $_GET['CAL_YEAR'];
            } else {
                $this->active_year = $date != null ? date('Y', strtotime($date)) : date('Y');
            }

            if (isset($_GET['CAL_MONTH']) and (int)$_GET['CAL_MONTH'] >= 1 and (int)$_GET['CAL_MONTH'] <= 12) {
                $this->active_month = $_GET['CAL_MONTH'];
            } else {
                $this->active_month = $date != null ? date('m', strtotime($date)) : date('m');
            }

            if (isset($_GET['CAL_DAY']) and $_GET['CAL_DAY'] >= 1 and (int)$_GET['CAL_DAY'] < cal_days_in_month(CAL_GREGORIAN, (int)$this->active_month, (int)$this->active_year)) {
                $this->active_day = $_GET['CAL_DAY'];
            } else {
                $this->active_day = $date != null ? date('d', strtotime($date)) : date('d');
            }
        }
        // end of check for null

        public function add_event(
            $txt,
            $date,
            $htmllink,
            $days = 1,
            $color = ''
        ) {
            $color = $color ? ' ' . $color : $color;
            $this->events[] = [$txt, $date, $days, $color, $htmllink];
        }

        public function __toString()
        {
            $num_days = date('t', strtotime($this->active_day . '-' . $this->active_month . '-' . $this->active_year));
            $num_days_last_month = date('j', strtotime('last day of previous month', strtotime($this->active_day . '-' . $this->active_month . '-' . $this->active_year)));
            $days = [0 => 'Sun', 1 => 'Mon', 2 => 'Tue', 3 => 'Wed', 4 => 'Thu', 5 => 'Fri', 6 => 'Sat'];
            $first_day_of_week = array_search(date('D', strtotime($this->active_year . '-' . $this->active_month . '-1')), $days);
            $html = '<div class="calendar">';

            
            $prev_month = (((int)($this->active_month) + 10) % 12) + 1;
            $next_month = ((int)($this->active_month) % 12) + 1;
            // change month

            $prev_options = array(
                "CAL_MONTH" => $prev_month
            );

            $next_options = array(
                "CAL_MONTH" => $next_month
            );

            if ($prev_month > (int)$this->active_month) {
                $prev_options["CAL_YEAR"] = (int)$this->active_year - 1;
            }

            if ($next_month < (int)$this->active_month) {
                $next_options["CAL_YEAR"] = (int)$this->active_year + 1;
            }
            // change year

            $prev_link = create_url(create_query($prev_options));
            $next_link = create_url(create_query($next_options));

            $html .= '<div class="header">';

            $html .= '<div class="d-flex justify-content-between p-0 my-4">';

            $html .= '<div class="month-year">';
            // Remove the date from the strtotime since it cause the month to jump from Aug to October
            $html .= date('F Y', strtotime($this->active_year . '-' . $this->active_month));
            $html .= '</div>';

            $html .= '<div class="d-flex justify-content-end">';
            $html .= '<a class="btn btn-outline-dark btn-md mx-2" href="' . $prev_link . '"><i class="fa fa-angle-left" aria-hidden="true"></i> Prev</a>';
            $html .= '<a class="btn btn-outline-dark btn-md" href="' . $next_link . '">Next <i class="fa fa-angle-right" aria-hidden="true"></i></a>';
            $html .= '</div>';

            $html .= '</div>';

            $html .= '</div>';

            $html .= '<div class="days">';
            foreach ($days as $day) {
                $html .= '
                <div class="day_name">
                    ' . $day . '
                </div>
            ';
            }
            for ($i = $first_day_of_week; $i > 0; $i--) {
                $html .= '
                <div class="day_num ignore">
                    ' . ($num_days_last_month - $i + 1) . '
                </div>
            ';
            }
            for ($i = 1; $i <= $num_days; $i++) {
                $selected = '';
                if ($i == $this->active_day) {
                    $selected = ' selected';
                }
                $html .= '<div class="day_num' . $selected . '">';
                $html .= '<span>' . $i . '</span>';
                foreach ($this->events as $event) {
                    for ($d = 0; $d <= ($event[2] - 1); $d++) {
                        if (date('y-m-d', strtotime($this->active_year . '-' . $this->active_month . '-' . $i . ' -' . $d . ' day')) == date('y-m-d', strtotime($event[1]))) {
                            $html .= '<div class="event' . $event[3] . '">';
                            $html .= '<a class="text-light" href="'. $event[4].'" target="_blank" >';
                            $html .= $event[0];
                            $html .= '</a>'; 
                            $html .= '</div>';
                        }
                    }
                }
                $html .= '</div>';
            }
            for ($i = 1; $i <= (42 - $num_days - max($first_day_of_week, 0)); $i++) {
                $html .= '
                <div class="day_num ignore">
                    ' . $i . '
                </div>
            ';
            }
            $html .= '</div>';
            $html .= '</div>';
            return $html;
        }
    }

    /*************** CALENDAR CLASS END *********************/

    $calendar = new Calendar();

    // Get first day of month
    $today = new DateTime();
    $today->setDate($today->format('Y'), $today->format('m'), 1);
    $today->setTime(0, 0, 0);

    // Get the first calendar day of the month
    $dayOfWeek = $today->format('w');
    $interval = new DateInterval("P" . $dayOfWeek . "D");
    $today->sub($interval);

    $timeMin = $today->format(DateTime::RFC3339);

    /*************** ADDING EVENTS TO CALENDAR WITH GOOGLE CALENDAR API *********************/

    $cid = "c_j1tju4ne2oh69hl7phrn6cfiqc@group.calendar.google.com"; // From I-Guide Calendar
    $cid =  get_field('IGUIDE_CALENDAR_ID', get_page_ID_by_slug('configuration'));

    $api_key = get_field('CALENDAR_API_KEY', get_page_ID_by_slug('configuration'));

    $endpoint = "https://www.googleapis.com/calendar/v3/calendars/$cid/events";

    $query = http_build_query(array(
        "key" => $api_key,
        "showDeleted" => "false",
        "singleEvents" => "true",
        "orderBy" => "startTime",
        "timeZone" => $timezone
        //"timeMin" => $timeMin
    ));

    $url = $endpoint . "?" . $query;

    $cURL = curl_init();
    curl_setopt($cURL, CURLOPT_URL, $url);
    curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);

    // echo($url);

    $response = curl_exec($cURL);

    curl_close($cURL);

    if(is_localhost()) {
        $response = file_get_contents(get_template_directory_uri().'/assets/js/events.json');
    };

    // Read the JSON file 
    $json = json_decode($response);

    //echo($response);

    if ($json == null) {
        exit(1);
    }

    foreach ($json->items as $event) {
        if ($event->status == 'confirmed') {
            $summary = $event->summary;
            $id = $event->id;
            $htmllink = $event->htmlLink;
            $location = $event->location;
            $email = $event->creator->email;
            $start_date = date_create($event->start->dateTime, new DateTimeZone($event->start->timeZone));
            $end_date = date_create($event->end->dateTime, new DateTimeZone($event->end->timeZone));

            $title = $event->summary . "(" . date_format($start_date, 'h:i a') . " - " . date_format($end_date, 'h:i a') . ")";

            $calendar->add_event($title, date_format($start_date, 'Y-m-d'), $location, 1);
        }
    }


    echo "<div class='row'>      
    <div class='container'>All events are in Central Timezone.</div>
    </div>";

    echo $calendar;

    ?>
  </div>
    </div>

<?php
    get_footer();
?>