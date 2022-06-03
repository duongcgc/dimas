<?php
/**
 * Dimas init
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Dimas
 */

namespace Dimas;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


/**
 * Dimas theme init
 */
final class Dimas_Theme {
	/**
	 * Instance
	 *
	 * @var $instance
	 */
	private static $instance = null;

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
		require_once get_template_directory() . '/inc/class-dimas-autoload.php';
		require_once get_template_directory() . '/inc/libs/class-mobile_detect.php';
		if ( is_admin() ) {
			require_once get_template_directory() . '/inc/libs/class-tgm-plugin-activation.php';
		}
	}

	/**
	 * Hooks to init
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function init() {
		// Before init action.
		do_action( 'before_dimas_init' );

		// Setup
		$this->get( 'autoload' );
		$this->get( 'setup' );
		$this->get( 'widgets' );

		$this->get( 'woocommerce' );

		$this->get( 'mobile' );

		$this->get( 'maintenance' );

		// Dimas_Header
		$this->get( 'preloader' );
		$this->get( 'topbar' );
		$this->get( 'header' );
		$this->get( 'campaigns' );

		// Dimas_Page Dimas_Header
		$this->get( 'page_header' );
		$this->get( 'breadcrumbs' );

		// Dimas_Layout & Style
		$this->get( 'layout' );
		$this->get( 'dynamic_css' );

		// Dimas_Comments
		$this->get( 'comments' );

		//Dimas_Footer
		$this->get( 'footer' );

		// Modules
		$this->get( 'search_ajax' );
		$this->get( 'newsletter' );

		// Templates
		$this->get( 'page' );

		$this->get( 'blog' );

		// Admin
		$this->get( 'admin' );

		// Init action.
		do_action( 'after_dimas_init' );

	}

	/**
	 * Get Dimas Class.
	 *
	 * @since 1.0.0
	 *
	 * @return object
	 */
	public function get( $class ) {
		switch ( $class ) {
			case 'woocommerce':
				if ( class_exists( 'Dimas_WooCommerce' ) ) {
					return Dimas_WooCommerce::instance();
				}
				break;

			case 'options':
				return Dimas_Options::instance();
				break;

			case 'search_ajax':
				return \Dimas\Modules\Search_Ajax::instance();
				break;

			case 'newsletter':
				return \Dimas\Modules\Newsletter_Popup::instance();
				break;

			case 'mobile':
				if ( Dimas_Helper::is_mobile() ) {
					return \Dimas\Mobile::instance();
				}
				break;

			default :
				$class = ucwords( $class );
				$class = "\Dimas\\" . $class;
				if ( class_exists( $class ) ) {
					return $class::instance();
				}
				break;
		}

	}


	/**
	 * Setup the theme global variable.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function setup_prop( $args = array() ) {
		$default = array(
			'modals' => array(),
		);

		if ( isset( $GLOBALS['dimas'] ) ) {
			$default = array_merge( $default, $GLOBALS['dimas'] );
		}

		$GLOBALS['dimas'] = wp_parse_args( $args, $default );
	}

	/**
	 * Get a propery from the global variable.
	 *
	 * @param string $prop Prop to get.
	 * @param string $default Default if the prop does not exist.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_prop( $prop, $default = '' ) {
		self::setup_prop(); // Ensure the global variable is setup.

		return isset( $GLOBALS['dimas'], $GLOBALS['dimas'][ $prop ] ) ? $GLOBALS['dimas'][ $prop ] : $default;
	}

	/**
	 * Sets a property in the global variable.
	 *
	 * @param string $prop Prop to set.
	 * @param string $value Value to set.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function set_prop( $prop, $value = '' ) {
		if ( ! isset( $GLOBALS['dimas'] ) ) {
			self::setup_prop();
		}

		if ( ! isset( $GLOBALS['dimas'][ $prop ] ) ) {
			$GLOBALS['dimas'][ $prop ] = $value;

			return;
		}

		if ( is_array( $GLOBALS['dimas'][ $prop ] ) ) {
			if ( is_array( $value ) ) {
				$GLOBALS['dimas'][ $prop ] = array_merge( $GLOBALS['dimas'][ $prop ], $value );
			} else {
				$GLOBALS['dimas'][ $prop ][] = $value;
				array_unique( $GLOBALS['dimas'][ $prop ] );
			}
		} else {
			$GLOBALS['dimas'][ $prop ] = $value;
		}
	}
}
