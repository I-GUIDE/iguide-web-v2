
<?php 
    get_header();
?>

<div class="page-title tw-w-full tw-block  tw-relative tw--mt-[200px] tw-pt-[200px]" >
        <div class="tw-container tw-mx-auto tw-px-4 tw-h-min-[200px] tw-pb-[80px] tw-pt-12">
            <div class="tw-border-l-8 tw-pl-3 tw-border-ig-orange tw-text-white tw-font-semibold tw-text-2xl">
                <h1><?php the_title();?></h1>
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
            
        <?php 
        $advisory_board_args = array(
            'posts_per_page'=> -1,
            'post_type'		=> 'people',
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
            'tax_query' => array(
                array(
                    'taxonomy' => 'position',
                    'field'    => 'slug',
                    'terms'    => array( 'advisory', 'council-of-geospatial-leaders'),
                    'operator' => 'NOT IN',
                )
            ),
            'meta_key'       => 'last_name', // Order by last name
            'orderby'        => 'meta_value',
            'order'          => 'ASC',
        );

        $advisory_boards = new WP_Query($advisory_board_args);
        ?>
        <div class="row  justify-content-center">

        <?php if ( $advisory_boards->have_posts() ) :?>
        <?php  while ( $advisory_boards->have_posts() ) : $advisory_boards->the_post(); ?>

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