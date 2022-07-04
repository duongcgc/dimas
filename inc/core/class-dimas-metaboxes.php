<?php
/**
 * Metaboxes functions
 *
 * @package Dimas
 */

namespace Dimas\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Metaboxes initial
 */
class Metaboxes_Register {
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

		if ( ! class_exists( 'ACF' ) ) {

			$plugin_url = \Dimas\Core\Helper::get_install_plugin_url( 'advanced-custom-fields' );
			$msg_html   = 'Dimas requires Advanced Custom Fields. Please install <a href="';
			$msg_html  .= $plugin_url;
			$msg_html  .= '">ACF</a> plugin.';

			\Dimas\Framework\Notice::add_notice( 'error', $msg_html );

			return;
		}

		$this->register();
	}

	/**
	 * Register metabox ACF.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register() {

	}
}
