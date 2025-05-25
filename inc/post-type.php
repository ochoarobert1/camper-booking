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

if (! defined('ABSPATH')) {
    exit;
}

/**
 * CamperBookingPostType
 */
class CamperBookingPostType
{


    /**
     * Method __construct
     *
     * @return void
     */
    public function __construct()
    {
        add_action('init', array($this, 'register_booking_post_type'));
        add_action('init', array($this, 'register_camper_post_type'));
    }

    /**
     * Method register_booking_post_type
     *
     * @return void
     */
    public function register_booking_post_type()
    {
        $labels = array(
            'name'               => esc_html__('Bookings', CAMPER_BOOKING_TEXT_DOMAIN),
            'singular_name'      => esc_html__('Booking', CAMPER_BOOKING_TEXT_DOMAIN),
            'menu_name'          => esc_html__('Bookings', CAMPER_BOOKING_TEXT_DOMAIN),
            'add_new'            => esc_html__('Add New', CAMPER_BOOKING_TEXT_DOMAIN),
            'add_new_item'       => esc_html__('Add New Booking', CAMPER_BOOKING_TEXT_DOMAIN),
            'edit_item'          => esc_html__('Edit Booking', CAMPER_BOOKING_TEXT_DOMAIN),
            'new_item'           => esc_html__('New Booking', CAMPER_BOOKING_TEXT_DOMAIN),
            'view_item'          => esc_html__('View Booking', CAMPER_BOOKING_TEXT_DOMAIN),
            'search_items'       => esc_html__('Search Bookings', CAMPER_BOOKING_TEXT_DOMAIN),
            'not_found'          => esc_html__('No bookings found', CAMPER_BOOKING_TEXT_DOMAIN),
            'not_found_in_trash' => esc_html__('No bookings found in Trash', CAMPER_BOOKING_TEXT_DOMAIN),
        );

        $args = array(
            'labels'              => $labels,
            'public'              => false,
            'show_ui'             => true,
            'show_in_menu'        => false,
            'capability_type'     => 'post',
            'hierarchical'        => false,
            'supports'            => array('title'),
            'has_archive'         => false,
            'show_in_nav_menus'   => false,
            'exclude_from_search' => true,
            'menu_position'       => 5,
            'publicly_queryable'  => false,
        );

        register_post_type('booking', $args);
    }

    /**
     * Method register_camper_post_type
     *
     * @return void
     */
    public function register_camper_post_type()
    {
        $labels = array(
            'name'               => esc_html__('Campers', CAMPER_BOOKING_TEXT_DOMAIN),
            'singular_name'      => esc_html__('Camper', CAMPER_BOOKING_TEXT_DOMAIN),
            'menu_name'          => esc_html__('Campers', CAMPER_BOOKING_TEXT_DOMAIN),
            'add_new'            => esc_html__('Add New', CAMPER_BOOKING_TEXT_DOMAIN),
            'add_new_item'       => esc_html__('Add New Camper', CAMPER_BOOKING_TEXT_DOMAIN),
            'edit_item'          => esc_html__('Edit Camper', CAMPER_BOOKING_TEXT_DOMAIN),
            'new_item'           => esc_html__('New Camper', CAMPER_BOOKING_TEXT_DOMAIN),
            'view_item'          => esc_html__('View Camper', CAMPER_BOOKING_TEXT_DOMAIN),
            'search_items'       => esc_html__('Search Campers', CAMPER_BOOKING_TEXT_DOMAIN),
            'not_found'          => esc_html__('No campers found', CAMPER_BOOKING_TEXT_DOMAIN),
            'not_found_in_trash' => esc_html__('No campers found in Trash', CAMPER_BOOKING_TEXT_DOMAIN),
        );

        $args = array(
            'labels'              => $labels,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'capability_type'     => 'post',
            'hierarchical'        => false,
            'supports'            => array('title', 'thumbnail'),
            'has_archive'         => false,
            'show_in_nav_menus'   => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'menu_icon'           => 'dashicons-car',
            'menu_position'       => 9,
        );

        register_post_type('campers', $args);
    }
}

new CamperBookingPostType();
