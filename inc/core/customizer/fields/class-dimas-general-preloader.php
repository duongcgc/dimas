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

class General_Preloader_Fields {
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
	private static $section = 'preloader';

	/**
	 * Section priority variable
	 *
	 * @var integer
	 */
	private static $section_priority = 10;

	/**
	 * Get customize fields
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function get_fields() {

		$priority = self::$section_priority;

		$fields = array(
			'preloader_enable'           => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Enable Preloader', 'dimas' ),
				'description' => esc_html__( 'Show a waiting screen when page is loading', 'dimas' ),
				'default'     => false,
				'section'     => 'preloader',
				'transport'   => 'postMessage',
			),
			'preloader_background_color' => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Background Color', 'dimas' ),
				'default'         => 'rgba(255,255,255,1)',
				'section'         => self::$section,
				'choices'         => array(
					'alpha' => true,
				),
				'active_callback' => array(
					array(
						'setting'  => 'preloader_enable',
						'operator' => '==',
						'value'    => true,
					),
				),
				'transport'       => 'postMessage',
				'js_vars'         => array(
					array(
						'element'  => '#preloader',
						'property' => 'background-color',
					),
				),
			),
			'preloader'                  => array(
				'type'            => 'radio',
				'label'           => esc_html__( 'Preloader', 'dimas' ),
				'default'         => 'default',
				'section'         => self::$section,
				'choices'         => array(
					'default'  => esc_attr__( 'Default Icon', 'dimas' ),
					'image'    => esc_attr__( 'Upload custom image', 'dimas' ),
					'external' => esc_attr__( 'External image URL', 'dimas' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'preloader_enable',
						'operator' => '==',
						'value'    => true,
					),
				),
				'transport'       => 'postMessage',
			),
			'preloader_image'            => array(
				'type'            => 'image',
				'description'     => esc_html__( 'Preloader Image', 'dimas' ),
				'section'         => self::$section,
				'active_callback' => array(
					array(
						'setting'  => 'preloader_enable',
						'operator' => '==',
						'value'    => true,
					),
					array(
						'setting'  => 'preloader',
						'operator' => '==',
						'value'    => 'image',
					),
				),
				'transport'       => 'postMessage',
			),
			'preloader_url'              => array(
				'type'            => 'text',
				'description'     => esc_html__( 'Preloader URL', 'dimas' ),
				'choices'         => array(
					'default'  => esc_attr__( 'Default Icon', 'dimas' ),
					'image'    => esc_attr__( 'Upload custom image', 'dimas' ),
					'external' => esc_attr__( 'External image URL', 'dimas' ),
				),
				'section'         => self::$section,
				'active_callback' => array(
					array(
						'setting'  => 'preloader_enable',
						'operator' => '==',
						'value'    => true,
					),
					array(
						'setting'  => 'preloader',
						'operator' => '==',
						'value'    => 'external',
					),
				),
				'transport'       => 'postMessage',
			),
		);

		return $fields;
	}



}
