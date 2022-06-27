<?php
/**
 * Customize Fields
 *
 * @package Dimas
 */

namespace Dimas\Core\Customizer;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Body Typography class
 */
class Typography_Body_Fields {
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
	private static $section = 'body_typography';

	/**
	 * Get section fields
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function get_fields() {

		$fields = array(

			// Typography body.
			'typo_main' => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Typography Body', 'dimas' ),
				'description' => esc_html__( 'Customize the main font', 'dimas' ),
				'section'     => self::$section,
				'default'     => array(
					'font-family'    => 'Poppins',
					'variant'        => 'regular',
					'font-size'      => '0.875rem',
					'line-height'    => '1.8571428571',
					'color'          => '#B3BBC0',
					'text-transform' => 'none',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport'   => 'postMessage',
				'js_vars'     => array(
					array(
						'element' => 'p, body',
					),
				),
			),
		);

		return $fields;
	}

}
