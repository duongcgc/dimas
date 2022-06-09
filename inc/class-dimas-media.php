<?php
/**
 * Media functions and definitions.
 * => Processing media files image, video, audio...
 *
 * @package Dimas
 */

namespace Dimas;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Media initial
 */
class Media {
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
		add_action( 'dimas_after_close_post_content', array( $this, 'get_comment' ), 20 );

		add_action( 'dimas_after_open_comments_content', array( $this, 'get_title' ), 10 );
		add_action( 'dimas_after_open_comments_content', array( $this, 'comment_content' ), 20 );
		add_action( 'dimas_after_open_comments_content', 'paginate_comments_links', 30 );
		add_action( 'dimas_after_open_comments_content', array( $this, 'comment_fields' ), 40 );

		add_filter( 'comment_form_default_fields', array( $this, 'comment_form_fields' ) );
	}

	/**
	 * Instantiate the object.
	 *
	 * @param string $url The url of video.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function render( $url = '' ) {

	}
}
