<?php
/**
 * Theme customizer
 *
 * @package Dimas
 */

namespace Dimas\Core;

use \Dimas\Core\Customizer\Register_Controls;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Customize.
 *
 * @var array
 */
class Customizer {
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
	 * Customize settings
	 *
	 * @var array
	 */
	protected $config = array();

	/**
	 * The class constructor
	 *
	 * @since 1.0.0
	 *
	 * @param array $config The array config.
	 *
	 * @return void
	 */
	public function __construct( $config = array() ) {
		$this->config = apply_filters( 'dimas_customize_config', $config );

		if ( ! class_exists( 'Kirki' ) ) {

			$plugin_url = \Dimas\Core\Helper::get_install_plugin_url( 'kirki' );
			$msg_html   = 'Dimas requires Kirki. Please install <a href="';
			$msg_html  .= $plugin_url;
			$msg_html  .= '">Kirki</a> plugin.';

			\Dimas\Framework\Notice::add_notice( 'error', $msg_html );

			return;
		}

		$this->register();

		add_action( 'customize_preview_init', array( $this, 'enqueue_preview_scripts' ) );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'customize_register', array( $this, 'customize_modify' ) );

	}

	/**
	 * Enqueues style and scripts for customizer controls
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		wp_add_inline_style( 'customize-controls', '.customize-control-kirki-radio-image label {margin-right: 5px}' );
	}

	/**
	 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function enqueue_preview_scripts() {
		wp_add_inline_style( 'wp-admin', '.customize-control-kirki-radio-image label {margin-right: 5px;}' );
	}

	/**
	 * Register settings
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register() {

		/**
		 * Add the theme configuration
		 */
		if ( ! empty( $this->config['theme'] ) ) {
			\Kirki::add_config(
				$this->config['theme'],
				array(
					'capability'  => 'edit_theme_options',
					'option_type' => 'theme_mod',
				)
			);
		}

		/**
		 * Add panels
		 */
		if ( ! empty( $this->config['panels'] ) ) {
			foreach ( $this->config['panels'] as $panel => $settings ) {
				\Kirki::add_panel( $panel, $settings );
			}
		}

		/**
		 * Add sections
		 */
		if ( ! empty( $this->config['sections'] ) ) {
			foreach ( $this->config['sections'] as $section => $settings ) {
				\Kirki::add_section( $section, $settings );
			}
		}

		/**
		 * Add fields
		 */
		if ( ! empty( $this->config['theme'] ) && ! empty( $this->config['fields'] ) ) {
			foreach ( $this->config['fields'] as $name => $settings ) {
				if ( ! isset( $settings['settings'] ) ) {
					$settings['settings'] = $name;
				}

				\Kirki::add_field( $this->config['theme'], $settings );
			}
		}

	}

	/**
	 * Get config ID
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_theme() {
		return $this->config['theme'];
	}

	/**
	 * Get customize setting value
	 *
	 * @since 1.0.0
	 *
	 * @param string $name The option name.
	 *
	 * @return bool|string
	 */
	public function get_option( $name ) {
		$default = $this->get_option_default( $name );

		return get_theme_mod( $name, $default );
	}

	/**
	 * Get default option values
	 *
	 * @since 1.0.0
	 *
	 * @param string $name The option name default.
	 *
	 * @return mixed
	 */
	public function get_option_default( $name ) {
		if ( ! isset( $this->config['fields'][ $name ] ) ) {
			return false;
		}

		return isset( $this->config['fields'][ $name ]['default'] ) ? $this->config['fields'][ $name ]['default'] : false;
	}

	/**
	 * Move some default sections to `general` panel that registered by theme
	 *
	 * @since 1.0.0
	 *
	 * @param object $wp_customize The custom customize.
	 *
	 * @return void
	 */
	public function customize_modify( $wp_customize ) {

		$wp_customize->get_section( 'title_tagline' )->panel     = 'general';
		$wp_customize->get_section( 'static_front_page' )->panel = 'general';

		// Remove custom nav menus panel.
		remove_action( 'customize_controls_enqueue_scripts', array( $wp_customize->nav_menus, 'enqueue_scripts' ) );
		remove_action( 'customize_register', array( $wp_customize->nav_menus, 'customize_register' ), 11 );
		remove_filter( 'customize_dynamic_setting_args', array( $wp_customize->nav_menus, 'filter_dynamic_setting_args' ) );
		remove_filter( 'customize_dynamic_setting_class', array( $wp_customize->nav_menus, 'filter_dynamic_setting_class' ) );
		remove_action( 'customize_controls_print_footer_scripts', array( $wp_customize->nav_menus, 'print_templates' ) );
		remove_action( 'customize_controls_print_footer_scripts', array( $wp_customize->nav_menus, 'available_items_template' ) );
		remove_action( 'customize_preview_init', array( $wp_customize->nav_menus, 'customize_preview_init' ) );

		// Remove custom widgets panel.
		remove_action( 'customize_controls_enqueue_scripts', array( $wp_customize->widgets, 'enqueue_scripts' ) );
		remove_action( 'customize_register', array( $wp_customize->widgets, 'customize_register' ), 11 );
		remove_filter( 'customize_dynamic_setting_args', array( $wp_customize->widgets, 'filter_dynamic_setting_args' ) );
		remove_filter( 'customize_dynamic_setting_class', array( $wp_customize->widgets, 'filter_dynamic_setting_class' ) );
		remove_action( 'customize_controls_print_footer_scripts', array( $wp_customize->widgets, 'print_templates' ) );
		remove_action( 'customize_controls_print_footer_scripts', array( $wp_customize->widgets, 'available_items_template' ) );
		remove_action( 'customize_preview_init', array( $wp_customize->widgets, 'customize_preview_init' ) );

		// Remove custom sections.
		$wp_customize->remove_section( 'background_image' );
		$wp_customize->remove_section( 'colors' );

	}

}
