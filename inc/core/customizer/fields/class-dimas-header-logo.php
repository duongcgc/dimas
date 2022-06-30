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
				'default' => dimas_defaults( 'logo_type' ),
				'section' => self::$section,
				'choices' => array(
					'image' => esc_html__( 'Image', 'dimas' ),
					'svg'  => esc_html__( 'Svg', 'dimas' ),
					'text'  => esc_html__( 'Text', 'dimas' ),
				),
			),
			'logo_svg'       => array(
				'type'              => 'textarea',
				'label'             => esc_html__( 'Logo SVG', 'dimas' ),
				'section'           => 'header_logo',
				'description'       => esc_html__( 'Paste SVG code of your logo here', 'dimas' ),
				'sanitize_callback' => '\Dimas\SVG_Icons::get_sanitize_svg',
				'output'            => array(
					array(
						'element' => 'a.dimas-navbar-logo',
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
				'default'         => dimas_defaults( 'logo' ),
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
				'section'           => 'header_logo',
				'description'       => esc_html__( 'Paste SVG code of your logo here', 'dimas' ),
				'sanitize_callback' => '\Dimas\SVG_Icons::get_sanitize_svg',
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
				'default'         => dimas_defaults( 'logo_light' ),
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
				'default'         => dimas_defaults( 'logo_text' ),
				'section'         => self::$section,
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
				'default'         => dimas_defaults( 'logo_dimension' ),
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
