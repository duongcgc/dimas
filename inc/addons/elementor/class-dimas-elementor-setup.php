<?php
/**
 * Elementor Global init
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Dimas
 */

namespace Dimas\Addons\Elementor;

/**
 * Integrate with Elementor.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Setup {

	/**
	 * Instance
	 *
	 * @var $instance
	 */
	private static $instance;


	/**
	 * Initiator
	 *
	 * @since 1.0.0
	 * @return object
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) ) {
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

		add_action( 'elementor/frontend/after_enqueue_styles', array( $this, 'styles' ) );
		add_action( 'elementor/frontend/after_register_scripts', array( $this, 'scripts' ) );

		add_action( 'elementor/elements/categories_registered', array( $this, 'add_category' ) );

		add_action( 'post_class', array( $this, 'get_product_classes' ), 20, 3 );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );

		if ( ! empty( $_REQUEST['action'] ) && 'elementor' === $_REQUEST['action'] && is_admin() ) {
			add_action( 'init', array( $this, 'register_wc_hooks' ), 5 );
		}

		echo 'Setup Elementor';

	}

	/**
	 * Add Dimas category
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function add_category( $elements_manager ) {
		$elements_manager->add_category(
			'dimas',
			array(
				'title' => esc_html__( 'Dimas', 'dimas' ),
			)
		);
	}


	/**
	 * Enqueue Style
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function enqueue_styles() {
		\Elementor\Plugin::$instance->frontend->enqueue_styles();
	}


	/**
	 * Add post type class
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_product_classes( $classes, $class, $post_id ) {
		if ( is_admin() && \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			$post      = get_post( $post_id );
			$classes[] = $post->post_type;
		}

		return $classes;
	}

	/**
	 * Register WC hooks for Elementor editor
	 */
	public function register_wc_hooks() {
		if ( function_exists( 'wc' ) ) {
			wc()->frontend_includes();
		}
	}

	/**
	 * Register styles
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function styles() {
		wp_register_style( 'mapbox', DIMAS_ADDONS_URL . 'assets/css/mapbox.css', array(), '1.0' );
		wp_register_style( 'mapboxgl', DIMAS_ADDONS_URL . 'assets/css/mapbox-gl.css', array(), '1.0' );
		wp_register_style( 'magnific', DIMAS_ADDONS_URL . 'assets/css/magnific-popup.css', array(), '1.0' );

		wp_register_style( 'image-slide-css', DIMAS_ADDONS_URL . 'assets/css/image-slide.css', array(), '1.0' );

	}

	/**
	 * Register after scripts
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function scripts() {
		wp_register_script( 'dimas-coundown', DIMAS_ADDONS_URL . '/assets/js/plugins/jquery.coundown.js', array(), '1.0', true );
		wp_register_script( 'mapbox', DIMAS_ADDONS_URL . '/assets/js/plugins/mapbox.min.js', array(), '1.0', true );
		wp_register_script( 'mapboxgl', DIMAS_ADDONS_URL . '/assets/js/plugins/mapbox-gl.min.js', array(), '1.0', true );
		wp_register_script( 'mapbox-sdk', DIMAS_ADDONS_URL . '/assets/js/plugins/mapbox-sdk.min.js', array(), '1.0', true );

		wp_register_script( 'magnific', DIMAS_ADDONS_URL . '/assets/js/plugins/jquery.magnific-popup.js', array(), '1.0', true );

		wp_register_script( 'image-slide', DIMAS_ADDONS_URL . 'assets/js/plugins/image-slide.js', array(), '1.0', true );
		wp_register_script( 'dimas-masonry', DIMAS_ADDONS_URL . '/assets/js/plugins/jquery.masonryGrid.js', array( 'jquery' ), '1.0', true );

		wp_register_script( 'jarallax', DIMAS_ADDONS_URL . 'assets/js/plugins/jarallax.min.js', array(), '1.12.8', true );
		wp_register_script( 'dimas-elementor-parallax', DIMAS_ADDONS_URL . 'assets/js/elementor-parallax-widgets.js', array(), '1.0', true );

		wp_register_script( 'eventmove', DIMAS_ADDONS_URL . 'assets/js/plugins/jquery.event.move.js', array(), '1.0', true );

		wp_register_script( 'dimas-frontend', DIMAS_ADDONS_URL . '/assets/js/frontend.js', array( 'jquery', 'elementor-frontend' ), '20220310', true );
		wp_register_script( 'dimas-product-shortcode', DIMAS_ADDONS_URL . '/assets/js/product-shortcode.js', array( 'jquery', 'elementor-frontend' ), '20220310', true );

	}
}
