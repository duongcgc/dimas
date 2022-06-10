<?php
/**
 * Back Compatible functions and definitions.
 * => Processing files to compatible previous versions.
 *
 * Prevents the theme from running on WordPress versions prior to 5.3,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 5.3.
 *
 * @package WordPress
 * @subpackage Dimas
 * @since Dimas 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Thumbnail initial
 */
class Dimas_Back_Compat {
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
		add_action( 'after_switch_theme', array( $this, 'dimas_switch_theme' ) );
		add_action( 'load-customize.php', array( $this, 'dimas_customize' ) );
		add_action( 'template_redirect', array( $this, 'dimas_preview' ) );
	}


	/**
	 * Display upgrade notice on theme switch.
	 *
	 * @since Dimas 1.0
	 *
	 * @return void
	 */
	public function dimas_switch_theme() {
		add_action( 'admin_notices', array( $this, 'dimas_upgrade_notice' ) );
	}

	/**
	 * Adds a message for unsuccessful theme switch.
	 *
	 * Prints an update nag after an unsuccessful attempt to switch to
	 * the theme on WordPress versions prior to 5.3.
	 *
	 * @since Dimas 1.0
	 *
	 * @global string $wp_version WordPress version.
	 *
	 * @return void
	 */
	public function dimas_upgrade_notice() {
		echo '<div class="error"><p>';
		printf(
		/* translators: %s: WordPress Version. */
			esc_html__( 'This theme requires WordPress 5.3 or newer. You are running version %s. Please upgrade.', 'dimas' ),
			esc_html( $GLOBALS['wp_version'] )
		);
		echo '</p></div>';
	}

	/**
	 * Prevents the Customizer from being loaded on WordPress versions prior to 5.3.
	 *
	 * @since Dimas 1.0
	 *
	 * @global string $wp_version WordPress version.
	 *
	 * @return void
	 */
	public function dimas_customize() {
		wp_die(
			sprintf(
			/* translators: %s: WordPress Version. */
				esc_html__( 'This theme requires WordPress 5.3 or newer. You are running version %s. Please upgrade.', 'dimas' ),
				esc_html( $GLOBALS['wp_version'] )
			),
			'',
			array(
				'back_link' => true,
			)
		);
	}

	/**
	 * Prevents the Dimas_Theme Preview from being loaded on WordPress versions prior to 5.3.
	 *
	 * @since Dimas 1.0
	 *
	 * @global string $wp_version WordPress version.
	 *
	 * @return void
	 */
	public function dimas_preview() {
		if ( isset( $_GET['preview'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			wp_die(
				sprintf(
				/* translators: %s: WordPress Version. */
					esc_html__( 'This theme requires WordPress 5.3 or newer. You are running version %s. Please upgrade.', 'dimas' ),
					esc_html( $GLOBALS['wp_version'] )
				)
			);
		}
	}


}
