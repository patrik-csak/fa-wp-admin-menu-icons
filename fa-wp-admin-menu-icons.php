<?php
/*
 * Plugin Name: FA WP Admin Menu Icons
 * Plugin URI: https://github.com/patrik-csak/font-awesome-wordpress-admin-menu-icons
 * Description: Use Font Awesome icons for custom post types and custom menu pages.
 * Version: 8.2.0
 * Author: Patrik Csak
 * Author URI: https://github.com/patrik-csak
 * License: GPL
 *
 * FA WP Admin Menu Icons is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or any later
 * version.
 *
 * FA WP Admin Menu Icons is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License along with
 * FA WP Admin Menu Icons. If not, see https://www.gnu.org/licenses/gpl.html.
 */

namespace Fawpami;

if (!defined('WPINC')) {
    die;
}

if (!is_admin()) {
    return;
}

require_once 'src/Fawpami.php';

add_action('plugins_loaded', [Fawpami::class, 'addHooks']);
