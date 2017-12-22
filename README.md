# FA WP Admin Menu Icons

[![WordPress plugin rating](https://img.shields.io/wordpress/plugin/r/fa-wp-admin-menu-icons.svg)]() [![WordPress plugin](https://img.shields.io/wordpress/plugin/dt/fa-wp-admin-menu-icons.svg)]() [![WordPress](https://img.shields.io/wordpress/v/fa-wp-admin-menu-icons.svg)]()

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
