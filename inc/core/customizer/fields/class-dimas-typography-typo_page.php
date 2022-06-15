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

class Typography_Typo_Page_Fields {
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
	private static $section = 'typo_page';

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
			'typo_page_title' => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Page Title', 'dimas' ),
				'description' => esc_html__( 'Customize the page title font', 'dimas' ),
				'section'     => self::$section,
				'default'     => array(
					'font-family'    => '',
					'variant'        => '500',
					'font-size'      => '32px',
					'line-height'    => '1.33',
					'text-transform' => 'none',
					'color'          => '#111',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport'   => 'postMessage',
				'js_vars'     => array(
					array(
						'element' => '.page-header__title',
					),
				),
			),

		);

		return $fields;
	}



}
