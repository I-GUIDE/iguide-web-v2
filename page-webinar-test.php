<?php
/*
Template Name: Webinar Page
*/
get_header();
?>

<!-- Page Title Section (Tailwind CSS) -->
<div class="page-title tw-w-full tw-block tw-relative tw--mt-[200px] tw-pt-[200px]">
    <div class="tw-container tw-mx-auto tw-px-4 tw-h-min-[200px] tw-pb-[80px] tw-pt-12">
        <div class="tw-border-l-8 tw-pl-3 tw-border-ig-orange tw-text-white tw-font-semibold tw-text-2xl">
            <h1>I-GUIDE Webinars</h1>
        </div>
    </div>
</div>

<!-- Page Content Section (Tailwind CSS) -->
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
                $abstract = get_post_meta( get_the_ID(), 'vco_abstract', true );

                // Calculate the webinar end time (date_time + 2 hours)
                $webinar_end_time = $date_time + (2 * HOUR_IN_SECONDS);
                $current_time = current_time( 'timestamp' ); // Get the current time in timestamp
                ?>
                
                <!-- Webinar Entry Card (Bootstrap CSS) -->
                <div class="card shadow mb-5">
                    <div class="card-body">
                        <!-- Date -->
                        <p class="text-muted small">
                            <?php echo date_i18n( 'l, F j, Y', $date_time ); ?>
                        </p>

                        <!-- Title -->
                        <h2 class="card-title">
                            <?php the_title(); ?>
                        </h2>

                        <!-- Registration Button (Bootstrap) -->
                        <?php if ( $registration_link && $current_time <= $webinar_end_time ) : ?>
                            <a href="<?php echo esc_url( $registration_link ); ?>" target="_blank" 
                               class="btn btn-warning btn-lg my-3">
                                Register Now
                            </a>
                        <?php endif; ?>

                        <!-- Speaker List (Bootstrap List Group) -->
                        <?php if ( !empty( $speakers ) ) : ?>
                            <h5 class="mt-4">Speakers:</h5>
                            <ul class="list-group list-group-flush mb-3">
                                <?php foreach ( $speakers as $speaker ) :
                                    $name = isset( $speaker['name'] ) ? $speaker['name'] : '';
                                    $affiliation = isset( $speaker['affiliation'] ) ? $speaker['affiliation'] : '';
                                    ?>
                                    <li class="list-group-item"><?php echo esc_html( $name . ( $affiliation ? ', ' . $affiliation : '' ) ); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>

                        <!-- Abstract Section -->
                        <?php if ( !empty( $abstract ) ) : ?>
                            <h5 class="mt-4">Abstract:</h5>
                            <p class="text-secondary">
                                <?php echo wp_kses_post( wpautop( $abstract ) ); ?>
                            </p>
                        <?php endif; ?>

                        <!-- Embedded Video (Bootstrap) -->
                        <?php if ( !empty( $video_embed_code ) ) : ?>
                            <div class="mt-4">
                                <?php echo $video_embed_code; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            <?php endwhile;
            wp_reset_postdata();
        else : ?>
            <p class="alert alert-info"><?php _e( 'No webinars found.', 'vco-plugin' ); ?></p>
        <?php endif; ?>
    </div>
</div>

<?php
get_footer();
?>
