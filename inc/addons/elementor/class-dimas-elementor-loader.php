<?php
/**
 * Auto Loader Addons Elements class.
 * => Elementor Widgets, Woocomerce, Custom Widgets, OCDI, Demo Data, Custom Fields, ...
 *
 * @package Dimas
 *
 * @return mixed
 **/

namespace Dimas\Addons\Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Autoloader elements of classes.
 */
class Elementor_Loader {

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
	 * Files to loaded.
	 *
	 * @var string $files     Lis of file.
	 */
	private static $files;

	/**
	 * Instantiate the object.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		spl_autoload_register( array( $this, 'load' ) );
	}

	/**
	 * Register files
	 *
	 * @param array $pathes    The path of file.
	 *
	 * @since 1.0.0
	 *
	 * @return void|boolen
	 */
	public static function register( $pathes ) {
		foreach ( $pathes as $namespace => $filename ) {
			self::$files[ $namespace ] = $filename;
		}
		return true;
	}


	/**
	 * Load files.
	 *
	 * @param string $class    The class loading.
	 *
	 * @since 1.0.0
	 *
	 * @return void|boolen
	 */
	public static function load( $class ) {
		if ( isset( self::$files[ $class ] ) ) {
			require self::$files[ $class ];
		}
		return true;
	}

}
