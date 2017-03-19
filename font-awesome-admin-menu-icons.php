<?php
/*
 * Plugin Name: Font Awesome Admin Menu Icons
 * Plugin URI:
 * Description:
 * Version: 0.1.0
 * Author: Patrik Csak
 * Author URI: patrikcsak.com
 * License: GPL
 *
 * Font Awesome Admin Menu Icons is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 2 of the License, or any later version.
 *
 * Font Awesome Admin Menu Icons is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
 * PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with Font Awesome Custom
 * Post Type Menu Icons. If not, see https://www.gnu.org/licenses/gpl.html.
 */

namespace FAAMI;

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Add Font Awesome icon to {@see \register_post_type()} args
 *
 * @param array $args The arguments passed to {@see \register_post_type()}
 *
 * @return array
 */
function add_fa_icon( $args ) {
	// Does the `menu_icon` arg start with 'fa-'?
	if ( strpos( $args['menu_icon'], 'fa-' ) === 0 ) {
		// Get the icon name
		preg_match( '/fa-(.*)/', $args['menu_icon'], $matches );
		$icon      = $matches[1];
		$icon_path = plugin_dir_path( __FILE__ ) . "icons/$icon.svg";
		if ( file_exists( $icon_path ) ) {
			$svg_contents = file_get_contents( $icon_path );
			$svg          = new \SimpleXMLElement( $svg_contents );
			/**
			 * Add necessary fill color to make SVG display properly
			 *
			 * Using Yoast's fill color:
			 * @see https://github.com/Yoast/wordpress-seo/blob/4.4/inc/class-wpseo-utils.php#L916
			 */
			$svg->addAttribute( 'style', 'fill:#82878c' );
			$args['menu_icon'] = 'data:image/svg+xml;base64,' . base64_encode( $svg->asXML() );
		} else {
			/**
			 * Couldn't find the icon, so there's nothing we can do. If we leave `menu_icon` as
			 * 'fa-<icon>', WordPress will use an image for the icon with `src` set to 'http://fa-<icon>',
			 * which we don't want.
			 *
			 * @see https://github.com/WordPress/WordPress/blob/4.7.3/wp-admin/menu.php#L106
			 */
			unset( $args['menu_icon'] );
		}
	}

	return $args;
}

add_filter( 'register_post_type_args', __NAMESPACE__ . '\\add_fa_icon' );
