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
					'text'  => esc_html__( 'Text', 'dimas' ),
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
