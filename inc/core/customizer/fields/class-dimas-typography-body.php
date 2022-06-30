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
 * Body Typography class
 */
class Typography_Body_Fields {
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
	private static $section = 'body_typography';

	/**
	 * Get section fields
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function get_fields() {

		$fields = array(

			// Typography body.
			'typo_main' => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Typography Body', 'dimas' ),
				'description' => esc_html__( 'Customize the main font', 'dimas' ),
				'section'     => self::$section,
				'default'     => dimas_defaults( 'typo_main' ),
			),
		);

		return $fields;
	}

}
