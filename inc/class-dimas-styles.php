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
			wp_enqueue_style( 'dimas-style', DIMAS_CSS_URI . '/ie.css', array(), wp_get_theme()->get( 'Version' ) );
		} else {
			// If not IE, use the standard stylesheet.
			wp_enqueue_style( 'dimas-style', get_template_directory_uri() . '/style.css', array(), wp_get_theme()->get( 'Version' ) );
		}

		// RTL styles.
		wp_style_add_data( 'dimas-style', 'rtl', 'replace' );

		// Print styles.
		wp_enqueue_style( 'dimas-print-style', DIMAS_CSS_URI . '/print.css', array(), wp_get_theme()->get( 'Version' ), 'print' );

		// Dimas styles.
		// Bootstrap styles.
		wp_enqueue_style( 'bootstrap-style', DIMAS_ADDONS_CSS_URI . '/bootstrap/bootstrap.min.css', array(), wp_get_theme()->get( 'Version' ) );

		// Animate styles.
		wp_enqueue_style( 'animate-style', DIMAS_ADDONS_CSS_URI . '/animate/animate.min.css', array(), wp_get_theme()->get( 'Version' ) );

		// Animsition styles.
		wp_enqueue_style( 'animsition-style', DIMAS_ADDONS_CSS_URI . '/animsition/animsition.min.css', array(), wp_get_theme()->get( 'Version' ) );
		wp_enqueue_style( 'animsition-style', DIMAS_ADDONS_CSS_URI . '/animsition/preload.min.css', array(), wp_get_theme()->get( 'Version' ) );

		// custom styles.
		wp_enqueue_style( 'custom', DIMAS_CSS_URI . '/custom.css', array(), wp_get_theme()->get( 'Version' ) );

		// header styles.
		wp_enqueue_style( 'header', DIMAS_CSS_URI . '/header.css', array(), wp_get_theme()->get( 'Version' ) );

		// footer styles.
		wp_enqueue_style( 'footer', DIMAS_CSS_URI . '/footer.css', array(), wp_get_theme()->get( 'Version' ) );

		( isset( $_GET['action'] ) && 'elementor' == $_GET['action'] ) ? $is_elementor_edit = true : $is_elementor_edit = false;

		if ( false == $is_elementor_edit ) {

			// Home styles.
			if ( is_front_page() ) {

				// pagepiling style.
				wp_enqueue_style( 'pagepiling-style', DIMAS_ADDONS_CSS_URI . '/pagepiling/pagepiling.min.css', array(), wp_get_theme()->get( 'Version' ) );

				// main style.
				wp_enqueue_style( 'home-style', DIMAS_CSS_URI . '/home.css', array(), wp_get_theme()->get( 'Version' ) );
			}

			// Project styles.
			if ( is_singular( 'project' ) ) {

				// pagepiling style.
				wp_enqueue_style( 'pagepiling-style', DIMAS_ADDONS_CSS_URI . '/pagepiling/pagepiling.min.css', array(), wp_get_theme()->get( 'Version' ) );

				// main style.
				wp_enqueue_style( 'project-style', DIMAS_CSS_URI . '/project-single.css', array(), wp_get_theme()->get( 'Version' ) );
			}

			// Blog Post styles.
			if ( is_singular( 'post' ) ) {

				// fancybox style.
				wp_enqueue_style( 'fancybox-style', DIMAS_ADDONS_CSS_URI . '/fancybox/fancybox.css', array(), wp_get_theme()->get( 'Version' ) );

				// main style.
				wp_enqueue_style( 'blog-post-style', DIMAS_CSS_URI . '/blog-single.css', array(), wp_get_theme()->get( 'Version' ) );

			}

			// Blog Archive styles.
			if ( is_category() ) {

				// main style.
				wp_enqueue_style( 'blog-archive-style', DIMAS_CSS_URI . '/blog-archive.css', array(), wp_get_theme()->get( 'Version' ) );
			}
		}

		do_action( 'dimas_after_enqueue_style' );

	}

}
