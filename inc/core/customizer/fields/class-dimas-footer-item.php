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
 * Footer Background Color class
 */
class Footer_Item_Fields {
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
	private static $section = 'footer_item';

	/**
	 * Get customize fields
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function get_fields() {

		$fields = array(

			// Footer Item Left Enable/Disable.
			'footer_item_left_show' => array(
				'type'    => 'toggle',
				'label'   => esc_html__( 'Enable/Disable Footer Item Left', 'dimas' ),
				'section' => self::$section,
				'default' => 1,
			),
			// Footer Item Left Input Text.
			'footer_item_left_text'  => array(
				'type' => 'text',
				'settings' => 'footer_item_left_text',
				'label'    => esc_html__( 'Enter Footer Left Item Text', 'dimas' ),
				'section'         => self::$section,
				'default'  => esc_html__( 'DIMAS@DOMAIN.COM', 'dimas' ),
				'active_callback' => array(
					array(
						'setting'  => 'footer_item_left_show',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
			// Footer Item Left Input Link.
			'footer_item_left_link'  => array(
				'type' => 'text',
				'settings' => 'footer_item_left_link',
				'label'    => esc_html__( 'Enter Footer Left Item Link', 'dimas' ),
				'section'         => self::$section,
				'default'  => esc_html__( 'mailto:dimas@domain.com', 'dimas' ),
				'active_callback' => array(
					array(
						'setting'  => 'footer_item_left_show',
						'operator' => '==',
						'value'    => true,
					),
				),
			),

			// Footer Item Right Enable/Disable.
			'footer_item_right_show' => array(
				'type'    => 'toggle',
				'label'   => esc_html__( 'Enable/Disable Footer Item Right', 'dimas' ),
				'section' => self::$section,
				'default' => 1,
			),
			// Footer Item Right Input Text.
			'footer_item_right_text'  => array(
				'type' => 'text',
				'settings' => 'footer_item_right_text',
				'label'    => esc_html__( 'Enter Footer Right Item Text', 'dimas' ),
				'section'         => self::$section,
				'default'  => esc_html__( 'TELL: (+34) 765 87 34 54', 'dimas' ),
				'active_callback' => array(
					array(
						'setting'  => 'footer_item_right_show',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
			// Footer Item Right Input Link.
			'footer_item_right_link'  => array(
				'type' => 'text',
				'settings' => 'footer_item_right_link',
				'label'    => esc_html__( 'Enter Footer Right Item Link', 'dimas' ),
				'section'         => self::$section,
				'default'  => esc_html__( 'tel:(+34)765873454', 'dimas' ),
				'active_callback' => array(
					array(
						'setting'  => 'footer_item_right_show',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
		);

		return $fields;
	}

}
