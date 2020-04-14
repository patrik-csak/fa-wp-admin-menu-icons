=== FA WP Admin Menu Icons ===
Contributors: ptrkcsk
Tags: fontawesome, icon, icons, custom
Requires at least: 4.4
Tested up to: 5.4
Requires PHP: 7.2
Stable tag: 4.1.0
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.en.html

Use Font Awesome icons for custom post types and custom menu pages.

== Description ==

Use Font Awesome icons for custom post types and custom menu pages.

    register_post_type( 'custom_post_type', [
        //...
        'menu_icon' => 'fas fa-thumbs-up',
        //...
    ] );

[FA WP Admin Menu Icons on GitHub](https://github.com/ptrkcsk/fa-wp-admin-menu-icons)

== Usage ==

FA WP Admin Menu Icons works for the following WordPress functions:

- `register_post_type()`
- `add_menu_page()`

**Custom post type**

    register_post_type( 'custom_post_type', [
        //...
        'menu_icon' => 'fas fa-thumbs-up',
        //...
    ] );

**Custom menu page**

    add_menu_page(
        'Custom Menu Page',
        'Custom Menu Page',
        'manage_options',
        'custom_menu_page',
        '',
        'fas fa-thumbs-up', // $icon_url
    );

== Installation ==

= Composer =

    $ composer require wpackagist-plugin/fa-wp-admin-menu-icons

= Git =

    $ cd <wp-content>/plugins
    $ git clone git@github.com:ptrkcsk/fa-wp-admin-menu-icons.git

= WordPress =

[How to install WordPress plugins.](https://codex.wordpress.org/Managing_Plugins#Installing_Plugins)

== Changelog ==

= 4.1.0 =

**Changed**

- Test with WordPress v5.2.1
- Upgrade Font Awesome to v5.13.0

= 4.0.0 =

**Removed**

- Support for EOL PHP versions

= 3.9.1 =

**Added**

- Restore support for EOL PHP versions because it's a breaking change

= 3.9.0 =

**Changed**

- Upgrade Font Awesome to v5.12.1

**Removed**

- Support for EOL PHP versions

= 3.8.0 =

**Changed**

- Update Font Awesome from v5.9.0 to v5.11.2

= 3.7.0 =

**Added**

- Test with WordPress v5.2.1
- Add support for PHP v7.3

**Changed**

- Update Font Awesome from v5.6.0 to v5.9.0

= 3.6.0 =

**Changed**

- Update Font Awesome from v5.5.0 to v5.6.0

= 3.5.0 =

**Changed**

- Update Font Awesome from v5.4.2 to v5.5.0

= 3.4.0 =

**Changed**

- Update Font Awesome from v5.4.1 to v5.4.2

= 3.3.0 =

**Changed**

- Update Font Awesome from v5.3.1 to v5.4.1

= 3.2.0 =

**Changed**

- Update Font Awesome from v5.2.0 to v5.3.1

= 3.1.0 =

**Changed**

- Update Font Awesome from v5.1.0 to v5.2.0

= 3.0.0 =

**Changed**

- Initialize the plugin earlier in the WP lifecycle

= 2.8.0 =

**Added**

- Tested with WordPress v4.9.6

**Changed**

- Update Font Awesome from v5.0.13 to v5.1.0

= 2.7.0 =

**Changed**

- Update Font Awesome from v5.0.12 to v5.0.13

= 2.6.0 =

**Changed**

- Update Font Awesome from v5.0.11 to v5.0.12

= 2.5.0 =

**Changed**

- Update Font Awesome from v5.0.10 to v5.0.11

= 2.4.0 =

**Changed**

- Update Font Awesome from v5.0.9 to v5.0.10

= 2.3.1 =

**Changed**

- Update README.txt changelog

= 2.3.0 =

**Changed**

- Bump Font Awesome version from 5.0.8 to 5.0.9

= 2.2.1 =

**Fixed**

- Fix styles action

= 2.2.0 =

**Added**

- Add support for Font Awesome versions. Icons are now cached with their Font Awesome version so they can be updated when the Font Awesome version changes.

= 2.1.0 =

**Added**

- Add links to changelog
- Add links to readme badges
- Integrate Travis and Code Climate test coverage

**Changed**

- Instead of storing all icons in the plugin, get them remotely, as needed, and cache them in the database for future use
- Make hooks code DRYer
- Stop using static methods, to make testing easier
- Make icons smaller so they look better next to Dashicons
- Update Font Awesome shims

= 2.0.1 =

**Added**

- Add CC BY 4.0 attribution in `icons/README.md` to adhere to [Font Awesome license](https://fontawesome.com/license)

**Fixed**

- Fix old syntax in readme examples
- Add missing 'Usage' section to `README.txt`

= 2.0.0 =

**Added**

- Add unit tests

**Changed**

- Upgrade to Font Awesome 5 icons and class syntax
- Use PSR instead of WordPress for code style

**Deprecated**

- Deprecate use of Font Awesome 4 class syntax

= 1.0.4 =

**Changed**

- Format code

**Removed**

- Remove caveat from documentation because it no longer applies

= 1.0.3 =

**Added**

- Add more icons

= 1.0.2 =

**Fixed**

- Fix undefined index

= 1.0.1 =

**Fixed**

- Add icons to `icons/`. The directory was empty on the WordPress plugin repository.

= 1.0.0 =

== Upgrade Notice ==

= 2.0.0 =

FA WP Admin Icons v2.0.0 supports Font Awesome 5!
