<?php

/**
 * CamperBookingOptions
 *
 * @package CamperBooking
 * @author  Robert Ochoa <contacto@robertochoaweb.com>
 * @license GPL-2.0+
 * @link    https://robertochoaweb.com/casos/camper-booking/
 * @return void
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * CamperBookingOptions
 */
class CamperBookingOptions {

	/**
	 * Method __construct
	 *
	 * @return void
	 */
	public function __construct() {
         add_action( 'admin_menu', array( $this, 'add_options_page' ), 20 );
		add_action( 'wp_ajax_camper_booking_save_general_options', array( $this, 'save_general_options' ) );
		add_action( 'wp_ajax_camper_booking_save_public_options', array( $this, 'save_public_options' ) );
		add_action( 'wp_ajax_camper_booking_save_email_options', array( $this, 'save_email_options' ) );
	}

	/**
	 * Method add_options_page
	 *
	 * @return void
	 */
	public function add_options_page() {
        add_submenu_page(
            'edit.php?post_type=booking',
            esc_html__( 'Options', CAMPER_BOOKING_TEXT_DOMAIN ),
            esc_html__( 'Options', CAMPER_BOOKING_TEXT_DOMAIN ),
            'manage_options',
            'camper-options',
            array( $this, 'options_page' ),
		);
	}

	/**
	 * Method render_options_page
	 *
	 * @return void
	 */
	public function options_page() {
        include plugin_dir_path( __FILE__ ) . '/views/options.php';
	}

	/**
	 * Method save_general_options
	 *
	 * @return void
	 */
	public function save_general_options() {
        if ( isset( $_POST['data'] ) ) {
			parse_str( $_POST['data'], $data );
		}

		if ( ! isset( $data['nonce'] ) || ! wp_verify_nonce( $data['nonce'], 'camper_booking_save_options' ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Invalid security token.', CAMPER_BOOKING_TEXT_DOMAIN ) ) );
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'You do not have permission to perform this action.', CAMPER_BOOKING_TEXT_DOMAIN ) ) );
		}

		$options = array(
			'camper_booking_sandbox'            => isset( $data['sandbox'] ) ? 1 : 0,
			'camper_booking_testing_api_key'    => isset( $data['testApiKey'] ) ? sanitize_text_field( $data['testApiKey'] ) : '',
			'camper_booking_testing_secret_key' => isset( $data['testSecretKey'] ) ? sanitize_text_field( $data['testSecretKey'] ) : '',
			'camper_booking_testing_api_url'    => isset( $data['testApiUrl'] ) ? esc_url_raw( $data['testApiUrl'] ) : '',
			'camper_booking_api_key'            => isset( $data['apiKey'] ) ? sanitize_text_field( $data['apiKey'] ) : '',
			'camper_booking_secret_key'         => isset( $data['secretKey'] ) ? sanitize_text_field( $data['secretKey'] ) : '',
			'camper_booking_api_url'            => isset( $data['apiUrl'] ) ? esc_url_raw( $data['apiUrl'] ) : '',
		);

		foreach ( $options as $key => $value ) {
			if ( in_array(
				$key,
				array(
					'camper_booking_sandbox',
					'camper_booking_testing_api_key',
					'camper_booking_testing_secret_key',
					'camper_booking_testing_api_url',
					'camper_booking_api_key',
					'camper_booking_secret_key',
					'camper_booking_api_url',
				),
				true
			) ) {
				update_option( $key, $value );
			}
		}

		wp_send_json_success( array( 'message' => esc_html__( 'Options saved successfully.', CAMPER_BOOKING_TEXT_DOMAIN ) ) );
	}

	/**
	 * Method save_email_options
	 *
	 * @return void
	 */
	public function save_email_options() {
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'camper_booking_save_options' ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Invalid security token.', CAMPER_BOOKING_TEXT_DOMAIN ) ) );
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'You do not have permission to perform this action.', CAMPER_BOOKING_TEXT_DOMAIN ) ) );
		}

		update_option( 'camper_booking_email_logo', isset( $_POST['emailLogo'] ) ? esc_url_raw( wp_unslash( $_POST['emailLogo'] ) ) : '' );
		update_option( 'camper_booking_email_notification', isset( $_POST['emailNotification'] ) ? sanitize_email( $_POST['emailNotification'] ) : '' );
		update_option( 'camper_booking_email_support', isset( $_POST['emailSupport'] ) ? sanitize_email( $_POST['emailSupport'] ) : '' );
		update_option( 'camper_booking_phone_support', isset( $_POST['phoneSupport'] ) ? wp_kses_post( $_POST['phoneSupport'] ) : '' );
		update_option( 'camper_booking_bank_transfer', isset( $_POST['bankTransferData'] ) ? wp_kses_post( $_POST['bankTransferData'] ) : '' );

		wp_send_json_success( array( 'message' => esc_html__( 'Email options saved successfully.', CAMPER_BOOKING_TEXT_DOMAIN ) ) );
	}

	/**
	 * Method save_public_options
	 *
	 * @return void
	 */
	public function save_public_options() {
		if ( isset( $_POST['data'] ) ) {
			parse_str( wp_unslash( sanitize_text_field( $_POST['data'] ) ), $data );
		}

		if ( ! isset( $data['nonce'] ) || ! wp_verify_nonce( $data['nonce'], 'camper_booking_save_options' ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Invalid security token.', CAMPER_BOOKING_TEXT_DOMAIN ) ) );
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'You do not have permission to perform this action.', CAMPER_BOOKING_TEXT_DOMAIN ) ) );
		}

		update_option( 'camper_booking_terms_conditions', isset( $data['terms-conditions'] ) ? wp_kses_post( $data['terms-conditions'] ) : '' );
		update_option( 'camper_booking_main_currency', isset( $data['mainCurrency'] ) ? wp_kses_post( $data['mainCurrency'] ) : '' );
		update_option( 'camper_booking_taxes_activate', isset( $data['activateTaxes'] ) ? 1 : 0 );
		update_option( 'camper_booking_taxes_name', isset( $data['taxesName'] ) ? wp_kses_post( $data['taxesName'] ) : '' );
		update_option( 'camper_booking_taxes_percentage', isset( $data['taxesPercentage'] ) ? wp_kses_post( $data['taxesPercentage'] ) : '' );

		wp_send_json_success( array( 'message' => esc_html__( 'Public options saved successfully.', CAMPER_BOOKING_TEXT_DOMAIN ) ) );
	}
}

new CamperBookingOptions();
