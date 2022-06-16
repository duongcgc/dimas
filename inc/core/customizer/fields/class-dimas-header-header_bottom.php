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

class Header_Header_Bottom_Fields {
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
	private static $section = 'header_bottom';

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

			// Header Bottom
			'header_bottom_left'          => array(
				'type'            => 'repeater',
				'label'           => esc_html__( 'Left Items', 'dimas' ),
				'description'     => esc_html__( 'Control items on the left side of header bottom', 'dimas' ),
				'transport'       => 'postMessage',
				'section'         => self::$section,
				'default'         => array(),
				'row_label'       => array(
					'type'  => 'field',
					'value' => esc_attr__( 'Item', 'dimas' ),
					'field' => 'item',
				),
				'fields'          => array(
					'item' => array(
						'type' => 'select',
						// 'choices' => $this->header_items_option(),
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_type',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
			'header_bottom_center'        => array(
				'type'            => 'repeater',
				'label'           => esc_html__( 'Center Items', 'dimas' ),
				'description'     => esc_html__( 'Control items at the center of header bottom', 'dimas' ),
				'transport'       => 'postMessage',
				'section'         => self::$section,
				'default'         => array(),
				'row_label'       => array(
					'type'  => 'field',
					'value' => esc_attr__( 'Item', 'dimas' ),
					'field' => 'item',
				),
				'fields'          => array(
					'item' => array(
						'type' => 'select',
						// 'choices' => $this->header_items_option(),
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_type',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
			'header_bottom_right'         => array(
				'type'            => 'repeater',
				'label'           => esc_html__( 'Right Items', 'dimas' ),
				'description'     => esc_html__( 'Control items on the right of header bottom', 'dimas' ),
				'transport'       => 'postMessage',
				'section'         => self::$section,
				'default'         => array(),
				'row_label'       => array(
					'type'  => 'field',
					'value' => esc_attr__( 'Item', 'dimas' ),
					'field' => 'item',
				),
				'fields'          => array(
					'item' => array(
						'type' => 'select',
						// 'choices' => $this->header_items_option(),
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_type',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
			'header_bottom_hr'            => array(
				'type'    => 'custom',
				'section' => 'header_bottom',
				'default' => '<hr>',
			),
			'header_bottom_height'        => array(
				'type'      => 'slider',
				'label'     => esc_html__( 'Header Height', 'dimas' ),
				'transport' => 'postMessage',
				'section'   => 'header_bottom',
				'default'   => '50',
				'choices'   => array(
					'min' => 0,
					'max' => 500,
				),
				'js_vars'   => array(
					array(
						'element'  => '#site-header .header-bottom',
						'property' => 'height',
						'units'    => 'px',
					),
				),
			),
			'sticky_header_bottom_height' => array(
				'type'            => 'slider',
				'label'           => esc_html__( 'Sticky Header Height', 'dimas' ),
				'description'     => esc_html__( 'Adjust Header Bottom height when the Sticky Header enabled', 'dimas' ),
				'transport'       => 'postMessage',
				'section'         => self::$section,
				'default'         => '50',
				'choices'         => array(
					'min' => 0,
					'max' => 500,
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_sticky',
						'operator' => '==',
						'value'    => 1,
					),
				),
				'js_vars'         => array(
					array(
						'element'  => '.header-sticky #site-header.minimized .header-bottom',
						'property' => 'height',
						'units'    => 'px',
					),
				),
			),
		);

		return $fields;
	}



}
