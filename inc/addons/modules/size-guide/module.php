<?php
/**
 * Dimas Addons Modules functions and definitions.
 *
 * @package Dimas
 */

namespace Dimas\Addons\Modules\Size_Guide;

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
			'Dimas\Addons\Modules\Size_Guide\Settings'    	=> DIMAS_ADDONS_DIR . 'modules/size-guide/settings.php',
			'Dimas\Addons\Modules\Size_Guide\Frontend'    	=> DIMAS_ADDONS_DIR . 'modules/size-guide/frontend.php',
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
			return \Dimas\Addons\Modules\Size_Guide\Settings::instance();
		}

		if ( get_option( 'razzi_size_guide' ) == 'yes' ) {
			return \Dimas\Addons\Modules\Size_Guide\Frontend::instance();
		}
	}

}
