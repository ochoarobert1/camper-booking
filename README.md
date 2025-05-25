# Camper Booking

A WordPress plugin to manage campervans bookings and reservations.

## Description

Camper Booking is a plugin designed to help manage campervan bookings and reservations. It provides a booking form through a shortcode, admin management pages, and a custom post type for storing booking information.

## Features

- Booking form shortcode `[camper-booking]`
- Admin dashboard for managing bookings
- Calendar view for visualizing reservations
- Custom post type for storing booking data
- Multi-step booking process
- Multilingual support (English and Spanish included)

## Installation

1. Upload the `camper-booking` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Use the shortcode `[camper-booking]` on any page to display the booking form

## Usage

### Shortcode

Add the booking form to any page or post using the shortcode:

```
[camper-booking]
```

### Admin Menu

The plugin adds a "Booking" menu to the WordPress admin with the following submenus:
- All Bookings - View and manage all bookings
- Add New - Create a new booking
- Calendar - View bookings in a calendar format
- Options - Configure plugin settings

## Development

### File Structure

- `camper-booking.php` - Main plugin file
- `inc/post-type.php` - Custom post type registration
- `public/shortcode.php` - Booking form shortcode
- `lang/` - Translation files
- `assets/` - CSS and JavaScript files

### Translations

The plugin is translation-ready and includes:
- English (default)
- Spanish (es_ES)

To add more translations, copy the `camper-booking.pot` file from the `lang` directory and create new PO/MO files for your language.

## Requirements

- WordPress 5.0 or higher
- PHP 7.0 or higher

## License

GPL v2 or later

## Author

Robert Ochoa - [https://robertochoaweb.com/](https://robertochoaweb.com/)