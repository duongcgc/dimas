<?php
/**
 * Dimas Addons init
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Dimas
 */

namespace Dimas\Addons;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Dimas Addons init
 *
 * @since 1.0.0
 */
class Addons_Init {

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
		add_action( 'plugins_loaded', array( $this, 'load_templates' ) );
		echo 'Addons Init';
	}

	/**
	 * Load Templates
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function load_templates() {

		// includes all addons.
		$this->includes();

		// auto includes all elements of addons.
		spl_autoload_register( '\Dimas\Addons\Addons_Auto_Loader::load' );

		// create all addons objects.
		$this->add_actions();
	}

	/**
	 * List components of addons.
	 */
	private $addons_classes_files = array(
		'Dimas\Addons\Elementor'  => DIMAS_ADDONS_DIR . '/class-dimas-addons-elementor.php',
		'Dimas\Addons\Helper'     => DIMAS_ADDONS_DIR . '/class-dimas-addons-helper.php',
		'Dimas\Addons\Shortcodes' => DIMAS_ADDONS_DIR . '/class-dimas-addons-shortcodes.php',
		'Dimas\Addons\Widgets'    => DIMAS_ADDONS_DIR . '/class-dimas-addons-widgets.php',
		'Dimas\Addons\Woocomerce' => DIMAS_ADDONS_DIR . '/class-dimas-addons-woocommerce.php',
	);
	/**
	 * List classes components of addons.
	 *
	 * @var array
	 */
	private $addons_classes_names = array(
		'elementor'  => 'Dimas\Addons\Elementor',
		'helper'     => 'Dimas\Addons\Helper',
		'shortcodes' => 'Dimas\Addons\Shortcodes',
		'widgets'    => 'Dimas\Addons\Widgets',
		'woocomerce' => 'Dimas\Addons\Woocomerce',
	);

	/**
	 * Includes files.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function includes() {
		// Auto Loader addons.
		require_once DIMAS_ADDONS_DIR . 'class-dimas-addons-autoloader.php';
		Addons_Auto_Loader::register(
			$this->addons_classes_files
		);
	}

	/**
	 * Add Actions.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	protected function add_actions() {
		// Before init action.
		do_action( 'before_dimas_init' );

		// Elmentor.
		$this->get( 'elementor' );

		// Helper.
		$this->get( 'helper' );

		// Shortcodes.
		$this->get( 'shortcodes' );

		// Widgets.
		$this->get( 'widgets' );

		add_action( 'after_setup_theme', array( $this, 'addons_init' ), 20 );

		// Init action.
		do_action( 'after_dimas_init' );
	}

	/**
	 * Get Dimas Addons Class instance.
	 *
	 * @since 1.0.0
	 *
	 * @return object
	 */
	public function get( $class ) {
		$class_name = $this->addons_classes_names[ $class ];

		if ( array_key_exists( $class, $this->addons_classes_files ) ) {
			if ( class_exists( $class_name ) ) {
				echo $class_name;
				return $class_name::instance();
			} else {
				echo '<br/>' . esc_html__( 'Not found the class: ', 'dimas' ) . esc_url( $class_name );
			}
		}
	}

	/**
	 * Get Dimas Addons Language
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function addons_init() {
		load_plugin_textdomain( 'dimas', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
	}
}
