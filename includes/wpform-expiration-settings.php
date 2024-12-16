<?php
/**
 * Expiration Settings for WPForms.
 * Adds a custom settings section, fields, and logic to handle form expiration.
 */

// 1. Add a new section to the WPForms Form Builder Settings.
function add_expiration_settings_section( $sections, $form_data ) {
    $sections['expiration_settings'] = __( 'Expiration Settings', 'wpform_expiration' );
    return $sections;
}
add_filter( 'wpforms_builder_settings_sections', 'add_expiration_settings_section', 20, 2 );

// 2. Add Expiration Settings fields (Expiration Date & Time, Expiration Message).
function add_expiration_settings_fields( $instance ) {
    
    echo '<div class="wpforms-panel-content-section wpforms-panel-content-section-expiration_settings">';
    echo '<div class="wpforms-panel-content-section-title">Expiration Settings</div>';

    // Expiration DateTime Field
    wpforms_panel_field(
        'text',
        'settings',
        'expiration_datetime',
        $instance->form_data,
        __( 'Expiration Date & Time', 'wpform_expiration' ),
        [
            'placeholder' => 'YYYY-MM-DD HH:MM:SS',
            'after'       => '<p class="description">' . __( 'Set the date and time when the form will expire (format: YYYY-MM-DD HH:MM:SS).', 'wpform_expiration' ) . '</p>',
        ]
    );

    // Expiration Message Field
    wpforms_panel_field(
        'tinymce',
        'settings',
        'expiration_message',
        $instance->form_data,
        __( 'Expiration Message', 'wpform_expiration' ),
        [
            'rows'        => 4,
            'placeholder' => __( 'This form has expired.', 'wpform_expiration' ),
            'after'       => '<p class="description">' . __( 'Message displayed to users when the form has expired.', 'wpform_expiration' ) . '</p>',
        ]
    );

    echo '</div>';
}
add_action( 'wpforms_form_settings_panel_content', 'add_expiration_settings_fields' );


// 3. Implement Expiration Logic to Hide Forms After Expiry.

function check_form_expiration( $form_data, $form ) {
    // Retrieve Expiration Settings
    $expiration_datetime = isset( $form_data['settings']['expiration_datetime'] ) ? $form_data['settings']['expiration_datetime'] : '';
    $expiration_message  = isset( $form_data['settings']['expiration_message'] ) ? $form_data['settings']['expiration_message'] : __( 'This form has expired.', 'wpform_expiration' );

    // Check Expiration
    if ( ! empty( $expiration_datetime ) ) {
        try {
            // Create a DateTime object for the expiration time in Chicago time zone
            $expiration_time = new DateTime( $expiration_datetime, new DateTimeZone( 'America/Chicago' ) );

            // Convert expiration time to UTC
            $expiration_time->setTimezone( new DateTimeZone( 'UTC' ) );

            // Get the current time in UTC
            $current_time = new DateTime( 'now', new DateTimeZone( 'UTC' ) );

            // Debugging output (remove in production)
            // echo '<div class="wpforms-form-expired-message">';
            // echo 'Expiration Time (UTC): ' . $expiration_time->format( 'Y-m-d H:i:s' ) . '<br>';
            // echo 'Current Time (UTC): ' . $current_time->format( 'Y-m-d H:i:s' ) . '<br>';
            // echo '</div>';

            // Compare times
            if ( $current_time > $expiration_time ) {
                // Output the expiration message
                echo '<div class="wpforms-form-expired-message">' 
                    . wp_kses_post( $expiration_message ) . 
                    '</div>';

                // Prevent the form from rendering
                add_filter( 'wpforms_frontend_load', '__return_false' );
            }
        } catch ( Exception $e ) {
            // Handle potential errors, such as invalid date formats
            error_log( 'Error in check_form_expiration: ' . $e->getMessage() );
        }
    }
}
add_action( 'wpforms_frontend_output_before', 'check_form_expiration', 10, 2 );



/**
 * Enqueue DateTime Picker scripts, styles, and custom CSS for WPForms Builder.
 */
function enqueue_expiration_datetimepicker() {
    // Only load on the WPForms Builder page
    if ( isset( $_GET['page'] ) && $_GET['page'] === 'wpforms-builder' ) {

        // Enqueue jQuery UI and Timepicker Addon
        wp_enqueue_script( 'jquery-ui-datepicker' );
        wp_enqueue_script( 'jquery-ui-timepicker-addon', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js', [ 'jquery', 'jquery-ui-datepicker' ], null, true );

        // Enqueue Styles
        wp_enqueue_style( 'jquery-ui-css', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css' );
        wp_enqueue_style( 'jquery-ui-timepicker-addon-css', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css' );

        // Include custom CSS fix for z-index
        wp_add_inline_style( 'jquery-ui-css', '
            .ui-datepicker {
                z-index: 999999 !important; /* Ensure DateTime Picker appears on top */
            }
        ' );

        // Enqueue Custom Initialization Script
        wp_enqueue_script( 'expiration-datetimepicker-init', get_template_directory_uri() . '/includes/expiration-datetimepicker.js', [ 'jquery', 'jquery-ui-timepicker-addon' ], null, true );
    }
}
add_action( 'admin_enqueue_scripts', 'enqueue_expiration_datetimepicker' );
