<?php

/**
 * CamperBookingOptions
 *
 * @package CamperBooking
 * @author  Robert Ochoa <ochoa.robert1@gmail.com>
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
	}

	/**
	 * Method add_options_page
	 *
	 * @return void
	 */
	public function add_options_page() {
		add_submenu_page(
			'camper-booking',
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
			parse_str( wp_unslash( sanitize_text_field( $_POST['data'] ) ), $data );
		}

		if ( ! isset( $data['camper_booking_general_nonce'] ) || ! wp_verify_nonce( $data['camper_booking_general_nonce'], 'camper_booking_general_settings_nonce' ) ) {
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
	 * Method save_public_options
	 *
	 * @return void
	 */
	public function save_public_options() {
		if ( isset( $_POST['data'] ) ) {
			parse_str( wp_unslash( sanitize_text_field( $_POST['data'] ) ), $data );
		}

		if ( ! isset( $data['camper_booking_public_nonce'] ) || ! wp_verify_nonce( $data['camper_booking_public_nonce'], 'camper_booking_public_settings_nonce' ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Invalid security token.', CAMPER_BOOKING_TEXT_DOMAIN ) ) );
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'You do not have permission to perform this action.', CAMPER_BOOKING_TEXT_DOMAIN ) ) );
		}

		update_option( 'camper_booking_terms_conditions', isset( $data['terms-conditions'] ) ? wp_kses_post( $data['terms-conditions'] ) : '' );

		wp_send_json_success( array( 'message' => esc_html__( 'Public options saved successfully.', CAMPER_BOOKING_TEXT_DOMAIN ) ) );
	}
}

new CamperBookingOptions();
