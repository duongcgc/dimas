<?php
/**
 * Header Builder for this theme.
 * => Drag and Drop Header Builder with Elementor.
 */

namespace Dimas;

class Header_Builder {
	public static $instance;

	private $content = '';

	public static function getInstance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Header_Builder ) ) {
			self::$instance = new Header_Builder();
		}

		return self::$instance;
	}

	public function __construct() {
		add_action( 'wp', array( $this, 'setup_header' ) );
		add_action( 'admin_bar_menu', array( $this, 'custom_button_header_builder' ), 50 );
		add_filter( 'body_class', array( $this, 'add_body_class' ) );
	}


	/**
	 * @param $wp_admin_bar WP_Admin_Bar
	 */
	public function custom_button_header_builder( $wp_admin_bar ) {
		global $osf_header;
		if ( $osf_header && $osf_header instanceof WP_Post ) {
			$args = array(
				'id'    => 'header-builder-button',
				'title' => __( 'Edit Header', 'dimas' ),
				'href'  => add_query_arg( 'action', 'elementor', remove_query_arg( 'action', get_edit_post_link( $osf_header->ID ) ) ),
			// 'meta'  => array(
			// 'class' => 'custom-button-class'
			// )
			);
			$wp_admin_bar->add_node( $args );
		}
	}

	public function add_body_class( $classes ) {
		global $osf_header;
		if ( $osf_header && $osf_header instanceof WP_Post ) {
			// Absolute Header
			if ( osf_get_metabox( $osf_header->ID, 'osf_enable_header_absolute', false ) ) {
				$classes[] = 'opal-header-absolute';
			}
		}

		return $classes;
	}

	public function setup_header() {
		global $osf_header;

		if ( (bool) osf_get_metabox( get_the_ID(), 'osf_enable_custom_header', false ) ) {
			if ( ( $header_slug = osf_get_metabox( get_the_ID(), 'osf_header_layout', 'default' ) ) !== 'default' ) {
				$osf_header = get_page_by_path( $header_slug, OBJECT, 'header' );
			}
		} else {
			if ( ( $header_slug = get_theme_mod( 'osf_header_builder', '' ) ) && get_theme_mod( 'osf_header_enable_builder', false ) ) {
				$osf_header = get_page_by_path( $header_slug, OBJECT, 'header' );
			}
		}

		if ( $osf_header && $osf_header instanceof WP_Post ) {

			// WPML
			$wpml_id        = apply_filters( 'wpml_object_id', $osf_header->ID );
			$osf_header->ID = $wpml_id ? $wpml_id : $osf_header->ID;

			// Polylang
			if ( function_exists( 'pll_get_post' ) ) {
				$osf_header->ID = pll_get_post( $osf_header->ID );
			}
			$this->content = \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $osf_header->ID );
		}
	}

	public function render() {
		return $this->content;
	}

}

Header_Builder::getInstance();
