<?php
/**
 * Page Builder functions and definitions.
 * => Init Elementor Page Builder
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
 * Dimas after setup theme
 */
class Addons_Elementor {

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

		if ( false === \Dimas\Core\Helper::dimas_is_elementor_activated() ) {

			$plugin_url = \Dimas\Core\Helper::get_install_plugin_url( 'elementor' );
			$msg_html   = 'Dimas requires Elementor. Please install <a href="';
			$msg_html  .= $plugin_url;
			$msg_html  .= '">Elementor</a> plugin.';

			\Dimas\Framework\Notice::add_notice( 'error', $msg_html );

			return;
		}

		// includes all addons.
		$this->includes();

		// create all addons objects.
		$this->add_actions();

	}

	/**
	 * List components of elementor.
	 *
	 * @var array $elementor_classes_files     The list of elementor files.
	 */
	private $elementor_classes_files = array(
		'Dimas\Addons\Elementor\Helper'        => DIMAS_ADDONS_DIR . '/elementor/class-dimas-elementor-helper.php',
		'Dimas\Addons\Elementor\Setup'         => DIMAS_ADDONS_DIR . '/elementor/class-dimas-elementor-setup.php',
		'Dimas\Addons\Elementor\Ajax_Loader'   => DIMAS_ADDONS_DIR . '/elementor/class-dimas-elementor-ajax-loader.php',
		'Dimas\Addons\Elementor\Widgets'       => DIMAS_ADDONS_DIR . '/elementor/class-dimas-elementor-widgets.php',
		'Dimas\Addons\Elementor\Controls'      => DIMAS_ADDONS_DIR . '/elementor/controls/class-dimas-elementor-controls.php',
		'Dimas\Addons\Elementor\Page_Settings' => DIMAS_ADDONS_DIR . '/elementor/class-dimas-elementor-page-settings.php',
	);
	/**
	 * List classes components of elementor.
	 *
	 * @var array $elementor_classes_names     The list of elementor modules classes name.
	 */
	private $elementor_classes_names = array(
		'helper'        => 'Dimas\Addons\Elementor\Helper',
		'setup'         => 'Dimas\Addons\Elementor\Setup',
		'ajax-loader'   => 'Dimas\Addons\Elementor\Ajax_Loader',
		'widgets'       => 'Dimas\Addons\Elementor\Widgets',
		'controls'      => 'Dimas\Addons\Elementor\Controls',
		'page-settings' => 'Dimas\Addons\Elementor\Page_Settings',
	);

	/**
	 * Includes files which are not widgets
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function includes() {

		foreach ( $this->elementor_classes_files as $class_file ) {
			require_once $class_file;
		}

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
		$this->get( 'ajax-loader' );
		$this->get( 'widgets' );
		$this->get( 'controls' );
		$this->get( 'page-settings' );

		if ( ! defined( 'ELEMENTOR_PRO_VERSION' ) ) {
			// $this->modules['motion_parallax'] = $this->get( 'motion_parallax' );
		}
	}

	/**
	 * Get Dimas Elementor Class instance.
	 *
	 * @since 1.0.0
	 *
	 * @return object
	 */
	public function get( $class ) {

		$class_name = $this->elementor_classes_names[ $class ];

		if ( array_key_exists( $class, $this->elementor_classes_names ) ) {
			return $class_name::instance();
		}

	}
}
