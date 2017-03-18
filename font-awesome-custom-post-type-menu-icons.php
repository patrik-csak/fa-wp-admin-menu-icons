<?php
/*
 * Plugin Name: Font Awesome Custom Post Type Menu Icons
 * Plugin URI:
 * Description:
 * Version: 0.1.0
 * Author: Patrik Csak
 * Author URI: patrikcsak.com
 * License: GPL
 *
 * Font Awesome Custom Post Type Menu Icons is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 2 of the License, or any later version.
 *
 * Font Awesome Custom Post Type Menu Icons is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
 * PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with Font Awesome Custom
 * Post Type Menu Icons. If not, see https://www.gnu.org/licenses/gpl.html.
 */

namespace FACPTMI;

if ( ! defined( 'WPINC' ) ) {
	die;
}

function plugin_activation() {
}

register_activation_hook( __FILE__, __NAMESPACE__ . '\\plugin_activation' );

function plugin_deactivation() {
}

register_deactivation_hook( __FILE__, __NAMESPACE__ . '\\plugin_deactivation' );
