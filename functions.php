<?php
/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Dimas
 * @since Dimas 1.0
 */

// This theme requires WordPress 5.3 or later.
if ( version_compare( $GLOBALS['wp_version'], '5.3', '<' ) ) {
	require get_template_directory() . '/inc/class-dimas-back-compat.php';
	\Dimas\Back_Compatible::instance();
}

// Global Constants.
if ( ! defined( 'DIMAS_INC_DIR' ) ) {
	define( 'DIMAS_INC_DIR', get_template_directory() . '/inc' );
}

if ( ! defined( 'DIMAS_INC_URI' ) ) {
	define( 'DIMAS_INC_URI', get_template_directory_uri() . '/inc' );
}

if ( ! defined( 'DIMAS_ASSETS_URI' ) ) {
	define( 'DIMAS_ASSETS_URI', get_template_directory_uri() . '/assets' );
}

if ( ! defined( 'DIMAS_ADDONS_DIR' ) ) {
	define( 'DIMAS_ADDONS_DIR', DIMAS_INC_DIR . '/addons' );
}

if ( ! defined( 'DIMAS_CORE_DIR' ) ) {
	define( 'DIMAS_CORE_DIR', DIMAS_INC_DIR . '/core' );
}

if ( ! defined( 'DIMAS_ADDONS_URL' ) ) {
	define( 'DIMAS_ADDONS_URI', DIMAS_INC_URI . '/addons' );
}

if ( ! defined( 'DIMAS_CORE_URI' ) ) {
	define( 'DIMAS_CORE_URI', DIMAS_INC_URI . '/core' );
}

if ( ! defined( 'DIMAS_JS_URI' ) ) {
	define( 'DIMAS_JS_URI', DIMAS_ASSETS_URI . '/js' );
}

if ( ! defined( 'DIMAS_CSS_URI' ) ) {
	define( 'DIMAS_CSS_URI', DIMAS_ASSETS_URI . '/js' );
}

// Setup Theme =================.
require DIMAS_INC_DIR . '/class-dimas-setup.php';
\Dimas\Theme_Setup::instance();

// Helper functions.
require DIMAS_INC_DIR . '/class-dimas-helper.php';

// HTML functions.
require DIMAS_INC_DIR . '/class-dimas-html.php';

// Block Editor Scripts.
require DIMAS_CORE_DIR . '/admin/class-dimas-admin-block-editor.php';
\Dimas\Admin\Block_Editor::instance();

// Theme Styles.
require DIMAS_INC_DIR . '/class-dimas-styles.php';
\Dimas\Styles::instance();

// Theme Scripts.
require DIMAS_INC_DIR . '/class-dimas-scripts.php';
\Dimas\Scripts::instance();

// SVG Icons class.
require DIMAS_INC_DIR . '/class-dimas-svg-icons.php';

// Custom color classes.
require DIMAS_INC_DIR . '/class-dimas-custom-colors.php';
new \Dimas\Custom_Colors();

// Enhance the theme by hooking into WordPress.
require DIMAS_INC_DIR . '/class-dimas-template-funs.php';

// Menu functions and filters.
require DIMAS_INC_DIR . '/class-dimas-menu.php';

// Custom template tags for the theme.
require DIMAS_INC_DIR . '/class-dimas-template-tags.php';

// Customizer additions.
require DIMAS_CORE_DIR . '/class-dimas-customize.php';
new \Dimas\Theme_Customize();

// Block Patterns.
require DIMAS_INC_DIR . '/block-patterns.php';

// Block Styles.
require DIMAS_INC_DIR . '/block-styles.php';

// Dark Mode.
require_once DIMAS_INC_DIR . '/class-dimas-dark-mode.php';
new \Dimas\Dark_Mode();

// Loading Addons.
require_once DIMAS_ADDONS_DIR . '/class-dimas-addons-plugin.php';
\Dimas\Addons::instance();
