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

class Typography_Typo_Widget_Fields {
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
	private static $section = 'typo_widget';

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

			// Typography
			'typo_widget_title'   => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Widget Title', 'dimas' ),
				'description' => esc_html__( 'Customize the widget title font', 'dimas' ),
				'section'     => self::$section,
				'default'     => array(
					'font-family'    => '',
					'variant'        => '600',
					'font-size'      => '16px',
					'text-transform' => 'uppercase',
					'color'          => '#111',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport'   => 'postMessage',
				'js_vars'     => array(
					array(
						'element' => '.widget-title, .footer-widgets .widget-title',
					),
				),
			),

			'typo_footer_extra'   => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Footer Extra', 'dimas' ),
				'description' => esc_html__( 'Customize the font of footer extra', 'dimas' ),
				'section'     => self::$section,
				'default'     => array(
					'font-family'    => '',
					'variant'        => 'regular',
					'font-size'      => '16px',
					'text-transform' => 'none',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport'   => 'postMessage',
				'js_vars'     => array(
					array(
						'element' => '.footer-extra',
					),
				),
			),
			'typo_footer_widgets' => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Footer Widgets', 'dimas' ),
				'description' => esc_html__( 'Customize the font of footer widgets', 'dimas' ),
				'section'     => self::$section,
				'default'     => array(
					'font-family'    => '',
					'variant'        => 'regular',
					'font-size'      => '16px',
					'text-transform' => 'none',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport'   => 'postMessage',
				'js_vars'     => array(
					array(
						'element' => '.footer-widgets',
					),
				),
			),
			'typo_footer_main'    => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Footer Main', 'dimas' ),
				'description' => esc_html__( 'Customize the font of footer main', 'dimas' ),
				'section'     => self::$section,
				'default'     => array(
					'font-family'    => '',
					'variant'        => 'regular',
					'font-size'      => '14px',
					'text-transform' => 'none',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport'   => 'postMessage',
				'js_vars'     => array(
					array(
						'element' => '.footer-main',
					),
				),
			),

		);

		return $fields;
	}



}
