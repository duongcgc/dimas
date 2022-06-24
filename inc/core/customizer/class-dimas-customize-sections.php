<?php

/**
 * Customize Sections
 *
 * @package Dimas
 */

namespace Dimas\Core\Customizer;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Sections {
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
	 * $dimas_sections
	 *
	 * @var $dimas_sections
	 */
	public $dimas_sections = null;

	/**
	 * The class constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_filter( 'dimas_customize_sections', array( $this, 'customize_sections' ) );
	}

	/**
	 * Get customize sections
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function customize_sections() {

		$sections = array(

			// General
			'preloader'               => array(
				'title'    => esc_html__( 'Preloader', 'dimas' ),
				'priority' => 20,
				'panel'    => 'general',
			),


			'colors_main'                  => array(
				'title'    => esc_html__( 'Main Colors', 'dimas' ),
				'panel'    => 'colors',
				'priority' => 10,
			),

			'colors_heading'                  => array(
				'title'    => esc_html__( 'Heading Colors', 'dimas' ),
				'panel'    => 'colors',
				'priority' => 20,
			),

			'colors_body'                  => array(
				'title'    => esc_html__( 'Body Colors', 'dimas' ),
				'panel'    => 'colors',
				'priority' => 30,
			),

		);

		return $sections;
	}

}
