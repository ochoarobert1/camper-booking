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

if (! defined('ABSPATH')) {
    exit;
}

/**
 * CamperBookingShortcodes
 */
class CamperBookingShortcodes
{


    /**
     * Method __construct
     *
     * @return void
     */
    public function __construct()
    {
        add_action('init', array($this, 'register_shortcodes'));
    }

    /**
     * Method register_shortcodes
     *
     * @return void
     */
    public function register_shortcodes()
    {
        add_shortcode('camper-booking', array($this, 'camper_booking_form'));
    }

    /**
     * Method camper_booking_form
     *
     * @return string
     */
    public function camper_booking_form()
    {
        ob_start();
?>
        <form id="camperBookingForm" class="camper-booking-form">
            <div class="camper-booking-step-container">
                <div class="camper-booking-step-item active">
                    <span class="camper-booking-step-icon">1</span>
                    <span class="camper-booking-step-text"><?php echo esc_html_e('Booking Dates', CAMPER_BOOKING_TEXT_DOMAIN); ?></span>
                </div>
                <div class="camper-booking-step-item">
                    <span class="camper-booking-step-icon">2</span>
                    <span class="camper-booking-step-text"><?php echo esc_html_e('Personal Info', CAMPER_BOOKING_TEXT_DOMAIN); ?></span>
                </div>
                <div class="camper-booking-step-item">
                    <span class="camper-booking-step-icon">3</span>
                    <span class="camper-booking-step-text"><?php echo esc_html_e('Camper Selection', CAMPER_BOOKING_TEXT_DOMAIN); ?></span>
                </div>
                <div class="camper-booking-step-item">
                    <span class="camper-booking-step-icon">4</span>
                    <span class="camper-booking-step-text"><?php echo esc_html_e('Payment & Confirmation', CAMPER_BOOKING_TEXT_DOMAIN); ?></span>
                </div>
            </div>

            <div class="camper-form-main-wrapper">
                <div class="camper-form-steps-container">
                    <div id="formStep1" class="camper-booking-form-step">
                        <div class="camper-form-item-wrapper">
                            <header class="step-header">
                                <h2><span class="step-number">1</span> <?php echo esc_html_e('Booking Dates', CAMPER_BOOKING_TEXT_DOMAIN); ?></h2>
                            </header>
                            <div class="step-content">
                                <div class="form-group">
                                    <label for="datePicker"><?php echo esc_html_e('Select the booking dates', CAMPER_BOOKING_TEXT_DOMAIN); ?>: <span class="required">*</span></label>
                                    <input id="datePicker" type="text" class="form-control" name="datetimes" class="custom-air-datepicker" />
                                    <small><?php echo esc_html_e('You can click this field to generate a calendar', CAMPER_BOOKING_TEXT_DOMAIN); ?>.</small>
                                </div>
                            </div>
                            <footer>
                                <button type="button" class="btn btn-primary next-step" data-step="1"><?php echo esc_html_e('Next', CAMPER_BOOKING_TEXT_DOMAIN); ?></button>
                            </footer>
                        </div>
                    </div>
                    <div id="formStep2" class="camper-booking-form-step hidden">
                        <div class="camper-form-item-wrapper">
                            <header class="step-header">
                                <h2><span class="step-number">2</span> <?php echo esc_html_e('Personal Information', CAMPER_BOOKING_TEXT_DOMAIN); ?></h2>
                            </header>
                            <div class="step-content">
                                <div class="form-group">
                                    <label for="name"><?php echo esc_html_e('Full Name', CAMPER_BOOKING_TEXT_DOMAIN); ?>: <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="email"><?php echo esc_html_e('Email', CAMPER_BOOKING_TEXT_DOMAIN); ?>: <span class="required">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="phone"><?php echo esc_html_e('Phone', CAMPER_BOOKING_TEXT_DOMAIN); ?>: <span class="required">*</span></label>
                                    <input type="tel" class="form-control" id="phone" name="phone" required>
                                </div>
                                <small id="camperError" class="error hidden">You must select one camper</small>
                            </div>
                            <footer>
                                <button type="button" class="btn btn-secondary prev-step" data-step="2"><?php echo esc_html_e('Previous', CAMPER_BOOKING_TEXT_DOMAIN); ?></button>
                                <button type="button" class="btn btn-primary next-step" data-step="2"><?php echo esc_html_e('Next', CAMPER_BOOKING_TEXT_DOMAIN); ?></button>
                            </footer>
                        </div>
                    </div>

                    <div id="formStep3" class="camper-booking-form-step hidden">
                        <div class="camper-form-item-wrapper">
                            <header class="step-header">
                                <h2><span class="step-number">3</span> <?php echo esc_html_e('Camper Selection', CAMPER_BOOKING_TEXT_DOMAIN); ?></h2>
                            </header>
                            <div class="step-content">
                                <div class="camper-radio-wrapper">
                                    <?php $arr_campers = new WP_Query(['posts_per_page' => -1, 'post_type' => 'campers', 'order' => 'ASC', 'orderby' => 'date']); ?>
                                    <?php if ($arr_campers->have_posts()) : ?>
                                        <?php while ($arr_campers->have_posts()) : $arr_campers->the_post(); ?>
                                            <?php $camper_price = get_post_meta(get_the_ID(), '_camper_booking_price', true); ?>
                                            <?php $features = get_post_meta(get_the_ID(), '_camper_booking_features', true); ?>
                                            <?php $camper_price_html = '$' . $camper_price . '/day'; ?>
                                            <label for="camper<?php echo esc_attr(sanitize_title(get_the_title())); ?>" class="radio-wrapper camper-radio-item">
                                                <?php the_post_thumbnail([250, 200], ['class' => 'camper-image', 'loading' => 'lazy']); ?>
                                                <span><?php echo esc_html(get_the_title() . ' - ' . $camper_price_html); ?></span>
                                                <input type="radio" name="camper" id="camper<?php echo esc_attr(sanitize_title(get_the_title())); ?>" value="<?php echo esc_attr(sanitize_title(get_the_title())); ?>">
                                                <div class="camper-details">
                                                    <?php foreach ($features as $feature) : ?>
                                                        <div class="camper-details-item">
                                                            <div class="icon">
                                                                <img loading="lazy" src="<?php echo esc_url($feature['icon']); ?>" alt="icon" />
                                                            </div>
                                                            <div class="text">
                                                                <p><?php echo esc_html($feature['text']); ?></p>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>

                                            </label>
                                        <?php endwhile; ?>
                                        <?php wp_reset_postdata(); ?>
                                    <?php else : ?>
                                        <p><?php echo esc_html_e('No campers available at the moment.', CAMPER_BOOKING_TEXT_DOMAIN); ?></p>
                                    <?php endif; ?>
                                </div>
                                <small id="camperError" class="error hidden">You must select one camper</small>
                            </div>
                            <footer>
                                <button type="button" class="btn btn-secondary prev-step" data-step="3"><?php echo esc_html_e('Previous', CAMPER_BOOKING_TEXT_DOMAIN); ?></button>
                                <button type="button" class="btn btn-primary next-step" data-step="3"><?php echo esc_html_e('Next', CAMPER_BOOKING_TEXT_DOMAIN); ?></button>
                            </footer>
                        </div>
                    </div>

                    <div id="formStep4" class="camper-booking-form-step hidden">
                        <div class="camper-form-item-wrapper">
                            <header class="step-header">
                                <h2><span class="step-number">4</span> <?php echo esc_html_e('Make your Payment', CAMPER_BOOKING_TEXT_DOMAIN); ?></h2>
                            </header>
                            <div class="step-content">
                                <p>This feature is currently under development.</p>
                            </div>
                            <footer>
                                <button type="button" class="btn btn-secondary prev-step" data-step="4"><?php echo esc_html_e('Previous', CAMPER_BOOKING_TEXT_DOMAIN); ?></button>
                                <button type="button" class="btn btn-primary make-payment" data-step="4"><?php echo esc_html_e('Make Payment', CAMPER_BOOKING_TEXT_DOMAIN); ?></button>
                            </footer>
                        </div>
                    </div>
                </div>
                <aside class="camper-form-aside-container">
                    <div class="camper-form-aside-wrapper">
                        <h2><?php echo esc_html_e('Booking Info', CAMPER_BOOKING_TEXT_DOMAIN); ?></h2>
                        <div class="camper-form-aside-step-item step-1">
                            <header class="camper-form-aside-step-item-header">
                                <span class="icon">1</span>
                                <span class="text"><?php echo esc_html_e('Booking Dates', CAMPER_BOOKING_TEXT_DOMAIN); ?></span>
                            </header>
                            <div class="camper-form-aside-step-item-content">
                                <p id="bookingDates"><?php echo esc_html_e('No Dates Selected', CAMPER_BOOKING_TEXT_DOMAIN); ?></p>
                                <p id="bookingDays"><?php echo esc_html_e('No Days Selected', CAMPER_BOOKING_TEXT_DOMAIN); ?></p>
                            </div>
                        </div>
                        <div class="camper-form-aside-step-item step-2">
                            <header class="camper-form-aside-step-item-header">
                                <span class="icon">2</span>
                                <span class="text"><?php echo esc_html_e('Personal Info', CAMPER_BOOKING_TEXT_DOMAIN); ?></span>
                            </header>
                            <div class="camper-form-aside-step-item-content">
                                <p id="personalInfo"><?php echo esc_html_e('No Days Selected', CAMPER_BOOKING_TEXT_DOMAIN); ?></p>
                            </div>
                        </div>
                        <div class="camper-form-aside-step-item step-3">
                            <header class="camper-form-aside-step-item-header">
                                <span class="icon">3</span>
                                <span class="text"><?php echo esc_html_e('Camper Selection', CAMPER_BOOKING_TEXT_DOMAIN); ?></span>
                            </header>
                            <div class="camper-form-aside-step-item-content">
                                <p id="camperSelection"><?php echo esc_html_e('No Days Selected', CAMPER_BOOKING_TEXT_DOMAIN); ?></p>
                            </div>
                        </div>
                        <div class="camper-form-aside-step-item step-4">
                            <header class="camper-form-aside-step-item-header">
                                <span class="icon">4</span>
                                <span class="text"><?php echo esc_html_e('Payment & Confirmation', CAMPER_BOOKING_TEXT_DOMAIN); ?></span>
                            </header>
                            <div class="camper-form-aside-step-item-content">
                                <p id="paymentConfirmation"></p>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </form>
<?php
        return ob_get_clean();
    }
}

new CamperBookingShortcodes();
