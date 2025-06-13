<?php

/**
 * CamperBookingCalendar
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
class CamperBookingCalendar {



	/**
	 * Method __construct
	 *
	 * @return void
	 */
	public function __construct() {
         add_action( 'admin_menu', array( $this, 'add_calendar_menu' ), 20 );
		add_action( 'wp_ajax_get_camper_bookings', array( $this, 'get_camper_bookings_handler' ) );
		add_action( 'wp_ajax_nopriv_get_camper_bookings', array( $this, 'get_camper_bookings_handler' ) );
	}

	/**
	 * Method add_options_page
	 *
	 * @return void
	 */
	public function add_calendar_menu() {
		add_submenu_page(
            'edit.php?post_type=booking',
            esc_html__( 'Calendar', CAMPER_BOOKING_TEXT_DOMAIN ),
            esc_html__( 'Calendar', CAMPER_BOOKING_TEXT_DOMAIN ),
            'manage_options',
            'camper-calendar',
            array( $this, 'calendar_page' ),
		);
	}

	/**
	 * Method render_options_page
	 *
	 * @return void
	 */
	public function calendar_page() {
		include plugin_dir_path( __FILE__ ) . '/views/calendar.php';
	}

	/**
	 * Method get_camper_bookings_handler
	 *
	 * @return void
	 */
	public function get_camper_bookings_handler() {
         $bookings    = [];
		$all_bookings = new WP_Query(
			array(
				'post_type'      => 'booking',
				'posts_per_page' => -1,
			)
		);

		if ( $all_bookings->have_posts() ) {
			while ( $all_bookings->have_posts() ) {
				$all_bookings->the_post();
				$booking    = get_post_meta( get_the_ID() );
				$bookings[] = array(
					'post_id' => get_the_ID(),
					'title'   => get_the_title(),
					'start'   => $booking['start_date'],
					'end'     => $booking['end_date'],
				);
			}
		}

		wp_send_json_success( $bookings, 200 );
	}
}

new CamperBookingCalendar();
