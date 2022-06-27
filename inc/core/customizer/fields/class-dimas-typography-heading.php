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
 * Heading color class
 */
class Typography_Heading_Fields {
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
	private static $section = 'heading_typography';

	/**
	 * Get section fields
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function get_fields() {

		$fields = array(

			// Typography H1.
			'typo_h1' => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Heading 1', 'dimas' ),
				'description' => esc_html__( 'Customize the H1 font', 'dimas' ),
				'section'     => self::$section,
				'choices'     => array(
					'fonts' => array(
						'families' => array(
							'custom' => array(
								'text'     => 'The Custom Font Added',
								'children' => array(
									array(
										'id'   => 'Heist',
										'text' => 'Heist',
									),
								),
							),
						),
						'variants' => array(
							'Heist' => array( 'regular', '500', '600', '700' ),
						),
					),
				),
				'default'     => array(
					'font-family'    => 'Heist',
					'variant'        => 'regular',
					'font-size'      => '5rem',
					'line-height'    => '1.25',
					'color'          => '#fff',
					'text-transform' => 'none',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport'   => 'postMessage',
				'js_vars'     => array(
					array(
						'element' => 'h1, .h1',
					),
				),
			),

			// Typography H2.
			'typo_h2' => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Heading 2', 'dimas' ),
				'description' => esc_html__( 'Customize the H2 font', 'dimas' ),
				'section'     => self::$section,
				'choices'     => array(
					'fonts' => array(
						'families' => array(
							'custom' => array(
								'text'     => 'The Custom Font Added',
								'children' => array(
									array(
										'id'   => 'Heist',
										'text' => 'Heist',
									),
								),
							),
						),
						'variants' => array(
							'Heist' => array( 'regular', '500', '600', '700' ),
						),
					),
				),
				'default'     => array(
					'font-family'    => 'Heist',
					'variant'        => 'regular',
					'font-size'      => '3.5rem',
					'line-height'    => '1.25',
					'color'          => '#fff',
					'text-transform' => 'none',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport'   => 'postMessage',
				'js_vars'     => array(
					array(
						'element' => 'h2, .h2',
					),
				),
			),

			// Typography H3.
			'typo_h3' => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Heading 3', 'dimas' ),
				'description' => esc_html__( 'Customize the H3 font', 'dimas' ),
				'section'     => self::$section,
				'choices'     => array(
					'fonts' => array(
						'families' => array(
							'custom' => array(
								'text'     => 'The Custom Font Added',
								'children' => array(
									array(
										'id'   => 'Heist',
										'text' => 'Heist',
									),
								),
							),
						),
						'variants' => array(
							'Heist' => array( 'regular', '500', '600', '700' ),
						),
					),
				),
				'default'     => array(
					'font-family'    => 'Heist',
					'variant'        => 'regular',
					'font-size'      => '1.25rem',
					'line-height'    => '1.3',
					'color'          => '#fff',
					'text-transform' => 'none',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport'   => 'postMessage',
				'js_vars'     => array(
					array(
						'element' => 'h3, .h3',
					),
				),
			),

			// Typography H4.
			'typo_h4' => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Heading 4', 'dimas' ),
				'description' => esc_html__( 'Customize the H4 font', 'dimas' ),
				'section'     => self::$section,
				'choices'     => array(
					'fonts' => array(
						'families' => array(
							'custom' => array(
								'text'     => 'The Custom Font Added',
								'children' => array(
									array(
										'id'   => 'Heist',
										'text' => 'Heist',
									),
								),
							),
						),
						'variants' => array(
							'Heist' => array( 'regular', '500', '600', '700' ),
						),
					),
				),
				'default'     => array(
					'font-family'    => 'Outfit',
					'variant'        => '700',
					'font-size'      => '1.25rem',
					'line-height'    => '1.1875',
					'color'          => '#fff',
					'text-transform' => 'none',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport'   => 'postMessage',
				'js_vars'     => array(
					array(
						'element' => 'h4, .h4',
					),
				),
			),

			// Typography H5.
			'typo_h5' => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Heading 5', 'dimas' ),
				'description' => esc_html__( 'Customize the H5 font', 'dimas' ),
				'section'     => self::$section,
				'choices'     => array(
					'fonts' => array(
						'families' => array(
							'custom' => array(
								'text'     => 'The Custom Font Added',
								'children' => array(
									array(
										'id'   => 'Heist',
										'text' => 'Heist',
									),
								),
							),
						),
						'variants' => array(
							'Heist' => array( 'regular', '500', '600', '700' ),
						),
					),
				),
				'default'     => array(
					'font-family'    => 'Poppins',
					'variant'        => 'regular',
					'font-size'      => '1rem',
					'line-height'    => '1.25',
					'color'          => '#F21967',
					'text-transform' => 'none',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport'   => 'postMessage',
				'js_vars'     => array(
					array(
						'element' => 'h5, .h5',
					),
				),
			),

			// Typography H6.
			'typo_h6' => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Heading 6', 'dimas' ),
				'description' => esc_html__( 'Customize the H6 font', 'dimas' ),
				'section'     => self::$section,
				'choices'     => array(
					'fonts' => array(
						'families' => array(
							'custom' => array(
								'text'     => 'The Custom Font Added',
								'children' => array(
									array(
										'id'   => 'Heist',
										'text' => 'Heist',
									),
								),
							),
						),
						'variants' => array(
							'Heist' => array( 'regular', '500', '600', '700' ),
						),
					),
				),
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
						'element' => 'h6, .h6',
					),
				),
			),
		);

		return $fields;
	}

}
