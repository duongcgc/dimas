<?php
/**
 * Admin Notice.
 *
 * @package Dimas
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Scripts initial
 */
class Dimas_Notice {
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

	}

	/**
	 * Add notice.
	 *
	 * @param string $type       The type of messenge (error, warning, success, info).
	 * @param string $message    The message text.
	 * @param string $tag        The tag for text.
	 * @return void
	 */
	public function add_notice( $type = 'warning', $message = '', $tag = 'p' ) {

		$params = array(
			'type' => $type,
			'mess' => $message,
			'tag'  => $tag,
		);

		add_action(
			'admin_notices',
			function() use ( $params ) {

				$html   = array();
				$html[] = '<div class="notice notice-';
				$html[] = $params['type'];
				$html[] = ' is-dismissible">';
				$html[] = '<';
				$html[] = $params['tag'];
				$html[] = '>';
				$html[] = $params['mess'];
				$html[] = '</p></div>';

				echo implode( '', $html );

			}
		);

	}

}
