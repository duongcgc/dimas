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

class Header_Header_Top_Fields {
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
	private static $section = 'header_top';

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

			// topbar
			'topbar'                => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Topbar', 'dimas' ),
				'default'     => '0',
				'section'     => self::$section,
				'description' => esc_html__( 'Check this option to enable a topbar above the site header', 'dimas' ),
			),

			'topbar_custom_field_1' => array(
				'type'    => 'custom',
				'section' => self::$section,
				'default' => '<hr/>',
			),

			'topbar_height'         => array(
				'type'      => 'slider',
				'label'     => esc_html__( 'Height', 'dimas' ),
				'transport' => 'postMessage',
				'default'   => '45',
				'choices'   => array(
					'min' => 0,
					'max' => 240,
				),
				'js_vars'   => array(
					array(
						'element'  => '.topbar',
						'property' => 'height',
						'units'    => 'px',
					),
				),
				'section'   => self::$section,
			),

			'topbar_custom_field_2' => array(
				'type'    => 'custom',
				'section' => self::$section,
				'default' => '<hr/>',
			),

			'topbar_left'           => array(
				'type'        => 'repeater',
				'label'       => esc_html__( 'Left Items', 'dimas' ),
				'description' => esc_html__( 'Control items on the left side of the topbar', 'dimas' ),
				'transport'   => 'postMessage',
				'default'     => array(),
				'row_label'   => array(
					'type'  => 'field',
					'value' => esc_attr__( 'Item', 'dimas' ),
					'field' => 'item',
				),
				'fields'      => array(
					'item' => array(
						'type' => 'select',
						// 'choices' => $this->topbar_items_option(),
					),
				),
				'section'     => self::$section,
			),
			'topbar_right'          => array(
				'type'        => 'repeater',
				'label'       => esc_html__( 'Right Items', 'dimas' ),
				'description' => esc_html__( 'Control items on the right side of the topbar', 'dimas' ),
				'transport'   => 'postMessage',
				'default'     => array(),
				'row_label'   => array(
					'type'  => 'field',
					'value' => esc_attr__( 'Item', 'dimas' ),
					'field' => 'item',
				),
				'fields'      => array(
					'item' => array(
						'type' => 'select',
						// 'choices' => $this->topbar_items_option(),
					),
				),
				'section'     => self::$section,
			),

			'topbar_custom_field_5' => array(
				'type'    => 'custom',
				'section' => self::$section,
				'default' => '<hr/>',
			),

			'topbar_menu_item'      => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Menu', 'dimas' ),
				'section' => 'header_top',
				'default' => '',
				// 'choices'         => $this->get_navigation_bar_get_menus(),

			),

			'topbar_custom_field_4' => array(
				'type'    => 'custom',
				'section' => self::$section,
				'default' => '<hr/>',
			),

			'topbar_svg_code'       => array(
				'type'              => 'textarea',
				'label'             => esc_html__( 'Custom Text SVG', 'dimas' ),
				'description'       => esc_html__( 'The SVG before your text', 'dimas' ),
				'default'           => '',
				'sanitize_callback' => '\Dimas\Icon::sanitize_svg',
				'output'            => array(
					array(
						'element' => '.dimas-topbar__text .dimas-svg-icon',
					),
				),
				'section'           => self::$section,
			),

			'topbar_text'           => array(
				'type'        => 'editor',
				'label'       => esc_html__( 'Custom Text', 'dimas' ),
				'description' => esc_html__( 'The content of Custom Text item', 'dimas' ),
				'default'     => '',
				'section'     => 'header_top',
			),
		);

		return $fields;
	}



}
