# FA WP Admin Menu Icons

![FA WP Admin Menu Icons: Tested WP Version](https://img.shields.io/wordpress/plugin/tested/fa-wp-admin-menu-icons.svg) [![Test Coverage](https://api.codeclimate.com/v1/badges/8e7095f8f9347a38a868/test_coverage)](https://codeclimate.com/github/ptrkcsk/fa-wp-admin-menu-icons/test_coverage) [![FA WP Admin Menu Icons download count](https://img.shields.io/wordpress/plugin/dt/fa-wp-admin-menu-icons.svg)](https://wordpress.org/plugins/fa-wp-admin-menu-icons/)

Use Font Awesome icons for custom post types and custom menu pages.

```php
register_post_type( 'custom_post_type', [
    //...
    'menu_icon' => 'fas fa-thumbs-up',
    //...
] );
```

## Installation

### Composer

```
$ composer require wpackagist-plugin/fa-wp-admin-menu-icons
```

### Git

```
$ cd <wp-content>/plugins
$ git clone git@github.com:ptrkcsk/fa-wp-admin-menu-icons.git
```

### WordPress

[How to install WordPress plugins.](https://codex.wordpress.org/Managing_Plugins#Installing_Plugins)


## Usage

FA WP Admin Menu Icons works for the following WordPress functions:

- `register_post_type()`
- `add_menu_page()`

### Custom post type

```php
register_post_type( 'custom_post_type', [
    //...
    'menu_icon' => 'fas fa-thumbs-up',
    //...
] );
```

### Custom menu page

```php
add_menu_page(
    'Custom Menu Page',
    'Custom Menu Page',
    'manage_options',
    'custom_menu_page',
    '',
    'fas fa-thumbs-up', // $icon_url
);
```
