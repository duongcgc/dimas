<?php
/**
 * Customize Panels
 *
 * @package Dimas
 */

namespace Dimas\Core\Customizer;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Panels class
 */
class Panels {
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
	 * $dimas_panels
	 *
	 * @var $dimas_panels
	 */
	public $dimas_panels = null;

	/**
	 * The class constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_filter( 'dimas_customize_panels', array( $this, 'customize_panels' ) );
	}

	/**
	 * Get customize panels
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function customize_panels() {

		$panels = array(

			// General.
			'general'      => array(
				'priority' => 10,
				'title'    => esc_html__( 'General', 'dimas' ),
			),

			// Colors.
			'colors'       => array(
				'priority' => 20,
				'title'    => esc_html__( 'Colors', 'dimas' ),
			),

			// Typography.
			'typography'   => array(
				'priority' => 30,
				'title'    => esc_html__( 'Typography', 'dimas' ),
			),

			// Animations.
			'animations'   => array(
				'priority' => 40,
				'title'    => esc_html__( 'Animations', 'dimas' ),
			),

			// Custom Header.
			'header'       => array(
				'priority' => 50,
				'title'    => esc_html__( 'Header', 'dimas' ),
			),

			// Custom Page.
			'pages'        => array(
				'priority' => 60,
				'title'    => esc_html__( 'Pages', 'dimas' ),
			),

			// Custom Posts Single.
			'post_single'  => array(
				'priority' => 70,
				'title'    => esc_html__( 'Posts Single', 'dimas' ),
			),

			// Custom Posts Archive.
			'post_archive' => array(
				'priority' => 80,
				'title'    => esc_html__( 'Posts Archive', 'dimas' ),
			),

			// Custom Footer.
			'footer'       => array(
				'priority' => 90,
				'title'    => esc_html__( 'Footer', 'dimas' ),
			),

			// Socials.
			'socials'      => array(
				'priority' => 100,
				'title'    => esc_html__( 'Socials', 'dimas' ),
			),

		);

		return $panels;
	}



}
