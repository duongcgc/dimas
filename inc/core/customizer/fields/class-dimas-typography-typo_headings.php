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

class Typography_Typo_Headings_Fields {
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
	private static $section = 'typo_headings';

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
			'typo_h1'                        => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Heading 1', 'dimas' ),
				'description' => esc_html__( 'Customize the H1 font', 'dimas' ),
				'section' 	  => self::$section,
				'default'     => array(
					'font-family'    => '',
					'variant'        => '500',
					'font-size'      => '60px',
					'line-height'    => '1.33',
					'color'          => '#111',
					'text-transform' => 'none',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport' => 'postMessage',
				'js_vars'      => array(
					array(
						'element' => 'h1, .h1',
					),
				),
			),
			'typo_h2'                        => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Heading 2', 'dimas' ),
				'description' => esc_html__( 'Customize the H2 font', 'dimas' ),
				'section' 	  => self::$section,
				'default'     => array(
					'font-family'    => '',
					'variant'        => '500',
					'font-size'      => '40px',
					'line-height'    => '1.33',
					'color'          => '#111',
					'text-transform' => 'none',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport' => 'postMessage',
				'js_vars'      => array(
					array(
						'element' => 'h2, .h2',
					),
				),
			),
			'typo_h3'                        => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Heading 3', 'dimas' ),
				'description' => esc_html__( 'Customize the H3 font', 'dimas' ),
				'section' 	  => self::$section,
				'default'     => array(
					'font-family'    => '',
					'variant'        => '500',
					'font-size'      => '32px',
					'line-height'    => '1.33',
					'color'          => '#111',
					'text-transform' => 'none',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport' => 'postMessage',
				'js_vars'      => array(
					array(
						'element' => 'h3, .h3',
					),
				),
			),
			'typo_h4'                        => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Heading 4', 'dimas' ),
				'description' => esc_html__( 'Customize the H4 font', 'dimas' ),
				'section' 	  => self::$section,
				'default'     => array(
					'font-family'    => '',
					'variant'        => '500',
					'font-size'      => '24px',
					'line-height'    => '1.33',
					'color'          => '#111',
					'text-transform' => 'none',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport' => 'postMessage',
				'js_vars'      => array(
					array(
						'element' => 'h4, .h4',
					),
				),
			),
			'typo_h5'                        => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Heading 5', 'dimas' ),
				'description' => esc_html__( 'Customize the H5 font', 'dimas' ),
				'section' 	  => self::$section,
				'default'     => array(
					'font-family'    => '',
					'variant'        => '500',
					'font-size'      => '20px',
					'line-height'    => '1.33',
					'color'          => '#111',
					'text-transform' => 'none',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport' => 'postMessage',
				'js_vars'      => array(
					array(
						'element' => 'h5, .h5',
					),
				),
			),
			'typo_h6'                        => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Heading 6', 'dimas' ),
				'description' => esc_html__( 'Customize the H6 font', 'dimas' ),
				'section' 	  => self::$section,
				'default'     => array(
					'font-family'    => '',
					'variant'        => '500',
					'font-size'      => '16px',
					'line-height'    => '1.33',
					'color'          => '#111',
					'text-transform' => 'none',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport' => 'postMessage',
				'js_vars'      => array(
					array(
						'element' => 'h6, .h6',
					),
				),
			),
			
		);

		return $fields;
	}

	

}
