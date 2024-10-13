<?php 
    get_header();
?>
    <div class="page-title tw-w-full tw-block  tw-relative tw--mt-[200px] tw-pt-[200px]" >
        <div class="tw-container tw-mx-auto tw-px-4 tw-h-min-[200px] tw-pb-[80px] tw-pt-12">
            <div class="tw-border-l-8 tw-pl-3 tw-border-ig-orange tw-text-white tw-font-semibold tw-text-2xl">
                <h1>News and Stories</h1>
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
        <div class="row content">
            <div class="col-12"> 
                <div class="row">
                    <?php 
                        $news_args = array(
                            'posts_per_page'=> -1,
                            'post_type'     => 'news_events',
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'news_cat',
                                    'field'    => 'slug',
                                    'terms'    => array('news','newsletter'),
                                ),
                            )
                        ); 
                        $news = new WP_Query($news_args);
                    ?>
                    <?php if ( $news->have_posts() ) :?>
                        <?php while ( $news->have_posts() ) : $news->the_post(); 
                            $news_or_event = get_the_terms( get_the_ID(), 'news_cat' );
                            $description = get_field('short_description');
                            $attachment_id = get_post_meta(get_the_ID(), 'image', true);
                            $attachment_src = wp_get_attachment_image_src($attachment_id, 'full');
                            $default_img = get_template_directory_uri()."/img/area_6.png";
                        ?>

                        <!-- Bootstrap column layout for responsiveness -->
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="card <?php echo $news_or_event[0]->slug;?> h-100">
                                <!-- Card Image -->
                                <img src="<?php echo ($attachment_src)? $attachment_src[0]: $default_img; ?>" class="card-img-top tw-object-cover tw-max-h-[200px]" alt="<?php echo get_the_title();?>">

                                <!-- Card Body -->
                                <div class="card-body">
                                    <!-- Title -->
                                    <h3 class="card-title"><?php the_title();?></h3>

                                    <!-- Post Time and Category Badge -->
                                    <p class="text-muted mb-2">
                                        <?php my_post_time_ago(); ?>
                                        <!-- Displaying Badge Based on Category -->
                                        <?php 
                                        if ($news_or_event[0]->name == "News") {
                                            echo "<span class='badge bg-primary'>".$news_or_event[0]->name."</span>";
                                        } else if ($news_or_event[0]->name == "Event") {
                                            echo "<span class='badge bg-warning'>".$news_or_event[0]->name."</span>";
                                        } else if ($news_or_event[0]->name == "Newsletter") {
                                            echo "<span class='badge bg-info'>".$news_or_event[0]->name."</span>";
                                        } 
                                        ?> 
                                    </p>

                                    <!-- Short Description -->
                                    <p class="card-text"><?php echo $description; ?></p>

                                    <!-- Link -->
                                    <a href="<?php (get_field("external_link")) ? the_field("external_link") : the_permalink(); ?>" class="btn btn-primary stretched-link">Read More</a>
                                </div>
                            </div>
                        </div>
                        
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>



<?php
    get_footer();
?>