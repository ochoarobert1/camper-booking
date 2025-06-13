<?php

/**
 * CamperBookingProcessor
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
 * CamperBookingProcessor
 */
class CamperBookingProcessor {

	/**
	 * Method __construct
	 *
	 * @return void
	 */
	public function __construct() {
         add_action( 'wp_ajax_camper_booking', [ $this, 'process_camper_booking' ] );
		add_action( 'wp_ajax_nopriv_camper_booking', [ $this, 'process_camper_booking' ] );
	}

	/**
	 * Method camper_booking
	 *
	 * @return void
	 */
	public function process_camper_booking() {
		if ( ! wp_verify_nonce( $_POST['nonce'], 'camper_booking_process' ) ) {
			wp_send_json_error( esc_html__( 'Security Error, please try again', CAMPER_BOOKING_TEXT_DOMAIN ), 401 );
			wp_die();
		}

		$name  = sanitize_text_field( $_POST['name'] );
		$email = sanitize_email( $_POST['email'] );
		$phone = sanitize_text_field( $_POST['phone'] );

		$days_selected = intval( $_POST['daysSelected'] );
		$startDate     = sanitize_text_field( $_POST['start-date'] );
		$endDate       = sanitize_text_field( $_POST['end-date'] );
		$camper        = sanitize_text_field( $_POST['camper'] );

		$total          = floatval( $_POST['total'] );
		$payment_method = sanitize_text_field( $_POST['payment_method'] );

		$data = [
			'name'           => $name,
			'email'          => $email,
			'phone'          => $phone,
			'days_selected'  => $days_selected,
			'start_date'     => $startDate,
			'end_date'       => $endDate,
			'camper'         => $camper,
			'total'          => $total,
			'payment_method' => $payment_method,
		];

		$booking_id = $this->create_booking_post( $data );
		if ( is_wp_error( $booking_id ) ) {
			wp_send_json_error( esc_html__( 'Error trying to create the booking, please try again', CAMPER_BOOKING_TEXT_DOMAIN ), 500 );
			wp_die();
		}

		$sent = $this->send_confirmation_email( $booking_id, $data );

		if ( $sent ) {
			wp_send_json_success( esc_html__( 'Booking created successfully', CAMPER_BOOKING_TEXT_DOMAIN ), 200 );
		} else {
			wp_send_json_error( esc_html__( 'Error trying to send the confirmation email, please try again', CAMPER_BOOKING_TEXT_DOMAIN ), 500 );
		}
		wp_die();
	}

	/**
	 * Method create_booking_post
	 *
	 * @param $data array
	 *
	 * @return int|WP_Error
	 */
	public function create_booking_post( $data ) {
		$booking_data = [
			'post_title'   => sprintf( 'Booking from %s - %s', $data['name'], date( 'Y-m-d' ) ),
			'post_content' => '',
			'post_status'  => 'publish',
			'post_type'    => 'booking',
			'post_author'  => 1,
			'meta_input'   => $data,
			'tax_input'    => [
				'status' => 'processing',
			],
		];

		$booking_id = wp_insert_post( $booking_data );
		if ( is_wp_error( $booking_id ) ) {
			return false;
		}

		return $booking_id;
	}

	/**
	 * Method send_confirmation_email
	 *
	 * @param $booking_id string
	 * @param $data array
	 *
	 * @return bool
	 */
	public function send_confirmation_email( $booking_id, $data ) {
		if ( ! $booking_id || ! $data ) {
			return false;
		}

		$logo   = get_option( 'camper_booking_email_logo' );
		$camper = get_page_by_path( $data['camper'], OBJECT, 'campers' );
		if ( $camper ) {
			$camper_name  = $camper->post_title;
			$camper_price = get_post_meta( $camper->ID, '_camper_booking_price', true );
		}
		$subtotal = $camper_price * (int) $data['days_selected'];

		ob_start();
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'inc/booking-confirmation.php';
		$body = ob_get_clean();
		$body = str_replace(
			[
				'{customer_name}',
				'{order_number}',
				'{order_date}',
				'{camper}',
				'{dates}',
				'{price}',
				'{subtotal}',
				'{total}',
				'{payment_method}',
				'{company_name}',
				'{year}',
				'{logo}',
				'{email}',
				'{phone}',
				'{instructions}',
			],
			[
				$data['name'],
				$booking_id,
				gmdate( 'Y-m-d' ),
				$camper_name,
				$data['start_date'] . ' - ' . $data['end_date'] . ' (' . $data['days_selected'] . ' days)',
				number_format( $camper_price, 2 ),
				number_format( $subtotal, 2 ),
				number_format( $data['total'], 2 ),
				$this->get_payment_method_name( $data['payment_method'] ),
				'Travel Palma',
				gmdate( 'Y' ),
				$logo,
				get_option( 'camper_booking_email_support' ),
				get_option( 'camper_booking_phone_support' ),
				$this->get_payment_method_instructions( $data['payment_method'] ),
			],
			$body
		);

		$to = $data['email'];

		$emailsCC  = array();
		$emailsBCC = array( get_option( 'camper_booking_email_notification' ) );

		$headers[] = 'Content-Type: text/html; charset=UTF-8';
		$headers[] = 'From: ' . esc_html( get_bloginfo( 'name' ) ) . ' <noreply@' . strtolower( $_SERVER['SERVER_NAME'] ) . '>';
		$headers[] = 'Cc: ' . join( ',', $emailsCC );
		$headers[] = 'Bcc: ' . join( ',', $emailsBCC );

		$subject = esc_html__( 'Order Confirmation', CAMPER_BOOKING_TEXT_DOMAIN );

		return wp_mail( $to, $subject, $body, $headers );
	}

	/**
	 * Method get_payment_method_name
	 *
	 * @param $payment_method string
	 *
	 * @return string
	 */
	public function get_payment_method_name( $payment_method ) {
        switch ( $payment_method ) {
			case 'bank_transfer':
				return esc_html__( 'Bank Transfer', CAMPER_BOOKING_TEXT_DOMAIN );
			case 'credit_card':
				return esc_html__( 'Credit Card', CAMPER_BOOKING_TEXT_DOMAIN );
			default:
				return esc_html__( 'Unknown', CAMPER_BOOKING_TEXT_DOMAIN );
		}
	}

	/**
	 * Method get_payment_method_instructions
	 *
	 * @param $payment_method string
	 *
	 * @return string
	 */
	public function get_payment_method_instructions( $payment_method ) {
        switch ( $payment_method ) {
			case 'bank_transfer':
				return get_option( 'camper_booking_bank_transfer' );
			case 'credit_card':
				return get_option( 'camper_booking_bank_transfer' );
			default:
				return esc_html( '' );
		}
	}
}

new CamperBookingProcessor();
