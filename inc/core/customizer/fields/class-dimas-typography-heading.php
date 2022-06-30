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
				'default'     => dimas_defaults( 'typo_h1' ),
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
				'default'     => dimas_defaults( 'typo_h2' ),
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
				'default'     => dimas_defaults( 'typo_h3' ),
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
				'default'     => dimas_defaults( 'typo_h4' ),
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
				'default'     => dimas_defaults( 'typo_h5' ),
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
				'default'     => dimas_defaults( 'typo_h6' ),
			),
		);

		return $fields;
	}

}
