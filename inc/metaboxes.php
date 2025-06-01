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
		add_action('save_post', array($this, 'save_camper_metaboxes'));
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
			array($this, 'render_camper_metaboxes'),
			'campers',
			'normal',
			'default'
		);

		add_meta_box(
			'camper_booking_features',
			esc_html__('Booking Information', CAMPER_BOOKING_TEXT_DOMAIN),
			array($this, 'render_booking_metaboxes'),
			'booking',
			'normal',
			'default'
		);
	}

	/**
	 * Method render_booking_metaboxes
	 *
	 * @param $post $post [object]
	 *
	 * @return void
	 */
	public function render_booking_metaboxes($post)
	{
		wp_nonce_field('camper_booking_save_details', 'camper_booking_nonce');
		$name = get_post_meta($post->ID, 'name', true);
		$email = get_post_meta($post->ID, 'email', true);
		$phone = get_post_meta($post->ID, 'phone', true);
		$days_selected = get_post_meta($post->ID, 'days_selected', true);
		$datetimes = get_post_meta($post->ID, 'datetimes', true);
		$camper = get_post_meta($post->ID, 'camper', true);
		$total = get_post_meta($post->ID, 'total', true);
		$payment_method = get_post_meta($post->ID, 'payment_method', true);
?>
		<h2><?php echo esc_html_e('Personal Information', CAMPER_BOOKING_TEXT_DOMAIN); ?></h2>
		<div class="form-group">
			<label for="name"><?php echo esc_html_e('Name', CAMPER_BOOKING_TEXT_DOMAIN); ?></label>
			<input type="text" id="name" name="name" value="<?php echo esc_attr($name); ?>" class="widefat" />
		</div>
		<div class="form-group">
			<label for="email"><?php echo esc_html_e('Email', CAMPER_BOOKING_TEXT_DOMAIN); ?></label>
			<input type="email" id="email" name="email" value="<?php echo esc_attr($email); ?>" class="widefat" />
		</div>
		<div class="form-group">
			<label for="phone"><?php echo esc_html_e('Phone', CAMPER_BOOKING_TEXT_DOMAIN); ?></label>
			<input type="text" id="phone" name="phone" value="<?php echo esc_attr($phone); ?>" class="widefat" />
		</div>
		<h2><?php echo esc_html_e('Date Information', CAMPER_BOOKING_TEXT_DOMAIN); ?></h2>
		<div class="form-group">
			<label for="days_selected"><?php echo esc_html_e('Days Selected', CAMPER_BOOKING_TEXT_DOMAIN); ?></label>
			<input type="number" id="days_selected" name="days_selected" value="<?php echo esc_attr($days_selected); ?>" class="widefat" />
		</div>
		<div class="form-group">
			<label for="datetimes"><?php echo esc_html_e('Dates Selected', CAMPER_BOOKING_TEXT_DOMAIN); ?></label>
			<input type="text" id="datetimes" name="datetimes" value="<?php echo esc_attr($datetimes); ?>" class="widefat" />
		</div>
		<h2><?php echo esc_html_e('Camper Information', CAMPER_BOOKING_TEXT_DOMAIN); ?></h2>
		<div class="form-group">
			<label for="camper"><?php echo esc_html_e('Camper Selected', CAMPER_BOOKING_TEXT_DOMAIN); ?></label>
			<?php $campers = get_posts(['post_type' => 'campers', 'posts_per_page' => -1]); ?>
			<select name="camper" id="camper" class="widefat">
				<option value=""><?php echo esc_html_e('Select a camper', CAMPER_BOOKING_TEXT_DOMAIN); ?></option>
				<?php foreach ($campers as $camper_post) : ?>
					<?php $price = get_post_meta($camper_post->ID, '_camper_booking_price', true); ?>
					<?php $price = (empty($price)) ? 0 : floatval($price); ?>
					<option value="<?php echo esc_attr($camper_post->ID); ?>" <?php selected($camper, $camper_post->post_name); ?>>
						<?php echo esc_html($camper_post->post_title . ' - ' . number_format($price, 2, ',', '.')); ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>
		<h2><?php echo esc_html_e('Payment Information', CAMPER_BOOKING_TEXT_DOMAIN); ?></h2>
		<div class="form-group">
			<label for="total"><?php echo esc_html_e('Total Amount', CAMPER_BOOKING_TEXT_DOMAIN); ?></label>
			<input type="number" id="total" name="total" value="<?php echo esc_attr($total); ?>" class="widefat" step="0.01" min="0" />
		</div>
		<div class="form-group">
			<label for="payment_method"><?php echo esc_html_e('Payment Method', CAMPER_BOOKING_TEXT_DOMAIN);	 ?></label>
			<select name="payment_method" id="payment_method" class="widefat">
				<option value=""><?php echo esc_html_e('Select a payment method', CAMPER_BOOKING_TEXT_DOMAIN); ?></option>
				<option value="credit_card" <?php selected($payment_method, 'credit_card'); ?>><?php echo esc_html_e('Credit Card', CAMPER_BOOKING_TEXT_DOMAIN); ?></option>
				<option value="paypal" <?php selected($payment_method, 'paypal'); ?>><?php echo esc_html_e('PayPal', CAMPER_BOOKING_TEXT_DOMAIN); ?></option>
				<option value="bank_transfer" <?php selected($payment_method, 'bank_transfer'); ?>><?php echo esc_html_e('Bank Transfer', CAMPER_BOOKING_TEXT_DOMAIN); ?></option>
			</select>
		</div>
	<?php
	}

	/**
	 * Method render_camper_metaboxes
	 *
	 * @param $post $post [object]
	 *
	 * @return void
	 */
	public function render_camper_metaboxes($post)
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
	 * Method save_camper_metaboxes
	 *
	 * @param $post_id $post_id [string]
	 *
	 * @return void
	 */
	public function save_camper_metaboxes($post_id)
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
