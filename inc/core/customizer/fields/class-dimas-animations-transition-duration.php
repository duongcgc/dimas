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
 * Animations Transition Duration class
 */
class Animations_Transition_Duration_Fields {
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
	private static $section = 'animation_transition_duration';

	/**
	 * Get customize fields
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function get_fields() {

		$fields = array(

			// Animations Transition Duration Time.
			'transition_duration_numer' => array(
				'type'    => 'slider',
				'label'   => esc_html__( 'Time Transition Duration (ms)', 'dimas' ),
				'section' => self::$section,
				'default' => 300,
				'choices' => array(
					'step' => 100,
					'min' => 200,
					'max' => 5000,
				),
			),
		);

		return $fields;
	}

}
