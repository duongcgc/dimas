<?php
/**
 * Scripts functions and definitions.
 *
 * @package Dimas
 */

namespace Dimas;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Scripts initial
 */
class Scripts {
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
		add_action( 'wp_print_footer_scripts', array( $this, 'dimas_skip_link_focus_fix' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'dimas_scripts' ) );

	}

	/**
	 * Enqueue scripts.
	 *
	 * @since Dimas 1.0
	 *
	 * @return void
	 */
	function dimas_scripts() {
		// Note, the is_IE global variable is defined by WordPress and is used
		// to detect if the current browser is internet explorer.
		global $is_IE, $wp_scripts;

		// Register the IE11 polyfill file.
		wp_register_script(
			'dimas-ie11-polyfills-asset',
			get_template_directory_uri() . '/assets/js/polyfills.js',
			array(),
			wp_get_theme()->get( 'Version' ),
			true
		);

		// Register the IE11 polyfill loader.
		wp_register_script(
			'dimas-ie11-polyfills',
			null,
			array(),
			wp_get_theme()->get( 'Version' ),
			true
		);
		wp_add_inline_script(
			'dimas-ie11-polyfills',
			wp_get_script_polyfill(
				$wp_scripts,
				array(
					'Element.prototype.matches && Element.prototype.closest && window.NodeList && NodeList.prototype.forEach' => 'dimas-ie11-polyfills-asset',
				)
			)
		);

		// Main navigation scripts.
		if ( has_nav_menu( 'primary' ) ) {
			wp_enqueue_script(
				'dimas-primary-navigation-script',
				get_template_directory_uri() . '/assets/js/primary-navigation.js',
				array( 'dimas-ie11-polyfills' ),
				wp_get_theme()->get( 'Version' ),
				true
			);
		}

		// Responsive embeds script.
		wp_enqueue_script(
			'dimas-responsive-embeds-script',
			get_template_directory_uri() . '/assets/js/responsive-embeds.js',
			array( 'dimas-ie11-polyfills' ),
			wp_get_theme()->get( 'Version' ),
			true
		);
	}

	/**
	 * Fix skip link focus in IE11.
	 *
	 * This does not enqueue the script because it is tiny and because it is only for IE11,
	 * thus it does not warrant having an entire dedicated blocking script being loaded.
	 *
	 * @since Dimas 1.0
	 *
	 * @link https://git.io/vWdr2
	 */
	public function dimas_skip_link_focus_fix() {

		// If SCRIPT_DEBUG is defined and true, print the unminified file.
		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
			echo '<script>';
			include get_template_directory() . '/assets/js/skip-link-focus-fix.js';
			echo '</script>';
		} else {
			// The following is minified via `npx terser --compress --mangle -- assets/js/skip-link-focus-fix.js`.
			?>
		<script>
		/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",(function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())}),!1);
		</script>
			<?php
		}
	}
}
