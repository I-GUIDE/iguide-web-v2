<?php
// At the top of the file, before get_header()
add_filter( 'pre_get_document_title', function( $title ) {
    return 'I-GUIDE Virtual Consulting Office : I-GUIDE';
}, 100 );

get_header();
?>
<div class="page-title tw-w-full tw-block tw-relative tw--mt-[200px] tw-pt-[200px]">
    <div class="tw-container tw-mx-auto tw-px-4 tw-h-min-[200px] tw-pb-[80px] tw-pt-12">
        <div class="tw-border-l-8 tw-pl-3 tw-border-ig-orange tw-text-white tw-font-semibold tw-text-2xl">
            <h1>I-GUIDE Virtual Consulting Office</h1>
        </div>
    </div>
    <div class="custom-shape-divider-bottom-1675786129">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M1200 120L0 16.48 0 0 1200 0 1200 120z" class="shape-fill"></path>
        </svg>
    </div>
</div>

<div class="page-content tw-w-full tw-flex tw-relative tw-bg-white tw-mt-5 tw-mb-16">
    <div class="tw-container tw-mx-auto tw-px-4 tw-py-6">
        <?php
            // Get current timestamp
            $current_time = current_time( 'timestamp' );
            
            // Get start and end of today
            $today_start = strtotime( 'today', $current_time );
            $today_end = strtotime( 'tomorrow', $current_time ) - 1;

            // Query for today's VCOs
            $today_args = array(
                'post_type'      => 'vco',
                'posts_per_page' => -1,
                'meta_key'       => 'vco_date_time',
                'orderby'        => 'meta_value_num',
                'order'          => 'ASC',
                'meta_query'     => array(
                    array(
                        'key'     => 'vco_date_time',
                        'value'   => array( $today_start, $today_end ),
                        'compare' => 'BETWEEN',
                        'type'    => 'NUMERIC',
                    ),
                ),
                'tax_query' => array(
                    array(
                        'taxonomy' => 'vco_category',
                        'field'    => 'slug',
                        'terms'    => 'vco',
                    ),
                ),
            );
            $today_vcos = new WP_Query( $today_args );

            // Query for upcoming VCOs (excluding today)
            $upcoming_args = array(
                'post_type'      => 'vco',
                'posts_per_page' => -1,
                'meta_key'       => 'vco_date_time',
                'orderby'        => 'meta_value_num',
                'order'          => 'ASC',
                'meta_query'     => array(
                    array(
                        'key'     => 'vco_date_time',
                        'value'   => $today_end,
                        'compare' => '>',
                        'type'    => 'NUMERIC',
                    ),
                ),
                'tax_query' => array(
                    array(
                        'taxonomy' => 'vco_category',
                        'field'    => 'slug',
                        'terms'    => 'vco',
                    ),
                ),
            );
            $upcoming_vcos = new WP_Query( $upcoming_args );

            // Query for past VCOs
            $past_args = array(
                'post_type'      => 'vco',
                'posts_per_page' => -1,
                'meta_key'       => 'vco_date_time',
                'orderby'        => 'meta_value_num',
                'order'          => 'DESC',
                'meta_query'     => array(
                    array(
                        'key'     => 'vco_date_time',
                        'value'   => $current_time,
                        'compare' => '<',
                        'type'    => 'NUMERIC',
                    ),
                ),
                'tax_query' => array(
                    array(
                        'taxonomy' => 'vco_category',
                        'field'    => 'slug',
                        'terms'    => 'vco',
                    ),
                ),
            );
            $past_vcos = new WP_Query( $past_args );
            ?>

        <!-- Today's VCOs Section -->
        <?php if ( $today_vcos->have_posts() ) : ?>
        <div class="row justify-content-md-center">
            <div class="col-md-8">
                <h1 class="mb-2 text-center" style="color: #e7b633;">Today's Sessions</h1>
                <h4 class="mb-4 text-center">Don't miss these sessions happening today! Click the cards for additional
                    information and registration.</h4>
            </div>
        </div>
        <div class="row justify-content-md-center">
            <?php
                    $count = 0;
                    while ( $today_vcos->have_posts() ) : $today_vcos->the_post();
                        $date_time = get_post_meta( get_the_ID(), 'vco_date_time', true );
                        $speakers  = get_post_meta( get_the_ID(), 'vco_speakers', true );
                        ?>
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow" style="border: 3px solid #e7b633;">
                    <div class="card-body" style="background-color: #fffbf0;">
                        <?php vco_recording_badge( get_the_ID() ); ?>
                        <?php if ( $date_time ) : ?>
                        <h3 class="card-title" style="color: #e7b633;">
                            <strong>TODAY - <?php echo date_i18n( 'g:i a', $date_time ); ?></strong>
                        </h3>
                        <?php endif; ?>
                        <h1 class="card-title">
                            <a href="<?php the_permalink(); ?>" class="link-dark text-decoration-none stretched-link"
                                style="font-weight: 700;"><?php the_title(); ?></a>
                        </h1>
                        <?php if ( ! empty( $speakers ) ) : ?>
                        <div class="mt-3">
                            <?php foreach ( $speakers as $speaker ) :
                                                $name = isset( $speaker['name'] ) ? $speaker['name'] : '';
                                                $affiliation = isset( $speaker['affiliation'] ) ? $speaker['affiliation'] : '';
                                                if ( $name || $affiliation ) :
                                                    ?>
                            <p class="p-0" style="font-size: 0.9em;">
                                <?php if ( $name ) : ?>
                                <span style="color: #f18149; font-weight: bold;"><?php echo esc_html( $name ); ?>
                                    &middot; </span>
                                <?php endif; ?>
                                <?php if ( $affiliation ) : ?>
                                <span style="color: #38c9c2;"><?php echo esc_html( $affiliation ); ?></span>
                                <?php endif; ?>
                            </p>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php
                        $count++;
                        if ( $count % 2 == 0 ) {
                            echo '<div class="w-100"></div>'; // Clear after every 2 items
                        }
                    endwhile;
                    wp_reset_postdata();
                    ?>
        </div>
        <hr class="my-5">
        <?php endif; ?>

        <!-- Upcoming VCOs Section -->
        <?php if ( $upcoming_vcos->have_posts() ) : ?>
        <div class="row justify-content-md-center">
            <div class="col-md-8">
                <h1 class="mb-2 text-center">Upcoming Sessions</h1>
                <h4 class="mb-3 text-center">I-GUIDE's virtual consulting office (VCO) showcases innovative research and
                    education. These are opportunities to share and get feedback on your geospatial data science
                    activities. Click the cards below for additional information and registration for each session.</h4>
                <h4 class="mb-4 text-center">If you have a suitable research topic you would like to share with a broad
                    geospatial community, <a href="<?php echo esc_url( home_url( '/vco-proposal/' ) ); ?>">complete this
                    form to tell us about your work</a>.</h4>
            </div>
        </div>

        <div class="row justify-content-md-center">
            <?php
                $count = 0;
                while ( $upcoming_vcos->have_posts() ) : $upcoming_vcos->the_post();
                    $date_time = get_post_meta( get_the_ID(), 'vco_date_time', true );
                    $speakers  = get_post_meta( get_the_ID(), 'vco_speakers', true );
                    ?>
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow">
                    <div class="card-body">
                        <?php vco_recording_badge( get_the_ID() ); ?>
                        <?php if ( $date_time ) : ?>
                        <h3 class="card-title" style="color: #e7b633;">
                            <?php echo date_i18n( 'F j, Y g:i a', $date_time ); ?>
                        </h3>
                        <?php endif; ?>
                        <h1 class="card-title">
                            <a href="<?php the_permalink(); ?>" class="link-dark text-decoration-none stretched-link"
                                style="font-weight: 700;"><?php the_title(); ?></a>
                        </h1>
                        <?php if ( ! empty( $speakers ) ) : ?>
                        <div class="mt-3">
                            <?php foreach ( $speakers as $speaker ) :
                                            $name = isset( $speaker['name'] ) ? $speaker['name'] : '';
                                            $affiliation = isset( $speaker['affiliation'] ) ? $speaker['affiliation'] : '';
                                            if ( $name || $affiliation ) :
                                                ?>
                            <p class="p-0" style="font-size: 0.9em;">
                                <?php if ( $name ) : ?>
                                <span style="color: #f18149; font-weight: bold;"><?php echo esc_html( $name ); ?>
                                    &middot; </span>
                                <?php endif; ?>
                                <?php if ( $affiliation ) : ?>
                                <span style="color: #38c9c2;"><?php echo esc_html( $affiliation ); ?></span>
                                <?php endif; ?>
                            </p>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php
                    $count++;
                    if ( $count % 2 == 0 ) {
                        echo '<div class="w-100"></div>'; // Clear after every 2 items
                    }
                endwhile;
                wp_reset_postdata();
                ?>
        </div>
        <?php else : ?>
        <p class="text-center py-5"><?php _e( 'No upcoming VCOs found.', 'vco-plugin' ); ?></p>
        <?php endif; ?>

        <hr class="my-5">

        <!-- Past VCOs Section -->
        <?php if ( $past_vcos->have_posts() ) : ?>
        <div class="row justify-content-md-center">
            <div class="col-md-8">
                <h1 class="mt-5 mb-2 text-center">Past Sessions</h1>
                <h4 class="mb-4 text-center">Recordings are available for all past I-GUIDE sessions. Click on the cards
                    below for additional information on each VCO as well as recordings.</h4>
            </div>
        </div>
        <div class="row">
            <?php
                    $count = 0;
                    while ( $past_vcos->have_posts() ) : $past_vcos->the_post();
                        $date_time = get_post_meta( get_the_ID(), 'vco_date_time', true );
                        $speakers  = get_post_meta( get_the_ID(), 'vco_speakers', true );
                        ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow" style="font-size: 0.9em;">
                    <div class="card-body">
                        <?php vco_recording_badge( get_the_ID() ); ?>
                        <?php if ( $date_time ) : ?>
                        <h3 class="card-title" style="color: #e7b633; font-size: 1em;">
                            <?php echo date_i18n( 'F j, Y g:i a', $date_time ); ?>
                        </h3>
                        <?php endif; ?>
                        <h1 class="card-title" style="font-size: 1.3em;line-height:1.25rem;">
                            <a href="<?php the_permalink(); ?>" class="link-dark text-decoration-none stretched-link"
                                style="font-weight: 700;"><?php the_title(); ?></a>
                        </h1>
                        <?php if ( ! empty( $speakers ) ) : ?>
                        <div class="mt-2">
                            <?php foreach ( $speakers as $speaker ) :
                                                $name = isset( $speaker['name'] ) ? $speaker['name'] : '';
                                                $affiliation = isset( $speaker['affiliation'] ) ? $speaker['affiliation'] : '';
                                                if ( $name || $affiliation ) :
                                                    ?>
                            <p class="p-0" style="font-size: 0.9em;">
                                <?php if ( $name ) : ?>
                                <span style="color: #f18149; font-weight: bold;"><?php echo esc_html( $name ); ?>
                                    &middot; </span>
                                <?php endif; ?>
                                <?php if ( $affiliation ) : ?>
                                <span style="color: #38c9c2;"><?php echo esc_html( $affiliation ); ?></span>
                                <?php endif; ?>
                            </p>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php
                        $count++;
                        if ( $count % 3 == 0 ) {
                            echo '<div class="w-100"></div>'; // Clear after every 4 items
                        }
                    endwhile;
                    wp_reset_postdata();
                    ?>
        </div>
        <?php else : ?>
        <p><?php _e( 'No past VCOs found.', 'vco-plugin' ); ?></p>
        <?php endif; ?>

    </div>
</div>

<?php
get_footer();
?>