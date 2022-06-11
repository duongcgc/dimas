<?php
/**
 * Testimonial functions and definitions.
 *
 * @package Dimas
 */

namespace Dimas\CPT;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Woocommerce initial
 *
 */
class GO_Testimonial {
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
		add_action( 'wp', array( $this, 'add_actions' ), 0 );
	}

	/**
	 * Add actions
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function add_actions() {
		$this->get( 'posts' );
		$this->get( 'post_loop' );
		$this->get( 'post' );
		$this->get( 'related_posts' );
		$this->get( 'search' );
	}

	/**
	 * Get Dimas Page Template Class.
	 *
	 * @since 1.0.0
	 *
	 * @return object
	 */
	public function get( $class ) {
		switch ( $class ) {
			case 'posts':
				if ( \Dimas\Helper::is_blog() ) {
					return \Dimas\Testimonial\Posts::instance();
				}
				break;
			case 'post_loop':
				return \Dimas\Testimonial\Post_Loop::instance();
				break;

			case 'post':
				if ( is_singular( 'post' ) ) {
					return \Dimas\Testimonial\Post::instance();
				}
				break;

			case 'related_posts':
				if ( is_singular( 'post' ) && Helper::get_option('related_posts') ) {
					return \Dimas\Testimonial\Related_Posts::instance();
				}
				break;

			case 'search':
				if ( is_search() ) {
					return \Dimas\Testimonial\Search::instance();
				}
				break;
		}

	}
}
