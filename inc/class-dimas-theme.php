<?php
/**
 * Dimas Them initial.
 * => Include and Instance main group classes base Platform, Core, Module and Addons classes.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Dimas
 */

namespace Dimas;

use Dimas\Woocommerce;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


/**
 * Dimas theme init
 */
final class Theme {
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

		// auto include classes.
		require_once DIMAS_INC_DIR . '/class-dimas-auto-loader.php';

		// create classes.
		$this->init();

		if ( is_admin() ) {
			// require_once DIMAS_INC_DIR . '/libs/class-tgm-plugin-activation.php';
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

		/**
		 * Setup popular components ===============.
		 */
		$this->get( 'auto-loader' );

		$this->get( 'styles' );
		$this->get( 'scripts' );

		$this->get( 'setup' );

		/**
		 * Framework init components ==============.
		 */
		$this->get( 'framework/template-function' );
		$this->get( 'framework/template-tag' );
		$this->get( 'framework/notice' );

		/**
		 * Core init components =====.
		 */
		$this->get( 'core/core-init' );

		/**
		 * Addons init components ====.
		 */
		$this->get( 'addons/addons-init' );

		// Init action.
		do_action( 'after_dimas_init' );

	}

	/**
	 * Convert file name into Class name.
	 *
	 * @param string $file    The file name with format - sperate.
	 * @return string
	 */
	public function file_to_class( $file ) {

		$file_parts = explode( '-', $file );
		$num_parts  = count( $file_parts );

		for ( $i = 0; $i < $num_parts; $i++ ) {
			$file_parts[ $i ] = ucwords( $file_parts[ $i ] );
		}

		$class_name = implode( '_', $file_parts );

		return $class_name;
	}

	/**
	 * Call class with namespace.
	 *
	 * @param string $class       The class name need init.
	 * @param string $namespace   The namespace of class.
	 * @return void
	 */
	public function create_object( $class, $namespace ) {

		$class = $this->file_to_class( $class );
		$class = $namespace . $class;

		if ( class_exists( $class ) ) {
			return $class::instance();
		} else {
			echo '<br/>' . esc_html__( '[Dimas] Not found the class: ', 'dimas' ) . esc_html( $class );
		}
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
	public function get( $slug_class ) {

		// get space in class.
		$space_parts  = explode( '/', $slug_class );
		$number_parts = count( $space_parts );

		if ( 1 === $number_parts ) {
			$space = 'dimas';
			$class = $slug_class;
		} else {
			$space = $space_parts[0];
			$class = $space_parts[ $number_parts - 1 ];
		}

		// namespace by space when get class.
		$namespace_array = array(
			'dimas'     => '\Dimas\\',
			'addons'    => '\Dimas\Addons\\',
			'core'      => '\Dimas\Core\\',
			'framework' => '\Dimas\Framework\\',
		);

		$namespace = $space;
		if ( array_key_exists( $space, $namespace_array ) ) {
			$namespace = $namespace_array[ $space ];
		}

		$this->create_object( $class, $namespace );
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
		Setup::instance();

		// Helper functions.
		require DIMAS_INC_DIR . '/class-dimas-helper.php';

		// Block Editor Scripts.
		require DIMAS_CORE_DIR . '/admin/class-dimas-admin-block-editor.php';
		Admin_Block_Editor::instance();

		// Theme Styles.
		require DIMAS_INC_DIR . '/class-dimas-styles.php';
		Styles::instance();

		// Theme Scripts.
		require DIMAS_INC_DIR . '/class-dimas-scripts.php';
		Scripts::instance();

		// SVG Icons class.
		require DIMAS_INC_DIR . '/class-dimas-svg-icon.php';

		// Custom color classes.
		require DIMAS_INC_DIR . '/class-dimas-custom-colors.php';
		new Custom_Colors();

		// Enhance the theme by hooking into WordPress.
		require DIMAS_INC_DIR . '/class-dimas-template-funs.php';

		// Menu functions and filters.
		require DIMAS_INC_DIR . '/class-dimas-menu.php';

		// Custom template tags for the theme.
		require DIMAS_INC_DIR . '/class-dimas-template-tags.php';

		// Customizer additions.
		require DIMAS_CORE_DIR . '/class-dimas-customize.php';
		new Customize();

		// Block Patterns.
		require DIMAS_INC_DIR . '/block-patterns.php';

		// Block Styles.
		require DIMAS_INC_DIR . '/block-styles.php';

		// Notice.
		require DIMAS_INC_DIR . '/class-dimas-notice.php';
		Notice::instance()->add_notice( 'warning', 'This is best.', );

		// Dark Mode.
		require_once DIMAS_INC_DIR . '/class-dimas-dark-mode.php';
		new Dark_Mode();

		// Loading Addons.
		require_once DIMAS_ADDONS_DIR . '/class-dimas-addons-plugin.php';
		Addons::instance();

	}
}
