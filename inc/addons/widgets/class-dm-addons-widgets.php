<?php
/**
 * Load and register widgets
 *
 * @package Dimas
 */

namespace Dimas\Addons;
/**
 * Dimas theme init
 */
class GO_Widgets {

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
		add_action( 'widgets_init', array( $this, 'register_widgets' ) );
	}


	/**
	 * Register widgets
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function register_widgets() {
		$this->includes();
		$this->add_actions();
	}

	/**
	 * Include Files
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function includes() {
		\Dimas\Addons\Auto_Loader::register( [
			'Dimas\Addons\Widgets\Social_Links'    => DIMAS_ADDONS_DIR . 'inc/widgets/class-dm-addons-socials.php',
		] );
	}

	/**
	 * Add Actions
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function add_actions() {
		register_widget( new \Dimas\Addons\Widgets\Social_Links() );
	}
}