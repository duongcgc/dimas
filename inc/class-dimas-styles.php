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
class Styles {
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

		// Bootstrap styles.
		wp_enqueue_style( 'bootstrap-style', get_template_directory_uri() . '/assets/addons/css/bootstrap/bootstrap.min.css', array(), wp_get_theme()->get( 'Version' ) );

		// Animate styles.
		wp_enqueue_style( 'animate-style', get_template_directory_uri() . '/assets/addons/css/animate/animate.min.css', array(), wp_get_theme()->get( 'Version' ) );

		// Animsition styles.
		wp_enqueue_style( 'animsition-style', get_template_directory_uri() . '/assets/addons/css/animsition/animsition.min.css', array(), wp_get_theme()->get( 'Version' ) );
		wp_enqueue_style( 'animsition-style', get_template_directory_uri() . '/assets/addons/css/animsition/preload.min.css', array(), wp_get_theme()->get( 'Version' ) );

		// Home styles.
		if ( is_front_page() ) {

			// pagepiling style.
			wp_enqueue_style( 'pagepiling-style', get_template_directory_uri() . '/assets/addons/css/pagepiling/pagepiling.min.css', array(), wp_get_theme()->get( 'Version' ) );

			// main style.
			wp_enqueue_style( 'home-style', get_template_directory_uri() . '/assets/css/home.css', array(), wp_get_theme()->get( 'Version' ) );
		}

		// Project styles.
		if ( is_singular( 'project' ) ) {

			// pagepiling style.
			wp_enqueue_style( 'pagepiling-style', get_template_directory_uri() . '/assets/addons/css/pagepiling/pagepiling.min.css', array(), wp_get_theme()->get( 'Version' ) );

			// main style.
			wp_enqueue_style( 'project-style', get_template_directory_uri() . '/assets/css/project-single.css', array(), wp_get_theme()->get( 'Version' ) );
		}

		// Blog Post styles.
		if ( is_singular( 'post' ) ) {

			// fancybox style.
			wp_enqueue_style( 'fancybox-style', get_template_directory_uri() . '/assets/addons/css/fancybox/fancybox.css', array(), wp_get_theme()->get( 'Version' ) );

			// main style.
			wp_enqueue_style( 'blog-post-style', get_template_directory_uri() . '/assets/css/blog-single.css', array(), wp_get_theme()->get( 'Version' ) );

		}

		// Blog Archive styles.
		if ( is_category() ) {

			// main style.
			wp_enqueue_style( 'blog-archive-style', get_template_directory_uri() . '/assets/css/blog-archive.css', array(), wp_get_theme()->get( 'Version' ) );
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
		$custom_css = \Dimas\Temp_Funs::instance()->dimas_get_non_latin_css( 'front-end' );

		if ( $custom_css ) {
			wp_add_inline_style( 'dimas-style', $custom_css );
		}
	}
}
