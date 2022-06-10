<?php
/**
 * Dimas Addons Modules functions and definitions.
 *
 * @package Dimas
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Addons Modules
 */
class Dimas_Addons_Modules {

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
			'Dimas\Addons\Modules\Size_Guide\Module'    			=> DIMAS_ADDONS_DIR . 'modules/size-guide/module.php',
			'Dimas\Addons\Modules\Catalog_Mode\Module'    			=> DIMAS_ADDONS_DIR . 'modules/catalog-mode/module.php',
			'Dimas\Addons\Modules\Product_Deals\Module'    			=> DIMAS_ADDONS_DIR . 'modules/product-deals/module.php',
			'Dimas\Addons\Modules\Buy_Now\Module'    				=> DIMAS_ADDONS_DIR . 'modules/buy-now/module.php',
			'Dimas\Addons\Modules\Mega_Menu\Module'    				=> DIMAS_ADDONS_DIR . 'modules/mega-menu/module.php',
			'Dimas\Addons\Modules\Products_Filter\Module'     		=> DIMAS_ADDONS_DIR . 'modules/products-filter/module.php',
			'Dimas\Addons\Modules\Related_Products\Module'    		=> DIMAS_ADDONS_DIR . 'modules/related-products/module.php',
			'Dimas\Addons\Modules\Product_Tabs\Module'    			=> DIMAS_ADDONS_DIR . 'modules/product-tabs/module.php',
			'Dimas\Addons\Modules\Ajax'    							=> DIMAS_ADDONS_DIR . 'modules/ajax.php',
			'Dimas\Addons\Modules\Shortcodes' 						=> DIMAS_ADDONS_DIR . 'modules/shortcodes.php',
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
			\Dimas\Addons\Modules\Ajax::instance();
		}

		\Dimas\Addons\Modules\Buy_Now\Module::instance();
		\Dimas\Addons\Modules\Catalog_Mode\Module::instance();
		\Dimas\Addons\Modules\Mega_Menu\Module::instance();
		\Dimas\Addons\Modules\Product_Deals\Module::instance();
		\Dimas\Addons\Modules\Products_Filter\Module::instance();
		\Dimas\Addons\Modules\Size_Guide\Module::instance();
		\Dimas\Addons\Modules\Related_Products\Module::instance();
		\Dimas\Addons\Modules\Product_Tabs\Module::instance();
		\Dimas\Addons\Modules\Shortcodes::instance();
	}

}
