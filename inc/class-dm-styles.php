<?php
/**
 * Styles functions and definitions.
 *
 * @package Dimas
 */

namespace Dimas;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Styles initial
 */
class DM_Styles {
	/**
	 * Instance
	 *
	 * @var $instance
	 */
	protected static $instance = null;

	/**
	 * Initiator
	 *
	 * @since 1.0.0
	 * @return object
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Instantiate the object.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'dimas_non_latin_languages' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'dimas_styles' ) );
	}

	/**
	 * Enqueue styles.
	 *
	 * @since Dimas 1.0
	 *
	 * @return void
	 */
	public function dimas_styles() {
		// Note, the is_IE global variable is defined by WordPress and is used
		// to detect if the current browser is internet explorer.
		global $is_IE;
		if ( $is_IE ) {
			// If IE 11 or below, use a flattened stylesheet with static values replacing CSS Variables.
			wp_enqueue_style( 'dimas-style', get_template_directory_uri() . '/assets/css/ie.css', array(), wp_get_theme()->get( 'Version' ) );
		} else {
			// If not IE, use the standard stylesheet.
			wp_enqueue_style( 'dimas-style', get_template_directory_uri() . '/style.css', array(), wp_get_theme()->get( 'Version' ) );
		}

		// RTL styles.
		wp_style_add_data( 'dimas-style', 'rtl', 'replace' );

		// Print styles.
		wp_enqueue_style( 'dimas-print-style', get_template_directory_uri() . '/assets/css/print.css', array(), wp_get_theme()->get( 'Version' ), 'print' );

		// Threaded comment reply styles.
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

	}

	/**
	 * Enqueue non-latin language styles.
	 *
	 * @since Dimas 1.0
	 *
	 * @return void
	 */
	public function dimas_non_latin_languages() {
		$custom_css = \DM_Fw_Template_Function::instance()->dimas_get_non_latin_css( 'front-end' );

		if ( $custom_css ) {
			wp_add_inline_style( 'dimas-style', $custom_css );
		}
	}
}
