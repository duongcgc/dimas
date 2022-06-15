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

class Header_Header_Layout_Fields {
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
	private static $section = 'header_layout';

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

			// Header Layout
			'header_type'                  => array(
				'type'        => 'radio',
				'label'       => esc_html__( 'Header Type', 'dimas' ),
				'description' => esc_html__( 'Select a default header or custom header', 'dimas' ),
				'section'     => self::$section,
				'default'     => 'default',
				'choices'     => array(
					'default' => esc_html__( 'Use pre-build header', 'dimas' ),
					'custom'  => esc_html__( 'Build my own', 'dimas' ),
				),
			),
			'header_layout'                => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Header Layout', 'dimas' ),
				'section'         => self::$section,
				'default'         => 'v1',
				'choices'         => array(
					'v1' => esc_html__( 'Header v1', 'dimas' ),
					'v2' => esc_html__( 'Header v2', 'dimas' ),
					'v3' => esc_html__( 'Header v3', 'dimas' ),
					'v4' => esc_html__( 'Header v4', 'dimas' ),
					'v5' => esc_html__( 'Header v5', 'dimas' ),
					'v6' => esc_html__( 'Header v6', 'dimas' ),
					'v7' => esc_html__( 'Header v7', 'dimas' ),
					'v8' => esc_html__( 'Header v8', 'dimas' ),
					'v9' => esc_html__( 'Header v9', 'dimas' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_type',
						'operator' => '==',
						'value'    => 'default',
					),
				),
			),
			'header_search_icon'           => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Header Search', 'dimas' ),
				'section'         => self::$section,
				'default'         => 1,
				'active_callback' => array(
					array(
						'setting'  => 'header_type',
						'operator' => '==',
						'value'    => 'default',
					),
					array(
						'setting'  => 'header_layout',
						'operator' => 'in',
						'value'    => array( 'v1', 'v2', 'v3', 'v5', 'v6', 'v8', 'v9' ),
					),
				),
			),
			'header_account_icon'          => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Header Account', 'dimas' ),
				'section'         => self::$section,
				'default'         => 1,
				'active_callback' => array(
					array(
						'setting'  => 'header_type',
						'operator' => '==',
						'value'    => 'default',
					),
					array(
						'setting'  => 'header_layout',
						'operator' => 'in',
						'value'    => array( 'v1', 'v2', 'v3', 'v4', 'v5', 'v6', 'v8', 'v9' ),
					),
				),
			),
			'header_wishlist_icon'         => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Header Wishlist', 'dimas' ),
				'section'         => self::$section,
				'default'         => 1,
				'active_callback' => array(
					array(
						'setting'  => 'header_type',
						'operator' => '==',
						'value'    => 'default',
					),
					array(
						'setting'  => 'header_layout',
						'operator' => 'in',
						'value'    => array( 'v1', 'v2', 'v3', 'v4', 'v5', 'v6', 'v8', 'v9' ),
					),
				),
			),
			'header_cart_icon'             => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Header Cart', 'dimas' ),
				'section'         => self::$section,
				'default'         => 1,
				'active_callback' => array(
					array(
						'setting'  => 'header_type',
						'operator' => '==',
						'value'    => 'default',
					),
					array(
						'setting'  => 'header_layout',
						'operator' => 'in',
						'value'    => array( 'v1', 'v2', 'v3', 'v4', 'v5', 'v6', 'v7', 'v8', 'v9' ),
					),
				),
			),
			'header_layout_custom_field_1' => array(
				'type'    => 'custom',
				'section' => self::$section,
				'default' => '<hr/>',
			),

			// Header Sticky
			'header_sticky'                => array(
				'type'    => 'toggle',
				'label'   => esc_html__( 'Sticky Header', 'dimas' ),
				'default' => 0,
				'section' => self::$section,
			),
			'header_width'                 => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Header Width', 'dimas' ),
				'section' => self::$section,
				'default' => '',
				'choices' => array(
					''      => esc_html__( 'Normal', 'dimas' ),
					'large' => esc_html__( 'Large', 'dimas' ),
					'wide'  => esc_html__( 'Wide', 'dimas' ),
				),
			),
			'header_sticky_el'             => array(
				'type'            => 'multicheck',
				'label'           => esc_html__( 'Sticky Header Elements', 'dimas' ),
				'section'         => 'header_layout',
				'default'         => array( 'header_main' ),
				'priority'        => 10,
				'choices'         => array(
					'header_main'   => esc_html__( 'Header Main', 'dimas' ),
					'header_bottom' => esc_html__( 'Header Bottom', 'dimas' ),
				),
				'active_callback' => function() {
					// return $this->display_header_sticky();
				},
			),
		);

		return $fields;
	}



}
