<?php
/**
 * Theme Settings Settings
 *
 * @package Dimas
 */

namespace Dimas\Core\Customizer;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Settings class
 */
class Settings {

	/**
	 * Instance
	 *
	 * @var $instance
	 */
	protected static $instance = null;

	/**
	 * $dimas_customize
	 *
	 * @var $dimas_customize
	 */
	protected static $dimas_customize = null;

	/**
	 * Initiator
	 *
	 * @since 1.0.0
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
		add_filter( 'dimas_customize_config', array( $this, 'customize_settings' ) );
		self::$dimas_customize = \Dimas\Core\Core_Init::instance()->get( 'customizer' );
	}


	/**
	 * This is a short hand function for getting setting value from customizer
	 *
	 * @since 1.0.0
	 *
	 * @param string $name The name of the setting.
	 *
	 * @return bool|string
	 */
	public function get_setting( $name ) {
		if ( is_object( self::$dimas_customize ) ) {
			$value = self::$dimas_customize->get_setting( $name );
		} elseif ( false !== get_theme_mod( $name ) ) {
			$value = get_theme_mod( $name );
		} else {
			$value = $this->get_setting_default( $name );
		}

		return apply_filters( 'dimas_get_setting', $value, $name );
	}

	/**
	 * Get default option values
	 *
	 * @since 1.0.0
	 *
	 * @param string $name The name of default setting.
	 *
	 * @return mixed
	 */
	public static function get_setting_default( $name ) {
		if ( empty( self::$dimas_customize ) ) {
			return false;
		}

		return self::$dimas_customize->get_setting_default( $name );
	}

	/**
	 * Get customize settings
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function customize_settings() {
		$settings = array(
			'theme' => 'Dimas Theme',
		);

		$panels   = \Dimas\Core\Customizer\Panels::customize_panels();
		$sections = \Dimas\Core\Customizer\Sections::customize_sections();
		$fields   = \Dimas\Core\Customizer\Fields::customize_fields();

		$settings['panels']   = apply_filters( 'dimas_customize_panels', $panels );
		$settings['sections'] = apply_filters( 'dimas_customize_sections', $sections );
		$settings['fields']   = apply_filters( 'dimas_customize_fields', $fields );

		return $settings;
	}

}
