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
class Addons {

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
		require_once RAZZI_ADDONS_DIR . 'class-razzi-addons-autoloader.php';
		\Dimas\Addons\Auto_Loader::register( [
			'Dimas\Addons\Helper'         => RAZZI_ADDONS_DIR . 'class-razzi-addons-helper.php',
			'Dimas\Addons\Widgets'        => RAZZI_ADDONS_DIR . 'inc/widgets/class-razzi-addons-widgets.php',
			'Dimas\Addons\Modules'        => RAZZI_ADDONS_DIR . 'modules/modules.php',
			'Dimas\Addons\Elementor'      => RAZZI_ADDONS_DIR . 'inc/elementor/class-razzi-elementor.php',
			'Dimas\Addons\Product_Brands' => RAZZI_ADDONS_DIR . 'inc/backend/class-razzi-addons-product-brand.php',
			'Dimas\Addons\Product_Authors'=> RAZZI_ADDONS_DIR . 'inc/backend/class-razzi-addons-product-author.php',
			'Dimas\Addons\Importer'       => RAZZI_ADDONS_DIR . 'inc/backend/class-razzi-addons-importer.php',
		] );
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
		do_action( 'before_razzi_init' );

		$this->get( 'product_brand' );
		$this->get( 'product_author' );

		$this->get( 'importer' );

		// Elmentor
		$this->get( 'elementor' );

		// Modules
		$this->get( 'modules' );

		// Widgets
		$this->get( 'widgets' );

		add_action( 'after_setup_theme', array( $this, 'addons_init' ), 20 );

		// Init action.
		do_action( 'after_razzi_init' );
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
	function addons_init() {
		load_plugin_textdomain( 'razzi', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
	}
}
