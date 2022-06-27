<?php
/**
 *
 * Customize Fields
 *
 * @package Dimas
 */

namespace Dimas\Core\Customizer;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Fields class
 */
class Fields {
	/**
	 * Instance
	 *
	 * @var $instance
	 */
	protected static $instance = null;

	/**
	 * Initiator
	 *
	 * @since 1.0.0
	 *
	 * @return object
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * The class constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_filter( 'dimas_customize_fields', array( $this, 'customize_fields' ) );
	}

	/**
	 * Create Fields.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function create_fields() {
		foreach ( self::$dimas_fields_classes as $field_class => $file_class ) {
			require_once $file_class;
			$field_class::instance();
		}
	}

	/**
	 * $dimas_fields
	 *
	 * @var $dimas_fields
	 */
	public static $dimas_fields_classes = array(
		// '\Dimas\Core\Customizer\General_Boxed_Layout_Fields' => DIMAS_CORE_DIR . '/customizer/fields/class-dimas-general-boxed_layout.php',
		// '\Dimas\Core\Customizer\General_Backtotop_Fields' => DIMAS_CORE_DIR . '/customizer/fields/class-dimas-general-general_backtotop.php',
		// '\Dimas\Core\Customizer\Colors_Fields'            => DIMAS_CORE_DIR . '/customizer/fields/class-dimas-colors.php',
		// '\Dimas\Core\Customizer\General_Preloader_Fields' => DIMAS_CORE_DIR . '/customizer/fields/class-dimas-general-preloader.php',
		// '\Dimas\Core\Customizer\Newsletter_Popup_Fields'  => DIMAS_CORE_DIR . '/customizer/fields/class-dimas-newsletter-popup.php',
		// '\Dimas\Core\Customizer\Header_Header_Top_Fields' => DIMAS_CORE_DIR . '/customizer/fields/class-dimas-header-header_top.php',
		// '\Dimas\Core\Customizer\Header_Header_Topbar_Bg_Fields' => DIMAS_CORE_DIR . '/customizer/fields/class-dimas-header-header_topbar_bg.php',
	);

	/**
	 * Get customize fields
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function customize_fields() {

		self::instance()->create_fields();

		$fields = array();

		foreach ( self::$dimas_fields_classes as $field_class => $file_class ) {
			$fields_tmp = $field_class::get_fields();
			$fields     = array_merge( $fields, $fields_tmp );
		}

		return $fields;
	}

}
