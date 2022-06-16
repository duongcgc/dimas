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

class Header_Header_Campaign_Fields {
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
	private static $section = 'header_campaign';

	/**
	 * Section priority variable
	 *
	 * @var integer
	 */
	private static $section_priority = 10;

	/**
	 * Get section fields
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function get_fields() {

		$priority = self::$section_priority;

		$fields = array(

			// Header Campain
			'campaign_bar'                              => array(
				'type'        => 'toggle',
				'label'       => esc_html__('Campaign Bar', 'dimas'),
				'section'     => self::$section,
				'description' => esc_html__('Display a bar bellow site header. This bar will be hidden when the header background is transparent.', 'dimas'),
				'default'     => false,
			),
			'campaign_bar_position'                     => array(
				'type'    => 'select',
				'label'   => esc_html__('Position', 'dimas'),
				'section'     => self::$section,
				'default' => 'after',
				'choices' => array(
					'after'  => esc_html__('After Header', 'dimas'),
					'before' => esc_html__('Before Header', 'dimas'),
				),
				'active_callback' => array(
					array(
						'setting'  => 'campaign_bar',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
			'campaign_bar_height'                       => array(
				'type'      => 'slider',
				'label'     => esc_html__('Height', 'dimas'),
				'section'     => self::$section,
				'default'   => '50',
				'transport' => 'postMessage',
				'choices'   => array(
					'min' => 0,
					'max' => 500,
				),
				'js_vars'         => array(
					array(
						'element'  => '#campaign-bar',
						'property' => 'height',
						'units'    => 'px',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'campaign_bar',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
			'campaign_bar_custom_field_1'               => array(
				'type'            => 'custom',
				'section'     => self::$section,
				'default'         => '<hr/>',
				'active_callback' => array(
					array(
						'setting'  => 'campaign_bar',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
			'campaign_items'                            => array(
				'type'      => 'repeater',
				'label'     => esc_html__('Campaigns', 'dimas'),
				'section'     => self::$section,
				'transport' => 'postMessage',
				'default'   => array(),
				'row_label' => array(
					'type'  => 'field',
					'value' => esc_attr__('Campaign', 'dimas'),
				),
				'fields'          => array(
					'text'    => array(
						'type'  => 'textarea',
						'label' => esc_html__('Text', 'dimas'),
					),
					'image'   => array(
						'type'  => 'image',
						'label' => esc_html__('Background Image', 'dimas'),
					),
					'bgcolor' => array(
						'type'  => 'color',
						'label' => esc_html__('Background Color', 'dimas'),
					),
					'color'   => array(
						'type'  => 'color',
						'label' => esc_html__('Color', 'dimas'),
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'campaign_bar',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
		);

		return $fields;
	}



}
