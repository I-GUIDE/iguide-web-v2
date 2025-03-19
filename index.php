<?php 
    get_header('index');
?>
    <div class="hero-section tw-relative tw-overflow-hidden">
        <?php do_shortcode("[active_slideshows]"); ?>
        <div class="tw-invisible sm:tw-visible custom-shape-divider-bottom-1676052306 z-10">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M1200 120L0 16.48 0 0 1200 0 1200 120z" class="shape-fill"></path>
            </svg>
        </div>
    </div>

    <div class="tw-container tw-flex tw-flex-col tw-gap-5 lg:tw-gap-10 tw-px-10 lg:tw-grid md:tw-grid-cols-2 md:tw-grid-row-[min-content_min-content] tw-pt-10">
        <div class="tw-w-full tw-flex tw-justify-center tw-drop-shadow-xl md:tw-row-start-1 md:tw-row-span-2">
            <div class="tw-text-center lg:tw-text-left tw-w-full">
                <h1 class="tw-text-3xl md:tw-text-6xl lg:tw-text-7xl xl:tw-text-8xl">
                    <span class="tw-text-ig-brown lg:tw-hidden">We are </span><span class="tw-text-ig-blue tw-font-black">I</span><span class="tw-text-ig-brown tw-font-black">-</span><span class="tw-text-ig-teal tw-font-black">G</span><span class="tw-text-ig-olive tw-font-black">U</span><span class="tw-text-ig-light-green tw-font-black">I</span><span class="tw-text-ig-orange tw-font-black">D</span><span class="tw-text-ig-mustard tw-font-black">E</span>
                </h1>
            </div>
        </div>
        <div class="md:tw-col-start-2 md:tw-row-start-1 md:tw-row-span-2">
            <p class="tw-text-md md:tw-text-lg lg:tw-text-2xl tw-font-light tw-tracking-wide tw-mt-1 tw-text-center lg:tw-text-left"><strong>Vision:</strong> <br class="tw-hidden md:tw-block lg:tw-hidden"> Drive digital discovery and innovation <br class="tw-hidden md:tw-block lg:tw-hidden"> by harnessing the geospatial data revolution </p> 
            <p class="tw-text-md md:tw-text-lg lg:tw-text-2xl tw-font-light tw-tracking-wide tw-mt-1 tw-text-center lg:tw-text-left tw-pt-4"><strong>Mission:</strong> <br class="tw-hidden md:tw-block lg:tw-hidden"> Advance convergence and geospatial sciences<br class="tw-hidden md:tw-block lg:tw-hidden"> for holistic sustainability solutions</p>
        </div>
    </div>

    <div class="tw-w-full tw-overflow-y-visible tw-relative tw-py-20">
        <div class="tw-w-full tw-bg-gray-200" style="transform: rotate(2deg); height:1px !important;"></div>
    </div>

    <div class="tw-container">
            <div class="tw-flex tw-flex-col md:tw-px-0 md:tw-flex-row md:tw-gap-5 lg:tw-gap-10 tw-justify-start">
                <div class="vw-screen tw-pr-5 md:tw-w-4/12 lg:tw-w-1/3 md:tw-mt-7 md:tw-pl-5 lg:tw-mt-10 lg:tw-pl-17">
                    <div id="tabs-nav" class="tw-text-black tw-text-[50px] md:tw-text-[2.5em] lg:tw-text-[4.7em] tw-font-semibold tw-text-shadow tw-inline-block">
                        <h1 class="tw-mb-3 md:tw-mb-3 lg:tw-mb-5">
                            <span id="map" class="sweep-to-right tw-cursor-pointer tw-text-black" link="#map-slide">Map. </span><br>
                            <span id="connect" class="sweep-to-right tw-cursor-pointer tw-text-black" link="#connect-slide">Connect.</span><br>
                            <span id="discover" class="sweep-to-right tw-cursor-pointer tw-text-black" link="#discover-slide">Discover.</span>
                        </h1>
                    </div> 
                    <p class="tw-text-black tw-text-sm md:tw-text-base tw-font-light inline-block">
                        <strong>I-GUIDE</strong> is empowering diverse communities to produce data-intensive solutions to society’s resilience and sustainability challenges.
                    </p>
                </div>
                <div class="tw-w-screen tw-mt-5 md:tw-mt-7 md:tw-w-8/12 lg:tw-w-2/3">
                    <div id="tw-tabs-content" class="md:tw-w-[150%] lg:tw-w-[110%]">
                        <div id="map-slide" class="hero-tab-content tw-p-0 lg:tw-p-2 z-20">
                            <?php echo do_shortcode('[hero_updates section="map"]'); ?>
                        </div>
                        <div id="connect-slide" class="hero-tab-content tw-p-0 lg:tw-p-2 z-20">
                            <?php echo do_shortcode('[hero_updates section="connect"]'); ?>
                        </div>
                        <div id="discover-slide" class="hero-tab-content tw-p-0 lg:tw-p-2 z-20">
                            <?php echo do_shortcode('[hero_updates section="discover"]'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div class="tw-w-full tw-overflow-y-visible tw-relative tw-py-20">
        <div class="tw-w-full tw-bg-gray-200" style="transform: rotate(-2deg); height:1px !important;"></div>
    </div>
    
    <div class="tw-container tw-flex tw-flex-col ">
        <section class="i-guide-section">
            <div class="images-container">
                <div class="image-wrap">
                    <div class="image-box box-1">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Image_5.png" alt="Access to High-Performance Computing system">
                        <p>Access to High-Performance Computing system</p>
                    </div>
                    <div class="image-box box-2">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Image_4.png" alt="Access to Datasets on Cloud">
                        <p>Access to Datasets on Cloud</p>
                    </div>
                    <div class="image-box box-3">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Image_6.png" alt="Simulation with Hydrological Model WRFHydro">
                        <p>Simulation with Hydrological Model WRFHydro</p>
                    </div>
                </div>
            </div>
            <div class="text-container">
                <div class="text-wrap">
                    <h1 class="tw-text-2xl lg:tw-text-3xl tw-font-semibold">I-GUIDE Platform</h1>
                    <h2>Integrative Discovery Starts Here!</h2>
                    <p class="tw-text-sm lg:tw-text-base tw-font-light tw-my-5 ">The I-GUIDE platform is designed to harness the vast, diverse, and distributed geospatial data at different spatial and temporal scales and make them broadly accessible and usable to convergence research and education enabled by cutting-edge cyberGIS and cyberinfrastructure.</p>
                    <a href="https://platform.i-guide.io/" class="btn btn-warning">Launch I-GUIDE Platform</a>
                </div>
            </div>
        </section>
    </div>

    <div class="tw-w-full tw-overflow-y-visible tw-relative tw-py-20">
        <div class="tw-w-full tw-bg-gray-200" style="transform: rotate(2deg); height:1px !important;"></div>
    </div>

        
    <div class="tw-container tw-flex tw-flex-col ">
        <h1 class="tw-text-2xl lg:tw-text-3xl tw-font-semibold mb-5">KNOWLEDGE FRONTIERS</h1>
        
        <?php echo do_shortcode("[iguide-10-items-w-link-icon]"); ?>
    </div>

    <div class="tw-w-full tw-overflow-y-visible tw-relative tw-py-20">
        <div class="tw-w-full tw-bg-gray-200" style="transform: rotate(2deg); height:1px !important;"></div>
    </div>

    <div class="news-section tw-container tw-w-full tw-px-10 tw-my-10 tw-pb-10">
        <h1 class="tw-text-2xl lg:tw-text-3xl tw-font-semibold">NEWS AND UPDATES</h1>
        <div class="news-grid tw-grid md:tw-grid-cols-3 lg:tw-grid-cols-4 md:tw-grid-rows-[max-content_min-content] md:tw-grid-flow-row tw-gap-3 md:tw-gap-5 lg:tw-gap-7  tw-mt-5">
            <?php
                $news_args = array(
                    'posts_per_page' => 8,
                    'post_type' => 'news_events',
                    'tax_query' => array(
                                        array(
                                            'taxonomy' => 'news_cat',
                                            'field'    => 'slug',
                                            'terms'    => array('news','newsletter'),
                                        ),
                                    )
                );
                $news = new WP_Query($news_args);
                $news_count = 1;
            ?>
                <?php if ($news->have_posts()): ?>
                <?php while ($news->have_posts()): $news->the_post();
                    $news_or_event = get_the_terms( get_the_ID(), 'news_cat' );
                    $description = get_field('short_description');
                    $attachment_id = get_post_meta(get_the_ID(), 'image', true);
                    $attachment_src = wp_get_attachment_image_src($attachment_id, 'full');
                    $default_img = get_template_directory_uri()."/img/area_6.png";
            ?>
            <div class="<?php if($news_count>4) echo 'tw-hidden'; ?> tw-relative tw-border lg:tw-block tw-max-w-sm tw-rounded tw-overflow-hidden tw-ease-in tw-duration-300 tw-shadow-lg hover:tw-shadow-xl">
            
                <a class="stretched-link" href="<?php (get_field("external_link")) ? the_field("external_link") : the_permalink(); ?>"></a>
                <img class="tw-object-cover tw-h-[200px] tw-w-full"
                                            src="<?php echo ($attachment_src)? $attachment_src[0]: $default_img; ?>"
                                            alt="<?php the_title();?>">
                <div class="tw-px-1 lg:tw-px-2 md:tw-px-6 tw-py-4">
                    <div class="tw-font-semibold tw-text-sm md:tw-text-sm lg:tw-text-base xl:tw-text-xl tw-mb-2"><?php the_title();?></div>
                    <?php if ( $news_or_event[0]->slug == "event"){?>
                        <p class="tw-font-light tw-mb-2 tw-text-sm"><strong>Event date:</strong> <?php echo get_field('event_date'); ?></p>
                    <?php } ?>
                    <p class="tw-text-gray-500 tw-font-light tw-italic tw-text-xs lg:tw-text-xs ">
                    <p class="tw-text-gray-500 tw-font-light tw-italic tw-text-xs lg:tw-text-sm ">
                        <?php my_post_time_ago(); ?>
                    </p>
                </div>
            </div>
            
            <?php $news_count++;
            endwhile;?>
            <?php endif;?>
            
            <!-- <div id="twt-block" class="tw-border tw-max-w-sm md:tw-row-start-1 md:tw-row-span-2 tw-rounded-xl justify-self-auto tw-shadow-lg tw-overflow-hidden">
                <a class="twitter-timeline tw-h-full" data-height="1000" href="https://twitter.com/NSFiGUIDE?ref_src=twsrc%5Etfw">Tweets by NSFiGUIDE</a> 
                <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script> 
            </div> -->
        </div>
    </div>

    <div class="maillist-section tw-bg-gray-100 tw-w-full tw-pt-5 tw-px-10 tw-pb-5">
        <div class="tw-container">
            <!-- <h1 class="tw-text-2xl lg:tw-text-3xl tw-font-semibold">Join I-GUIDE's Mailing List</h1>
            <p class="tw-font-light tw-text-sm lg:tw-text-base tw-text-black tw-mt-5">Join I-GUIDE's mailing list for updates on geospatial
                discovery and
                innovation. Stay informed on community priorities, cutting-edge data capabilities, and exciting
                advancements in various disciplines. Don't miss out on opportunities to participate in shaping the
                future of geospatial data-intensive sciences. Sign up now!</p> -->
            <!-- Begin Constant Contact Inline Form Code -->
            <div class="ctct-inline-form" data-form-id="44d7424d-0385-4ea9-8145-50702484d1f0"></div>
            <!-- End Constant Contact Inline Form Code -->
        </div>
    </div>


    <div class="tw-collob-section tw-w-full tw-my-16 tw-px-10 tw-max-w-full">
        <div class="tw-container">
            <h1 class="tw-text-2xl lg:tw-text-3xl tw-font-semibold">Collaborating Institutions</h1>
            <div class="tw-flex tw-gap-x-5 tw-gap-y-10 md:tw-gap-y-10 tw-align-center tw-items-center tw-justify-content tw-mx-auto tw-flex-wrap tw-py-10 tw-mt-5">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/uiuc.png" alt="" class="tw-mx-auto tw-h-[10vh] md:tw-h-[80px] lg:tw-h-[12vh]">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/columbiauniv.png" alt="" class="tw-mx-auto tw-h-[10vh] md:tw-h-[80px] lg:tw-h-[12vh]">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/inst7.png" alt="" class="tw-mx-auto tw-h-[10vh] md:tw-h-[80px] lg:tw-h-[12vh]">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/fiu.png" alt="" class="tw-mx-auto tw-h-[10vh] md:tw-h-[80px] lg:tw-h-[12vh]">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/michiganstate.png" alt="" class="tw-mx-auto tw-h-[10vh] md:tw-h-[80px] lg:tw-h-[12vh]">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/inst9.png" alt="" class="tw-mx-auto h-[10vh] md:tw-h-[80px] lg:tw-h-[12vh]">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/purdue.png" alt="" class="tw-mx-auto h-[10vh] md:tw-h-[80px] lg:tw-h-[12vh]">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/inst10.png" alt="" class="tw-mx-auto h-[10vh] md:tw-h-[80px] lg:tw-h-[12vh]">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/inst8.png" alt="" class="tw-mx-auto h-[10vh] md:tw-h-[80px] lg:tw-h-[12vh]">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/minnesota.png" alt="" class="tw-mx-auto tw-h-[10vh] md:tw-h-[80px] lg:tw-h-[12vh]">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/utahstate.png" alt="" class="tw-mx-auto tw-h-[10vh] md:tw-h-[80px] lg:tw-h-[12vh]">
            </div>
        </div>
    </div>

<?php
    get_footer();
?>