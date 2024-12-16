<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class WPForms_Expiration_Manager {

    private static $instance = null;

    private function __construct() {
        // Hook to add settings page.
        add_action( 'admin_menu', array( $this, 'add_settings_page' ) );

        // Hook to register settings.
        add_action( 'admin_init', array( $this, 'register_settings' ) );

        // Hook to check form expiration before rendering.
        add_filter( 'wpforms_frontend_form_data', array( $this, 'check_form_expiration' ), 10, 2 );
    }

    public static function get_instance() {
        if ( null == self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function add_settings_page() {
        add_options_page(
            __( 'WPForms Expiration Manager', 'wpforms-expiration-manager' ),
            __( 'WPForms Expiration', 'wpforms-expiration-manager' ),
            'manage_options',
            'wpforms-expiration-manager',
            array( $this, 'render_settings_page' )
        );
    }

    public function register_settings() {
        register_setting( 'wpforms_expiration_manager', 'wpforms_expiration_settings' );

        add_settings_section(
            'wpforms_expiration_section',
            __( 'Form Expiration Settings', 'wpforms-expiration-manager' ),
            null,
            'wpforms-expiration-manager'
        );

        add_settings_field(
            'form_id',
            __( 'Select Form', 'wpforms-expiration-manager' ),
            array( $this, 'form_id_callback' ),
            'wpforms-expiration-manager',
            'wpforms_expiration_section'
        );

        add_settings_field(
            'expiration_datetime',
            __( 'Expiration Date & Time', 'wpforms-expiration-manager' ),
            array( $this, 'expiration_datetime_callback' ),
            'wpforms-expiration-manager',
            'wpforms_expiration_section'
        );

        add_settings_field(
            'expiration_message',
            __( 'Expiration Message', 'wpforms-expiration-manager' ),
            array( $this, 'expiration_message_callback' ),
            'wpforms-expiration-manager',
            'wpforms_expiration_section'
        );
    }

    public function form_id_callback() {
        $options = get_option( 'wpforms_expiration_settings' );
        $selected_form_id = isset( $options['form_id'] ) ? $options['form_id'] : '';
        $forms = wpforms()->form->get();

        echo '<select name="wpforms_expiration_settings[form_id]">';
        echo '<option value="">' . __( 'Select a form', 'wpforms-expiration-manager' ) . '</option>';
        if ( ! empty( $forms ) ) {
            foreach ( $forms as $form ) {
                echo '<option value="' . esc_attr( $form->ID ) . '" ' . selected( $selected_form_id, $form->ID, false ) . '>' . esc_html( $form->post_title ) . '</option>';
            }
        }
        echo '</select>';
    }

    public function expiration_datetime_callback() {
        $options = get_option( 'wpforms_expiration_settings' );
        $expiration_datetime = isset( $options['expiration_datetime'] ) ? $options['expiration_datetime'] : '';
        echo '<input type="datetime-local" name="wpforms_expiration_settings[expiration_datetime]" value="' . esc_attr( $expiration_datetime ) . '">';
    }

    public function expiration_message_callback() {
        $options = get_option( 'wpforms_expiration_settings' );
        $expiration_message = isset( $options['expiration_message'] ) ? $options['expiration_message'] : '';
        wp_editor( $expiration_message, 'wpforms_expiration_settings_expiration_message', array(
            'textarea_name' => 'wpforms_expiration_settings[expiration_message]',
            'textarea_rows' => 5,
        ) );
    }

    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h1><?php _e( 'WPForms Expiration Manager', 'wpforms-expiration-manager' ); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields( 'wpforms_expiration_manager' );
                do_settings_sections( 'wpforms-expiration-manager' );
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function check_form_expiration( $form_data, $form_id ) {
        $options = get_option( 'wpforms_expiration_settings' );
        $target_form_id = isset( $options['form_id'] ) ? $options['form_id'] : '';
        $expiration_datetime = isset( $options['expiration_datetime'] ) ? $options['expiration_datetime'] : '';
        $expiration_message = isset( $options['expiration_message'] ) ? $options['expiration_message'] : '';

        if ( $form_id == $target_form_id && ! empty( $expiration_datetime ) ) {
            $current_datetime = current_time( 'Y-m-d\TH:i' );
            if ( $current_datetime > $expiration_datetime ) {
                $form_data['settings']['form_status'] = 'inactive';
                $form_data['settings']['submit_text'] = $expiration_message;
            }
        }

        return $form_data;
    }
}
