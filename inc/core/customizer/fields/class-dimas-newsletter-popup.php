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

class Newsletter_Popup_Fields {
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
	private static $section = 'newsletter_popup';

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

			// Popup
			'newsletter_popup_enable'        => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Enable Popup', 'dimas' ),
				'description' => esc_html__( 'Show a newsletter popup after website loaded.', 'dimas' ),
				'section'     => self::$section,
				'default'     => false,
				'transport'   => 'postMessage',
			),

			'newsletter_popup_layout'        => array(
				'type'            => 'radio-buttonset',
				'label'           => esc_html__( 'Popup Layout', 'dimas' ),
				'default'         => '2-columns',
				'transport'       => 'postMessage',
				'choices'         => array(
					'1-column'  => esc_attr__( '1 Column', 'dimas' ),
					'2-columns' => esc_attr__( '2 Columns', 'dimas' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'newsletter_popup_enable',
						'operator' => '==',
						'value'    => true,
					),
				),
				'section'         => self::$section,
			),

			'newsletter_popup_image'         => array(
				'type'            => 'image',
				'label'           => esc_html__( 'Image', 'dimas' ),
				'description'     => esc_html__( 'This image will be used as background of the popup if the layout is 1 Column', 'dimas' ),
				'transport'       => 'postMessage',
				'active_callback' => array(
					array(
						'setting'  => 'newsletter_popup_enable',
						'operator' => '==',
						'value'    => true,
					),
				),
				'section'         => self::$section,
			),

			'newsletter_popup_content'       => array(
				'type'            => 'editor',
				'label'           => esc_html__( 'Popup Content', 'dimas' ),
				'description'     => esc_html__( 'Enter popup content. HTML and shortcodes are allowed.', 'dimas' ),
				'active_callback' => array(
					array(
						'setting'  => 'newsletter_popup_enable',
						'operator' => '==',
						'value'    => true,
					),
				),
				'transport'       => 'postMessage',
				'section'         => self::$section,
			),

			'newsletter_popup_form'          => array(
				'type'            => 'textarea',
				'label'           => esc_html__( 'NewsLetter Form', 'dimas' ),
				'default'         => '',
				'description'     => sprintf( wp_kses_post( 'Enter the shortcode of MailChimp form . You can edit your sign - up form in the <a href= "%s" > MailChimp for WordPress form settings </a>.', 'dimas' ), admin_url( 'admin.php?page=mailchimp-for-wp-forms' ) ),
				'section'         => 'newsletter_popup',
				'active_callback' => array(
					array(
						'setting'  => 'newsletter_popup_enable',
						'operator' => '==',
						'value'    => true,
					),
				),
				'transport'       => 'postMessage',

			),

			'newsletter_popup_frequency'     => array(
				'type'            => 'number',
				'label'           => esc_html__( 'Frequency', 'dimas' ),
				'description'     => esc_html__( 'Do NOT show the popup to the same visitor again until this much days has passed.', 'dimas' ),
				'default'         => 1,
				'choices'         => array(
					'min'  => 0,
					'step' => 1,
				),
				'active_callback' => array(
					array(
						'setting'  => 'newsletter_popup_enable',
						'operator' => '==',
						'value'    => true,
					),
				),
				'transport'       => 'postMessage',
				'section'         => self::$section,
			),

			'newsletter_popup_visible'       => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Popup Visible', 'dimas' ),
				'description'     => esc_html__( 'Select when the popup appear', 'dimas' ),
				'default'         => 'loaded',
				'choices'         => array(
					'loaded' => esc_html__( 'Right after page loads', 'dimas' ),
					'delay'  => esc_html__( 'Wait for seconds', 'dimas' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'newsletter_popup_enable',
						'operator' => '==',
						'value'    => true,
					),
				),
				'transport'       => 'postMessage',
				'section'         => self::$section,
			),

			'newsletter_popup_visible_delay' => array(
				'type'            => 'number',
				'label'           => esc_html__( 'Delay Time', 'dimas' ),
				'description'     => esc_html__( 'The time (in seconds) before the popup is displayed, after the page loaded.', 'dimas' ),
				'default'         => 5,
				'choices'         => array(
					'min'  => 0,
					'step' => 1,
				),
				'active_callback' => array(
					array(
						'setting'  => 'newsletter_popup_enable',
						'operator' => '==',
						'value'    => true,
					),
					array(
						'setting'  => 'newsletter_popup_visible',
						'operator' => '==',
						'value'    => 'delay',
					),
				),
				'transport'       => 'postMessage',
				'section'         => self::$section,
			),
		);

		return $fields;
	}



}
