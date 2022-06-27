<?php
/**
 * Customize Sections
 *
 * @package Dimas
 */

namespace Dimas\Core\Customizer;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sections class
 */
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

			// General.
			'preloader'                     => array(
				'title'    => esc_html__( 'Preloader', 'dimas' ),
				'priority' => 20,
				'panel'    => 'general',
			),

			// Colors.
			'color_main'                    => array(
				'title'    => esc_html__( 'Main Color', 'dimas' ),
				'panel'    => 'colors',
				'priority' => 10,
			),

			'color_heading'                 => array(
				'title'    => esc_html__( 'Heading Colors', 'dimas' ),
				'panel'    => 'colors',
				'priority' => 20,
			),

			'color_body'                    => array(
				'title'    => esc_html__( 'Body Color', 'dimas' ),
				'panel'    => 'colors',
				'priority' => 30,
			),

			// Typography.
			'typography_main'               => array(
				'title'    => esc_html__( 'Typography Color', 'dimas' ),
				'panel'    => 'colors',
				'priority' => 10,
			),

			'typography_heading'            => array(
				'title'    => esc_html__( 'Typography Colors', 'dimas' ),
				'panel'    => 'colors',
				'priority' => 20,
			),

			'typography_body'               => array(
				'title'    => esc_html__( 'Typography Color', 'dimas' ),
				'panel'    => 'colors',
				'priority' => 30,
			),

			// Animations.
			'animation_transition_duration' => array(
				'title'    => esc_html__( 'Animation Transition Duration', 'dimas' ),
				'panel'    => 'animations',
				'priority' => 10,
			),

			// Header.
			'header_bg'                     => array(
				'title'    => esc_html__( 'Header Background', 'dimas' ),
				'panel'    => 'header',
				'priority' => 10,
			),

			'header_logo'                   => array(
				'title'    => esc_html__( 'Header Logo', 'dimas' ),
				'panel'    => 'header',
				'priority' => 20,
			),

			'header_menu'                   => array(
				'title'    => esc_html__( 'Header Menu', 'dimas' ),
				'panel'    => 'header',
				'priority' => 30,
			),

			'header_socials'                => array(
				'title'    => esc_html__( 'Header Socials', 'dimas' ),
				'panel'    => 'header',
				'priority' => 40,
			),

			// Pages.
			'page_title'                    => array(
				'title'    => esc_html__( 'Page Title', 'dimas' ),
				'panel'    => 'pages',
				'priority' => 10,
			),

			'page_comments'                 => array(
				'title'    => esc_html__( 'Page Comments', 'dimas' ),
				'panel'    => 'pages',
				'priority' => 20,
			),

			// Posts Single.
			'post_single_fetured_img'       => array(
				'title'    => esc_html__( 'Posts Single Fetured Image', 'dimas' ),
				'panel'    => 'post_single',
				'priority' => 10,
			),

			'post_single_date'              => array(
				'title'    => esc_html__( 'Posts Single Posted On', 'dimas' ),
				'panel'    => 'post_single',
				'priority' => 20,
			),

			'post_single_title'             => array(
				'title'    => esc_html__( 'Posts Single Title', 'dimas' ),
				'panel'    => 'post_single',
				'priority' => 30,
			),

			'post_single_social_share'      => array(
				'title'    => esc_html__( 'Posts Single Social Share', 'dimas' ),
				'panel'    => 'post_single',
				'priority' => 40,
			),

			'post_single_related'           => array(
				'title'    => esc_html__( 'Posts Single Related Posts', 'dimas' ),
				'panel'    => 'post_single',
				'priority' => 50,
			),

			'post_single_comments'          => array(
				'title'    => esc_html__( 'Posts Single Comments', 'dimas' ),
				'panel'    => 'post_single',
				'priority' => 60,
			),

			// Posts Archive.
			'post_archive_title'            => array(
				'title'    => esc_html__( 'Posts Archive Title', 'dimas' ),
				'panel'    => 'post_archive',
				'priority' => 10,
			),
			'post_archive_style'            => array(
				'title'    => esc_html__( 'Posts Archive Style', 'dimas' ),
				'panel'    => 'post_archive',
				'priority' => 20,
			),

			// Footer.
			'footer_bg'                     => array(
				'title'    => esc_html__( 'Footer Background', 'dimas' ),
				'panel'    => 'footer',
				'priority' => 10,
			),

			'footer_left'                   => array(
				'title'    => esc_html__( 'Footer Item Left', 'dimas' ),
				'panel'    => 'footer',
				'priority' => 20,
			),

			'footer_right'                  => array(
				'title'    => esc_html__( 'Footer Item Right', 'dimas' ),
				'panel'    => 'footer',
				'priority' => 30,
			),

			// Socials.
			'socials_link'                  => array(
				'title'    => esc_html__( 'Socials Link', 'dimas' ),
				'panel'    => 'socials',
				'priority' => 10,
			),

			'socials_share'                 => array(
				'title'    => esc_html__( 'Socials Share', 'dimas' ),
				'panel'    => 'socials',
				'priority' => 20,
			),

		);

		return $sections;
	}

}
