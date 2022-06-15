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

class Typography_Typo_Header_Fields {
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
	private static $section = 'typo_header';

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
			'typo_menu'    => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Menu', 'dimas' ),
				'description' => esc_html__( 'Customize the menu font', 'dimas' ),
				'section'     => self::$section,
				'default'     => array(
					'font-family'    => '',
					'variant'        => '500',
					'font-size'      => '16px',
					'text-transform' => 'none',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport'   => 'postMessage',
				'js_vars'     => array(
					array(
						'element' => '.main-navigation a, .hamburger-navigation a',
					),
				),
			),
			'typo_submenu' => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Sub-Menu', 'dimas' ),
				'description' => esc_html__( 'Customize the sub-menu font', 'dimas' ),
				'section'     => self::$section,
				'default'     => array(
					'font-family'    => '',
					'variant'        => '500',
					'font-size'      => '15px',
					'text-transform' => 'none',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport'   => 'postMessage',
				'js_vars'     => array(
					array(
						'element' => '.main-navigation ul ul a, .hamburger-navigation ul ul a',
					),
				),
			),

		);

		return $fields;
	}



}
