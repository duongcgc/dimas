<?php
/**
 * Dimas Core init
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Dimas
 */

namespace Dimas\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Dimas Core init
 *
 * @since 1.0.0
 */
class Core_Init {

	/**
	 * Instance
	 *
	 * @var $instance
	 */
	private static $instance;

	/**
	 * Initiator
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
	 * Instantiate the object.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'load_templates' ) );
	}

	/**
	 * Load Templates
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function load_templates() {

		// includes all core.
		$this->includes();

		// auto includes all elements of core.
		\Dimas\Core\Core_Loader::instance();

		// create all core objects.
		$this->add_actions();
	}

	/**
	 * List components of core.
	 *
	 * @var array
	 */
	private $core_classes_files = array(
		'Dimas\Core\Helper'              => DIMAS_CORE_DIR . '/class-dimas-helper.php',
		'Dimas\Core\CPT_Register'        => DIMAS_CORE_DIR . '/class-dimas-cpt-register.php',
		'Dimas\Core\Customizer\Settings' => DIMAS_CORE_DIR . '/customizer/class-dimas-customize-settings.php',
		'Dimas\Core\Customizer\Panels'   => DIMAS_CORE_DIR . '/customizer/class-dimas-customize-panels.php',
		'Dimas\Core\Customizer\Sections' => DIMAS_CORE_DIR . '/customizer/class-dimas-customize-sections.php',
		'Dimas\Core\Customizer\Fields'   => DIMAS_CORE_DIR . '/customizer/class-dimas-customize-fields.php',
		'Dimas\Core\Customizer'          => DIMAS_CORE_DIR . '/class-dimas-customizer.php',
		// 'Dimas\Core\Metaboxes_Register'  => DIMAS_CORE_DIR . '/class-dimas-metaboxes.php',.
		// 'Dimas\Core\Options'             => DIMAS_CORE_DIR . '/class-dimas-options.php',.
	);

	/**
	 * List classes components of core.
	 *
	 * @var array
	 */
	private $core_classes_names = array(
		'helper'              => 'Dimas\Core\Helper',
		'cpt-register'        => 'Dimas\Core\CPT_Register',
		'customizer/settings' => 'Dimas\Core\Customizer\Settings',
		'customizer/panels'   => 'Dimas\Core\Customizer\Panels',
		'customizer/sections' => 'Dimas\Core\Customizer\Sections',
		'customizer/fields'   => 'Dimas\Core\Customizer\Fields',
		'customizer'          => 'Dimas\Core\Customizer',
		// 'metaboxes'           => 'Dimas\Core\Metaboxes_Register',.
		// 'options'             => 'Dimas\Core\Options',.
	);

	/**
	 * Includes files.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function includes() {
		// Auto Loader core.
		require_once DIMAS_CORE_DIR . '/class-dimas-core-loader.php';
		require_once DIMAS_CORE_DIR . '/class-dimas-cpt-abstract.php';

		Core_Loader::register( $this->core_classes_files );
	}

	/**
	 * Add Actions
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	protected function add_actions() {
		// Before init action.
		do_action( 'before_dimas_init' );

		$this->get( 'helper' );

		$this->get( 'cpt-register' );

		// Customizer.
		$this->get( 'customizer/settings' );
		$this->get( 'customizer/panels' );
		$this->get( 'customizer/sections' );
		$this->get( 'customizer/fields' );

		// Metabos.
		$this->get( 'metaboxes' );

		// Options.
		$this->get( 'options' );

		add_action( 'after_setup_theme', array( $this, 'core_init' ), 20 );

		// Init action.
		do_action( 'after_dimas_init' );
	}

	/**
	 * Get Dimas Core Class instance.
	 *
	 * @since 1.0.0
	 *
	 * @param string $class The class name.
	 *
	 * @return object
	 */
	public function get( $class ) {

		$class_name = $this->core_classes_names[ $class ];

		if ( array_key_exists( $class, $this->core_classes_names ) ) {
			return $class_name::instance();
		}

	}

	/**
	 * Get Dimas Core Language
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function core_init() {
		load_plugin_textdomain( 'dimas', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
	}
}
