<?php
get_header();
?>
    <div class="page-title tw-w-full tw-block tw-relative tw--mt-[200px] tw-pt-[200px]">
        <div class="tw-container tw-mx-auto tw-px-4 tw-h-min-[200px] tw-pb-[80px] tw-pt-12">
            <div class="tw-border-l-8 tw-pl-3 tw-border-ig-orange tw-text-white tw-font-semibold tw-text-2xl">
                <?php
                // Check the category and display the appropriate title prefix
                if ( has_term( 'vco', 'vco_category' ) ) {
                    echo '<h1 class="mt-3 mb-5">I-GUIDE VCO: ' . get_the_title() . '</h1>';
                } elseif ( has_term( 'webinar', 'vco_category' ) ) {
                    echo '<h1 class="mt-3 mb-5">I-GUIDE Webinar: ' . get_the_title() . '</h1>';
                } else {
                    echo '<h1 class="mt-3 mb-5">' . get_the_title() . '</h1>'; // Default title if neither category matches
                }
                ?>
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
    
    
    <?php
    /* Start the Loop */
    while ( have_posts() ) :
        the_post();
        // Get meta values
        $date_time = get_post_meta( get_the_ID(), 'vco_date_time', true );
        $registration_link = get_post_meta( get_the_ID(), 'vco_registration_link', true );
        $abstract = get_post_meta( get_the_ID(), 'vco_abstract', true );
        $speakers = get_post_meta( get_the_ID(), 'vco_speakers', true );
        $embedded_video = get_post_meta( get_the_ID(), 'vco_embedded_video', true );
        
        // Determine if there's content (abstract or speakers)
        $has_content = ! empty( $abstract ) || ! empty( $speakers );
        ?>

    <div class="page-content tw-w-full tw-flex tw-relative tw-bg-white tw-mt-5 tw-mb-16">
        <div class="tw-container tw-mx-auto tw-px-4 tw-py-6">
            <h1 class="text-center"><?php the_title(); ?></h1>
            <h2 class="text-center"></strong> <?php echo date_i18n( 'F j, Y g:i a', $date_time ); ?> (Central Time)</h2>
            <?php
                // Get the current timestamp
                $current_time = current_time( 'timestamp' );
                
                // Calculate the timestamp for 2 hours after the event
                $event_end_time = $date_time + 2 * HOUR_IN_SECONDS;

                // Check if the current time is before 2 hours after the event
                if ( $current_time < $event_end_time ) :
                    if ( empty( $registration_link ) ) : ?>
                        <p class="mb-4 mt-3 text-center">
                            <a href="#" target="_blank" rel="noopener noreferrer" class="btn btn-primary btn-lg">Register coming soon!</a>
                        </p>
                    <?php elseif ( $registration_link && empty( $embedded_video ) ) : ?>
                        <p class="mb-4 mt-3 text-center">
                            <a href="<?php echo esc_url( $registration_link ); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-primary btn-lg">Register to attend the VCO!</a>
                        </p>
                    <?php endif;
                endif;
            ?>
            
            <hr>

            <?php if ( ! empty( $embedded_video ) ) : ?>
                <div class="my-5">
                    <h3 style="text-align: center;"><strong>Recorded VCO</strong></h3>
                    <?php
                    // Define allowed HTML tags and attributes
                    $allowed_tags = wp_kses_allowed_html( 'post' );

                    $allowed_tags['iframe'] = array(
                        'id'                  => true,
                        'class'               => true,
                        'title'               => true,
                        'src'                 => true,
                        'width'               => true,
                        'height'              => true,
                        'frameborder'         => true,
                        'sandbox'             => true,
                        'allow'               => true,
                        'allowfullscreen'     => true,
                        'allowtransparency'   => true,
                        'style'               => true,
                        'loading'             => true,
                    );

                    // Output the embedded video code safely
                    echo '<div class="embedded-video d-flex justify-content-md-center">';
                    echo wp_kses( $embedded_video, $allowed_tags );
                    echo '</div>';
                    ?>
                </div>
                <hr>
            <?php endif; ?>

            <div class="row"> 
            <?php if ( $has_content ) : ?>     
                    <!-- If there is content, display the first column -->          
                <?php if ( empty( $embedded_video ) ) : ?>
                    <!-- Display both columns -->
                    <div class="col-md-8">
                <?php else : ?>
                    <!-- Display full width column -->
                    <div class="col-12">
                <?php endif; ?>

                        <?php if ( $abstract ) : ?>
                            <h3 class="mt-2 mb-3">Abstract</h3>
                            <div class="mb-5">
                                <?php echo wpautop( $abstract ); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( ! empty( $speakers ) ) : ?>
                            <h3 class="mt-5 mb-4">Speakers</h3>
                            <?php foreach ( $speakers as $speaker ) :
                                $name = isset( $speaker['name'] ) ? $speaker['name'] : '';
                                $affiliation = isset( $speaker['affiliation'] ) ? $speaker['affiliation'] : '';
                                $photo_id = isset( $speaker['photo_id'] ) ? $speaker['photo_id'] : '';
                                $photo = $photo_id ? wp_get_attachment_url( $photo_id ) : '';
                                $bio = isset( $speaker['bio'] ) ? $speaker['bio'] : '';
                                ?>
                                <div class="vco-speaker d-flex mb-2">
                                    <?php if ( $photo ) : ?>
                                        <div class="flex-shrink-0">
                                            <img src="<?php echo esc_url( $photo ); ?>" alt="<?php echo esc_attr( $name ); ?>" class="rounded" style="width: 150px; height: 150px; object-fit: cover;">
                                        </div>
                                    <?php endif; ?>
                                    <div class="ms-4">
                                        <h4 class="mb-1"><?php echo esc_html( $name ); ?></h4>
                                        <p class="text-muted mb-2"><em><?php echo esc_html( $affiliation ); ?></em></p>
                                        <?php if ( $bio ) : ?>
                                            <div>
                                                <?php echo wpautop( $bio ); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <?php if ( empty( $embedded_video ) ) : ?>
                        <!-- Second Column (25%) -->
                        <div class="col-md-4">
                            <!-- Begin Constant Contact Inline Form Code -->
                            <div class="ctct-inline-form" data-form-id="48bb00c3-d290-45ea-b50b-dfbd4c882b00"></div>
                            <!-- End Constant Contact Inline Form Code -->
                        </div>
                    <?php endif; ?>
                <?php else : ?>
                    <!-- If no content, display the second column centered with width 7 -->
                    <div class="col-md-7 mx-auto">
                        <?php if ( empty( $embedded_video ) ) : ?>
                            <!-- Constant Contact Inline Form -->
                            <div class="ctct-inline-form" data-form-id="48bb00c3-d290-45ea-b50b-dfbd4c882b00"></div>
                        <?php else : ?>
                            <!-- Embedded Video (should not happen as per previous logic, but included for completeness) -->
                            <div class="mb-5">
                                <?php
                                echo '<div class="embedded-video">';
                                echo wp_kses( $embedded_video, $allowed_tags );
                                echo '</div>';
                                ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <?php
            // Comments
            if ( comments_open() || get_comments_number() ) {
                comments_template();
            }
            endwhile; // End of the loop.
            ?>
        </div>
    </div>

<?php
get_footer();
?>
