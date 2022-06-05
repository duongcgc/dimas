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

// Theme Scripts.
require get_template_directory() . '/inc/class-dimas-scripts.php';
\Dimas\Scripts::instance();

// Theme Styles.
require get_template_directory() . '/inc/class-dimas-styles.php';
\Dimas\Styles::instance();

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

/**
 * Enqueue scripts for the customizer preview.
 *
 * @since Dimas 1.0
 *
 * @return void
 */
function dimas_customize_preview_init() {
	wp_enqueue_script(
		'dimas-customize-helpers',
		get_theme_file_uri( '/assets/js/customize-helpers.js' ),
		array(),
		wp_get_theme()->get( 'Version' ),
		true
	);

	wp_enqueue_script(
		'dimas-customize-preview',
		get_theme_file_uri( '/assets/js/customize-preview.js' ),
		array( 'customize-preview', 'customize-selective-refresh', 'jquery', 'dimas-customize-helpers' ),
		wp_get_theme()->get( 'Version' ),
		true
	);
}
add_action( 'customize_preview_init', 'dimas_customize_preview_init' );

/**
 * Enqueue scripts for the customizer.
 *
 * @since Dimas 1.0
 *
 * @return void
 */
function dimas_customize_controls_enqueue_scripts() {

	wp_enqueue_script(
		'dimas-customize-helpers',
		get_theme_file_uri( '/assets/js/customize-helpers.js' ),
		array(),
		wp_get_theme()->get( 'Version' ),
		true
	);
}
add_action( 'customize_controls_enqueue_scripts', 'dimas_customize_controls_enqueue_scripts' );

/**
 * Calculate classes for the main <html> element.
 *
 * @since Dimas 1.0
 *
 * @return void
 */
function dimas_the_html_classes() {
	/**
	 * Filters the classes for the main <html> element.
	 *
	 * @since Dimas 1.0
	 *
	 * @param string The list of classes. Default empty string.
	 */
	$classes = apply_filters( 'dimas_html_classes', '' );
	if ( ! $classes ) {
		return;
	}
	echo 'class="' . esc_attr( $classes ) . '"';
}

/**
 * Add "is-IE" class to body if the user is on Internet Explorer.
 *
 * @since Dimas 1.0
 *
 * @return void
 */
function dimas_add_ie_class() {
	?>
	<script>
	if ( -1 !== navigator.userAgent.indexOf( 'MSIE' ) || -1 !== navigator.appVersion.indexOf( 'Trident/' ) ) {
		document.body.classList.add( 'is-IE' );
	}
	</script>
	<?php
}
add_action( 'wp_footer', 'dimas_add_ie_class' );

if ( ! function_exists( 'wp_get_list_item_separator' ) ) :
	/**
	 * Retrieves the list item separator based on the locale.
	 *
	 * Added for backward compatibility to support pre-6.0.0 WordPress versions.
	 *
	 * @since 6.0.0
	 */
	function wp_get_list_item_separator() {
		/* translators: Used between list items, there is a space after the comma. */
		return __( ', ', 'dimas' );
	}
endif;
