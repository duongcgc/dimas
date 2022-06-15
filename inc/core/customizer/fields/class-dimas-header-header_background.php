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

class Header_Header_Background_Fields {
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
	private static $section = 'header_background';

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

			// Header Backgound
			'header_main_background'                    => array(
				'type'    => 'toggle',
				'label'   => esc_html__( 'Header Main Custom Color', 'dimas' ),
				'section' => self::$section,
				'default' => 0,
			),
			'header_main_background_color'              => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Background Color', 'dimas' ),
				'default'         => '',
				'transport'       => 'postMessage',
				'section'         => self::$section,
				'active_callback' => array(
					array(
						'setting'  => 'header_main_background',
						'operator' => '==',
						'value'    => 1,
					),
				),
				'js_vars'         => array(
					array(
						'element'  => '.site-header .header-main, .site-header .header-mobile',
						'property' => 'background-color',
					),
					array(
						'element'  => '.header-v6 .header-main .dimas-header-container',
						'property' => '--rz-background-color-light',
					),
				),
			),
			'header_main_background_text_color'         => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Text Color', 'dimas' ),
				'default'         => '',
				'transport'       => 'postMessage',
				'section'         => self::$section,
				'active_callback' => array(
					array(
						'setting'  => 'header_main_background',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'js_vars'         => array(
					array(
						'element'  => '.site-header .header-main, .site-header .header-mobile',
						'property' => '--rz-header-color-dark',
					),
					array(
						'element'  => '.site-header .header-main, .site-header .header-mobile',
						'property' => '--rz-stroke-svg-dark',
					),
				),
			),
			'header_main_background_text_color_hover'   => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Text Hover Color', 'dimas' ),
				'default'         => '',
				'transport'       => 'postMessage',
				'section'         => self::$section,
				'active_callback' => array(
					array(
						'setting'  => 'header_main_background',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'js_vars'         => array(
					array(
						'element'  => '.site-header .header-main',
						'property' => '--rz-color-hover-primary',
					),
				),
			),
			'header_main_background_border_color'       => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Border Color', 'dimas' ),
				'default'         => '',
				'transport'       => 'postMessage',
				'section'         => self::$section,
				'active_callback' => array(
					array(
						'setting'  => 'header_main_background',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'js_vars'         => array(
					array(
						'element'  => '.site-header .header-main',
						'property' => 'border-color',
					),
				),
			),
			'header_background_hr'                      => array(
				'type'    => 'custom',
				'section' => 'header_background',
				'default' => '<hr>',
			),
			'header_bottom_background'                  => array(
				'type'    => 'toggle',
				'label'   => esc_html__( 'Header Bottom Custom Color', 'dimas' ),
				'section' => 'header_background',
				'default' => 0,
			),
			'header_bottom_background_color'            => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Background Color', 'dimas' ),
				'default'         => '',
				'transport'       => 'postMessage',
				'section'         => self::$section,
				'active_callback' => array(
					array(
						'setting'  => 'header_bottom_background',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'js_vars'         => array(
					array(
						'element'  => '.site-header .header-bottom',
						'property' => 'background-color',
					),
				),
			),
			'header_bottom_background_text_color'       => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Text Color', 'dimas' ),
				'default'         => '',
				'transport'       => 'postMessage',
				'section'         => self::$section,
				'active_callback' => array(
					array(
						'setting'  => 'header_bottom_background',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'js_vars'         => array(
					array(
						'element'  => '.site-header .header-bottom',
						'property' => '--rz-header-color-dark',
					),
					array(
						'element'  => '.header-v3 .header-bottom .main-navigation > ul > li > a',
						'property' => '--rz-header-color-dark',
					),
					array(
						'element'  => '.site-header .header-bottom',
						'property' => '--rz-stroke-svg-dark',
					),
				),
			),
			'header_bottom_background_text_color_hover' => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Text Hover Color', 'dimas' ),
				'default'         => '',
				'transport'       => 'postMessage',
				'section'         => self::$section,
				'active_callback' => array(
					array(
						'setting'  => 'header_bottom_background',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'js_vars'         => array(
					array(
						'element'  => '.site-header .header-bottom',
						'property' => '--rz-color-hover-primary',
					),
				),
			),
			'header_bottom_background_border_color'     => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Border Color', 'dimas' ),
				'default'         => '',
				'transport'       => 'postMessage',
				'section'         => self::$section,
				'active_callback' => array(
					array(
						'setting'  => 'header_bottom_background',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'js_vars'         => array(
					array(
						'element'  => '.site-header .header-bottom',
						'property' => 'border-color',
					),
				),
			),
			'header_menu_hr'                            => array(
				'type'    => 'custom',
				'section' => 'header_background',
				'default' => '<hr>',
			),

			'header_active_primary_menu_color'          => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Active Primary Menu Color', 'dimas' ),
				'section' => 'header_background',
				'default' => 'primary',
				'choices' => array(
					'primary' => esc_html__( 'Primary Color', 'dimas' ),
					'current' => esc_html__( 'Current Color', 'dimas' ),
				),
			),
		);

		return $fields;
	}



}
