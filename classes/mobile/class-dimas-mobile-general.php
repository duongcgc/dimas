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

class General {
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
		add_filter( 'dimas_newsletter_popup', array( $this, 'get_newsletter_popup' ) );
		if ( intval( Dimas_Helper::get_option( 'custom_mobile_homepage' ) ) ) {
			add_filter( 'pre_option_page_on_front', array( $this, 'get_homepage_mobile' ) );
		}
	}

	/**
	 * Get Mobile Newsletter Popup
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_newsletter_popup() {
		return Dimas_Helper::get_option( 'mobile_newsletter_popup' );
	}

	/**
	 * Get Mobile Homepage
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_homepage_mobile( $value ) {
		if ( ! isset( $this->mobile_homepage_id ) ) {
			$page_id                  = Dimas_Helper::get_option( 'mobile_homepage_id' );
			$page_id                  = ! empty( $page_id ) ? $page_id : $value;
			$this->mobile_homepage_id = $page_id;
		}

		return $this->mobile_homepage_id;
	}

}


