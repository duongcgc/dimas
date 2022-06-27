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
 * Social Share class
 */
class Social_Share_Fields {
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

		$fields = array(

			// Social share.
			'social_share_count' => array(
				'type'    => 'slider',
				'label'   => esc_html__( 'Counter Item of social share', 'dimas' ),
				'section' => self::$section,
				'default' => 3,
				'choices' => array(
					'min' => 1,
					'max' => 6,
				),
			),
			// Social share item 1.
			'social_share_item_1_text'  => array(
				'type' => 'text',
				'settings' => 'social_share_item_1_text',
				'label'    => esc_html__( 'Enter Social Share Item 1 Text', 'dimas' ),
				'section'         => self::$section,
				'default'  => '',
				'active_callback' => array(
					array(
						'setting'  => 'social_share_count',
						'operator' => '=>',
						'value'    => 1,
					),
				),
			),
		);

		return $fields;
	}

}
