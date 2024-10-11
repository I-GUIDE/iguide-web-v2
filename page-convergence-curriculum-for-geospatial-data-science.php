<?php 
if(is_child_of(get_page_ID_by_slug('platform'))) { // check if it is platform 
    get_template_part('platform/template');
} //if not platform 
else {
    get_header();
?>
    <div class="page-title tw-w-full tw-block  tw-relative tw--mt-[200px] tw-pt-[200px]" >
        <div class="tw-container tw-mx-auto tw-px-4 tw-h-min-[200px] tw-pb-[80px] tw-pt-12">
            <div class="tw-border-l-8 tw-pl-3 tw-border-ig-orange tw-text-white tw-font-semibold tw-text-2xl">
                <h1><?php the_title();?></h1>
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
                /* Start the Loop */
                while ( have_posts() ) :
                    the_post();
                    $bottom_part = get_field('bottom_part');
                    the_content();
                    // If comments are open or we have at least one comment, load up the comment template.
                    if ( comments_open() || get_comments_number() ) {
                        comments_template();
                    }
                endwhile; // End of the loop.
            ?>

            <hr>
            <h2 class="text-left"><b>Convergence Curriculum Components</b></h2>
            <div class="row">
                    <?php
                    $taxonomy = 'curr_group'; // Replace with the desired taxonomy name
                    $terms = get_terms( array(
                        'taxonomy' => $taxonomy,
                        'hide_empty' => false,
                    ) );

                    // var_dump($terms);

                    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                        foreach ( $terms as $term ) {
                            $args = array(
                                'post_type' => 'convergent_curr',
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => $taxonomy,
                                        'field' => 'slug',
                                        'terms' => $term->slug,
                                    ),
                                ),
                            );
                            $posts = new WP_Query( $args );
                            if ( $posts->have_posts() ) {
                                echo '<div class="col-12 mt-4"><h4>' . esc_html( $term->name ) . '</h4></div>';
                                echo '<div class="row d-flex">';
                                while ( $posts->have_posts() ) {
                                    $posts->the_post();
                                    $platform_url = get_post_meta(get_the_ID(), 'platform_url', true);
                                    if (!empty($platform_url)) {
                                        // Use the platform URL if it's not empty
                                        $url = $platform_url;
                                    } else {
                                        // Fallback to the permalink if the platform URL is empty
                                        $url = get_permalink($post->ID);
                                    }
                                    
                                    $attachment_id = get_post_meta(get_the_ID(), 'curr_image', true);
                                    $attachment_src = wp_get_attachment_image_src($attachment_id, 'full');
                                    $curr_title = esc_html( get_the_title() );
                                    ?>
                                    <div class="col" style="max-width:20%;">
                                        <div class="card curr-card my-2 rounded-3" style="height:200px; background-image: url(<?php echo ($attachment_src) ? $attachment_src[0] : $default_img; ?>);">
                                            <div class="card-img-overlay d-flex align-items-end">
                                                <h4 style="font-size:15px;" class="card-title text-white text-left"><?php echo $curr_title; ?></h4>
                                                <a href="<?php echo esc_url($url); ?>" class="stretched-link"></a>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    // echo '<li><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a></li>';
                                }
                                echo '</div>';
                            }
                            wp_reset_postdata();
                        }
                    }
                    ?>
                </div>
                
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                        <hr>
                        <h2 class="text-center"><b>Presentations and Community</b></h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                        <?php
                            echo  $bottom_part ;
                        ?>
                        </div>
                    </div>
                </div>

        </div>
    </div>

<?php
    get_footer();
};
?>