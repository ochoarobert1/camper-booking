<?php

/**
 * CamperBookingShortcodes
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

// Plugin constants.
define( 'CAMPER_BOOKING_VERSION', '1.0.0' );
define( 'CAMPER_BOOKING_PLUGIN_NAME', 'Camper Booking' );
define( 'CAMPER_BOOKING_TEXT_DOMAIN', 'camper-booking' );

/**
 * CamperBookingShortcodes
 */
class CamperBookingShortcodes {


    /**
     * Method __construct
     *
     * @return void
     */
    public function __construct() {
        add_action( 'init', array( $this, 'register_shortcodes' ) );
    }

    /**
     * Method register_shortcodes
     *
     * @return void
     */
    public function register_shortcodes() {
        add_shortcode( 'camper-booking', array( $this, 'camper_booking_form' ) );
    }

    /**
     * Method camper_booking_form
     *
     * @return string
     */
    public function camper_booking_form() {
        ob_start();
		?>
        <form id="camperBookingForm" class="camper-booking-form">
            <div class="camper-booking-step-container">
                <div class="camper-booking-step-item active">
                    <span class="camper-booking-step-icon">1</span>
                    <span class="camper-booking-step-text"><?php echo esc_html_e( 'Booking Dates', CAMPER_BOOKING_TEXT_DOMAIN ); ?></span>
                </div>
                <div class="camper-booking-step-item">
                    <span class="camper-booking-step-icon">2</span>
                    <span class="camper-booking-step-text"><?php echo esc_html_e( 'Personal Info', CAMPER_BOOKING_TEXT_DOMAIN ); ?></span>
                </div>
                <div class="camper-booking-step-item">
                    <span class="camper-booking-step-icon">3</span>
                    <span class="camper-booking-step-text"></span>
                </div>
                <div class="camper-booking-step-item">
                    <span class="camper-booking-step-icon">4</span>
                    <span class="camper-booking-step-text"><?php echo esc_html_e( 'Payment & Confirmation', CAMPER_BOOKING_TEXT_DOMAIN ); ?></span>
                </div>
            </div>

            <div class="camper-form-main-wrapper">
                <div class="camper-form-steps-container">
                    <div id="formStep1" class="camper-booking-form-step">
                        <div class="camper-form-item-wrapper">
                            <header class="step-header">
                                <h2><span class="step-number">1</span> <?php echo esc_html_e( 'Booking Dates', CAMPER_BOOKING_TEXT_DOMAIN ); ?></h2>
                            </header>
                            <div class="step-content">
                                <div class="form-group">
                                    <label for="datePicker"><?php echo esc_html_e( 'Select the booking dates', CAMPER_BOOKING_TEXT_DOMAIN ); ?>: <span class="required">*</span></label>
                                    <input id="datePicker" type="text" class="form-control" name="datetimes" class="custom-air-datepicker" />
                                    <small><?php echo esc_html_e( 'You can click this field to generate a calendar', CAMPER_BOOKING_TEXT_DOMAIN ); ?>.</small>
                                </div>
                            </div>
                            <footer>
                                <button type="button" class="btn btn-primary next-step" data-step="1"><?php echo esc_html_e( 'Next', CAMPER_BOOKING_TEXT_DOMAIN ); ?></button>
                            </footer>
                        </div>
                    </div>
                    <div id="formStep2" class="camper-booking-form-step hidden">
                        <div class="camper-form-item-wrapper">
                            <header class="step-header">
                                <h2><span class="step-number">2</span> <?php echo esc_html_e( 'Personal Information', CAMPER_BOOKING_TEXT_DOMAIN ); ?></h2>
                            </header>
                            <div class="step-content">
                                <div class="form-group">
                                    <label for="name"><?php echo esc_html_e( 'Full Name', CAMPER_BOOKING_TEXT_DOMAIN ); ?>: <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="email"><?php echo esc_html_e( 'Email', CAMPER_BOOKING_TEXT_DOMAIN ); ?>: <span class="required">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="phone"><?php echo esc_html_e( 'Phone', CAMPER_BOOKING_TEXT_DOMAIN ); ?>: <span class="required">*</span></label>
                                    <input type="tel" class="form-control" id="phone" name="phone" required>
                                </div>
                                <small id="camperError" class="error hidden">You must select one camper</small>
                            </div>
                            <footer>
                                <button type="button" class="btn btn-secondary prev-step" data-step="2"><?php echo esc_html_e( 'Previous', CAMPER_BOOKING_TEXT_DOMAIN ); ?></button>
                                <button type="button" class="btn btn-primary next-step" data-step="2"><?php echo esc_html_e( 'Next', CAMPER_BOOKING_TEXT_DOMAIN ); ?></button>
                            </footer>
                        </div>
                    </div>

                    <div id="formStep3" class="camper-booking-form-step hidden">
                        <div class="camper-form-item-wrapper">
                            <header class="step-header">
                                <h2><span class="step-number">3</span> <?php echo esc_html_e( 'Select Camper', CAMPER_BOOKING_TEXT_DOMAIN ); ?></h2>
                            </header>
                            <div class="step-content">
                                <div class="camper-radio-wrapper">
                                    <label for="camperBoraBora" class="radio-wrapper camper-radio-item">
                                        <img decoding="async" src="https://dtwstudio.com/travelpalma/wp-content/uploads/elementor/thumbs/dsc05533_result-r4y7m8hf020expvo43t5m31rupbkh78lseo2y0wxhk.jpg" alt="Bora Bora" class="camper-image">
                                        <span>Bora Bora - $75/night</span>
                                        <input type="radio" name="camper" id="camperBoraBora" value="bora-bora">
                                    </label>
                                    <label for="camperPuraVida" class="radio-wrapper camper-radio-item">
                                        <img decoding="async" src="https://dtwstudio.com/travelpalma/wp-content/uploads/elementor/thumbs/camper-van-on-road-near-hill-and-blue-sky-2021-12-09-12-34-12-utc-r3ix93v9c0sam5zw4yjh5u5mpp6z5ieo4rnq95cqdk.jpg" alt="Pura Vida" class="camper-image">
                                        <span>Pura Vida - $65/night</span>
                                        <input type="radio" name="camper" id="camperPuraVida" value="pura-vida">
                                    </label>
                                    <label for="camperAloha" class="radio-wrapper camper-radio-item">
                                        <img decoding="async" src="https://dtwstudio.com/travelpalma/wp-content/uploads/elementor/thumbs/55281-camper-van-on-rural-road-pioneer-mountains-2021-08-28-23-40-24-utc-r3ix92xf56r0ak19ag4ulce64bblxtaxsn08rve4js.jpg" alt="Aloha" class="camper-image">
                                        <span>Aloha - $75/night</span>
                                        <input type="radio" name="camper" id="camperAloha" value="aloha">
                                    </label>
                                </div>
                                <small id="camperError" class="error hidden">You must select one camper</small>
                            </div>
                            <footer>
                                <button type="button" class="btn btn-secondary prev-step" data-step="3"><?php echo esc_html_e( 'Previous', CAMPER_BOOKING_TEXT_DOMAIN ); ?></button>
                                <button type="button" class="btn btn-primary next-step" data-step="3"><?php echo esc_html_e( 'Next', CAMPER_BOOKING_TEXT_DOMAIN ); ?></button>
                            </footer>
                        </div>
                    </div>

                    <div id="formStep4" class="camper-booking-form-step hidden">
                        <div class="camper-form-item-wrapper">
                            <header class="step-header">
                                <h2><span class="step-number">4</span> <?php echo esc_html_e( 'Make your Payment', CAMPER_BOOKING_TEXT_DOMAIN ); ?></h2>
                            </header>
                            <div class="step-content">
                                <p>This feature is currently under development.</p>
                            </div>
                            <footer>
                                <button type="button" class="btn btn-secondary prev-step" data-step="4"><?php echo esc_html_e( 'Previous', CAMPER_BOOKING_TEXT_DOMAIN ); ?></button>
                                <button type="button" class="btn btn-primary make-payment" data-step="4"><?php echo esc_html_e( 'Make Payment', CAMPER_BOOKING_TEXT_DOMAIN ); ?></button>
                            </footer>
                        </div>
                    </div>
                </div>
                <aside class="camper-form-aside-container">
                    <div class="camper-form-aside-wrapper">
                        
                    </div>
                </aside>
            </div>
        </form>
		<?php
        return ob_get_clean();
    }
}

new CamperBookingShortcodes();
