<?php
/**
 * Dimas Them initial.
 * => Include and Instance main group classes base Platform, Core, Module and Addons classes.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Dimas
 */

use Dimas\Dimas_Woocommerce;

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

		require_once get_template_directory() . '/inc/class-dimas-autoloader.php';

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

		// Setup.
		$this->get( 'autoload' );
		$this->get( 'setup' );
		$this->get( 'widgets' );

		$this->get( 'woocommerce' );

		$this->get( 'mobile' );

		$this->get( 'maintenance' );

		// Header.
		$this->get( 'preloader' );
		$this->get( 'topbar' );
		$this->get( 'header' );
		$this->get( 'campaigns' );

		// Page Header.
		$this->get( 'page_header' );
		$this->get( 'breadcrumbs' );

		// Layout & Style.
		$this->get( 'layout' );
		$this->get( 'dynamic_css' );

		// Comments.
		$this->get( 'comments' );

		// Footer.
		$this->get( 'footer' );

		// Modules.
		$this->get( 'search_ajax' );
		$this->get( 'newsletter' );

		// Templates.
		$this->get( 'page' );

		$this->get( 'blog' );

		// Admin.
		$this->get( 'admin' );

		// Init action.
		do_action( 'after_dimas_init' );

	}

	/**
	 * Get Dimas Class.
	 *
	 * @param mixed $class        Get class name.
	 *
	 * @since 1.0.0
	 *
	 * @return object
	 */
	public function get( $class ) {
		switch ( $class ) {
			case 'woocommerce':
				if ( class_exists( 'Dimas_Woocommerce' ) ) {
					return Dimas_Woocommerce::instance();
				}
				break;

			case 'options':
				return Dimas_Options::instance();
				break;

			case 'search_ajax':
				return Dimas_Addons_Modules_Search_Ajax::instance();
				break;

			case 'newsletter':
				return Dimas_Addons_Modules_Newsletter_Popup::instance();
				break;

			case 'mobile':
				if ( Dimas_Helper::is_mobile() ) {
					return Dimas_Mobile::instance();
				}
				break;

			default:
				$class = ucwords( $class );
				$class = 'Dimas_' . $class;
				if ( class_exists( $class ) ) {
					return $class::instance();
				}
				break;
		}

	}


	/**
	 * Setup the theme global variable.
	 *
	 * @param array $args    The array of arguments.
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

	/**
	 * Include all.
	 *
	 * @return void
	 */
	public function dimas_includes() {
		// Setup Theme =================.
		require DIMAS_INC_DIR . '/class-dimas-setup.php';
		Dimas_Setup::instance();

		// Helper functions.
		require DIMAS_INC_DIR . '/class-dimas-helper.php';

		// Block Editor Scripts.
		require DIMAS_CORE_DIR . '/admin/class-dimas-admin-block-editor.php';
		Dimas_Admin_Block_Editor::instance();

		// Theme Styles.
		require DIMAS_INC_DIR . '/class-dimas-styles.php';
		Dimas_Styles::instance();

		// Theme Scripts.
		require DIMAS_INC_DIR . '/class-dimas-scripts.php';
		Dimas_Scripts::instance();

		// SVG Icons class.
		require DIMAS_INC_DIR . '/class-dimas-svg-icon.php';

		// Custom color classes.
		require DIMAS_INC_DIR . '/class-dimas-custom-colors.php';
		new Dimas_Custom_Colors();

		// Enhance the theme by hooking into WordPress.
		require DIMAS_INC_DIR . '/class-dimas-template-funs.php';

		// Menu functions and filters.
		require DIMAS_INC_DIR . '/class-dimas-menu.php';

		// Custom template tags for the theme.
		require DIMAS_INC_DIR . '/class-dimas-template-tags.php';

		// Customizer additions.
		require DIMAS_CORE_DIR . '/class-dimas-customize.php';
		new Dimas_Customize();

		// Block Patterns.
		require DIMAS_INC_DIR . '/block-patterns.php';

		// Block Styles.
		require DIMAS_INC_DIR . '/block-styles.php';

		// Notice.
		require DIMAS_INC_DIR . '/class-dimas-notice.php';
		Dimas_Notice::instance()->add_notice( 'warning', 'This is best.', );

		// Dark Mode.
		require_once DIMAS_INC_DIR . '/class-dimas-dark-mode.php';
		new Dimas_Dark_Mode();

		// Loading Addons.
		require_once DIMAS_ADDONS_DIR . '/class-dimas-addons-plugin.php';
		Dimas_Addons::instance();

	}
}
