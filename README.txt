=== FA WP Admin Menu Icons ===
Contributors: ptrkcsk
Tags: fontawesome, icon, icons, custom
Requires at least: 4.4
Tested up to: 4.8.2
Stable tag: 1.0.4
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.en.html

A simple way to use Font Awesome icons for custom post types and custom admin menu pages.

== Description ==

Use `'fa-<icon-name>'` (i.e. `'fa-address-book'`) wherever you would use `'dashicons-<icon-name>'`.

[FA WP Admin Menu Icons on GitHub](https://github.com/ptrkcsk/font-awesome-wordpress-admin-menu-icons)

= Examples =

**Use Font Awesome icon for custom post type:**

	register_post_type( 'custom_post_type', [
		...
		'menu_icon' => 'fa-<icon-name>',
		...
	] );

**Use Font Awesome icon for custom menu page:**

	add_menu_page(
		'Custom Menu Page',
		'Custom Menu Page',
		'manage_options',
		'custom_menu_page',
		'',
		'fa-<icon-name>',
	);
