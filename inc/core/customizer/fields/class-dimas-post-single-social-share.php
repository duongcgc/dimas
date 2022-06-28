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
 * Post Single Social Share class
 */
class Post_Single_Social_Share_Fields {
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
	private static $section = 'post_single_social_share';

	/**
	 * Get customize fields
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function get_fields() {

		$fields = array(

			// Post Single Social Share.
			'post_single_social_share_show' => array(
				'type'    => 'toggle',
				'label'   => esc_html__( 'Enable/Disable Single Social Share', 'dimas' ),
				'section' => self::$section,
				'default' => dimas_defaults( 'post_single_social_share_show' ),
			),

		);

		return $fields;
	}

}
