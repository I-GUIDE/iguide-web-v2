<?php
/*
Template Name: Webinar Page
*/
get_header();
?>

<div class="page-title tw-w-full tw-block tw-relative tw--mt-[200px] tw-pt-[200px]">
    <div class="tw-container tw-mx-auto tw-px-4 tw-h-min-[200px] tw-pb-[80px] tw-pt-12">
        <div class="tw-border-l-8 tw-pl-3 tw-border-ig-orange tw-text-white tw-font-semibold tw-text-2xl">
            <h1>I-GUIDE Webinars</h1>
        </div>
    </div>
</div>

<div class="page-content tw-w-full tw-flex tw-relative tw-bg-white tw-mt-5 tw-mb-16">
    <div class="tw-container tw-mx-auto tw-px-4 tw-py-6">

        <?php
        // Query only 'webinar' category posts from 'vco' post type
        $webinar_args = array(
            'post_type'      => 'vco',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'vco_category',
                    'field'    => 'slug',
                    'terms'    => 'webinar',
                ),
            ),
            'meta_key'       => 'vco_date_time',
            'orderby'        => 'meta_value_num',
            'order'          => 'DESC',
        );

        $webinar_query = new WP_Query( $webinar_args );

        if ( $webinar_query->have_posts() ) :
            while ( $webinar_query->have_posts() ) : $webinar_query->the_post();
                $date_time = get_post_meta( get_the_ID(), 'vco_date_time', true );
                $speakers  = get_post_meta( get_the_ID(), 'vco_speakers', true );
                $video_embed_code = get_post_meta( get_the_ID(), 'vco_embedded_video', true );
                $registration_link = get_post_meta( get_the_ID(), 'vco_registration_link', true );

                // Calculate the webinar end time (date_time + 2 hours)
                $webinar_end_time = $date_time + (2 * HOUR_IN_SECONDS);
                $current_time = current_time( 'timestamp' ); // Get the current time in timestamp
                ?>
                
                <div class="tw-mb-10">
                    <!-- Date -->
                    <p class="tw-text-gray-600 tw-text-sm">
                        <?php echo date_i18n( 'l, F j, Y', $date_time ); ?>
                    </p>

                    <!-- Title -->
                    <h2 class="tw-font-semibold tw-text-2xl">
                        <?php the_title(); ?>
                    </h2>

                    <!-- Display Registration Button if Condition is Met -->
                    <?php if ( $registration_link && $current_time <= $webinar_end_time ) : ?>
                        <a href="<?php echo esc_url( $registration_link ); ?>" target="_blank" 
                            class="tw-inline-block tw-bg-ig-orange tw-text-white tw-px-6 tw-py-2 tw-rounded-lg tw-font-semibold tw-mt-4 tw-mb-4 tw-shadow-lg hover:tw-bg-ig-orange-dark">
                            Register Now
                        </a>
                    <?php endif; ?>

                    <!-- Speaker Information -->
                    <?php if ( ! empty( $speakers ) ) : ?>
                        <p class="tw-text-gray-700">
                            <?php foreach ( $speakers as $speaker ) :
                                $name = isset( $speaker['name'] ) ? $speaker['name'] : '';
                                $affiliation = isset( $speaker['affiliation'] ) ? $speaker['affiliation'] : '';
                                echo esc_html( $name . ', ' . $affiliation );
                            endforeach; ?>
                        </p>
                    <?php endif; ?>

                    <!-- Embedded Video -->
                    <div class="tw-mt-4 tw-w-full tw-max-w-lg">
                        <?php
                        if ( $video_embed_code ) {
                            echo $video_embed_code;
                        }
                        ?>
                    </div>
                </div>

            <?php endwhile;
            wp_reset_postdata();
        else : ?>
            <p><?php _e( 'No webinars found.', 'vco-plugin' ); ?></p>
        <?php endif; ?>

    </div>
</div>

<?php
get_footer();
?>
