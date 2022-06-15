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

class Typography_Typo_Main_Fields {
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
	private static $section = 'typo_main';

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
			'typo_body'                      => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Body', 'dimas' ),
				'description' => esc_html__( 'Customize the body font', 'dimas' ),
				'section' 	  => 'typo_main',
				'default'     => array(
					'font-family' => '',
					'variant'     => '400',
					'font-size'   => '16px',
					'line-height' => '1.5',
					'color'       => '#525252',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport' => 'postMessage',
				'js_vars'      => array(
					array(
						'element' => 'body',
					),
				),
			),
			
		);

		return $fields;
	}

	

}
