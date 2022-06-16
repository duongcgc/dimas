<?php

/**
 * Customize Fields
 *
 * @package Dimas
 */

namespace Dimas\Core\Customizer;

// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

class Footer_Fields {
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
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}

		return self:: $instance;
	}	

	/**
	 * Section name.
	 *
	 * @var string
	 */
	private static $section = 'colors';

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

			// Boxed Layout
			'boxed_layout'                => array(
				'type'     => 'toggle',
				'label'    => esc_html__('Boxed Layout', 'dimas'),
				'section'  => self::$section,
				'default'  => 0,
				'priority' => $priority++,
			),
			'boxed_background_color'      => array(
				'type'            => 'color',
				'label'           => esc_html__('Background Color', 'dimas'),
				'default'         => '',
				'section'         => self::$section,
				'priority' => $priority++,
				'active_callback' => array(
					array(
						'setting'  => 'boxed_layout',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'boxed_background_image'      => array(
				'type'            => 'image',
				'label'           => esc_html__('Background Image', 'dimas'),
				'default'         => '',
				'section'         => self::$section,
				'priority' => $priority++,
				'active_callback' => array(
					array(
						'setting'  => 'boxed_layout',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'boxed_background_horizontal' => array(
				'type'     => 'select',
				'label'    => esc_html__('Background Horizontal', 'dimas'),
				'section'  => self::$section,
				'default'  => '',
				'priority' => $priority++,
				'choices'  => array(
					''       => esc_html__('None', 'dimas'),
					'left'   => esc_html__('Left', 'dimas'),
					'center' => esc_html__('Center', 'dimas'),
					'right'  => esc_html__('Right', 'dimas'),
				),
				'active_callback' => array(
					array(
						'setting'  => 'boxed_layout',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'boxed_background_vertical'   => array(
				'type'     => 'select',
				'label'    => esc_html__('Background Vertical', 'dimas'),
				'section'  => self::$section,
				'default'  => '',
				'priority' => $priority++,
				'choices'  => array(
					''       => esc_html__('None', 'dimas'),
					'top'    => esc_html__('Top', 'dimas'),
					'center' => esc_html__('Center', 'dimas'),
					'bottom' => esc_html__('Bottom', 'dimas'),
				),
				'active_callback' => array(
					array(
						'setting'  => 'boxed_layout',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'boxed_background_repeat'     => array(
				'type'     => 'select',
				'label'    => esc_html__('Background Repeat', 'dimas'),
				'section'  => self::$section,
				'default'  => '',
				'priority' => $priority++,
				'choices'  => array(
					''          => esc_html__('None', 'dimas'),
					'no-repeat' => esc_html__('No Repeat', 'dimas'),
					'repeat'    => esc_html__('Repeat', 'dimas'),
					'repeat-y'  => esc_html__('Repeat Vertical', 'dimas'),
					'repeat-x'  => esc_html__('Repeat Horizontal', 'dimas'),
				),
				'active_callback' => array(
					array(
						'setting'  => 'boxed_layout',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'boxed_background_attachment' => array(
				'type'     => 'select',
				'label'    => esc_html__('Background Attachment', 'dimas'),
				'section'  => self::$section,
				'default'  => '',
				'priority' => $priority++,
				'choices'  => array(
					''       => esc_html__('None', 'dimas'),
					'scroll' => esc_html__('Scroll', 'dimas'),
					'fixed'  => esc_html__('Fixed', 'dimas'),
				),
				'active_callback' => array(
					array(
						'setting'  => 'boxed_layout',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'boxed_background_size'       => array(
				'type'     => 'select',
				'label'    => esc_html__('Background Size', 'dimas'),
				'section'  => self::$section,
				'default'  => '',
				'priority' => $priority++,
				'choices'  => array(
					''        => esc_html__('None', 'dimas'),
					'auto'    => esc_html__('Auto', 'dimas'),
					'cover'   => esc_html__('Cover', 'dimas'),
					'contain' => esc_html__('Contain', 'dimas'),
				),
				'active_callback' => array(
					array(
						'setting'  => 'boxed_layout',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
		);

		return $fields;
	}

	

}
