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

// custom post type project.
/**
 * Undocumented function dimas_cpt_register
 *
 * @return void
 */
function dimas_cpt_register() {
	/**
	 * Post Type: project
	 */
	$labels = array(
		'all_items'     => __( 'All Projects', 'dimas' ),
		'menu_name'     => __( 'Project', 'dimas' ),
		'singular_name' => __( 'Project', 'dimas' ),
		'add_new'       => __( 'Add Project', 'dimas' ),
	);

	$args = array(
		'label'                 => __( 'Project', 'dimas' ),
		'labels'                => $labels,
		'description'           => '',
		'public'                => true,
		'publicly_queryable'    => true,
		'show_ui'               => true,
		'show_in_rest'          => true,
		'rest_base'             => '',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
		'has_archive'           => true,
		'show_in_menu'          => true,
		'show_in_nav_menus'     => true,
		'delete_with_user'      => false,
		'exclude_from_search'   => false,
		'capability_type'       => 'post',
		'map_meta_cap'          => true,
		'hierarchical'          => true,
		'rewrite'               => true,
		'query_var'             => true,
		'menu_position'         => 10,
		'menu_icon'             => 'data:image/svg+xml;base64,' . base64_encode(
			'<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-projector-fill" viewBox="0 0 16 16">
			<path d="M2 4a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1h6a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H2Zm.5 2h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1 0-1ZM14 7.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm-12 1a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5Z"/>
		  </svg>'
		),
		'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
		'show_in_graphql'       => true,
	);
	register_post_type( 'project', $args );
	/**
	 * Taxonomies: Branch Project
	 */
	$labels = array(
		'name'      => 'Branch Project',
		'singular'  => 'Branch Project',
		'menu_name' => 'Branch Project',
	);
	$args   = array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => false,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => false,
	);
	register_taxonomy( 'branch-project', 'project', $args );
}

add_action( 'init', 'dimas_cpt_register' );
