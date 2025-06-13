<?php

/**
 * CamperBookingPostType
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
 * CamperBookingPostType
 */
class CamperBookingPostType {



    /**
     * Method __construct
     *
     * @return void
     */
    public function __construct() {
         add_action( 'init', array( $this, 'register_booking_post_type' ) );
        add_action( 'init', array( $this, 'register_camper_post_type' ) );
        add_action( 'init', array( $this, 'register_booking_status_taxonomy' ) );
        add_filter( 'manage_booking_posts_columns', array( $this, 'camper_booking_admin_columns_head' ) );
        add_action( 'manage_booking_posts_custom_column', array( $this, 'camper_booking_admin_columns_content' ), 10, 2 );
    }

    /**
     * Method camper_booking_admin_columns_head
     *
     * @param $columns array
     *
     * @return void
     */
    public function camper_booking_admin_columns_head( $columns ) {
         unset( $columns['date'] );
        $columns['camper']     = esc_html__( 'Camper', CAMPER_BOOKING_TEXT_DOMAIN );
        $columns['start_date'] = esc_html__( 'Start Date', CAMPER_BOOKING_TEXT_DOMAIN );
        $columns['end_date']   = esc_html__( 'End Date', CAMPER_BOOKING_TEXT_DOMAIN );
        $columns['status']     = esc_html__( 'Status', CAMPER_BOOKING_TEXT_DOMAIN );
        $columns['date']       = esc_html__( 'Date', CAMPER_BOOKING_TEXT_DOMAIN );

        return $columns;
    }

    /**
     * Method camper_booking_admin_columns_content
     *
     * @param $column array
     * @param $post_id string
     *
     * @return void
     */
    public function camper_booking_admin_columns_content( $column, $post_id ) {
		switch ( $column ) {
            case 'camper':
                $camper_slug = get_post_meta( $post_id, 'camper', true );
                $camper      = get_page_by_path( $camper_slug, OBJECT, 'campers' );
                echo esc_html( $camper->post_title );
                break;
            case 'start_date':
                $start_date = get_post_meta( $post_id, 'start_date', true );
                echo esc_html( $start_date );
                break;
            case 'end_date':
                $end_date = get_post_meta( $post_id, 'end_date', true );
                echo esc_html( $end_date );
                break;
            case 'status':
                $statuses = get_the_terms( $post_id, 'status' );
                if ( is_array( $statuses ) ) :
                    foreach ( $statuses as $status ) : ?>
                        <span class="booking-status booking-status-<?php echo esc_attr( $status->slug ); ?>"><?php echo esc_html( $status->name ); ?></span>
						<?php
                    endforeach;
                endif;
                break;
		}
    }

    /**
     * Method register_booking_post_type
     *
     * @return void
     */
    public function register_booking_post_type() {
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
			 'show_in_menu'        => true,
			 'capability_type'     => 'post',
			 'hierarchical'        => false,
			 'supports'            => array( 'title' ),
			 'has_archive'         => false,
			 'show_in_nav_menus'   => false,
			 'exclude_from_search' => true,
			 'menu_icon'           => 'dashicons-calendar',
			 'menu_position'       => 5,
			 'publicly_queryable'  => false,
		 );

		 register_post_type( 'booking', $args );
    }

    /**
     * Method register_camper_post_type
     *
     * @return void
     */
    public function register_camper_post_type() {
         $labels = array(
			 'name'               => esc_html__( 'Campers', CAMPER_BOOKING_TEXT_DOMAIN ),
			 'singular_name'      => esc_html__( 'Camper', CAMPER_BOOKING_TEXT_DOMAIN ),
			 'menu_name'          => esc_html__( 'Campers', CAMPER_BOOKING_TEXT_DOMAIN ),
			 'add_new'            => esc_html__( 'Add New', CAMPER_BOOKING_TEXT_DOMAIN ),
			 'add_new_item'       => esc_html__( 'Add New Camper', CAMPER_BOOKING_TEXT_DOMAIN ),
			 'edit_item'          => esc_html__( 'Edit Camper', CAMPER_BOOKING_TEXT_DOMAIN ),
			 'new_item'           => esc_html__( 'New Camper', CAMPER_BOOKING_TEXT_DOMAIN ),
			 'view_item'          => esc_html__( 'View Camper', CAMPER_BOOKING_TEXT_DOMAIN ),
			 'search_items'       => esc_html__( 'Search Campers', CAMPER_BOOKING_TEXT_DOMAIN ),
			 'not_found'          => esc_html__( 'No campers found', CAMPER_BOOKING_TEXT_DOMAIN ),
			 'not_found_in_trash' => esc_html__( 'No campers found in Trash', CAMPER_BOOKING_TEXT_DOMAIN ),
		 );

		 $args = array(
			 'labels'              => $labels,
			 'public'              => true,
			 'show_ui'             => true,
			 'show_in_menu'        => true,
			 'capability_type'     => 'post',
			 'hierarchical'        => false,
			 'supports'            => array( 'title', 'thumbnail' ),
			 'has_archive'         => false,
			 'show_in_nav_menus'   => true,
			 'exclude_from_search' => false,
			 'publicly_queryable'  => true,
			 'menu_icon'           => 'dashicons-car',
			 'menu_position'       => 9,
		 );

		 register_post_type( 'campers', $args );
    }


    /**
     * Method register_booking_status_taxonomy
     *
     * @return void
     */
    public function register_booking_status_taxonomy() {
         $labels = array(
			 'name'              => esc_html__( 'Status', CAMPER_BOOKING_TEXT_DOMAIN ),
			 'singular_name'     => esc_html__( 'Status', CAMPER_BOOKING_TEXT_DOMAIN ),
			 'search_items'      => esc_html__( 'Search Status', CAMPER_BOOKING_TEXT_DOMAIN ),
			 'all_items'         => esc_html__( 'All Status', CAMPER_BOOKING_TEXT_DOMAIN ),
			 'parent_item'       => esc_html__( 'Parent Status', CAMPER_BOOKING_TEXT_DOMAIN ),
			 'parent_item_colon' => esc_html__( 'Parent Status:', CAMPER_BOOKING_TEXT_DOMAIN ),
			 'edit_item'         => esc_html__( 'Edit Status', CAMPER_BOOKING_TEXT_DOMAIN ),
			 'update_item'       => esc_html__( 'Update Status', CAMPER_BOOKING_TEXT_DOMAIN ),
			 'add_new_item'      => esc_html__( 'Add New Status', CAMPER_BOOKING_TEXT_DOMAIN ),
			 'new_item_name'     => esc_html__( 'New Status Name', CAMPER_BOOKING_TEXT_DOMAIN ),
			 'menu_name'         => esc_html__( 'Status', CAMPER_BOOKING_TEXT_DOMAIN ),
		 );

		 $args = array(
			 'hierarchical'      => true,
			 'labels'            => $labels,
			 'show_ui'           => true,
			 'show_admin_column' => false,
			 'query_var'         => true,
			 'rewrite'           => array( 'slug' => 'status' ),
		 );

		 register_taxonomy( 'status', array( 'booking' ), $args );
    }
}

new CamperBookingPostType();
