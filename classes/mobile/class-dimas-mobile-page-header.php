<?php
/**
 * Dimas_Topbar Mobile functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Dimas
 */

namespace Dimas\Mobile;
use Dimas\Dimas_Helper;

class Dimas_Page_Header {
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
		add_filter( 'dimas_get_page_header_elements', array( $this, 'get_page_header_elements' ) );
	}

	/**
	 * Dimas_Page Dimas_Header elements
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_page_header_elements($items) {
		if ( is_singular('post') ) {
			$items = intval( Dimas_Helper::get_option( 'mobile_single_post_breadcrumb' ) ) ? [ 'breadcrumb' ] : $items;
		} elseif ( is_singular('product') ) {
			$items = intval( Dimas_Helper::get_option( 'mobile_single_product_breadcrumb' ) ) ? [ 'breadcrumb' ] : $items;
		} elseif ( \Dimas\Dimas_Helper::is_catalog() ) {
			if ( intval( Dimas_Helper::get_option( 'mobile_catalog_page_header' ) ) ) {
				$items = Dimas_Helper::get_option( 'mobile_catalog_page_header_els' );
			}

		} elseif ( is_page() ) {
			if ( intval( Dimas_Helper::get_option( 'mobile_page_header' ) ) ) {
				$items = Dimas_Helper::get_option( 'mobile_page_header_els' );
			}

			$items = $this->custom_items( $items );

		} elseif ( intval( Dimas_Helper::get_option( 'mobile_blog_page_header' ) ) ) {
			$items = Dimas_Helper::get_option( 'mobile_blog_page_header_els' );
		}

		return $items;
	}

	/**
	 * Custom page header
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function custom_items( $items ) {
		if ( empty( $items ) ) {
			return [];
		}

		$get_id = Dimas_Helper::get_post_ID();

		if ( get_post_meta( $get_id, 'rz_hide_page_header', true ) ) {
			return [];
		}

		if ( get_post_meta( $get_id, 'rz_hide_breadcrumb', true ) ) {
			$key = array_search( 'breadcrumb', $items );
			if ( $key !== false ) {
				unset( $items[ $key ] );
			}
		}

		if ( get_post_meta( $get_id, 'rz_hide_title', true ) ) {
			$key = array_search( 'title', $items );
			if ( $key !== false ) {
				unset( $items[ $key ] );
			}
		}

		return $items;
	}
}
