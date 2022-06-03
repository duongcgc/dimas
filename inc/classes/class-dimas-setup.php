<?php
/**
 * Dimas functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Dimas
 */

namespace Dimas;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


/**
 * Dimas after setup theme
 */
class Setup {
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
		add_action( 'after_setup_theme', array( $this, 'setup_theme' ), 2 );
		add_action( 'after_setup_theme', array( $this, 'setup_content_width' ) );
	}

	/**
	 * Setup theme
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function setup_theme() {
		/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on dimas, use a find and replace
	 * to change  'dimas' to the name of your theme in all the template files.
	 */
		load_theme_textdomain( 'dimas', get_template_directory() . '/lang' );

		// Dimas_Theme supports
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );
		add_theme_support( 'customize-selective-refresh-widgets' );

		add_editor_style( 'assets/css/editor-style.css' );

		// Load regular editor styles into the new block-based editor.
		add_theme_support( 'editor-styles' );

		// Load default block styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for responsive embeds.
		add_theme_support( 'responsive-embeds' );

		add_theme_support( 'align-wide' );

		add_theme_support( 'align-full' );

		add_image_size( 'dimas-blog-grid', 600, 398, true );
		add_image_size( 'dimas-post-full', 1170, 450, true );
		add_image_size( 'dimas-products-with-thumbnails-large', 270, 270, true );
		add_image_size( 'dimas-products-with-thumbnails-small', 94, 86, true );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary'    => esc_html__( 'Primary Menu', 'dimas' ),
			'secondary'  => esc_html__( 'Secondary Menu', 'dimas' ),
			'hamburger'  => esc_html__( 'Hamburger Menu', 'dimas' ),
			'socials'    => esc_html__( 'Social Menu', 'dimas' ),
			'department' => esc_html__( 'Department Menu', 'dimas' ),
			'mobile'     => esc_html__( 'Mobile Menu', 'dimas' ),
		) );

	}

	/**
	 * Set the $content_width global variable used by WordPress to set image dimennsions.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function setup_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'dimas_content_width', 640 );
	}
}
