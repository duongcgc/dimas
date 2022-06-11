<?php
/**
 * Block Editor functions
 *
 * @package Dimas
 */

namespace Dimas\Admin;

use Dimas\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Block Editor
 */
class Block_Editor {
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
		add_action( 'enqueue_block_editor_assets', array( $this, 'block_editor_styles' ) );
		add_action( 'enqueue_block_editor_assets', array( $this, 'dimas_block_editor_script' ) );

	}

	/**
	 * Enqueue editor styles for Gutenberg
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function block_editor_styles() {
		wp_enqueue_style( 'dimas-block-editor-style', get_template_directory_uri() . '/assets/css/editor-blocks.css', array(), '20180831' );
		wp_enqueue_style( 'dimas-block-editor-fonts', Helper::get_fonts_url(), array(), '20180831' );
	}

	/**
	 * Enqueue block editor script.
	 *
	 * @since Dimas 1.0
	 *
	 * @return void
	 */
	public function dimas_block_editor_script() {
		wp_enqueue_script( 'dimas-editor', get_theme_file_uri( '/assets/js/editor.js' ), array( 'wp-blocks', 'wp-dom' ), wp_get_theme()->get( 'Version' ), true );
	}

}


