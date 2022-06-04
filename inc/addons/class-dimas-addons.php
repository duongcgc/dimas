<?php
/**
 * Plugin Name: Dimas Addons
 * Plugin URI: http://drfuri.com/plugins/razzi-addons.zip
 * Description: Extra elements for Elementor. It was built for Dimas theme.
 * Version: 1.4.0
 * Author: Drfuri
 * Author URI: http://drfuri.com/
 * License: GPL2+
 * Text Domain: razzi
 * Domain Path: /lang/
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

if ( ! defined( 'DIMAS_ADDONS_DIR' ) ) {
	define( 'DIMAS_ADDONS_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'DIMAS_ADDONS_URL' ) ) {
	define( 'DIMAS_ADDONS_URL', plugin_dir_url( __FILE__ ) );
}

require_once DIMAS_ADDONS_DIR . 'class-razzi-addons-plugin.php';

\Dimas\Addons::instance();