<?php
/**
 * Add custom columns for first_name and last_name in 'people' post type.
 */
function add_people_custom_columns($columns) {
    $columns['first_name'] = 'First Name';
    $columns['last_name'] = 'Last Name';
    return $columns;
}
add_filter('manage_people_posts_columns', 'add_people_custom_columns');

/**
 * Populate the custom columns with data from post meta.
 */
function fill_people_custom_columns($column, $post_id) {
    if ($column === 'first_name') {
        echo esc_html(get_post_meta($post_id, 'first_name', true));
    }
    if ($column === 'last_name') {
        echo esc_html(get_post_meta($post_id, 'last_name', true));
    }
}
add_action('manage_people_posts_custom_column', 'fill_people_custom_columns', 10, 2);

/**
 * Make first_name and last_name columns sortable.
 */
function make_people_columns_sortable($sortable_columns) {
    $sortable_columns['first_name'] = 'first_name';
    $sortable_columns['last_name'] = 'last_name';
    return $sortable_columns;
}
add_filter('manage_edit-people_sortable_columns', 'make_people_columns_sortable');

/**
 * Modify the query to sort by first_name or last_name when sorting in admin.
 */
function sort_people_columns_by_meta($query) {
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }

    $orderby = $query->get('orderby');

    if ($orderby === 'first_name' || $orderby === 'last_name') {
        $query->set('meta_key', $orderby);
        $query->set('orderby', 'meta_value');
    }
}
add_action('pre_get_posts', 'sort_people_columns_by_meta');
