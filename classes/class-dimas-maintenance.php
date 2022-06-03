<?php
/**
 * Dimas maintenance functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Dimas
 */

namespace Dimas;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Dimas maintenance
 */
class Dimas_Maintenance {
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
		add_action( 'template_redirect', array( $this, 'maintenance_redirect' ), 1 );
	}

	/**
	 * Redirect to the target page if the maintenance mode is enabled.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function maintenance_redirect() {
		if ( ! Dimas_Helper::get_option( 'maintenance_enable' ) ) {
			return;
		}

		if ( current_user_can( 'super admin' ) || current_user_can( 'administrator' ) ) {
			return;
		}

		$mode     = Dimas_Helper::get_option( 'maintenance_mode' );
		$page_id  = Dimas_Helper::get_option( 'maintenance_page' );
		$code     = 'maintenance' == $mode ? 503 : 200;
		$page_url = $page_id ? get_page_link( $page_id ) : '';

		// Use default message.
		if ( ! $page_id || ! $page_url ) {
			if ( 'coming_soon' == $mode ) {
				$message = sprintf( '<h1>%s</h1><p>%s</p>', esc_html__( 'Coming Soon', 'dimas' ), esc_html__( 'Our website is under construction. We will be here soon with our new awesome site.', 'dimas' ) );
			} else {
				$message = sprintf( '<h1>%s</h1><p>%s</p>', esc_html__( 'Website Under Dimas_Maintenance', 'dimas' ), esc_html__( 'Our website is currently undergoing scheduled maintenance. Please check back soon.', 'dimas' ) );
			}

			wp_die( $message, get_bloginfo( 'name' ), array( 'response' => $code ) );
		}

		// Add body classes.
		add_filter( 'body_class', array( $this, 'maintenance_page_body_class' ) );

		// Redirect to the correct page.
		if ( ! is_page( $page_id ) ) {
			wp_redirect( $page_url );
			exit;
		} else {
			if ( ! headers_sent() ) {
				status_header( $code );
			}

			add_filter( 'dimas_topbar', '__return_false' );
			add_filter( 'dimas_get_campaign_bar', '__return_false' );
			add_filter( 'dimas_get_header', '__return_false' );
			add_filter( 'dimas_get_header_mobile', '__return_false' );
			add_filter( 'dimas_get_page_header', '__return_false' );
			add_filter( 'dimas_get_footer', '__return_false' );
			add_filter( 'dimas_newsletter_popup', '__return_false' );

		}
	}

	/**
	 * Add classes for maintenance mode.
	 *
	 * @since 1.0.0
	 *
	 * @param array $classes
	 *
	 * @return array
	 */
	public function maintenance_page_body_class( $classes ) {
		if ( ! Dimas_Helper::get_option( 'maintenance_enable' ) ) {
			return $classes;
		}

		if ( current_user_can( 'super admin' ) ) {
			return $classes;
		}

		$classes[] = 'maintenance-mode';

		if ( $this->is_maintenance_page() ) {
			$classes[] = 'maintenance-page';
		}

		return $classes;
	}


	/**
	 * Check is maintenance page
	 *
	 * @since 1.0.0
	 *
	 * @return boolean
	 */
	public function is_maintenance_page() {
		if ( ! Dimas_Helper::get_option( 'maintenance_enable' ) ) {
			return false;
		}

		if ( current_user_can( 'super admin' ) ) {
			return false;
		}

		$page_id = Dimas_Helper::get_option( 'maintenance_page' );

		if ( ! $page_id ) {
			return false;
		}

		return is_page( $page_id );
	}
}
