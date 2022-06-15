<?php
/**
 * Custom Post Type functions
 *
 * @package Dimas
 */

namespace Dimas\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Custom_Post_Type initial
 */
class CPT_Register {
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

		echo 'Custom Posts';
		
		require_once DIMAS_CORE_DIR . '/cpt/class-dimas-header.php';
		require_once DIMAS_CORE_DIR . '/cpt/class-dimas-footer.php';
		
	}

}
