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

		// includes all addons.
		$this->includes();

		// auto includes all elements of addons.
		spl_autoload_register( '\Dimas\Core\Core_Loader::load' );

		// create all addons objects.
		$this->add_actions();
	}

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
		Core_Auto_Loader::register(
			array(
				'Dimas\Core\Helper'          => DIMAS_ADDONS_DIR . '/class-dimas-addons-helper.php',
				'Dimas\Core\Widgets'         => DIMAS_ADDONS_DIR . '/widgets/class-dimas-addons-widgets.php',
				'Dimas\Core\Modules'         => DIMAS_ADDONS_DIR . 'modules/modules.php',
				'Dimas\Core\Elementor'       => DIMAS_ADDONS_DIR . '/elementor/class-dimas-elementor.php',
				'Dimas\Core\Product_Brands'  => DIMAS_ADDONS_DIR . '/backend/class-dimas-addons-product-brand.php',
				'Dimas\Core\Product_Authors' => DIMAS_ADDONS_DIR . '/backend/class-dimas-addons-product-author.php',
				'Dimas\Core\Importer'        => DIMAS_ADDONS_DIR . '/backend/class-dimas-addons-importer.php',
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
	 * Get Dimas Core Class instance
	 *
	 * @since 1.0.0
	 *
	 * @return object
	 */
	public function get( $class ) {
		switch ( $class ) {
			case 'product_brand':
				if ( class_exists( 'WooCommerce' ) ) {
					return \Dimas\Core\Product_Brands::instance();
				}
				break;
			case 'product_author':
				if ( class_exists( 'WooCommerce' ) ) {
					return \Dimas\Core\Product_Authors::instance();
				}
				break;
			case 'importer':
				if ( is_admin() ) {
					return \Dimas\Core\Importer::instance();
				}
				break;
			case 'elementor':
				if ( did_action( 'elementor/loaded' ) ) {
					return \Dimas\Core\Elementor::instance();
				}
				break;

			case 'modules':
				return \Dimas\Core\Modules::instance();
				break;

			case 'widgets':
				return \Dimas\Core\Widgets::instance();
				break;
		}
	}

	/**
	 * Get Dimas Core Language
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function addons_init() {
		load_plugin_textdomain( 'dimas', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
	}
}
