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

// Setup Theme.
require get_template_directory() . '/inc/class-dimas-setup.php';
\Dimas\Theme_Setup::instance();

// Helper functions.
require get_template_directory() . '/inc/class-dimas-helper.php';

// Block Editor Scripts.
require get_template_directory() . '/inc/core/admin/class-dimas-admin-block-editor.php';
\Dimas\Admin\Block_Editor::instance();

// Theme Styles.
require get_template_directory() . '/inc/class-dimas-styles.php';
\Dimas\Styles::instance();

// Theme Scripts.
require get_template_directory() . '/inc/class-dimas-scripts.php';
\Dimas\Scripts::instance();

// SVG Icons class.
require get_template_directory() . '/inc/class-dimas-svg-icons.php';

// Custom color classes.
require get_template_directory() . '/inc/class-dimas-custom-colors.php';
new \Dimas\Custom_Colors();

// Enhance the theme by hooking into WordPress.
require get_template_directory() . '/inc/class-dimas-template-funs.php';

// Menu functions and filters.
require get_template_directory() . '/inc/class-dimas-menu.php';

// Custom template tags for the theme.
require get_template_directory() . '/inc/class-dimas-template-tags.php';

// Customizer additions.
require get_template_directory() . '/inc/core/class-dimas-customize.php';
new \Dimas\Theme_Customize();

// Block Patterns.
require get_template_directory() . '/inc/block-patterns.php';

// Block Styles.
require get_template_directory() . '/inc/block-styles.php';

// Dark Mode.
require_once get_template_directory() . '/inc/class-dimas-dark-mode.php';
new \Dimas\Dark_Mode();
