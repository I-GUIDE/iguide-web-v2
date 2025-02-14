<?php 
    get_header();
?>
    <div class="page-title tw-w-full tw-block tw-relative tw--mt-[200px] tw-pt-[200px]">
        <div class="tw-container tw-mx-auto tw-px-4 tw-h-min-[200px] tw-pb-[80px] tw-pt-12">
            <div class="tw-border-l-8 tw-pl-3 tw-border-ig-orange tw-text-white tw-font-semibold tw-text-2xl">
                <h1>Alumni</h1>
            </div>
            <p class="tw-text-light tw-text-sm tw-text-white tw-pt-2 tw-pl-5">
                Recognizing past contributors who have been part of I-GUIDE.
            </p>
        </div>
        <div class="custom-shape-divider-bottom-1675786129">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M1200 120L0 16.48 0 0 1200 0 1200 120z" class="shape-fill"></path>
            </svg>
        </div>
    </div>

    <div class="page-content tw-w-full tw-flex tw-relative tw-bg-white tw-mt-5 tw-mb-16">
        <div class="tw-container tw-mx-auto tw-px-4 tw-py-6">
            <!-- <div class="row">
                <h2 class="section-header">Our Alumni</h2>
            </div> -->

            <?php 
            // Query all alumni (where is_alumni is true)
            $alumni_args = array(
                'posts_per_page' => -1,
                'post_type'      => 'people',
                'meta_query'     => array(
                    array(
                        'key'   => 'is_alumni', // ACF True/False field
                        'value' => '1', // '1' means true
                    ),
                ),
                'meta_key'       => 'last_name', // Order by last name
                'orderby'        => 'meta_value',
                'order'          => 'ASC',
            );

            $alumni_query = new WP_Query($alumni_args);
            ?>

            <div class="row justify-content-center">

            <?php if ($alumni_query->have_posts()) : ?>
                <?php while ($alumni_query->have_posts()) : $alumni_query->the_post(); ?>
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <div class="card people-card">
                        <?php if (get_field("profile_url")): ?>
                            <a href="<?php the_field("profile_url"); ?>" class="stretched-link" target="_new">
                                <div class="card-img-top box-shadow" style="background-image: url('<?php the_field('photo'); ?>');"></div>
                            </a>
                        <?php else: ?>
                            <div class="card-img-top box-shadow" style="background-image: url('<?php the_field('photo'); ?>');"></div>
                        <?php endif; ?> 
                            <div class="card-body">
                                <h5 class="card-title name"><?php the_title(); ?></h5>
                                <p class="card-text affiliation"><?php the_field('affiliation'); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="tw-text-center tw-text-gray-500">No alumni found.</p>
            <?php endif; ?>

            </div>
        </div>
    </div>

<?php
    get_footer();
?>
