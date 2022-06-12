<?php

namespace Dimas\Addons\Elementor;

use Dimas\Addons\Elementor\Control\Autocomplete;
use Dimas\Addons\Elementor\Controls\AjaxLoader;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Controls.
 */
class Controls {

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
		// Include plugin files
		$this->includes();

		// Register controls
		add_action( 'elementor/controls/controls_registered', array( $this, 'register_controls' ) );

		AjaxLoader::instance();
	}

	/**
	 * Include Files
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function includes() {

		$control_elementor = array(
			'Dimas\Addons\Elementor\Controls\AjaxLoader'   => DIMAS_ADDONS_DIR . '/elementor/controls/class-dimas-elementor-controls-ajaxloader.php',
			'Dimas\Addons\Elementor\Controls\Autocomplete' => DIMAS_ADDONS_DIR . '/elementor/controls/class-dimas-elementor-autocomplete.php',
		);

		foreach ( $control_elementor as $class_file ) {
			require_once $class_file;
		}

	}

	/**
	 * Register autocomplete control
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_controls() {
		$controls_manager = \Elementor\Plugin::$instance->controls_manager;
		$controls_manager->register_control( 'dm_autocomplete', \Dimas\Addons\Elementor\Control\Autocomplete::instance() );

	}
}
