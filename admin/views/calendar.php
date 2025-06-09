<?php

/**
 * Calendar page for Camper Booking plugin.
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

?>
<div class="wrap">
	<h1><?php echo esc_html(get_admin_page_title()); ?></h1>
	<div id="camperBookingFullCalendar"></div>
</div>