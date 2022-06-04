<?php
/**
 * Admin and Backend functions and definitions.
 * => Importer, Block Editor, Plugin Installer,...
 *
 * @package Dimas
 */

namespace Dimas;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Admin initial
 */
class Admin {
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
		if ( is_admin() ) {
			$this->get( 'plugin' );
			$this->get( 'block_editor' );
			$this->get( 'meta_boxes' );
		}
	}

	/**
	 * Get Mobile Class Init.
	 *
	 * @since 1.0.0
	 *
	 * @return object
	 */
	public function get( $class ) {
		switch ( $class ) {

			case 'plugin':
				return \Dimas\Admin\Plugin_Install::instance();
				break;
			case 'block_editor':
				return \Dimas\Admin\Block_Editor::instance();
				break;
			case 'meta_boxes':
				return \Dimas\Admin\Meta_Boxes::instance();
				break;
		}
	}
}

