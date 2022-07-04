<?php
/**
 * Dimas helper functions and definitions.
 *
 * @package Dimas
 */

namespace Dimas\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Core Helper initial
 */
class Helper {
	/**
	 * Post ID
	 *
	 * @var $post_id
	 */
	protected static $post_id = null;

	/**
	 * Header Layout
	 *
	 * @var $header_layout
	 */
	protected static $header_layout = null;

	/**
	 * Instance.
	 *
	 * @var $instance
	 */
	private static $instance;

	/**
	 * Initiator.
	 *
	 * @since 1.0.0
	 * @return object
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}


	/**
	 * Install plugin url function
	 *
	 * @param string $plugin_slug     The plugin slug.
	 * @return string
	 */
	public static function get_install_plugin_url( $plugin_slug ) {

		$action = 'install-plugin';
		$slug   = $plugin_slug;
		$url    = '';

		$url = wp_nonce_url(
			add_query_arg(
				array(
					'action' => $action,
					'plugin' => $slug,
				),
				admin_url( 'update.php' )
			),
			$action . '_' . $slug
		);

		return $url;
	}

	/**
	 * Get font url
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function get_fonts_url() {
		$fonts_url = '';

		/*
		 Translators: If there are characters in your language that are not
		* supported by Montserrat, translate this to 'off'. Do not translate
		* into your own language.
		*/
		if ( 'off' !== _x( 'on', 'Jost font: on or off', 'dimas' ) ) {
			$font_families[] = 'Jost:200,300,400,500,600,700,800';
		}

		if ( ! empty( $font_families ) ) {
			$query_args = array(
				'family' => urlencode( implode( '|', $font_families ) ),
				'subset' => urlencode( 'latin,latin-ext' ),
			);

			$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
		}

		return esc_url_raw( $fonts_url );
	}

	/**
	 * Content limit
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	/**
	 * Undocumented function
	 *
	 * @param int    $num_words The number of words to limit on content.
	 * @param string $more The string end of content.
	 * @param string $content The content.
	 * @return string
	 */
	public static function get_content_limit( $num_words, $more = '&hellip;', $content = '' ) {
		if ( class_exists( '\Dimas\Addons\Helper' ) && method_exists( '\Dimas\Addons\Helper', 'get_content_limit' ) ) {
			return \Dimas\Addons\Helper::get_content_limit( $num_words, $more, $content );
		}
		$content = empty( $content ) ? get_the_excerpt() : $content;

		return $content;
	}

	/**
	 * Check elementor actived.
	 *
	 * @return boolean
	 */
	public static function dimas_is_elementor_activated() {
		return function_exists( 'elementor_load_plugin_textdomain' );
	}

	/**
	 * Check contactform7 actived.
	 *
	 * @return boolean
	 */
	public static function dimas_is_contactform7_activated() {
		return class_exists( 'WPCF7' );
	}

	/**
	 * Check OCDI actived.
	 *
	 * @return boolean
	 */
	public static function dimas_is_one_click_import_activated() {
		return class_exists( 'OCDI_Plugin' ) ? true : false;
	}

	/**
	 * Check Mailchimp actived.
	 *
	 * @return boolean
	 */
	public static function dimas_is_mailchimp_activated() {
		return function_exists( '_mc4wp_load_plugin' );
	}

	/**
	 * Check ACF actived.
	 *
	 * @return boolean
	 */
	public static function dimas_is_acf_activated() {
		return class_exists( 'ACF' );
	}

}
