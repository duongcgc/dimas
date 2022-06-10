<?php

/**
 * Footer Builder for this theme.
 * => Drag and Drop Footer Builder with Elementor.
 */

class DM_Footer_Builder {

	public static $instance;

	private $content = '';

	public static function getInstance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Footer_Builder ) ) {
			self::$instance = new Footer_Builder();
		}

		return self::$instance;
	}

	public function __construct() {
		add_action( 'wp', array( $this, 'setup_footer' ) );
		add_action( 'admin_bar_menu', array( $this, 'custom_button_footer_builder' ), 50 );
	}

	/**
	 * @param $wp_admin_bar WP_Admin_Bar
	 */
	public function custom_button_footer_builder( $wp_admin_bar ) {
		global $dimas_footer;
		if ( $dimas_footer && $dimas_footer instanceof WP_Post ) {
			$args = array(
				'id'    => 'footer-builder-button',
				'title' => __( 'Edit Footer', 'dimas' ),
				'href'  => add_query_arg( 'action', 'elementor', remove_query_arg( 'action', get_edit_post_link( $dimas_footer->ID ) ) ),
			// 'meta'  => array(
			// 'class' => 'custom-button-class'
			// )
			);
			$wp_admin_bar->add_node( $args );
		}
	}


	public function setup_footer() {
		global $dimas_footer;
		if ( dimas_get_metabox( get_the_ID(), 'dimas_enable_custom_footer', false ) ) {
			$footer_slug = dimas_get_metabox( get_the_ID(), 'dimas_footer_layout', '' );
			if ( ! $footer_slug ) {
				$footer_slug = get_theme_mod( 'dimas_footer_layout', '' );
			}
		} else {
			$footer_slug = get_theme_mod( 'dimas_footer_layout', '' );
		}

		$dimas_footer = get_page_by_path( $footer_slug, OBJECT, 'footer' );

		if ( $dimas_footer && $dimas_footer instanceof WP_Post ) {

			// WPML
			$wpml_id        = apply_filters( 'wpml_object_id', $dimas_footer->ID );
			$dimas_footer->ID = $wpml_id ? $wpml_id : $dimas_footer->ID;

			// Polylang
			if ( function_exists( 'pll_get_post' ) ) {
				$dimas_footer->ID = pll_get_post( $dimas_footer->ID );
			}
			$this->content = \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $dimas_footer->ID );
		}
	}

	public function render() {
		return $this->content;
	}

}

Footer_Builder::getInstance();
