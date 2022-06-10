<?php
/**
 * Auto Loader class.
 *
 * @package Dimas
 *
 * @return mixed
 **/

namespace Dimas\Addons;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Autoloader elements of classes.
 */
class Dimas_Addons_AutoLoader {

	/**
	 * Files to loaded.
	 *
	 * @var string $files     Lis of file.
	 */
	private static $files;

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
