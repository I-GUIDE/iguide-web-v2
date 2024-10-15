<?php 
    get_header();
?>

    <style>
        .curr-card {
            position: relative;
            overflow: hidden;
        }

        .curr-card .card-img-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0); /* Transparent by default */
            transition: background 0.3s ease, filter 0.3s ease; /* Smooth transition for background and filter */
            backdrop-filter: blur(0px); /* Initial blur effect */
        }

        .curr-card:hover .card-img-overlay {
            background: rgba(0, 0, 0, 0.5); /* Darken overlay with 50% opacity on hover */
            backdrop-filter: blur(2px); /* Apply blur effect on hover */
        }

        .curr-card .card-title {
            z-index: 1; /* Keep the text above the overlay */
            transition: color 0.3s ease;
        }
        .border-blue {
            border: 3px solid #00A0B0;
        }

        .border-pink {
            border: 3px solid #BD1550;
        }

        .border-green {
            border: 3px solid #8A9B0F;
        }

        .border-yellow {
            border: 3px solid #F8CA00;
        }

        .border-purple {
            border: 3px solid #490A3D;
        }

        .border-orange {
            border: 3px solid #E97F02;
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
            <div class="row">
                <!-- First column with the image -->
                <div class="col-12 col-md-5 p-3 align-self-center">
                    <img src="https://i-guide.io/wp-content/uploads/2024/10/Convergent-Curriculum-Design.png" alt="Convergence Curriculum Design" class="shadow-none">

                    <p class="mt-4">The Convergence Curriculum for Geospatial Data Science is an integrative framework designed to equip students, scholars, and professionals with the skills to address complex, real-world problems by building foundational literacy across multiple disciplines. It offers a flexible, multi-tiered structure with five Foundational Knowledge Threads, leading to Knowledge Connections and Knowledge Convergence, enabling learners to blend diverse skills, methods, and technologies. Content is available in varying depths (from brief overviews to in-depth modules), allowing for adaptable learning paths. The curriculum is continuously refined based on community feedback, with ongoing development and content releases.</p>
                </div>
                <!-- Second column -->
                <div class="col-12 col-md-7 text-white p-3">
                <div class="row">
                <?php
                    $taxonomy = 'curr_group'; // Replace with the desired taxonomy name
                    $terms = get_terms(array(
                        'taxonomy' => $taxonomy,
                        'hide_empty' => false,
                    ));

                    if (!empty($terms) && !is_wp_error($terms)) {
                        foreach ($terms as $term) {
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
                            $posts = new WP_Query($args);
                            if ($posts->have_posts()) {
                                echo '<div class="col-12 mt-1 text-dark"><h4>' . esc_html($term->name) . '</h4></div>';
                                echo '<div class="row d-flex">';

                                // Map slugs to border color classes
                                $border_classes = array(
                                    'fkt' => 'border-blue',
                                    'kc' => 'border-pink',
                                    'kf' => 'border-green',
                                    'dk' => 'border-yellow',
                                    'kconv' => 'border-purple',
                                    'cc' => 'border-orange',
                                );

                                // Determine the border class based on the current term slug
                                $border_class = isset($border_classes[$term->slug]) ? $border_classes[$term->slug] : 'border-default';

                                while ($posts->have_posts()) {
                                    $posts->the_post();
                                    $platform_url = get_post_meta(get_the_ID(), 'platform_url', true);
                                    $url = !empty($platform_url) ? $platform_url : get_permalink($post->ID);

                                    $attachment_id = get_post_meta(get_the_ID(), 'curr_image', true);
                                    $attachment_src = wp_get_attachment_image_src($attachment_id, 'full');
                                    $curr_title = esc_html(get_the_title());
                                    ?>
                                    <div class="col" style="max-width:20%;">
                                        <div class="card curr-card my-1 rounded-3 p-0 shadow-none <?php echo esc_attr($border_class); ?>" style="height:100px; background-image: url(<?php echo ($attachment_src) ? $attachment_src[0] : $default_img; ?>);">
                                            <div class="card-img-overlay d-flex align-items-end p-2">
                                                <h4 style="font-size:15px;" class="card-title text-white text-left m-0 p-0"><?php echo $curr_title; ?></h4>
                                                <a href="<?php echo esc_url($url); ?>" class="stretched-link"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                echo '</div>';
                            }
                            wp_reset_postdata();
                        }
                    }
                    ?>
                </div>
                </div>
            </div>


            <div class="container">
                <hr class="my-5">
                <h2 class="text-center mb-4"><b>Learn More about the NSF I-GUIDE Convergence Curriculum Program</b></h2>
                <div class="row g-4">
                    <!-- First Column -->
                    <div class="col-md-3">
                        <div class="card border-0">
                        <iframe width="100%" height="200" src="https://www.youtube.com/embed/2JV_tikDw9Q" title="Plenary Talk: Convergence Curriculum Powered by I GUIDE by Eric Shook and Rajesh Kalyanam" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            <div class="card-body">
                                <h5 class="card-title">Convergence Curriculum Powered by I-GUIDE</h5>
                                <p class="card-text">Eric Shook and Rajesh Kalyanam</p>
                                <a href="https://i-guide.io/forum-2023" class="text-danger">2023 NSF I-GUIDE Forum</a>
                                <p>October 5, 2023</p>
                            </div>
                        </div>
                    </div>
                    <!-- Second Column -->
                    <div class="col-md-3">
                        <div class="card border-0">
                        <iframe id="kmsembed-1_8dcqg40b" class="aligncenter" title="I-GUIDE Virtual Consulting Office (VCO) - The Convergence Curriculum for Geospatial Data Science: Materials Available" src="https://mediaspace.illinois.edu/embed/secure/iframe/entryId/1_8dcqg40b/uiConfId/26883701/st/0" width="100%" height="200" frameborder="0" sandbox="allow-downloads allow-forms allow-same-origin allow-scripts allow-top-navigation allow-pointer-lock allow-popups allow-modals allow-orientation-lock allow-popups-to-escape-sandbox allow-presentation allow-top-navigation-by-user-activation" allowfullscreen="allowfullscreen"><span data-mce-type="bookmark" style="width: 0px;overflow: hidden;line-height: 0" class="mce_SELRES_start">&#xFEFF;</span></iframe>
                            <div class="card-body">
                                <h5 class="card-title">Convergence Curriculum for Geospatial Data Science</h5>
                                <p class="card-text">Eric Shook</p>
                                <a href="https://i-guide.io/i-guide-vco/convergence-curriculum-for-geospatial-data-science/" class="text-danger">NSF I-GUIDE VCO Series</a>
                                <p>February 7, 2023</p>
                            </div>
                        </div>
                    </div>
                    <!-- Third Column -->
                    <div class="col-md-3">
                        <div class="card border-0">
                        <iframe id="kmsembed-1_mp5n5i6i" class="aligncenter" title="I-GUIDE Virtual Consulting Office _GeoEDF" src="https://mediaspace.illinois.edu/embed/secure/iframe/entryId/1_1f99enxq" width="100%" height="200" frameborder="0" sandbox="allow-downloads allow-forms allow-same-origin allow-scripts allow-top-navigation allow-pointer-lock allow-popups allow-modals allow-orientation-lock allow-popups-to-escape-sandbox allow-presentation allow-top-navigation-by-user-activation" allowfullscreen="allowfullscreen"></iframe>
                            <div class="card-body">
                                <h5 class="card-title">The Convergence Curriculum for Geospatial Data Science: Open Resources for You and your Learners</h5>
                                <p class="card-text">Eric Shook</p>
                                <a href="https://i-guide.io/i-guide-vco/the-convergence-curriculum-for-geospatial-data-science-open-resources-for-you-and-your-learners/" class="text-danger">NSF I-GUIDE VCO Series</a>
                                <p>November 14, 2022</p>
                            </div>
                        </div>
                    </div>
                    <!-- Fourth Column -->
                    <div class="col-md-3">
                        <div class="card border-0">
                        <iframe width="100%" height="200" src="https://www.youtube.com/embed/CAaJkAkA9t4" title="I-GUIDE Webinar : Navigating the Evolving Educational Landscape in a Convergent Geospatial World" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            <div class="card-body">
                                <h5 class="card-title">Navigating the Evolving Educational Landscape in a Convergent Geospatial World</h5>
                                <p class="card-text">Eric Shook</p>
                                <a href="https://i-guide.io/i-guide-webinar-series/" class="text-danger">NSF I-GUIDE Webinar Series</a>
                                <p>March 23, 2022</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                
            <div class="col-12">
                <div class="row">
                    <div class="col-12">
                    <hr class="my-5">
                    <h2 class="text-center"><b>Presentations and Community</b></h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <ul>
                            <li aria-checked="false" aria-level="3"><a href="https://i-guide.io/i-guide-webinar-series/#:~:text=Navigating%20the%20Evolving%20Educational%20Landscape%20in%20a%20Convergent%20Geospatial%20World" target="_blank" rel="noopener">I-GUIDE Webinar Series: Navigating the Evolving Educational Landscape in a Convergent Geospatial World</a></li>
                            <li aria-checked="false" aria-level="3"><a href="https://i-guide.io/community-champions" target="_blank" rel="noopener">UCGIS I-GUIDE Community Champions</a></li>
                            <li aria-checked="false" aria-level="3"><a href="https://i-guide.io/i-guide-vco/i-guide-vco-the-convergence-curriculum-for-geographic-information-science/" target="_blank" rel="noopener">The Convergence Curriculum for Geospatial Data Science: Open Resources for You and Your Learners</a></li>
                            <li aria-checked="false" aria-level="3"><a href="https://i-guide.io/geoethics/" target="_blank" rel="noopener">I-GUIDE addresses the challenge of computational reproducibility and data ethics by guiding data sharing and ethical decision-making in research practices and AI algorithms</a></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

<?php
    get_footer();
?>