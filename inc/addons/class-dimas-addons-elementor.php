<?php
/**
 * Page Builder functions and definitions.
 * => Init Elementor Page Builder
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Dimas
 */

namespace Dimas\Addons;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Dimas after setup theme
 */
class Addons_Elementor {
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
	 * Instantiate the object.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		echo 'Elementor Helo';
		add_action( 'widgets_init', array( $this, 'widgets_init' ) );		
	}

	/**
	 * Register widget area.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function widgets_init() {
		$sidebars = array(
			'blog-sidebar' => esc_html__( 'Blog Sidebar', 'dimas' ),
			'header-bar'   => esc_html__( 'Header Bar', 'dimas' ),
		);

		// Register footer sidebars.
		for ( $i = 1; $i <= 5; $i ++ ) {
			$sidebars[ "footer-$i" ] = esc_html__( 'Footer', 'dimas' ) . " $i";
		}

		// Register sidebars.
		foreach ( $sidebars as $id => $name ) {
			register_sidebar(
				array(
					'name'          => $name,
					'id'            => $id,
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h2 class="widget-title">',
					'after_title'   => '</h2>',
				)
			);
		}

	}
}
