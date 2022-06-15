<?php

/**
 * Customize Fields
 *
 * @package Dimas
 */

namespace Dimas\Core\Customizer;

// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

class Colors_Fields {
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
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}

		return self:: $instance;
	}	

	/**
	 * Section name.
	 *
	 * @var string
	 */
	private static $section = 'colors';

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

			// Colors
			'color_scheme_title'  => array(
				'type'  => 'custom',
				'section'     => self::$section,
				'label' => esc_html__( 'Color Scheme', 'dimas' ),
			),
			'color_scheme'        => array(
				'type'            => 'color-palette',
				'default'         => '#ff6F61',
				'choices'         => array(
					'colors' => array(
						'#ff6F61',
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
				'section'     => self::$section,
				'active_callback' => array(
					array(
						'setting'  => 'color_scheme_custom',
						'operator' => '!=',
						'value'    => true,
					),
				),
			),
			'color_scheme_custom' => array(
				'type'      => 'checkbox',
				'label'     => esc_html__( 'Pick my favorite color', 'dimas' ),
				'default'   => false,
				'section'     => self::$section,
			),
			'color_scheme_color'  => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Custom Color', 'dimas' ),
				'default'         => '#161619',
				'section'     => 'colors',
				'active_callback' => array(
					array(
						'setting'  => 'color_scheme_custom',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
		);

		return $fields;
	}

	

}
