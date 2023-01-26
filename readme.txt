=== FA WP Admin Menu Icons ===
Contributors: ptrkcsk
Donate link: https://www.buymeacoffee.com/patrikcsak
Tags: fontawesome, icon, icons, custom
Requires at least: 4.4
Tested up to: 6.1
Requires PHP: 8.0
Stable tag: 7.0.0
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.en.html

Use Font Awesome icons for custom post types and custom menu pages.

== Description ==

[View on GitHub](https://github.com/patrik-csak/fa-wp-admin-menu-icons) for better documentation

**FA WP Admin Menu Icons** allows you to use Font Awesome icons for WordPress custom post types and custom menu pages by passing the Font Awesome class string, just like using Font Awesome on the front end

Here's an example:

    register_post_type( 'custom_post_type', [
        //...
        'menu_icon' => 'fas fa-thumbs-up',
        //...
    ] );

== Usage ==

= `register_post_type()` =

To use a Font Awesome icon for your custom post type with [`register_post_type()`](http://developer.wordpress.org/reference/functions/register_post_type/), use a Font Awesome class string for the `$args['menu_icon]` parameter:

    register_post_type( 'custom_post_type', [
        //...
        'menu_icon' => 'fa-solid fa-thumbs-up',
        //...
    ] );

= `add_menu_page()` =

To use a Font Awesome icon for your custom menu page with [`add_menu_page()`](http://developer.wordpress.org/reference/functions/add_menu_page/), use a Font Awesome class string for the `$icon_url` parameter:

    add_menu_page(
        page_title: 'Custom Menu Page',
        menu_title: 'Custom Menu Page',
        capability: 'manage_options',
        menu_slug: 'custom_menu_page',
        icon_url: 'fa-solid fa-thumbs-up',
    );

= Custom Post Type UI plugin =

To use a Font Awesome icon with the [Custom Post Type UI plugin](https://wordpress.org/plugins/custom-post-type-ui/), use a Font Awesome class string for the **Menu Icon** field when adding or editing a Post Type

== Installation ==

= WordPress Admin Dashboard =

In your WordPress Admin Dashboard, go to **Plugins > Add New**, search for 'fa wp admin menu icons', then click **Install Now**

Read more about [automatic plugin installation with the WordPress Admin Dashboard](https://wordpress.org/support/article/managing-plugins/#automatic-plugin-installation-1)

= WP-CLI =

Install with WP-CLI by running the following command:

    wp plugin install fa-wp-admin-menu-icons --activate

= Install with Composer =

Install with Composer by running the following command:

    composer require wpackagist-plugin/fa-wp-admin-menu-icons

= Install with Git =

Install with Git by running the following commands:

    cd <wp-content>/plugins
    git clone git@github.com:patrik-csak/fa-wp-admin-menu-icons.git

== Caveats ==

FA WP Admin Menu Icons only supports Font Awesome's [free icons](https://fontawesome.com/v5.15/icons?d=gallery&p=2&m=free)

== Screenshots ==

1. Screenshot of WordPress Admin Dashboard menu with an example custom post type and custom menu page which use the Font Awesome flag icon
2. Screenshot of Custom Post Type UI Menu Icon field populated with 'fa-solid fa-thumbs-up'

== Changelog ==

= 7.0.0 =

**Changed**

- Require PHP v8.0+

**Removed**

- Support for Font Awesome v4 icons
- `Fawpami\\faVersion` filter

= 6.0.0 =

**Changed**

- Require PHP v7.4+
- Test with WordPress v5.9

= 5.0.1 =

**Changed**

- Upgrade Font Awesome to v5.15.4
- Test with WordPress v5.8.1

= 5.0.0 =

**Changed**

- Upgrade Font Awesome to v5.15.1
- Test with WordPress v5.5.3
- Drop support for PHP v7.2

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

= 7.0.0 =

FA WP Admin Menu Icons v7 adds support for Font Awesome v6 icons, and drops support for PHP versions older than 8.0

= 2.0.0 =

FA WP Admin Menu Icons v2.0.0 supports Font Awesome 5!
