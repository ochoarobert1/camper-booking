<?php

/**
 * CamperBookingMetaboxes
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

class CamperBookingMetaboxes
{

	/**
	 * Method __construct
	 *
	 * @return void
	 */
	public function __construct()
	{
		add_action('add_meta_boxes', array($this, 'add_metaboxes'));
		add_action('save_post', array($this, 'save_metaboxes'));
	}

	/**
	 * Method add_metaboxes
	 *
	 * @return void
	 */
	public function add_metaboxes()
	{
		add_meta_box(
			'camper_booking_details',
			esc_html__('Camper Details', CAMPER_BOOKING_TEXT_DOMAIN),
			array($this, 'render_metabox'),
			'campers',
			'normal',
			'default'
		);
	}

	/**
	 * Method render_metabox
	 *
	 * @param $post $post [object]
	 *
	 * @return void
	 */
	public function render_metabox($post)
	{
		wp_nonce_field('camper_booking_save_details', 'camper_booking_nonce');

		$price    = get_post_meta($post->ID, '_camper_booking_price', true);
		$features = get_post_meta($post->ID, '_camper_booking_features', true);

		wp_enqueue_media();
?>
		<h4><?php esc_html_e('Pricing', CAMPER_BOOKING_TEXT_DOMAIN); ?></h4>
		<div class="form-group">
			<label for="camper_booking_price"><?php echo esc_html_e('Booking Price (per day)', CAMPER_BOOKING_TEXT_DOMAIN); ?></label>
			<div class="input-group">
				<input type="number" id="camper_booking_price" name="camper_booking_price" value="<?php echo esc_attr($price); ?>" step="0.01" min="0" />
				<small><?php echo esc_html_e('Enter price for booking this camper per day', CAMPER_BOOKING_TEXT_DOMAIN); ?></small>
			</div>
		</div>

		<hr>

		<!-- Features Repeater -->
		<div id="camper_booking_features">
			<h4><?php esc_html_e('Features', CAMPER_BOOKING_TEXT_DOMAIN); ?></h4>
			<p>Add icons and features for this campervan:</p>

			<div class="features-container">
				<?php
				if (! empty($features)) {
					foreach ($features as $feature) {
				?>
						<div class="feature-row">
							<img src="<?php echo esc_url($feature['icon']); ?>" class="icon-preview" style="max-width: 40px; max-height: 40px; margin: 0 10px; vertical-align: middle;">
							<input type="hidden" name="feature_icon[]" class="icon-url" value="<?php echo esc_attr($feature['icon']); ?>">
							<input type="text" name="feature_text[]" value="<?php echo esc_attr($feature['text']); ?>" placeholder="Feature description">
							<button type="button" class="upload-icon button"><span class="dashicons dashicons-upload"></span></button>
							<button type="button" class="remove-feature button button-danger"><span class="dashicons dashicons-remove"></span></button>
						</div>
				<?php
					}
				}
				?>
			</div>
			<button type="button" id="add_feature" class="button button-add-feature button-primary">Add Feature</button>
		</div>

		<template id="feature-row-template">
			<div class="feature-row">
				<input type="hidden" name="feature_icon[]" class="icon-url">
				<img src="" class="icon-preview" style="max-width: 40px; max-height: 40px; margin: 0 10px; vertical-align: middle; display: none;">
				<input type="text" name="feature_text[]" placeholder="Feature description">
				<button type="button" class="upload-icon button"><span class="dashicons dashicons-upload"></span></button>
				<button type="button" class="remove-feature button"><span class="dashicons dashicons-remove"></span></button>
			</div>
		</template>
<?php
	}

	/**
	 * Method save_metaboxes
	 *
	 * @param $post_id $post_id [string]
	 *
	 * @return void
	 */
	public function save_metaboxes($post_id)
	{
		if (! isset($_POST['camper_booking_nonce']) || ! wp_verify_nonce($_POST['camper_booking_nonce'], 'camper_booking_save_details')) {
			return;
		}

		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}

		if (! current_user_can('edit_post', $post_id)) {
			return;
		}

		if (isset($_POST['camper_booking_price'])) {
			update_post_meta($post_id, '_camper_booking_price', sanitize_text_field($_POST['camper_booking_price']));
		}

		if (isset($_POST['feature_icon']) && isset($_POST['feature_text'])) {
			$features = array();
			$icons    = $_POST['feature_icon'];
			$texts    = $_POST['feature_text'];

			for ($i = 0; $i < count($icons); $i++) {
				if (! empty($texts[$i])) {
					$features[] = array(
						'icon' => sanitize_text_field($icons[$i]),
						'text' => sanitize_text_field($texts[$i]),
					);
				}
			}

			update_post_meta($post_id, '_camper_booking_features', $features);
		}
	}
}

new CamperBookingMetaboxes();
