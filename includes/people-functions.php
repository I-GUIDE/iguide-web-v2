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

/**
 * Automatically extracts and updates the first name and last name 
 * from the post title when a 'people' post is saved, but prioritizes 
 * manually entered values if they exist.
 *
 * @param int     $post_id The ID of the post being saved.
 * @param WP_Post $post The post object.
 * @param bool    $update Whether this is an existing post being updated.
 */
function update_people_name_fields($post_id, $post, $update) {
    // Prevent execution during autosave.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    // Ensure this only applies to 'people' post type.
    if ($post->post_type !== 'people') return;

    // Get the manually set first and last name values.
    $manual_first_name = get_post_meta($post_id, 'first_name', true);
    $manual_last_name = get_post_meta($post_id, 'last_name', true);

    // If both first_name and last_name exist, do not override.
    if (!empty($manual_first_name) && !empty($manual_last_name)) {
        return;
    }

    // Get the full name from the post title and trim whitespace.
    $full_name = trim($post->post_title);

    // Split the full name into words.
    $name_parts = explode(' ', $full_name);

    // Ensure at least two words exist for proper name separation.
    if (count($name_parts) > 1) {
        // Extract the last word as the last name.
        $last_name = array_pop($name_parts);
        // Combine the remaining words as the first name.
        $first_name = implode(' ', $name_parts);
    } else {
        // If there's only one word, assume it's the first name.
        $first_name = $full_name;
        $last_name = '';
    }

    // Only update the first_name if it’s not manually set.
    if (empty($manual_first_name)) {
        update_post_meta($post_id, 'first_name', $first_name);
    }

    // Only update the last_name if it’s not manually set.
    if (empty($manual_last_name)) {
        update_post_meta($post_id, 'last_name', $last_name);
    }
}

// Hook into WordPress to execute the function when a 'people' post is saved.
add_action('save_post', 'update_people_name_fields', 10, 3);
