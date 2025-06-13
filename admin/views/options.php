<?php

/**
 * Options page for Camper Booking plugin.
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

?>
<div class="wrap">
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
	<div class="camper-booking-options-wrapper">
		<ul class="camper-booking-options-list">
			<li><a href="#" id="generalSettingsTab" data-panel="generalSettings" class="camper-booking-option-item active"><?php echo esc_html_e( 'General Settings', CAMPER_BOOKING_TEXT_DOMAIN ); ?></a></li>
			<li><a href="#" id="emailSettingsTab" data-panel="emailSettings" class="camper-booking-option-item"><?php echo esc_html_e( 'Email Settings', CAMPER_BOOKING_TEXT_DOMAIN ); ?></a></li>
			<li><a href="#" id="publicSettingsTab" data-panel="publicSettings" class="camper-booking-option-item"><?php echo esc_html_e( 'Public Settings', CAMPER_BOOKING_TEXT_DOMAIN ); ?></a></li>
		</ul>
		<div class="camper-booking-options-panels">
			<div id="generalSettings" class="camper-booking-option-panel">
				<h2><?php echo esc_html_e( 'General Settings', CAMPER_BOOKING_TEXT_DOMAIN ); ?></h2>
				<form id="generalSettingsForm">
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
							<input type="url" name="testApiUrl" id="testApiUrl" value="<?php echo esc_url( get_option( 'camper_booking_testing_api_url' ) ); ?>" />
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
							<input type="url" name="apiUrl" id="apiUrl" value="<?php echo esc_url( get_option( 'camper_booking_api_url' ) ); ?>" />
							<small><?php echo esc_html_e( 'Enter here the API URL or Webhook URL (Production Mode)', CAMPER_BOOKING_TEXT_DOMAIN ); ?></small>
						</div>

					</div>

					<button id="saveGeneralSettings" type="submit" class="button button-primary"><?php echo esc_html_e( 'Save Settings', CAMPER_BOOKING_TEXT_DOMAIN ); ?></button>
				</form>
			</div>
			<div id="emailSettings" class="camper-booking-option-panel hidden-tab">
				<h2><?php echo esc_html_e( 'Email Settings', CAMPER_BOOKING_TEXT_DOMAIN ); ?></h2>
				<form id="emailSettingsForm">
					<div class="form-group form-group-upload">
						<label for="emailLogo"><?php echo esc_html_e( 'Email Logo', CAMPER_BOOKING_TEXT_DOMAIN ); ?></label>
						<div class="input-group">
							<input type="text" name="emailLogo" id="emailLogo" value="<?php echo esc_url( get_option( 'camper_booking_email_logo' ) ); ?>" />
							<button id="uploadEmailLogo" class="button button-secondary"><?php echo esc_html_e( 'Upload Logo', CAMPER_BOOKING_TEXT_DOMAIN ); ?></button>
							<small><?php echo esc_html_e( 'Upload logo to be shown on the email', CAMPER_BOOKING_TEXT_DOMAIN ); ?></small>
						</div>
					</div>
					<h3><?php echo esc_html_e( 'Email Main Data', CAMPER_BOOKING_TEXT_DOMAIN ); ?></h3>
					<div class="form-group">
						<label for="emailNotification"><?php echo esc_html_e( 'Email Address to receive notifications', CAMPER_BOOKING_TEXT_DOMAIN ); ?></label>
						<div class="input-group">
							<input type="email" name="emailNotification" id="emailNotification" value="<?php echo esc_attr( get_option( 'camper_booking_email_notification' ) ); ?>" />
							<small><?php echo esc_html_e( 'Enter email address who will be receiving booking notifications', CAMPER_BOOKING_TEXT_DOMAIN ); ?></small>
						</div>
					</div>
					<div class="form-group">
						<label for="emailSupport"><?php echo esc_html_e( 'Email Address for Support', CAMPER_BOOKING_TEXT_DOMAIN ); ?></label>
						<div class="input-group">
							<input type="email" name="emailSupport" id="emailSupport" value="<?php echo esc_attr( get_option( 'camper_booking_email_support' ) ); ?>" />
							<small><?php echo esc_html_e( 'Enter email address who will be used in email content as support email', CAMPER_BOOKING_TEXT_DOMAIN ); ?></small>
						</div>
					</div>
					<div class="form-group">
						<label for="phoneSupport"><?php echo esc_html_e( 'Phone Number for Support', CAMPER_BOOKING_TEXT_DOMAIN ); ?></label>
						<div class="input-group">
							<input type="tel" name="phoneSupport" id="phoneSupport" value="<?php echo esc_attr( get_option( 'camper_booking_phone_support' ) ); ?>" />
							<small><?php echo esc_html_e( 'Enter phone number who will be used in email content as support phone', CAMPER_BOOKING_TEXT_DOMAIN ); ?></small>
						</div>
					</div>
					<div class="form-group form-group-textarea">
						<label for="bankTransferData"><?php echo esc_html_e( 'Bank Transfer: Instructions', CAMPER_BOOKING_TEXT_DOMAIN ); ?></label>
						<textarea name="bankTransferData" id="bankTransferData" class="large-text" rows="10"><?php echo esc_textarea( get_option( 'camper_booking_bank_transfer' ) ); ?></textarea>
						<small><?php echo esc_html_e( 'Enter instructions for Bank Transfer to be shown in the notification process', CAMPER_BOOKING_TEXT_DOMAIN ); ?></small>
					</div>
					<button id="saveEmailSettings" type="submit" class="button button-primary"><?php echo esc_html_e( 'Save Settings', CAMPER_BOOKING_TEXT_DOMAIN ); ?></button>
				</form>
			</div>
			<div id="publicSettings" class="camper-booking-option-panel hidden-tab">
				<h2><?php echo esc_html_e( 'Public Settings', CAMPER_BOOKING_TEXT_DOMAIN ); ?></h2>
				<form id="publicSettingsForm">
					<div class="form-group form-group-textarea">
						<label for="terms-conditions"><?php echo esc_html_e( 'Terms &amp; Conditions', CAMPER_BOOKING_TEXT_DOMAIN ); ?></label>
						<textarea name="terms-conditions" id="terms-conditions" class="large-text" rows="10"><?php echo esc_textarea( get_option( 'camper_booking_terms_conditions' ) ); ?></textarea>
						<small><?php echo esc_html_e( 'Enter here the Terms and Conditions to be shown on the booking process', CAMPER_BOOKING_TEXT_DOMAIN ); ?></small>
					</div>

					<h3><?php echo esc_html_e( 'Currency and Taxes', CAMPER_BOOKING_TEXT_DOMAIN ); ?></h3>
					<div class="form-group">
						<label for="mainCurrency"><?php echo esc_html_e( 'Currency', CAMPER_BOOKING_TEXT_DOMAIN ); ?></label>
						<div class="input-group">
							<input type="text" name="mainCurrency" id="mainCurrency" value="<?php echo esc_attr( get_option( 'camper_booking_main_currency' ) ); ?>" />
							<small><?php echo esc_html_e( 'Enter the currency symbol to be used on site', CAMPER_BOOKING_TEXT_DOMAIN ); ?></small>
						</div>
					</div>

					<div class="form-group form-group-checkbox">
						<input type="checkbox" name="activateTaxes" id="activateTaxes" value="1" <?php checked( get_option( 'camper_booking_taxes_activate' ), 1 ); ?> />
						<label for="activateTaxes"><?php echo esc_html_e( 'Enable Taxes', CAMPER_BOOKING_TEXT_DOMAIN ); ?></label>
						<small><?php echo esc_html_e( 'Click here to activate taxes for payment process', CAMPER_BOOKING_TEXT_DOMAIN ); ?></small>
					</div>

					<div class="form-group">
						<label for="taxesName"><?php echo esc_html_e( 'Taxes: Name', CAMPER_BOOKING_TEXT_DOMAIN ); ?></label>
						<div class="input-group">
							<input type="text" name="taxesName" id="taxesName" value="<?php echo esc_attr( get_option( 'camper_booking_taxes_name' ) ); ?>" />
							<small><?php echo esc_html_e( 'Enter name of tax to be used on site', CAMPER_BOOKING_TEXT_DOMAIN ); ?></small>
						</div>
					</div>
					<div class="form-group">
						<label for="taxesPercentage"><?php echo esc_html_e( 'Taxes: Percentage', CAMPER_BOOKING_TEXT_DOMAIN ); ?></label>
						<div class="input-group">
							<input type="number" name="taxesPercentage" id="taxesPercentage" value="<?php echo esc_attr( get_option( 'camper_booking_taxes_percentage' ) ); ?>" />
							<small><?php echo esc_html_e( 'Enter percentage of tax to be used on site', CAMPER_BOOKING_TEXT_DOMAIN ); ?></small>
						</div>
					</div>

					<button id="savePublicSettings" type="submit" class="button button-primary"><?php echo esc_html_e( 'Save Settings', CAMPER_BOOKING_TEXT_DOMAIN ); ?></button>
				</form>
			</div>
		</div>
	</div>
</div>
