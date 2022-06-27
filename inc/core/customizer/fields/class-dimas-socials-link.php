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
 * Social Link class
 */
class Social_Link_Fields {
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
	private static $section = 'socials_link';

	/**
	 * Get customize fields
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function get_fields() {

		$fields = array(

			// Social link.
			'social_link_count' => array(
				'type'    => 'number',
				'label'   => esc_html__( 'Counter Item of social link', 'dimas' ),
				'section' => self::$section,
				'default' => 3,
				'choices' => array(
					'min' => 1,
					'max' => 6,
				),
			),
			// Social link item 1.
			'social_link_item_1_icon_type'  => array(
				'type' => 'select',
				'settings' => 'social_link_item_1_icon_type',
				'label'    => esc_html__( 'Chose Type Icon Of Social Link Item 1', 'dimas' ),
				'section'         => self::$section,
				'default'  => 'custom',
				'choices'         => array(
					'custom' => esc_html__( 'Cumstom Icon From Theme', 'dimas' ),
					'input' => esc_html__( 'Enter Icon From Input', 'dimas' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'social_link_count',
						'operator' => '>',
						'value'    => 0,
					),
				),
			),
			'social_link_item_1_icon_custom'  => array(
				'type' => 'notice',
				'settings' => 'social_link_item_1_icon_custom',
				'label'    => esc_html__( 'Chose Icon Of Social Link Item 1', 'dimas' ),
				'section'         => self::$section,
				'default'  => 'dimas_fb',
				'choices'         => SVG_Icons::get_all_theme_svg(),
				'active_callback' => array(
					array(
						'setting'  => 'social_link_count',
						'operator' => '>',
						'value'    => 0,
					),
					array(
						'setting'  => 'social_link_item_1_icon_type',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
			'social_link_item_1_icon_input'  => array(
				'type' => 'textarea',
				'settings' => 'social_link_item_1_icon_input',
				'label'    => esc_html__( 'Enter Icon Of Social Link Item 1', 'dimas' ),
				'section'         => self::$section,
				'default'  => '',
				'active_callback' => array(
					array(
						'setting'  => 'social_link_count',
						'operator' => '>',
						'value'    => 0,
					),
					array(
						'setting'  => 'social_link_item_1_icon_type',
						'operator' => '==',
						'value'    => 'input',
					),
				),
			),
			'post_archive_style_chose'   => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Chose Style', 'dimas' ),
				'section'         => self::$section,
				'default'         => 'masonry',
				'choices'         => array(
					'flex' => esc_html__( 'Flex', 'dimas' ),
					'grid' => esc_html__( 'Grid', 'dimas' ),
					'masonry'      => esc_html__( 'Masonry', 'dimas' ),
				),
			),
			'social_link_item_1_text'  => array(
				'type' => 'text',
				'settings' => 'social_link_item_1_text',
				'label'    => esc_html__( 'Enter Text Of Social Link Item 1', 'dimas' ),
				'section'         => self::$section,
				'default'  => '',
				'active_callback' => array(
					array(
						'setting'  => 'social_link_count',
						'operator' => '>',
						'value'    => 0,
					),
				),
			),
			'social_link_item_1_link'  => array(
				'type' => 'text',
				'settings' => 'social_link_item_1_text',
				'label'    => esc_html__( 'Enter Link Of Social Link Item 1', 'dimas' ),
				'section'         => self::$section,
				'default'  => '',
				'active_callback' => array(
					array(
						'setting'  => 'social_link_count',
						'operator' => '>',
						'value'    => 0,
					),
				),
			),

		);

		return $fields;
	}

}
