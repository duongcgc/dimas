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
		echo 'Core Init';
	}

	/**
	 * Load Templates
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function load_templates() {

		// includes all core.
		$this->includes();

		// auto includes all elements of core.
		spl_autoload_register( '\Dimas\Core\Core_Loader::load' );

		// create all core objects.
		$this->add_actions();
	}

	/**
	 * List components of core.
	 */
	private $core_classes_files = array(
		'Dimas\Core\Helper'       => DIMAS_CORE_DIR . '/class-dimas-helper.php',
		'Dimas\Core\Blog'         => DIMAS_CORE_DIR . '/class-dimas-blog.php',
		'Dimas\Core\CPT_Abstract' => DIMAS_CORE_DIR . '/class-dimas-cpt-abstract.php',
		'Dimas\Core\CPT_Register' => DIMAS_CORE_DIR . '/class-dimas-cpt-register.php',
		'Dimas\Core\Customize'    => DIMAS_CORE_DIR . '/class-dimas-customize.php',
		'Dimas\Core\Metaboxes'    => DIMAS_CORE_DIR . '/class-dimas-metaboxes.php',
		'Dimas\Core\Options'      => DIMAS_CORE_DIR . '/class-dimas-options.php',
		'Dimas\Core\Mobile'       => DIMAS_CORE_DIR . '/class-dimas-mobile.php',
	);

	/**
	 * List classes components of core.
	 *
	 * @var array
	 */
	private $core_classes_names = array(
		'help'         => 'Dimas\Core\Helper',
		'blog'         => 'Dimas\Core\Blog',
		'cpt-abstract' => 'Dimas\Core\CPT_Abstract',
		'cpt-register' => 'Dimas\Core\CPT_Register',
		'customizer'   => 'Dimas\Core\Customize',
		'metaboxes'    => 'Dimas\Core\Metaboxes',
		'options'      => 'Dimas\Core\Options',
		'mobile'       => 'Dimas\Core\Mobile',
	);

	/**
	 * Includes files.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function includes() {
		// Auto Loader core.
		require_once DIMAS_ADDONS_DIR . 'class-dimas-core-loader.php';
		Core_Loader::register(
			$this->core_classes_files
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

		$this->get( 'helper' );
		$this->get( 'blog' );

		$this->get( 'cpt-abstract' );
		$this->get( 'cpt-register' );

		// Customizer.
		$this->get( 'customizer' );

		// Metabos.
		$this->get( 'metaboxes' );

		// Options.
		$this->get( 'options' );

		// Mobile.
		$this->get( 'mobile' );

		add_action( 'after_setup_theme', array( $this, 'core_init' ), 20 );

		// Init action.
		do_action( 'after_dimas_init' );
	}

	/**
	 * Get Dimas Core Class instance.
	 *
	 * @since 1.0.0
	 *
	 * @return object
	 */
	public function get( $class ) {

		$class_name = $this->core_classes_names[ $class ];

		if ( array_key_exists( $class, $this->core_classes_files ) ) {
			if ( class_exists( $class_name ) ) {
				return $class_name::instance();				
			} else {
				echo '<br/>' . esc_html__( 'Not found the class: ', 'dimas' ) . esc_url( $class_name );
			}
		}

	}

	/**
	 * Get Dimas Core Language
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function core_init() {
		load_plugin_textdomain( 'dimas', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
	}
}
