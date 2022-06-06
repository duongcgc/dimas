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

if ( ! defined( 'DIMAS_ADDONS_DIR' ) ) {
	define( 'DIMAS_ADDONS_DIR', DIMAS_INC_DIR . '/addons' );
}

if ( ! defined( 'DIMAS_CORE_DIR' ) ) {
	define( 'DIMAS_CORE_DIR', DIMAS_INC_DIR . '/core' );
}


// Setup Theme.
require DIMAS_INC_DIR . '/class-dimas-setup.php';
\Dimas\Theme_Setup::instance();

// Helper functions.
require DIMAS_INC_DIR . '/class-dimas-helper.php';

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
