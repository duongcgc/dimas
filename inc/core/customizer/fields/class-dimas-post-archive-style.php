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
 * Post Archive Style class
 */
class Post_Archive_Style_Fields {
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
	private static $section = 'post_archive_style';

	/**
	 * Get customize fields
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function get_fields() {

		$fields = array(

			// Post Archive Style Chose.
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

		);

		return $fields;
	}

}
