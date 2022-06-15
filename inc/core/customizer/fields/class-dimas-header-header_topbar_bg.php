<?php

/**
 * Customize Fields
 *
 * @package Dimas
 */

namespace Dimas\Core\Customizer;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Header_Header_Topbar_Bg_Fields {
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
	private static $section = 'header_topbar_bg';

	/**
	 * Section priority variable
	 *
	 * @var integer
	 */
	private static $section_priority = 10;

	/**
	 * Get section fields
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function get_fields() {

		$priority = self::$section_priority;

		$fields = array(

			// topbar bg
			'topbar_bg_custom_color'          => array(
				'type'    => 'toggle',
				'label'   => esc_html__( 'Custom Color', 'dimas' ),
				'section' => self::$section,
				'default' => 0,
			),
			'topbar_bg_color'                 => array(
				'label'           => esc_html__( 'Background Color', 'dimas' ),
				'type'            => 'color',
				'default'         => '',
				'transport'       => 'postMessage',
				'active_callback' => array(
					array(
						'setting'  => 'topbar_bg_custom_color',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'js_vars'         => array(
					array(
						'element'  => '.topbar',
						'property' => 'background-color',
					),
				),
				'section' => self::$section,
			),
			'topbar_text_color'               => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Text Color', 'dimas' ),
				'transport'       => 'postMessage',
				'default'         => '',
				'active_callback' => array(
					array(
						'setting'  => 'topbar_bg_custom_color',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'js_vars'         => array(
					array(
						'element'  => '.topbar',
						'property' => '--rz-color-dark',
					),
					array(
						'element'  => '.topbar',
						'property' => '--rz-icon-color',
					),
				),
				'section' => self::$section,
			),
			'topbar_text_color_hover'         => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Text Hover Color', 'dimas' ),
				'transport'       => 'postMessage',
				'default'         => '',
				'active_callback' => array(
					array(
						'setting'  => 'topbar_bg_custom_color',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'js_vars'         => array(
					array(
						'element'  => '.topbar',
						'property' => '--rz-color-primary',
					),
				),
				'section' => self::$section,
			),
			'topbar_bg_border_custom_field_1' => array(
				'type'    => 'custom',
				'section' => 'header_topbar_bg',
				'default' => '<hr/>',
			),
			'topbar_bg_border'                => array(
				'type'    => 'toggle',
				'label'   => esc_html__( 'Border Line', 'dimas' ),
				'section' => 'header_topbar_bg',
				'default' => 0,
			),
			'topbar_bg_border_color'          => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Border Color', 'dimas' ),
				'transport'       => 'postMessage',
				'default'         => '',
				'active_callback' => array(
					array(
						'setting'  => 'topbar_bg_border',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'js_vars'         => array(
					array(
						'element'  => '.topbar',
						'property' => 'border-color',
					),
				),
				'section' => self::$section,
			),
		);

		return $fields;
	}



}
