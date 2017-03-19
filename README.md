# Font Awesome WordPress Admin Menu Icons

Use Font Awesome icons for WordPress custom post types and menu pages by simply passing `'fa-<icon>'`.

## Usage

Use `'fa-<icon>'` (where `<icon>` is the name of the Font Awesome icon, i.e. `fa-address-book`)

**Use Font Awesome icon for custom post type:**

```php
register_post_type('custom_post_type', [
  ...
  'menu_icon' => 'fa-<icon>',
  ...
]);
```

**Use Font Awesome icon for custom menu page:**

```php
add_menu_page('Custom Menu Page', 'Custom Menu Page', 'manage_options', 'fa-<icon>');
```
