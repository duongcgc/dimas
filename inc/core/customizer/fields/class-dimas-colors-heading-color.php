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
 * Heading color class
 */
class Colors_Heading_Color_Fields {
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
	private static $section = 'heading_color';

	/**
	 * Get section fields
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function get_fields() {

		$fields = array(

			// Colors H1.
			'color_h1_title'  => array(
				'type'    => 'custom',
				'section' => self::$section,
				'label'   => esc_html__( 'Color H1', 'dimas' ),
			),
			'color_h1_default'        => array(
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
						'setting'  => 'color_h1_custom',
						'operator' => '==',
						'value'    => false,
					),
				),
			),
			'color_h1_custom' => array(
				'type'    => 'checkbox',
				'label'   => esc_html__( 'Pick my favorite color', 'dimas' ),
				'default' => true,
				'section' => self::$section,
			),
			'color_h1'  => array(
				'settings'        => 'color_setting_rgba_h1',
				'type'            => 'color',
				'label'           => esc_html__( 'Custom H1 Color', 'dimas' ),
				'default'         => '#ffffff',
				'section'         => self::$section,
				'choices'         => array( 'alpha' => true ),
				'active_callback' => array(
					array(
						'setting'  => 'color_h1_custom',
						'operator' => '==',
						'value'    => true,
					),
				),
			),

			// Colors H2.
			'color_h2_title'  => array(
				'type'    => 'custom',
				'section' => self::$section,
				'label'   => esc_html__( 'Color H2', 'dimas' ),
			),
			'color_h2_default'        => array(
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
						'setting'  => 'color_h2_custom',
						'operator' => '==',
						'value'    => false,
					),
				),
			),
			'color_h2_custom' => array(
				'type'    => 'checkbox',
				'label'   => esc_html__( 'Pick my favorite color', 'dimas' ),
				'default' => true,
				'section' => self::$section,
			),
			'color_h2'  => array(
				'settings'        => 'color_setting_rgba_h2',
				'type'            => 'color',
				'label'           => esc_html__( 'Custom H2 Color', 'dimas' ),
				'default'         => '#ffffff',
				'section'         => self::$section,
				'choices'         => array( 'alpha' => true ),
				'active_callback' => array(
					array(
						'setting'  => 'color_h2_custom',
						'operator' => '==',
						'value'    => true,
					),
				),
			),

			// Colors H3.
			'color_h3_title'  => array(
				'type'    => 'custom',
				'section' => self::$section,
				'label'   => esc_html__( 'Color H3', 'dimas' ),
			),
			'color_h3_default'        => array(
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
						'setting'  => 'color_h3_custom',
						'operator' => '==',
						'value'    => false,
					),
				),
			),
			'color_h3_custom' => array(
				'type'    => 'checkbox',
				'label'   => esc_html__( 'Pick my favorite color', 'dimas' ),
				'default' => true,
				'section' => self::$section,
			),
			'color_h3'  => array(
				'settings'        => 'color_setting_rgba_h3',
				'type'            => 'color',
				'label'           => esc_html__( 'Custom H3 Color', 'dimas' ),
				'default'         => '#ffffff',
				'section'         => self::$section,
				'choices'         => array( 'alpha' => true ),
				'active_callback' => array(
					array(
						'setting'  => 'color_h3_custom',
						'operator' => '==',
						'value'    => true,
					),
				),
			),

			// Colors H4.
			'color_h4_title'  => array(
				'type'    => 'custom',
				'section' => self::$section,
				'label'   => esc_html__( 'Color H4', 'dimas' ),
			),
			'color_h4_default'        => array(
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
						'setting'  => 'color_h4_custom',
						'operator' => '==',
						'value'    => false,
					),
				),
			),
			'color_h4_custom' => array(
				'type'    => 'checkbox',
				'label'   => esc_html__( 'Pick my favorite color', 'dimas' ),
				'default' => true,
				'section' => self::$section,
			),
			'color_h4'  => array(
				'settings'        => 'color_setting_rgba_h4',
				'type'            => 'color',
				'label'           => esc_html__( 'Custom H4 Color', 'dimas' ),
				'default'         => 'rgb(242, 25, 103, 1)',
				'section'         => self::$section,
				'choices'         => array( 'alpha' => true ),
				'active_callback' => array(
					array(
						'setting'  => 'color_h4_custom',
						'operator' => '==',
						'value'    => true,
					),
				),
			),

			// Colors H5.
			'color_h5_title'  => array(
				'type'    => 'custom',
				'section' => self::$section,
				'label'   => esc_html__( 'Color H5', 'dimas' ),
			),
			'color_h5_default'        => array(
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
						'setting'  => 'color_h5_custom',
						'operator' => '==',
						'value'    => false,
					),
				),
			),
			'color_h5_custom' => array(
				'type'    => 'checkbox',
				'label'   => esc_html__( 'Pick my favorite color', 'dimas' ),
				'default' => true,
				'section' => self::$section,
			),
			'color_h5'  => array(
				'settings'        => 'color_setting_rgba_h5',
				'type'            => 'color',
				'label'           => esc_html__( 'Custom H5 Color', 'dimas' ),
				'default'         => '#ffffff',
				'section'         => self::$section,
				'choices'         => array( 'alpha' => true ),
				'active_callback' => array(
					array(
						'setting'  => 'color_h5_custom',
						'operator' => '==',
						'value'    => true,
					),
				),
			),

			// Colors H6.
			'color_h6_title'  => array(
				'type'    => 'custom',
				'section' => self::$section,
				'label'   => esc_html__( 'Color H6', 'dimas' ),
			),
			'color_h6_default'        => array(
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
						'setting'  => 'color_h6_custom',
						'operator' => '==',
						'value'    => false,
					),
				),
			),
			'color_h6_custom' => array(
				'type'    => 'checkbox',
				'label'   => esc_html__( 'Pick my favorite color', 'dimas' ),
				'default' => true,
				'section' => self::$section,
			),
			'color_h6'  => array(
				'settings'        => 'color_setting_rgba_h6',
				'type'            => 'color',
				'label'           => esc_html__( 'Custom H6 Color', 'dimas' ),
				'default'         => '#ffffff',
				'section'         => self::$section,
				'choices'         => array( 'alpha' => true ),
				'active_callback' => array(
					array(
						'setting'  => 'color_h6_custom',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
		);

		return $fields;
	}

}
