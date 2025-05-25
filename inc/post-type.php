<?php

/**
 * CamperBookingPostType
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
 * CamperBookingPostType
 */
class CamperBookingPostType {

    /**
     * Method __construct
     *
     * @return void
     */
    public function __construct() {
        add_action( 'init', array( $this, 'register_post_type' ) );
    }

    /**
     * Method register_post_type
     *
     * @return void
     */
    public function register_post_type() {
        $labels = array(
            'name'               => esc_html__( 'Bookings', CAMPER_BOOKING_TEXT_DOMAIN ),
            'singular_name'      => esc_html__( 'Booking', CAMPER_BOOKING_TEXT_DOMAIN ),
            'menu_name'          => esc_html__( 'Bookings', CAMPER_BOOKING_TEXT_DOMAIN ),
            'add_new'            => esc_html__( 'Add New', CAMPER_BOOKING_TEXT_DOMAIN ),
            'add_new_item'       => esc_html__( 'Add New Booking', CAMPER_BOOKING_TEXT_DOMAIN ),
            'edit_item'          => esc_html__( 'Edit Booking', CAMPER_BOOKING_TEXT_DOMAIN ),
            'new_item'           => esc_html__( 'New Booking', CAMPER_BOOKING_TEXT_DOMAIN ),
            'view_item'          => esc_html__( 'View Booking', CAMPER_BOOKING_TEXT_DOMAIN ),
            'search_items'       => esc_html__( 'Search Bookings', CAMPER_BOOKING_TEXT_DOMAIN ),
            'not_found'          => esc_html__( 'No bookings found', CAMPER_BOOKING_TEXT_DOMAIN ),
            'not_found_in_trash' => esc_html__( 'No bookings found in Trash', CAMPER_BOOKING_TEXT_DOMAIN ),
        );

        $args = array(
            'labels'              => $labels,
            'public'              => false,
            'show_ui'             => true,
            'show_in_menu'        => false,
            'capability_type'     => 'post',
            'hierarchical'        => false,
            'supports'            => array( 'title' ),
            'has_archive'         => false,
            'show_in_nav_menus'   => false,
            'exclude_from_search' => true,
            'publicly_queryable'  => false,
        );

        register_post_type( 'booking', $args );
    }
}

new CamperBookingPostType();
