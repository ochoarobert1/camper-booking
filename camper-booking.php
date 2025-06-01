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
if (! defined('ABSPATH')) {
    exit;
}

// Plugin constants.
define('CAMPER_BOOKING_VERSION', '1.0.0');
define('CAMPER_BOOKING_PLUGIN_NAME', 'Camper Booking');
define('CAMPER_BOOKING_TEXT_DOMAIN', 'camper-booking');

/**
 * CamperBooking Main Class
 */
class CamperBooking
{



    /**
     * Method __construct
     *
     * @return void
     */
    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_admin_menu'), 10);
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_public_scripts'));
        add_action('init', array($this, 'load_textdomain'));
    }

    /**
     * Method load_textdomain
     *
     * @return void
     */
    public function load_textdomain()
    {
        load_plugin_textdomain(
            CAMPER_BOOKING_TEXT_DOMAIN,
            false,
            dirname(plugin_basename(__FILE__)) . '/lang/'
        );
    }

    /**
     * Method enqueue_admin_scripts
     *
     * @return void
     */
    public function enqueue_admin_scripts()
    {
        wp_enqueue_style(
            'air-datepicker-css',
            'https://cdn.jsdelivr.net/npm/air-datepicker@3.5.3/air-datepicker.min.css',
            array(),
            CAMPER_BOOKING_VERSION,
            'all'
        );

        wp_enqueue_style(
            'camper-booking-css',
            plugin_dir_url(__FILE__) . 'assets/css/admin-camper-booking.css',
            array('air-datepicker-css'),
            CAMPER_BOOKING_VERSION,
            'all'
        );

        wp_enqueue_script(
            'air-datepicker-js',
            'https://cdn.jsdelivr.net/npm/air-datepicker@3.5.3/air-datepicker.min.js',
            array(),
            CAMPER_BOOKING_VERSION,
            array('in_footer' => true)
        );

        wp_enqueue_script(
            'camper-booking-js',
            plugin_dir_url(__FILE__) . 'assets/js/admin-camper-booking.js',
            array('air-datepicker-js'),
            CAMPER_BOOKING_VERSION,
            array('in_footer' => true)
        );

        wp_localize_script(
            'camper-booking-js',
            'camperBooking',
            array(
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'nonce'   => wp_create_nonce('camper_booking_save_general_options'),
            )
        );
    }

    /**
     * Method enqueue_public_scripts
     *
     * @return void
     */
    public function enqueue_public_scripts()
    {
        wp_enqueue_style(
            'air-datepicker-css',
            'https://cdn.jsdelivr.net/npm/air-datepicker@3.5.3/air-datepicker.min.css',
            array(),
            CAMPER_BOOKING_VERSION,
            'all'
        );

        wp_enqueue_style(
            'camper-booking-css',
            plugin_dir_url(__FILE__) . 'assets/css/camper-booking.css',
            array('air-datepicker-css'),
            CAMPER_BOOKING_VERSION,
            'all'
        );

        wp_enqueue_script(
            'air-datepicker-js',
            'https://cdn.jsdelivr.net/npm/air-datepicker@3.5.3/air-datepicker.min.js',
            array(),
            CAMPER_BOOKING_VERSION,
            array('in_footer' => true)
        );

        wp_enqueue_script(
            'camper-booking-js',
            plugin_dir_url(__FILE__) . 'assets/js/camper-booking.js',
            array('air-datepicker-js'),
            CAMPER_BOOKING_VERSION,
            array('in_footer' => true)
        );

        wp_localize_script(
            'camper-booking-js',
            'camperBooking',
            array(
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'nonce'   => wp_create_nonce('camper_booking_process'),
            )
        );
    }

    /**
     * Method add_admin_menu
     *
     * @return void
     */
    public function add_admin_menu()
    {
        add_menu_page(
            esc_html__('Booking', CAMPER_BOOKING_TEXT_DOMAIN),
            esc_html__('Booking', CAMPER_BOOKING_TEXT_DOMAIN),
            'manage_options',
            'camper-booking',
            array($this, 'admin_page'),
            'dashicons-calendar-alt',
            7
        );

        // Add submenu for all bookings.
        add_submenu_page(
            'camper-booking',
            esc_html__('All Bookings', CAMPER_BOOKING_TEXT_DOMAIN),
            esc_html__('All Bookings', CAMPER_BOOKING_TEXT_DOMAIN),
            'manage_options',
            'edit.php?post_type=booking',
            array()
        );

        // Add submenu for new booking.
        add_submenu_page(
            'camper-booking',
            esc_html__('Add New Booking', CAMPER_BOOKING_TEXT_DOMAIN),
            esc_html__('Add New', CAMPER_BOOKING_TEXT_DOMAIN),
            'manage_options',
            'post-new.php?post_type=booking',
            array()
        );

        add_submenu_page(
            'camper-booking',
            esc_html__('Calendar', CAMPER_BOOKING_TEXT_DOMAIN),
            esc_html__('Calendar', CAMPER_BOOKING_TEXT_DOMAIN),
            'manage_options',
            'camper-calendar',
            array($this, 'calendar_page'),
        );
    }

    /**
     * Method admin_page
     *
     * @return void
     */
    public function admin_page()
    {
?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        </div>
    <?php
    }

    /**
     * Method calendar_page
     *
     * @return void
     */
    public function calendar_page()
    {
    ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        </div>
<?php
    }
}

new CamperBooking();

require_once plugin_dir_path(__FILE__) . 'inc/post-type.php';
require_once plugin_dir_path(__FILE__) . 'inc/metaboxes.php';
require_once plugin_dir_path(__FILE__) . 'inc/processor.php';
require_once plugin_dir_path(__FILE__) . 'public/shortcode.php';
require_once plugin_dir_path(__FILE__) . 'admin/options.php';
