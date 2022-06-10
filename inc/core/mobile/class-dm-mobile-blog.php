<?php
/**
 * Mobile Blog functions and definitions.
 *
 * @package Dimas
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Mobile Blog initial
 *
 */
class DM_Mobile_Blog {
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
		add_filter( 'dimas_get_blog_type', array( $this, 'get_blog_type' ) );
	}

	/**
	 * Get blog type
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_blog_type() {
		return 'listing';
	}
}
