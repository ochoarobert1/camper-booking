<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Method register_booking_post_type
 *
 * @return void
 */
function register_booking_post_type() {
    $labels = array(
        'name'               => __( 'Bookings', 'my-plugin-textdomain' ),
        'singular_name'      => __( 'Booking', 'my-plugin-textdomain' ),
        'menu_name'          => __( 'Bookings', 'my-plugin-textdomain' ),
        'add_new'            => __( 'Add New', 'my-plugin-textdomain' ),
        'add_new_item'       => __( 'Add New Booking', 'my-plugin-textdomain' ),
        'edit_item'          => __( 'Edit Booking', 'my-plugin-textdomain' ),
        'new_item'           => __( 'New Booking', 'my-plugin-textdomain' ),
        'view_item'          => __( 'View Booking', 'my-plugin-textdomain' ),
        'search_items'       => __( 'Search Bookings', 'my-plugin-textdomain' ),
        'not_found'          => __( 'No bookings found', 'my-plugin-textdomain' ),
        'not_found_in_trash' => __( 'No bookings found in Trash', 'my-plugin-textdomain' ),
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
add_action( 'init', 'register_booking_post_type' );
