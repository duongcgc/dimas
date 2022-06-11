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

namespace Dimas;

// This theme requires WordPress 5.3 or later.
if ( version_compare( $GLOBALS['wp_version'], '5.3', '<' ) ) {
	require get_template_directory() . '/inc/framework/class-dimas-back-compat.php';
	\Dimas\Back_Compat::instance();
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

if ( ! defined( 'DIMAS_CORE_FRAMEWORK' ) ) {
	define( 'DIMAS_CORE_FRAMEWORK', DIMAS_INC_DIR . '/framework' );
}

if ( ! defined( 'DIMAS_ADDONS_URL' ) ) {
	define( 'DIMAS_ADDONS_URI', DIMAS_INC_URI . '/addons' );
}

if ( ! defined( 'DIMAS_CORE_URI' ) ) {
	define( 'DIMAS_CORE_URI', DIMAS_INC_URI . '/core' );
}

if ( ! defined( 'DIMAS_FRAMEWORK_URI' ) ) {
	define( 'DIMAS_FRAMEWORK_URI', DIMAS_INC_URI . '/framework' );
}

if ( ! defined( 'DIMAS_JS_URI' ) ) {
	define( 'DIMAS_JS_URI', DIMAS_ASSETS_URI . '/js' );
}

if ( ! defined( 'DIMAS_CSS_URI' ) ) {
	define( 'DIMAS_CSS_URI', DIMAS_ASSETS_URI . '/js' );
}

// Init Dimas Theme.
require DIMAS_INC_DIR . '/class-dimas-theme.php';
\Dimas\Theme::instance();