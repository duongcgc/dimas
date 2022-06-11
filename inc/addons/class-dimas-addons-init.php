<?php
/**
 * Dimas Addons init
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
	}

	/**
	 * Load Templates
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function load_templates() {
		$this->includes();
		spl_autoload_register( '\Dimas\Addons\Auto_Loader::load' );

		$this->add_actions();
	}

	/**
	 * Includes files
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function includes() {
		// Auto Loader
		require_once DIMAS_ADDONS_DIR . 'class-dm-addons-autoloader.php';
		Addons_Auto_Loader::register(
			array(
				'Dimas\Addons\Helper'          => DIMAS_ADDONS_DIR . '/class-dm-addons-helper.php',
				'Dimas\Addons\Widgets'         => DIMAS_ADDONS_DIR . '/widgets/class-dm-addons-widgets.php',
				'Dimas\Addons\Modules'         => DIMAS_ADDONS_DIR . 'modules/modules.php',
				'Dimas\Addons\Elementor'       => DIMAS_ADDONS_DIR . '/elementor/class-dm-elementor.php',
				'Dimas\Addons\Product_Brands'  => DIMAS_ADDONS_DIR . '/backend/class-dm-addons-product-brand.php',
				'Dimas\Addons\Product_Authors' => DIMAS_ADDONS_DIR . '/backend/class-dm-addons-product-author.php',
				'Dimas\Addons\Importer'        => DIMAS_ADDONS_DIR . '/backend/class-dm-addons-importer.php',
			)
		);
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

		$this->get( 'product_brand' );
		$this->get( 'product_author' );

		$this->get( 'importer' );

		// Elmentor.
		$this->get( 'elementor' );

		// Modules.
		$this->get( 'modules' );

		// Widgets.
		$this->get( 'widgets' );

		add_action( 'after_setup_theme', array( $this, 'addons_init' ), 20 );

		// Init action.
		do_action( 'after_dimas_init' );
	}

	/**
	 * Get Dimas Addons Class instance
	 *
	 * @since 1.0.0
	 *
	 * @return object
	 */
	public function get( $class ) {
		switch ( $class ) {
			case 'product_brand':
				if ( class_exists( 'WooCommerce' ) ) {
					return \Dimas\Addons\Product_Brands::instance();
				}
				break;
			case 'product_author':
				if ( class_exists( 'WooCommerce' ) ) {
					return \Dimas\Addons\Product_Authors::instance();
				}
				break;
			case 'importer':
				if ( is_admin() ) {
					return \Dimas\Addons\Importer::instance();
				}
				break;
			case 'elementor':
				if ( did_action( 'elementor/loaded' ) ) {
					return \Dimas\Addons\Elementor::instance();
				}
				break;

			case 'modules':
				return \Dimas\Addons\Modules::instance();
				break;

			case 'widgets':
				return \Dimas\Addons\Widgets::instance();
				break;
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
