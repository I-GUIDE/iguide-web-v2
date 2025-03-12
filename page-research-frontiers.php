<?php
/**
 * Template Name: Research Frontiers
 */

get_header();
?>

<style>
    .research-frontiers-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        padding: 40px 20px;
        max-width: 1200px;
        margin: auto;
    }

    .research-frontier-block {
        position: relative;
        overflow: hidden;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background: white;
    }

    .research-frontier-block img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .research-frontier-content {
        padding: 15px;
    }

    .research-frontier-content h3 {
        font-size: 1.5em;
        margin-bottom: 10px;
    }

    .research-frontier-content p {
        font-size: 1em;
        color: #555;
    }
</style>

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
                    the_content();
                    // If comments are open or we have at least one comment, load up the comment template.
                    if ( comments_open() || get_comments_number() ) {
                        comments_template();
                    }
                endwhile; // End of the loop.
            ?>
        </div>
    </div>

<div class="research-frontiers-container">
    <?php
    $research_frontiers = array(
        'iguide_platform'                     => 'I-GUIDE Platform',
        'spatial_ai_challenge'                => 'Spatial AI Challenge',
        'virtual_consulting_offices'          => 'Virtual Consulting Offices (VCOs)',
        'iguide_summer_schools'               => 'I-GUIDE Summer Schools',
        'convergence_curriculum'              => 'Convergence Curriculum',
        'aging_dam_infrastructure'            => 'Aging Dam Infrastructure',
        'geospatial_knowledge_hypercube'      => 'Geospatial Knowledge Hypercube',
        'extreme_events_resilience'           => 'Extreme Events & Disaster Resilience',
        'robust_geospatial_data_science'      => 'Robust Geospatial Data Science',
        'telecoupling_cross_scale_sustainability' => 'Telecoupling and Cross-scale Understanding of Sustainability'
    );

    foreach ($research_frontiers as $key => $title) :
        $description = get_option("iguide10_options")[$key] ?? '';
        $image_url = get_template_directory_uri() . "/images/{$key}.jpg"; // Ensure these images exist in your theme's images folder
    ?>
        <div class="research-frontier-block">
            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($title); ?>">
            <div class="research-frontier-content">
                <h3><?php echo esc_html($title); ?></h3>
                <p><?php echo wp_kses_post($description); ?></p>
                <?php echo do_shortcode("[iguide-10-items-w-link-icon key='$key']"); ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php get_footer(); ?>
