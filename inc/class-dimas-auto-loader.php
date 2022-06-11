<?php
/**
 * Autoload Classes.
 * => Auto load all class with prefix class-dm- in addons, core, platform
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Dimas
 */

namespace Dimas;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Auto_Loader init
 */
class Auto_Loader {
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
		spl_autoload_register( array( $this, 'load' ) );
	}

	/**
	 * Auto load classes without namespace
	 * => Class name: This_Class_Name   => file name is class-this-class-name.php
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function load2( $class ) {
		if ( false === strpos( $class, 'Dimas' ) ) {
			return;
		}

		$relative_class_name = strtolower( $class );
		$relative_class_name = str_replace( '_', '-', $relative_class_name );
		$file_parts          = explode( '-', $relative_class_name );
		$file_name           = $relative_class_name;
		$file_dir            = DIMAS_INC_DIR . '/';

		$addons_folder = array(
			'widgets'   => 'addons/widgets',
			'elementor' => 'addons/elementor',
			'ocdi'      => 'addons/ocdi',
			'woo'       => 'addons/woocommerce',
		);

		$core_folder = array(
			'admin'      => 'core/admin',
			'blog'       => 'core/blog',
			'cpt'        => 'core/cpt',
			'customizer' => 'core/customizer',
			'libs'       => 'core/libs',
			'mobile'     => 'core/mobile',
			'options'    => 'core/options',
		);

		$core_framework = array(
			'co'     => 'core',
			'fw'     => 'framework',
			'addons' => 'addons',
		);

		if ( count( $file_parts ) > 1 ) {
			$i         = 0;
			$file_name = '';
			foreach ( $file_parts as $file_part ) {
				$file_part  = $file_part === 'woocommerce' ? 'woo' : $file_part;
				$file_name .= $i == 0 ? '' : '-';
				$file_name .= $file_part;
				$i ++;
			}
			if ( array_key_exists( $file_parts['1'], $addons_folder ) ) {
				$file_dir .= $addons_folder[ $file_parts['1'] ] . '/';
			} elseif ( array_key_exists( $file_parts['1'], $core_folder ) ) {
				$file_dir .= $core_folder[ $file_parts['1'] ] . '/';
			} elseif ( array_key_exists( $file_parts['1'], $core_framework ) ) {
				$file_dir .= $core_framework[ $file_parts['1'] ] . '/';
			}
		}

		$file_name = $file_dir . 'class-' . $file_name . '.php';

		echo $file_name . '<br/>';

		if ( is_readable( $file_name ) ) {
			include $file_name;
		}
	}

	/**
	 * Auto load classes with namespace
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function load( $class ) {

		// If namespace is key then folder is value.
		$folder_by_space = array(
			'dimas'     => '/',
			'addons'    => '/addons',
			'elementor' => '/addons/elementor',
			'core'      => '/core',
			'options'   => '/core/options',
			'framework' => '/framework',
		);

		// If class name is key then remove name on filename.
		$file_by_class = array(
			'addons'     => 'addons',
			'core'       => '',
			'framework'  => '',
			'woocomerce' => 'woo',
		);

		if ( false === strpos( $class, 'Dimas' ) ) {
			return;
		}

		$relative_class_name = preg_replace( '/^' . __NAMESPACE__ . '\\\/', '', $class );
		$relative_class_name = strtolower( $relative_class_name );
		$relative_class_name = str_replace( '_', '-', $relative_class_name );
		$file_parts          = explode( '\\', $relative_class_name );
		$file_name           = $relative_class_name;
		$file_dir            = DIMAS_INC_DIR;

		if ( count( $file_parts ) > 1 ) {
			$i         = 0;
			$file_name = '';

			// file name.
			foreach ( $file_parts as $file_part ) {

				if ( array_key_exists( $file_part, $file_by_class ) ) {
					$file_part = $file_by_class[ $file_part ];
					// if ( $file_by_class[ $file_part ] != '' ) {
					// 	$file_part .= '-';
					// }
					$file_name .= $i == 0 ? '' : '-';
				}

				$file_name .= $file_part;
				$i ++;
			}

			// file dir.
			if ( array_key_exists( $file_parts['0'], $folder_by_space ) ) {
				$file_dir .= $folder_by_space[ $file_parts['0'] ];
			} else {
				$file_dir .= '/';
			}
		}

		$file_name = $file_dir . '/class-dimas-' . $file_name . '.php';

		// echo '<br>' . $file_name;

		if ( is_readable( $file_name ) ) {
			include $file_name;
		}
	}
}
