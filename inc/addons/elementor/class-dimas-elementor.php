<?php
/**
 * Elementor init
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Dimas
 */

namespace Dimas\Addons;

/**
 * Integrate with Elementor.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Elementor {

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
	 * Includes files which are not widgets
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function includes() {
		\Dimas\Addons\Auto_Loader::register( [
			'Dimas\Addons\Elementor\Helper'                 => RAZZI_ADDONS_DIR . 'inc/elementor/class-razzi-elementor-helper.php',
			'Dimas\Addons\Elementor\Setup'                  => RAZZI_ADDONS_DIR . 'inc/elementor/class-razzi-elementor-setup.php',
			'Dimas\Addons\Elementor\AjaxLoader'             => RAZZI_ADDONS_DIR . 'inc/elementor/class-razzi-elementor-ajaxloader.php',
			'Dimas\Addons\Elementor\Widgets'                => RAZZI_ADDONS_DIR . 'inc/elementor/class-razzi-elementor-widgets.php',
			'Dimas\Addons\Elementor\Module\Motion_Parallax' => RAZZI_ADDONS_DIR . 'inc/elementor/modules/class-razzi-elementor-motion-parallax.php',
			'Dimas\Addons\Elementor\Controls'               => RAZZI_ADDONS_DIR . 'inc/elementor/controls/class-razzi-elementor-controls.php',
			'Dimas\Addons\Elementor\Page_Settings'          => RAZZI_ADDONS_DIR . 'inc/elementor/class-razzi-elementor-page-settings.php',
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
		$this->get( 'setup' );
		$this->get( 'ajax_loader' );
		$this->get( 'widgets' );
		$this->get( 'controls' );
		$this->get( 'page_settings' );

		if ( ! defined( 'ELEMENTOR_PRO_VERSION' ) ) {
			$this->modules['motion_parallax'] = $this->get( 'motion_parallax' );
		}
	}

	/**
	 * Get Dimas Elementor Class instance
	 *
	 * @since 1.0.0
	 *
	 * @return object
	 */
	public function get( $class ) {
		switch ( $class ) {
			case 'setup':
				return \Dimas\Addons\Elementor\Setup::instance();
				break;
			case 'ajax_loader':
				return \Dimas\Addons\Elementor\AjaxLoader::instance();
				break;
			case 'widgets':
				return \Dimas\Addons\Elementor\Widgets::instance();
				break;
			case 'motion_parallax':
				if ( ! defined( 'ELEMENTOR_PRO_VERSION' ) ) {
					return \Dimas\Addons\Elementor\Module\Motion_Parallax::instance();
				}
				break;
			case 'controls':
				return \Dimas\Addons\Elementor\Controls::instance();
				break;
			case 'page_settings':
				return \Dimas\Addons\Elementor\Page_Settings::instance();
				break;
		}
	}
}
