<?php
/**
 * Auto Loader Core Modules Elements class.
 * => Custom Post Types, Metaboxes Custom Fields, Customize Settings, Settings Options, ...
 *
 * @package Dimas
 *
 * @return mixed
 **/

namespace Dimas\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Auto loading all elements core modules.
 */
class Core_Loader {

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
	public function load( $class ) {

		if ( isset( self::$files[ $class ] ) ) {
			require self::$files[ $class ];
		}
		return true;
	}

}
