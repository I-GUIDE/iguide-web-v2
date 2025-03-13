<?php
/**
 * Template Name: Research Frontiers
 */

get_header();
?>

<style>
    .research-frontier-block {
        position: relative;
        overflow: hidden;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background: white;
        margin-bottom: 20px;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .research-frontier-image {
        width: 100%;
        height: 250px;
        object-fit: cover;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        position: relative;
        background-position: center center;
        background-size: cover;
    }

    .research-frontier-image::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(0deg, rgba(255,255,255,1) 0%, rgba(255,255,255,0) 25%);
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .research-frontier-content {
        position: relative;
        padding: 0 15px 15px; 
        background: white;
        z-index: 2;
        flex-grow: 1;
    }

    .research-frontier-content h3 {
        font-size: 1.5em;
        margin-bottom: 10px;
    }

    .research-frontier-content p, .research-frontier-content ul {
        font-size: 1em;
        color: #555;
    }

    .research-frontier-content h4 {
        font-size: 1.2em;
        margin-top: 10px;
        color: #0073aa;
    }

    .research-frontier-column {
        padding: 10px;
    }

    .page-subtext {
        margin-top: 15px;
        font-size: 15px;
        font-weight: 100;
        line-height: 1.5rem;
    }
</style>

<div class="page-title tw-w-full tw-block tw-relative tw--mt-[200px] tw-pt-[200px]" >
    <div class="tw-container tw-mx-auto tw-px-4 tw-h-min-[200px] tw-pb-[80px] tw-pt-12">
        <div class="tw-border-l-8 tw-pl-3 tw-border-ig-orange tw-text-white tw-font-semibold tw-text-2xl">
            <h1><?php the_title();?></h1>
            <p class="page-subtext">I-GUIDE is at the forefront of geospatial data science, pioneering cutting-edge advancements in sustainability, resilience, and technological innovation. Through interdisciplinary research, advanced cyberinfrastructure, and AI-driven solutions, we are expanding the boundaries of knowledge in geospatial analysis, education, and decision-making. The following highlights key areas where I-GUIDE is creating transformative impact.</p>
        </div>
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
        <div class="row">
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

            $options = get_option('iguide10_options', []);

            foreach ($research_frontiers as $key => $title) :
                $image_url = get_template_directory_uri() . "/assets/images/{$key}.jpeg"; // Ensure these images exist
            ?>
                <div class="col-lg-6 col-md-6 col-sm-12 research-frontier-column">
                    <div class="research-frontier-block">
                        <div class="research-frontier-image" style="background-image: url('<?php echo esc_url($image_url); ?>');"></div>
                        <div class="research-frontier-content">
                            <h3><?php echo esc_html($title); ?></h3>
                            <p><?php echo isset($options[$key]) ? wp_kses_post($options[$key]) : ''; ?></p>
                            <?php echo iguide10_get_content_for_item($key); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
