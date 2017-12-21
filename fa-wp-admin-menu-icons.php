<?php
/*
 * Plugin Name: FA WP Admin Menu Icons
 * Plugin URI: https://github.com/ptrkcsk/font-awesome-wordpress-admin-menu-icons
 * Description:
 * Version: 2.0.0
 * Author: Patrik Csak
 * Author URI: patrikcsak.com
 * License: GPL
 *
 * FA WP Admin Menu Icons is free software: you can redistribute it and/or modify it under the terms
 * of the GNU General Public License as published by the Free Software Foundation, either version 2
 * of the License, or any later version.
 *
 * FA WP Admin Menu Icons is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR
 * PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with FA WP Admin Menu
 * Icons. If not, see https://www.gnu.org/licenses/gpl.html.
 */

namespace Fawpami;

if ( ! defined('WPINC')) {
    die;
}

if (is_admin()) {
    require_once 'src/Fawpami.php';
    Fawpami::addHooks();
}
