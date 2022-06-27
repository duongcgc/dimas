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
 * Header Logo class
 */
class Header_Logo_Fields {
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
	private static $section = 'header_logo';

	/**
	 * Get customize fields
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function get_fields() {

		$fields = array(

			// Header Logo.
			'logo_type'      => array(
				'type'    => 'radio',
				'label'   => esc_html__( 'Logo Type', 'dimas' ),
				'default' => 'text',
				'section' => self::$section,
				'choices' => array(
					'image' => esc_html__( 'Image', 'dimas' ),
					'svg'   => esc_html__( 'SVG', 'dimas' ),
					'text'  => esc_html__( 'Text', 'dimas' ),
				),
			),
			'logo_svg'       => array(
				'type'              => 'textarea',
				'label'             => esc_html__( 'Logo SVG', 'dimas' ),
				'section'           => self::$section,
				'description'       => esc_html__( 'Paste SVG code of your logo here', 'dimas' ),
				'sanitize_callback' => '\dimas\Icon::sanitize_svg',
				'output'            => array(
					array(
						'element' => '.dimas-navbar-logo img',
					),
				),
				'active_callback'   => array(
					array(
						'setting'  => 'logo_type',
						'operator' => '==',
						'value'    => 'svg',
					),
				),
			),
			'logo'           => array(
				'type'            => 'image',
				'label'           => esc_html__( 'Logo', 'dimas' ),
				'default'         => '',
				'section'         => self::$section,
				'active_callback' => array(
					array(
						'setting'  => 'logo_type',
						'operator' => '==',
						'value'    => 'image',
					),
				),
			),
			'logo_svg_light' => array(
				'type'              => 'textarea',
				'label'             => esc_html__( 'Logo Light SVG', 'dimas' ),
				'section'           => self::$section,
				'description'       => esc_html__( 'Paste SVG code of your logo here', 'dimas' ),
				'sanitize_callback' => '\dimas\Icon::sanitize_svg',
				'output'            => array(
					array(
						'element' => '.dimas-navbar-logo img',
					),
				),
				'active_callback'   => array(
					array(
						'setting'  => 'logo_type',
						'operator' => '==',
						'value'    => 'svg',
					),
				),
			),
			'logo_light'     => array(
				'type'            => 'image',
				'label'           => esc_html__( 'Logo Light', 'dimas' ),
				'default'         => '',
				'section'         => self::$section,
				'active_callback' => array(
					array(
						'setting'  => 'logo_type',
						'operator' => '==',
						'value'    => 'image',
					),
				),
			),
			'logo_text'      => array(
				'type'            => 'textarea',
				'label'           => esc_html__( 'Logo Text', 'dimas' ),
				'default'         => 'Dimas.',
				'section'         => self::$section,
				'output'          => array(
					array(
						'element' => '.dimas-navbar-logo img',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'logo_type',
						'operator' => '==',
						'value'    => 'text',
					),
				),
			),
			'logo_dimension' => array(
				'type'            => 'dimensions',
				'label'           => esc_html__( 'Logo Dimension', 'dimas' ),
				'default'         => array(
					'width'  => '',
					'height' => '',
				),
				'section'         => self::$section,
				'active_callback' => array(
					array(
						'setting'  => 'logo_type',
						'operator' => '==',
						'value'    => 'image',
					),
				),
			),
		);

		return $fields;
	}

}
