<?php

/**
 * Options page for Camper Booking plugin.
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

?>
<div class="wrap">
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
	<div class="camper-booking-options-wrapper">
		<ul class="camper-booking-options-list">
			<li><a href="#" id="generalSettingsTab" data-panel="generalSettings" class="camper-booking-option-item active"><?php echo esc_html_e( 'General Settings', CAMPER_BOOKING_TEXT_DOMAIN ); ?></a></li>
			<li><a href="#" id="publicSettingsTab" data-panel="publicSettings" class="camper-booking-option-item"><?php echo esc_html_e( 'Public Settings', CAMPER_BOOKING_TEXT_DOMAIN ); ?></a></li>
		</ul>
		<div class="camper-booking-options-panels">
			<div id="generalSettings" class="camper-booking-option-panel">
				<h2><?php echo esc_html_e( 'General Settings', CAMPER_BOOKING_TEXT_DOMAIN ); ?></h2>
				<form id="generalSettingsForm">
					<?php wp_nonce_field( 'camper_booking_general_settings_nonce', 'camper_booking_general_nonce' ); ?>
					<div class="form-group form-group-checkbox">
						<input type="checkbox" name="sandbox" id="sandbox" value="1" <?php checked( get_option( 'camper_booking_sandbox' ), 1 ); ?> />
						<label for="sandbox"><?php echo esc_html_e( 'Enable Sandbox Mode', CAMPER_BOOKING_TEXT_DOMAIN ); ?></label>
						<small><?php echo esc_html_e( 'Click here to swap between test and live keys for payment process', CAMPER_BOOKING_TEXT_DOMAIN ); ?></small>
					</div>

					<h3><?php echo esc_html_e( 'API Settings (Test Mode)', CAMPER_BOOKING_TEXT_DOMAIN ); ?></h3>
					<div class="form-group">
						<label for="testApiKey"><?php echo esc_html_e( 'API Key', CAMPER_BOOKING_TEXT_DOMAIN ); ?></label>
						<div class="input-group">
							<input type="password" name="testApiKey" id="testApiKey" value="<?php echo esc_attr( get_option( 'camper_booking_testing_api_key' ) ); ?>" />
							<small><?php echo esc_html_e( 'Enter here the API Key (Test Mode)', CAMPER_BOOKING_TEXT_DOMAIN ); ?></small>
						</div>
					</div>
					<div class="form-group">
						<label for="testSecretKey"><?php echo esc_html_e( 'Secret Key', CAMPER_BOOKING_TEXT_DOMAIN ); ?></label>
						<div class="input-group">
							<input type="password" name="testSecretKey" id="testSecretKey" value="<?php echo esc_attr( get_option( 'camper_booking_testing_secret_key' ) ); ?>" />
							<small><?php echo esc_html_e( 'Enter here the API Secret (Test Mode)', CAMPER_BOOKING_TEXT_DOMAIN ); ?></small>
						</div>
					</div>
					<div class="form-group">
						<label for="testApiUrl"><?php echo esc_html_e( 'API URL', CAMPER_BOOKING_TEXT_DOMAIN ); ?></label>
						<div class="input-group">
							<input type="url" name="testApiUrl" id="testApiUrl" value="<?php echo esc_attr( get_option( 'camper_booking_testing_api_url' ) ); ?>" />
							<small><?php echo esc_html_e( 'Enter here the API URL or Webhook URL (Test Mode)', CAMPER_BOOKING_TEXT_DOMAIN ); ?></small>
						</div>
					</div>

					<h3><?php echo esc_html_e( 'API Settings (Production Mode)', CAMPER_BOOKING_TEXT_DOMAIN ); ?></h3>
					<div class="form-group">
						<label for="apiKey"><?php echo esc_html_e( 'API Key', CAMPER_BOOKING_TEXT_DOMAIN ); ?></label>
						<div class="input-group">
							<input type="password" name="apiKey" id="apiKey" value="<?php echo esc_attr( get_option( 'camper_booking_api_key' ) ); ?>" />
							<small><?php echo esc_html_e( 'Enter here the API Key (Production Mode)', CAMPER_BOOKING_TEXT_DOMAIN ); ?></small>
						</div>
					</div>
					<div class="form-group">
						<label for="secretKey"><?php echo esc_html_e( 'Secret Key', CAMPER_BOOKING_TEXT_DOMAIN ); ?></label>
						<div class="input-group">
							<input type="password" name="secretKey" id="secretKey" value="<?php echo esc_attr( get_option( 'camper_booking_secret_key' ) ); ?>" />
							<small><?php echo esc_html_e( 'Enter here the API Secret (Production Mode)', CAMPER_BOOKING_TEXT_DOMAIN ); ?></small>
						</div>
					</div>
					<div class="form-group">
						<label for="apiUrl"><?php echo esc_html_e( 'API URL', CAMPER_BOOKING_TEXT_DOMAIN ); ?></label>
						<div class="input-group">
							<input type="url" name="apiUrl" id="apiUrl" value="<?php echo esc_attr( get_option( 'camper_booking_api_url' ) ); ?>" />
							<small><?php echo esc_html_e( 'Enter here the API URL or Webhook URL (Production Mode)', CAMPER_BOOKING_TEXT_DOMAIN ); ?></small>
						</div>

					</div>

					<button id="saveGeneralSettings" type="submit" class="button button-primary"><?php echo esc_html_e( 'Save Settings', CAMPER_BOOKING_TEXT_DOMAIN ); ?></button>
				</form>
			</div>
			<div id="publicSettings" class="camper-booking-option-panel hidden-tab">
				<h2><?php echo esc_html_e( 'Public Settings', CAMPER_BOOKING_TEXT_DOMAIN ); ?></h2>
				<form id="publicSettingsForm">
					<?php wp_nonce_field( 'camper_booking_public_settings_nonce', 'camper_booking_public_nonce' ); ?>
					<div class="form-group form-group-textarea">
						<label for="terms-conditions"><?php echo esc_html_e( 'Terms &amp; Conditions', CAMPER_BOOKING_TEXT_DOMAIN ); ?></label>
						<textarea name="terms-conditions" id="terms-conditions" class="large-text" rows="10"><?php echo esc_textarea( get_option( 'camper_booking_terms_conditions' ) ); ?></textarea>
						<small><?php echo esc_html_e( 'Enter here the Terms and Conditions to be shown on the booking process', CAMPER_BOOKING_TEXT_DOMAIN ); ?></small>
					</div>

					<button id="savePublicSettings" type="submit" class="button button-primary"><?php echo esc_html_e( 'Save Settings', CAMPER_BOOKING_TEXT_DOMAIN ); ?></button>
				</form>
			</div>
		</div>
	</div>
</div>
