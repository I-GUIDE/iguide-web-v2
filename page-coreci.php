<?php 
    get_header();
?>
    <div class="page-title tw-w-full tw-block  tw-relative tw--mt-[200px] tw-pt-[200px]" >
        <div class="tw-container tw-mx-auto tw-px-4 tw-h-min-[200px] tw-pb-[80px] tw-pt-12">
            <div class="tw-border-l-8 tw-pl-3 tw-border-ig-orange tw-text-white tw-font-semibold tw-text-2xl">
                <h1><?php the_title();?></h1>
            </div>
            <p class="tw-text-light tw-text-sm tw-text-white tw-pt-2 tw-pl-5">Integrate distributed geospatial data capabilities and advanced CI to form a composable and open I-GUIDE platform to accelerate scientific workflows and support education and workforce development as well as broader community engagement</p>
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
            <h2 class="section-header">Team Leads</h2>
        </div>

        <?php 
        $coreci_leader_args = array(
            'posts_per_page'=> -1,
            'post_type'		=> 'people',
            'post__in' => array(82,87),
            'meta_query'     => array(
                'relation' => 'OR',
                array(
                    'key'     => 'is_alumni',
                    'value'   => '0',  // Explicitly include non-alumni
                    'compare' => '=',  // Must be exactly 0 (false)
                ),
                array(
                    'key'     => 'is_alumni',
                    'compare' => 'NOT EXISTS', // Include people where 'is_alumni' is missing (NULL)
                ),
            ),
            'meta_key'       => 'last_name', // Order by last name
            'orderby'        => 'meta_value',
            'order'          => 'ASC',
        );

        $coreci_leader_query = new WP_Query($coreci_leader_args);
        ?>

        <div class="row justify-content-center">

            <?php if ( $coreci_leader_query->have_posts() ) :?>
                <?php  while ( $coreci_leader_query->have_posts() ) : $coreci_leader_query->the_post(); ?>
                <div class="col-6 col-sm-4 col-md-3 col-lg-3">
                    <div class="card people-card ">
                    <a href="<?php the_field("profile_url"); ?>" class="stretched-link" target="_new"><div class="card-img-top box-shadow" style="background-image: url('<?php the_field('photo'); ?>');"></div></a>
                        <div class="card-body ">
                            <h5 class="card-title name "><?php the_title(); ?></h5>
                            <!-- <p class="card-text position "><?php the_field("team_position"); ?></p> -->
                            <p class="card-text affiliation "><?php the_field("affiliation"); ?></p>
                        </div>
                    </div>
                </div>
                <?php  endwhile;  ?>
            <?php endif; ?>

        </div>
        <div class="row">
            <h2 class="section-header">Team Members</h2>
        </div>

        <?php 
        $coreci_member_args = array(
            'posts_per_page'=> -1,
            'post_type'		=> 'people',
            'post__not_in' => array(82,87),
            'tax_query' => array(
                array(
                    'taxonomy' => 'focus_area',
                    'field'    => 'slug',
                    'terms'    => 'coreci',
                ),
            ),
            'meta_query'     => array(
                'relation' => 'OR',
                array(
                    'key'     => 'is_alumni',
                    'value'   => '0',  // Explicitly include non-alumni
                    'compare' => '=',  // Must be exactly 0 (false)
                ),
                array(
                    'key'     => 'is_alumni',
                    'compare' => 'NOT EXISTS', // Include people where 'is_alumni' is missing (NULL)
                ),
            ),
            'meta_key'       => 'last_name', // Order by last name
            'orderby'        => 'meta_value',
            'order'          => 'ASC',
        );

        $coreci_member_query = new WP_Query($coreci_member_args);
        ?>
        <div class="row  justify-content-center">

        <?php if ( $coreci_member_query->have_posts() ) :?>
        <?php  while ( $coreci_member_query->have_posts() ) : $coreci_member_query->the_post(); ?>

            <div class="col-6 col-sm-4 col-md-2 col-lg-2">
                <div class="card people-card ">
                <a href="<?php the_field("profile_url"); ?>" class="stretched-link" target="_new"><div class="card-img-top box-shadow" style="background-image: url('<?php the_field('photo'); ?>');"></div></a>
                    <div class="card-body ">
                        <h5 class="card-title name "><?php the_title(); ?></h5>
                        <p class="card-text affiliation "><?php the_field('affiliation'); ?></p>
                    </div>
                </div>
            </div>

            
        <?php  endwhile;  ?>
        <?php endif; ?>
        </div>
        </div>
    </div>

<?php
    get_footer();
?>