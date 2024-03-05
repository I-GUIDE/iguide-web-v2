<?php 
    get_header();
?>
    <div class="page-title tw-w-full tw-block  tw-relative tw--mt-[200px] tw-pt-[200px]" >
        <div class="tw-container tw-mx-auto tw-px-4 tw-h-min-[200px] tw-pb-[80px] tw-pt-12">
            <div class="tw-border-l-8 tw-pl-3 tw-border-ig-orange tw-text-white tw-font-semibold tw-text-2xl">
                <h1><?php the_title();?></h1>
            </div>
            <p class="tw-text-light tw-text-sm tw-text-white tw-pt-2 tw-pl-5"><?php my_post_time_ago(); ?></p>
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
                    /* Start the Loop */
                    while ( have_posts() ) :
                        the_post();
                        $attachment_id = get_post_meta(get_the_ID(), 'curr_image', true);
                        $attachment_src = wp_get_attachment_image_src($attachment_id, 'full');
                        // the_content();
                        // If comments are open or we have at least one comment, load up the comment template.
                        // if ( comments_open() || get_comments_number() ) {
                        //     comments_template();
                        // }
                        ?>
                        
                        <h3>3 Sentences</h3>
                        <hr>
                        <?php
                            echo wp_kses_post( get_field('3_sentences') );
                        ?>
                        
                        <h3 class="mt-5">3 slides</h3>
                        <hr>
                        <?php
                            echo wp_kses_post( get_field('google_slide_embed') );
                        ?>
                        <h3 class="mt-5">3 hour module</h3>
                        <hr>
                        <?php
                            echo wp_kses_post( get_field('3_hours_module') );
                    endwhile; // End of the loop.
                    ?>
        </div>
    </div>

<?php
    get_footer();
?>