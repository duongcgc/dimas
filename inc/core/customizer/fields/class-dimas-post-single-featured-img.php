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
 * Post Single Fetured Img class
 */
class Post_Single_Fetured_Img_Fields {
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
	private static $section = 'post_single_fetured_img';

	/**
	 * Get customize fields
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function get_fields() {

		$fields = array(

			// Post Single Fetured Img.
			'post_single_fetured_img_show' => array(
				'type'    => 'toggle',
				'label'   => esc_html__( 'Enable/Disable Single Featured Images', 'dimas' ),
				'section' => self::$section,
				'default' => 1,
			),

		);

		return $fields;
	}

}
