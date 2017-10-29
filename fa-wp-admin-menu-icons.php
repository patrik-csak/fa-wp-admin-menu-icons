<?php
/*
 * Plugin Name: FA WP Admin Menu Icons
 * Plugin URI: https://github.com/ptrkcsk/font-awesome-wordpress-admin-menu-icons
 * Description:
 * Version: 1.0.3
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

namespace FAWPAMI;

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Get the icon name from a string formatted as 'fa-<icon>'
 *
 * @param string $fa_string String with starts with 'fa-'
 *
 * @return string
 */
function get_icon_name( $fa_string ) {
	preg_match( '/fa-(.*)/', $fa_string, $matches );

	return $matches[1];
}

/**
 * Get the path to the icon
 *
 * @param string $icon_name Name of a Font Awesome icon (not prepended with 'fa-'
 *
 * @return string
 */
function get_icon_path( $icon_name ) {
	return plugin_dir_path( __FILE__ ) . "icons/$icon_name.svg";
}

/**
 * Base64 encode the SVG and prepend with necessary code to make it usable as a data URI
 *
 * Also add fill color to the SVG
 *
 * @param string $path Path to the icon file
 *
 * @return string
 */
function get_icon_svg_data_uri( $path ) {
	$svg_contents = file_get_contents( $path );
	$svg          = new \SimpleXMLElement( $svg_contents );
	/*
	 * Add necessary fill color to make SVG display properly.
	 *
	 * Using Yoast's fill color: https://github.com/Yoast/wordpress-seo/blob/4.4/inc/class-wpseo-utils.php#L916
	 */
	$svg->addAttribute( 'style', 'fill:#82878c' );

	return 'data:image/svg+xml;base64,' . base64_encode( $svg->asXML() );
}

/**
 * Add Font Awesome icon to {@see \register_post_type()} args
 *
 * @param array $args The arguments passed to {@see \register_post_type()}
 *
 * @return array
 */
function post_type_font_awesome_icon( $args ) {
	// Does the `menu_icon` arg start with 'fa-'?
	if ( isset( $args['menu_icon'] ) && strpos( $args['menu_icon'], 'fa-' ) === 0 ) {
		$icon      = get_icon_name( $args['menu_icon'] );
		$icon_path = get_icon_path( $icon );
		if ( file_exists( $icon_path ) ) {
			$args['menu_icon'] = get_icon_svg_data_uri( $icon_path );
		} else {
			/*
			 * Couldn't find the icon, so there's nothing we can do. If we leave `menu_icon` as
			 * 'fa-<icon>', WordPress will use an image for the icon with `src` set to 'http://fa-<icon>',
			 * which we don't want.
			 *
			 * https://github.com/WordPress/WordPress/blob/4.7.3/wp-admin/menu.php#L106
			 */
			unset( $args['menu_icon'] );
		}
	}

	return $args;
}

add_filter( 'register_post_type_args', __NAMESPACE__ . '\\post_type_font_awesome_icon' );

function menu_page_font_awesome_icon( $url ) {
	if ( strpos( $url, 'fa-' ) === 0 ) {
		$icon      = get_icon_name( $url );
		$icon_path = get_icon_path( $icon );
		if ( file_exists( $icon_path ) ) {
			return get_icon_svg_data_uri( $icon_path );
		} else {
			/*
			 * Couldn't find the icon, so there's nothing we can do. Resetting the url to
			 * `dashicons-admin-generic`, because that's what WP does if you don't pass an `icon_url`
			 * parameter to `add_menu_page`
			 *
			 * https://github.com/WordPress/WordPress/blob/4.7.3/wp-admin/includes/plugin.php#L1087
			 */
			return 'dashicons-admin-generic';
		}
	} else {
		return $url;
	}
}

add_filter( 'set_url_scheme', __NAMESPACE__ . '\\menu_page_font_awesome_icon' );
