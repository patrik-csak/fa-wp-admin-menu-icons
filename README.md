# FA WP Admin Menu Icons

A super simple way to use Font Awesome icons for custom post types and custom admin menu pages.

## Usage

Use `'fa-<icon-name>'` (i.e. `'fa-address-book'`) wherever you would use `'dashicons-<icon-name>'`.

## Examples

**Use Font Awesome icon for custom post type:**

```php
register_post_type( 'custom_post_type', [
	...
	'menu_icon' => 'fa-<icon-name>',
	...
] );
```

**Use Font Awesome icon for custom menu page:**

```php
add_menu_page(
	'Custom Menu Page',
	'Custom Menu Page',
	'manage_options',
	'custom_menu_page',
	'',
	'fa-<icon-name>',
);
```

## Caveats

At the moment, this plugin relies on [Font-Awesome-SVG-PNG](https://github.com/encharm/Font-Awesome-SVG-PNG), which has not kept up with [Font Awesome](https://github.com/FortAwesome/Font-Awesome). Some icons may be out of date or missing.
