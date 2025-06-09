<?php

/**
 * CamperBookingProcessor
 *
 * @package CamperBooking
 * @author  Robert Ochoa <ochoa.robert1@gmail.com>
 * @license GPL-2.0+
 * @link    https://robertochoaweb.com/casos/camper-booking/
 * @return void
 */

if (! defined('ABSPATH')) {
	exit;
}

/**
 * CamperBookingProcessor
 */
class CamperBookingProcessor
{

	/**
	 * Method __construct
	 *
	 * @return void
	 */
	public function __construct()
	{
		add_action('wp_ajax_camper_booking', [$this, 'process_camper_booking']);
		add_action('wp_ajax_nopriv_camper_booking', [$this, 'process_camper_booking']);
	}

	/**
	 * Method camper_booking
	 *
	 * @return void
	 */
	public function process_camper_booking()
	{
		if (! wp_verify_nonce($_POST['nonce'], 'camper_booking_process')) {
			wp_send_json_error(esc_html_e('Security Error, please try again', CAMPER_BOOKING_TEXT_DOMAIN), 401);
			wp_die();
		}

		$name  = sanitize_text_field($_POST['name']);
		$email = sanitize_email($_POST['email']);
		$phone = sanitize_text_field($_POST['phone']);

		$days_selected = intval($_POST['daysSelected']);
		$startDate     = sanitize_text_field($_POST['start-date']);
		$endDate       = sanitize_text_field($_POST['end-date']);
		$camper        = sanitize_text_field($_POST['camper']);

		$total          = floatval($_POST['total']);
		$payment_method = sanitize_text_field($_POST['payment_method']);

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

		$booking_id = $this->create_booking_post($data);
		if (is_wp_error($booking_id)) {
			wp_send_json_error(esc_html_e('Error trying to create the booking, please try again', CAMPER_BOOKING_TEXT_DOMAIN), 500);
			wp_die();
		}

		//$sent = $this->send_confirmation_email($booking_id, $data);
		if ($booking_id) {
			$sent = true; // Simulate email sending for now.
		} else {
			$sent = false;
		}

		if ($sent) {
			wp_send_json_success(esc_html_e('Booking created successfully', CAMPER_BOOKING_TEXT_DOMAIN));
		} else {
			wp_send_json_error(esc_html_e('Error trying to send the confirmation email, please try again', CAMPER_BOOKING_TEXT_DOMAIN), 500);
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
	public function create_booking_post($data)
	{
		$booking_data = [
			'post_title'   => sprintf('Booking from %s - %s', $data['name'], date('Y-m-d')),
			'post_content' => '',
			'post_status'  => 'publish',
			'post_type'    => 'booking',
			'post_author'  => 1,
			'meta_input'   => $data,
		];

		$booking_id = wp_insert_post($booking_data);
		if (is_wp_error($booking_id)) {
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
	public function send_confirmation_email($booking_id, $data)
	{
		/*
		$to = $data['email'];
		$subject = sprintf('Booking Confirmation #%d', $booking_id);
		$headers = ['Content-Type: text/html; charset=UTF-8'];
		$body = sprintf(
			'<h1>Booking Confirmation</h1>
			<p>Thank you for your booking, %s!</p>
			<p>Your booking ID is: <strong>%d</strong></p>
			<p>Details:</p>
			<ul>
				<li>Name: %s</li>
				<li>Email: %s</li>
				<li>Phone: %s</li>
				<li>Days Selected: %s</li>
				<li>Camper: %d</li>
				<li>Total: %.2f</li>
				<li>Payment Method: %d</li>
			</ul>',
			$data['name'],
			$booking_id,
			$data['name'],
			$data['email'],
			$data['phone'],
			$data['days_selected'],
			$data['camper'],
			$data['total'],
			$data['payment_method']
		);

		wp_mail($to, $subject, $body, $headers);

		return wp_mail($to, $subject, $body, $headers);
		*/
	}
}

new CamperBookingProcessor();
