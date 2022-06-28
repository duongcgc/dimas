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
 * Post Archive Title class
 */
class Post_Archive_Title_Fields {
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
	private static $section = 'post_archive_title';

	/**
	 * Get customize fields
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function get_fields() {

		$fields = array(

			// Post Archive Title Enable/Disable.
			'post_archive_title_show' => array(
				'type'    => 'toggle',
				'label'   => esc_html__( 'Enable/Disable Archive Title', 'dimas' ),
				'section' => self::$section,
				'default' => dimas_defaults( 'post_archive_title_show' ),
			),

			// Post Archive Title Type.
			'post_archive_title_type'   => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Chose Type Of Archive Name', 'dimas' ),
				'section'         => self::$section,
				'default'         => dimas_defaults( 'post_archive_title_type' ),
				'choices'         => array(
					'custom'      => esc_html__( 'Name Of Archive', 'dimas' ),
					'enter_input' => esc_html__( 'Name Form Input Fields', 'dimas' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'post_archive_title_show',
						'operator' => '==',
						'value'    => true,
					),
				),
			),

			// Post Archive Input Title.
			'post_archive_title_input'  => array(
				'type' => 'text',
				'settings' => 'post_archive_title_input',
				'label'    => esc_html__( 'Enter Archive Title Show', 'dimas' ),
				'section'         => self::$section,
				'default'  => dimas_defaults( 'post_archive_title_input' ),
				'active_callback' => array(
					array(
						'setting'  => 'post_archive_title_type',
						'operator' => '==',
						'value'    => 'enter_input',
					),
				),
			),

		);

		return $fields;
	}

}
