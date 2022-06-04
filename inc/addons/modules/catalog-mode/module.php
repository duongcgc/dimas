<?php
/**
 * Dimas Addons Modules functions and definitions.
 *
 * @package Dimas
 */

namespace Dimas\Addons\Modules\Catalog_Mode;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Addons Modules
 */
class Module {

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
		$this->includes();
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
		\Dimas\Addons\Auto_Loader::register( [
			'Dimas\Addons\Modules\Catalog_Mode\Frontend'        => RAZZI_ADDONS_DIR . 'modules/catalog-mode/frontend.php',
			'Dimas\Addons\Modules\Catalog_Mode\Settings'    	=> RAZZI_ADDONS_DIR . 'modules/catalog-mode/settings.php',
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
		if ( is_admin() ) {
			\Dimas\Addons\Modules\Catalog_Mode\Settings::instance();
		}

		if ( get_option( 'rz_catalog_mode' ) == 'yes' ) {
			\Dimas\Addons\Modules\Catalog_Mode\Frontend::instance();
		}
	}

}
