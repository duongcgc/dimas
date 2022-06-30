<?php
/**
 * Customize Fields
 *
 * @package Dimas
 */

namespace Dimas\Core\Customizer;

use \Dimas\SVG_Icons;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Info class
 */
class Info_Fields {
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
	private static $section = 'socials_share';

	/**
	 * Get customize fields
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function get_fields() {

		$max_item = 6;
		$fields   = array(

			// Social share.
			'info_count' => array(
				'type'    => 'number',
				'label'   => esc_html__( 'Counter Item Of Info', 'dimas' ),
				'section' => self::$section,
				'default' => dimas_defaults( 'info_count' ),
				'choices' => array(
					'min' => 1,
					'max' => $max_item,
				),
			),

		);

		for ( $i = 1;$i <= $max_item;$i++ ) {
			$fields[ 'info_item_' . $i . '_icon_type' ]   = array(
				'type'            => 'select',
				'settings'        => 'info_item_' . $i . '_icon_type',
				/* translators: %s: the number of items*/
				'label'           => esc_html( sprintf( __( 'Chose Type Icon Of Info Item %d' ), $i ) ),
				'section'         => self::$section,
				'default'         => dimas_defaults( 'info_item_' . $i . '_icon_type' ),
				'choices'         => array(
					'custom' => esc_html__( 'Cumstom Icon From Theme', 'dimas' ),
					'input'  => esc_html__( 'Enter Icon From Input', 'dimas' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'info_count',
						'operator' => '>',
						'value'    => $i - 1,
					),
				),
			);
			$fields[ 'info_item_' . $i . '_icon_custom' ] = array(
				'type'            => 'select',
				'settings'        => 'info_item_' . $i . '_icon_custom',
				/* translators: %s: the number of items*/
				'label'           => esc_html( sprintf( __( 'Chose Icon Of Info Item %d' ), $i ) ),
				'section'         => self::$section,
				'default'         => dimas_defaults( 'info_item_' . $i . '_icon_custom' ),
				'choices'         => SVG_Icons::get_all_theme_svg(),
				'active_callback' => array(
					array(
						'setting'  => 'info_count',
						'operator' => '>',
						'value'    => $i - 1,
					),
					array(
						'setting'  => 'info_item_' . $i . '_icon_type',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			);
			$fields[ 'info_item_' . $i . '_icon_input' ]  = array(
				'type'            => 'textarea',
				'settings'        => 'info_item_' . $i . '_icon_input',
				/* translators: %s: the number of items*/
				'label'           => esc_html( sprintf( __( 'Enter Icon Of Info Item %d' ), $i ) ),
				'section'         => self::$section,
				'default'         => dimas_defaults( 'info_item_' . $i . '_icon_input' ),
				'active_callback' => array(
					array(
						'setting'  => 'info_count',
						'operator' => '>',
						'value'    => $i - 1,
					),
					array(
						'setting'  => 'info_item_' . $i . '_icon_type',
						'operator' => '==',
						'value'    => 'input',
					),
				),
			);
			$fields[ 'info_item_' . $i . '_text' ]        = array(
				'type'            => 'text',
				'settings'        => 'info_item_' . $i . '_text',
				/* translators: %s: the number of items*/
				'label'           => esc_html( sprintf( __( 'Enter Text Of Info Item %d' ), $i ) ),
				'section'         => self::$section,
				'default'         => dimas_defaults( 'info_item_' . $i . '_text' ),
				'active_callback' => array(
					array(
						'setting'  => 'info_count',
						'operator' => '>',
						'value'    => $i - 1,
					),
				),
			);
			$fields[ 'info_item_' . $i . '_link' ]        = array(
				'type'            => 'link',
				'settings'        => 'info_item_' . $i . '_link',
				/* translators: %s: the number of items*/
				'label'           => esc_html( sprintf( __( 'Enter Link Of Info Item %d' ), $i ) ),
				'section'         => self::$section,
				'default'         => dimas_defaults( 'info_item_' . $i . '_link' ),
				'active_callback' => array(
					array(
						'setting'  => 'info_count',
						'operator' => '>',
						'value'    => $i - 1,
					),
				),
			);
		}

		return $fields;
	}

}
