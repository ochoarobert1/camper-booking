<?php

/**
 * Plugin Name: Camper Booking
 * Plugin URI: https://robertochoaweb.com/casos/camper-booking/
 * Description: A plugin to manage campervans bookings and reservations
 * Version: 1.0.0
 * Author: Robert Ochoa
 * Author URI: https://robertochoaweb.com/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: camper-booking
 * Domain Path: /languages
 *
 * @package CamperBooking
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Plugin constants.
define( 'CAMPER_BOOKING_VERSION', '1.0.0' );
define( 'CAMPER_BOOKING_PLUGIN_NAME', 'Camper Booking' );
define( 'CAMPER_BOOKING_TEXT_DOMAIN', 'camper-booking' );

/**
 * CamperBooking Main Class
 */
class CamperBooking {

    /**
     * Method __construct
     *
     * @return void
     */
    public function __construct() {
         add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_public_scripts' ) );
        add_action( 'init', array( $this, 'load_textdomain' ) );
        add_action( 'init', array( $this, 'image_sizes' ) );
        add_filter( 'image_size_names_choose', array( $this, 'custom_image_size' ) );
    }

    /**
     * Method image_sizes
     *
     * @return void
     */
    public function image_sizes() {
         add_image_size( 'camper-booking-thumb', 300, 200, true );
    }

    /**
     * Method custom_image_size
     *
     * @param $sizes array
     *
     * @return void
     */
    public function custom_image_size( $sizes ) {
        return array_merge(
            $sizes,
            array(
				'camper-booking-thumb' => __( 'Camper Booking Thumb' ),
            )
		);
    }

    /**
     * Method load_textdomain
     *
     * @return void
     */
    public function load_textdomain() {
        load_plugin_textdomain(
            CAMPER_BOOKING_TEXT_DOMAIN,
            false,
            dirname( plugin_basename( __FILE__ ) ) . '/lang/'
		);
    }

    /**
     * Method enqueue_admin_scripts
     *
     * @return void
     */
    public function enqueue_admin_scripts() {
        wp_enqueue_style(
            'air-datepicker-css',
            'https://cdn.jsdelivr.net/npm/air-datepicker@3.5.3/air-datepicker.min.css',
            array(),
            CAMPER_BOOKING_VERSION,
            'all'
		);

        wp_enqueue_style(
            'camper-booking-css',
            plugin_dir_url( __FILE__ ) . 'assets/css/admin-camper-booking.css',
            array( 'air-datepicker-css' ),
            CAMPER_BOOKING_VERSION,
            'all'
        );

        wp_enqueue_script(
            'air-datepicker-js',
            'https://cdn.jsdelivr.net/npm/air-datepicker@3.5.3/air-datepicker.min.js',
            array(),
            CAMPER_BOOKING_VERSION,
            array( 'in_footer' => true )
        );

        wp_enqueue_script(
            'full-calendar-js',
            'https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js',
            array(),
            CAMPER_BOOKING_VERSION,
            array( 'in_footer' => true )
        );

        wp_enqueue_script(
            'full-calendar-locale-js',
            plugin_dir_url( __FILE__ ) . 'assets/js/es.global.min.js',
            array(),
            CAMPER_BOOKING_VERSION,
            array( 'in_footer' => true )
        );

        wp_enqueue_script(
            'camper-booking-js',
            plugin_dir_url( __FILE__ ) . 'assets/js/admin-camper-booking.js',
            array( 'air-datepicker-js', 'full-calendar-js', 'full-calendar-locale-js' ),
            CAMPER_BOOKING_VERSION,
            array( 'in_footer' => true )
        );

        wp_enqueue_media();

        wp_localize_script(
            'camper-booking-js',
            'camperBooking',
            array(
                'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
                'adminUrl' => admin_url( '/' ),
                'nonce'    => wp_create_nonce( 'camper_booking_save_options' ),
            )
        );
    }


    /**
     * Method enqueue_public_scripts
     *
     * @return void
     */
    public function enqueue_public_scripts() {
        wp_enqueue_style(
            'air-datepicker-css',
            'https://cdn.jsdelivr.net/npm/air-datepicker@3.5.3/air-datepicker.min.css',
            array(),
            CAMPER_BOOKING_VERSION,
            'all'
		);

        wp_enqueue_style(
            'camper-booking-css',
            plugin_dir_url( __FILE__ ) . 'assets/css/camper-booking.css',
            array( 'air-datepicker-css' ),
            CAMPER_BOOKING_VERSION,
            'all'
        );

        wp_enqueue_script(
            'air-datepicker-js',
            'https://cdn.jsdelivr.net/npm/air-datepicker@3.5.3/air-datepicker.min.js',
            array(),
            CAMPER_BOOKING_VERSION,
            array( 'in_footer' => true )
        );

        wp_enqueue_script(
            'camper-booking-js',
            plugin_dir_url( __FILE__ ) . 'assets/js/camper-booking.js',
            array( 'air-datepicker-js' ),
            CAMPER_BOOKING_VERSION,
            array( 'in_footer' => true )
        );

        wp_localize_script(
            'camper-booking-js',
            'camperBooking',
            array(
                'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
                'thanksUrl' => home_url( '/thanks' ),
                'nonce'     => wp_create_nonce( 'camper_booking_process' ),
            )
        );
    }
}

new CamperBooking();

require_once plugin_dir_path( __FILE__ ) . 'inc/post-type.php';
require_once plugin_dir_path( __FILE__ ) . 'admin/calendar.php';
require_once plugin_dir_path( __FILE__ ) . 'admin/options.php';
require_once plugin_dir_path( __FILE__ ) . 'inc/metaboxes.php';
require_once plugin_dir_path( __FILE__ ) . 'inc/processor.php';
require_once plugin_dir_path( __FILE__ ) . 'public/shortcode.php';
