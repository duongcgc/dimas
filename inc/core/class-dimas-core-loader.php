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
class Core_Auto_Loader {

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
	 * Load all custom post types.
	 *
	 * @return mixed
	 */
	public static function cpt_loader() {
		return true;
	}

	/**
	 * Load all customize settings.
	 *
	 * @return mixed
	 */
	public static function customize_settings_loader() {
		return true;
	}

	/**
	 * Load all admin options settings.
	 *
	 * @return mixed
	 */
	public static function addmin_settings_loader() {
		return true;
	}

	/**
	 * Load all metaboxs custom fields.
	 *
	 * @return mixed
	 */
	public static function custom_fields_loader() {
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
