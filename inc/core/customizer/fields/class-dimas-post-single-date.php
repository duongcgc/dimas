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
 * Post Single Posted Date class
 */
class Post_Single_Date_Fields {
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
	private static $section = 'post_single_date';

	/**
	 * Get customize fields
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function get_fields() {

		$fields = array(

			// Single Posted Date.
			'post_single_date_show' => array(
				'type'    => 'toggle',
				'label'   => esc_html__( 'Enable/Disable Single Posted Date', 'dimas' ),
				'section' => self::$section,
				'default' => dimas_defaults( 'post_single_date_show' ),
			),

		);

		return $fields;
	}

}
