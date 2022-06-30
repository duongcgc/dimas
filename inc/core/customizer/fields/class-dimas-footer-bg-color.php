<?php
/**
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
 * Footer Background Color class
 */
class Footer_Background_Color_Fields {
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
	 * @return object
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Section name.
	 *
	 * @var string
	 */
	private static $section = 'footer_bg';

	/**
	 * Get customize fields
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function get_fields() {

		$fields = array(

			// Colors Background Footer.
			'footer_bg_title'         => array(
				'type'    => 'custom',
				'section' => self::$section,
				'label'   => esc_html__( 'Color Background Footer', 'dimas' ),
			),
			'footer_bg_color_default' => array(
				'type'            => 'color-palette',
				'default'         => dimas_defaults( 'footer_bg_color_default' ),
				'choices'         => array(
					'colors' => array(
						'#ff6F610',
						'#053399',
						'#3f51b5',
						'#7b1fa2',
						'#009688',
						'#388e3c',
						'#e64a19',
						'#b8a08d',
					),
					'style'  => 'round',
				),
				'section'         => self::$section,
				'active_callback' => array(
					array(
						'setting'  => 'footer_bg_custom',
						'operator' => '==',
						'value'    => false,
					),
				),
			),
			'footer_bg_custom'        => array(
				'type'    => 'checkbox',
				'label'   => esc_html__( 'Pick my favorite color', 'dimas' ),
				'default' => dimas_defaults( 'footer_bg_custom' ),
				'section' => self::$section,
			),
			'footer_bg_color'         => array(
				'settings'        => 'footer_bg_color',
				'type'            => 'color',
				'label'           => esc_html__( 'Color Background Footer', 'dimas' ),
				'default'         => dimas_defaults( 'footer_bg_color' ),
				'section'         => self::$section,
				'choices'         => array( 'alpha' => true ),
				'active_callback' => array(
					array(
						'setting'  => 'footer_bg_custom',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
		);

		return $fields;
	}

}
