<?php
/*
Template Name: SummerSchoolParticipants
Description: A template to display Summer School participants filtered by focus area.
Template Post Type: post, page, event
*/

get_header();
?>
<div class="page-title tw-w-full tw-block  tw-relative tw--mt-[200px] tw-pt-[200px]">
    <div class="tw-container tw-mx-auto tw-px-4 tw-h-min-[200px] tw-pb-[80px] tw-pt-12">
        <div class="tw-border-l-8 tw-pl-3 tw-border-ig-orange tw-text-white tw-font-semibold tw-text-2xl">
            <h1><?php the_title(); ?></h1>
        </div>
        <p class="tw-text-light tw-text-sm tw-text-white tw-pt-2 tw-pl-5">Participants of the Summer School filtered by
            Focus Area</p>
    </div>
    <div class="custom-shape-divider-bottom-1675786129">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M1200 120L0 16.48 0 0 1200 0 1200 120z" class="shape-fill"></path>
        </svg>
    </div>
</div>
<div class="page-content tw-w-full tw-flex tw-relative tw-bg-white tw-mt-5 tw-mb-16">
    <div class="tw-container tw-mx-auto tw-px-4 tw-py-6">
        <div class="row">
            <h2 class="section-header">Participants</h2>
        </div>
        <?php
        $focus_area_slug = isset($_GET['focus_area']) ? sanitize_text_field($_GET['focus_area']) : '';
        if ($focus_area_slug) {
            $args = array(
                'post_type' => 'people',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'focus_area',
                        'field' => 'slug',
                        'terms' => $focus_area_slug,
                    ),
                ),
                'posts_per_page' => -1,
                'meta_key' => 'last_name',
                'orderby' => 'meta_value',
                'order' => 'ASC',
            );
            $query = new WP_Query($args);
            ?>
        <div class="row justify-content-center">
            <?php
                if ($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post();
                        $profile_url = get_field('profile_url');
                        $photo = get_field('photo');
                        $affiliation = get_field('affiliation');
                        $department = get_field('department_program'); // optional field
                        ?>
            <div class="col-6 col-sm-4 col-md-2 col-lg-2">
                <div class="card people-card ">
                    <?php if ($profile_url): ?><a href="<?php echo esc_url($profile_url); ?>" class="stretched-link"
                        target="_new"><?php endif; ?>
                        <div class="card-img-top box-shadow"
                            style="background-image: url('<?php echo esc_url($photo); ?>');"></div>
                        <?php if ($profile_url): ?>
                    </a><?php endif; ?>
                    <div class="card-body ">
                        <h5 class="card-title name "><?php the_title(); ?></h5>
                        <p class="card-text affiliation "><?php echo esc_html($affiliation); ?></p>
                        <?php if ($department): ?>
                        <p class="card-text department "><?php echo esc_html($department); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php
                    }
                    wp_reset_postdata();
                } else {
                    echo '<p>No participants found for this focus area.</p>';
                }
                ?>
        </div>
        <?php } else {
            echo '<p>No focus area specified.</p>';
        }
        ?>
    </div>
</div>
<?php
get_footer();