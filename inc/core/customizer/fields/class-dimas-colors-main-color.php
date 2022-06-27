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
 * Main color class
 */
class Colors_Main_Color_Fields {
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
	private static $section = 'main_color';

	/**
	 * Get section fields
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function get_fields() {

		$fields = array(

			// Colors.
			'color_main_title'  => array(
				'type'    => 'custom',
				'section' => self::$section,
				'label'   => esc_html__( 'Main Color', 'dimas' ),
			),
			'color_main_default'        => array(
				'type'            => 'color-palette',
				'default'         => '#ff6F61',
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
						'setting'  => 'color_main_custom',
						'operator' => '==',
						'value'    => false,
					),
				),
			),
			'color_main_custom' => array(
				'type'    => 'checkbox',
				'label'   => esc_html__( 'Pick my favorite color', 'dimas' ),
				'default' => true,
				'section' => self::$section,
			),
			'color_main'  => array(
				'settings'        => 'color_setting_rgba_main',
				'type'            => 'color',
				'label'           => esc_html__( 'Custom Main Color', 'dimas' ),
				'default'         => 'rgb(242, 25, 103, 1)',
				'section'         => self::$section,
				'choices'         => array( 'alpha' => true ),
				'active_callback' => array(
					array(
						'setting'  => 'color_main_custom',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
		);

		return $fields;
	}

}
