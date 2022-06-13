<?php

/**
 * Customize Panels
 *
 * @package Dimas
 */

namespace Dimas\Core\Customizer;

// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

class Panels {
	/**
	 * Instance
	 *
	 * @var $instance
	 */
	protected static $instance = null;

	/**
	 * $dimas_customize
	 *
	 * @var $dimas_customize
	 */
	protected static $dimas_customize = null;

	/**
	 * Initiator
	 *
	 * @since 1.0.0
	 * @return object
	 */
	public static function instance() {
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}

		return self:: $instance;
	}

	/**
	 * The class constructor
	 *
	 *
	 * @since 1.0.0
	 *
	 */
	public function __construct() {
		add_filter('dimas_customize_panels', array($this, 'customize_panels'));
	}	

	/**
	 * Get customize panels
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function customize_panels() {	

		$panels = array(
			'general' => array(
				'priority' => 10,
				'title'    => esc_html__('General', 'dimas'),
			),

			// Typography
			'typography' => array(
				'priority' => 30,
				'title'    => esc_html__( 'Typography', 'dimas' ),
			),

			// Header
			'header'  => array(
				'title'      => esc_html__('Header', 'dimas'),
				'capability' => 'edit_theme_options',
				'priority'   => 30,
			),

			'page'   => array(
				'title'      => esc_html__('Page', 'dimas'),
				'capability' => 'edit_theme_options',
				'priority'   => 40,
			),

			// Blog
			'blog'   => array(
				'title'      => esc_html__('Blog', 'dimas'),
				'capability' => 'edit_theme_options',
				'priority'   => 50,
			),

			// Footer
			'footer' => array(
				'title'      => esc_html__('Footer', 'dimas'),
				'capability' => 'edit_theme_options',
				'priority'   => 60,
			),
			// Footer
			'mobile' => array(
				'title'      => esc_html__('Mobile', 'dimas'),
				'capability' => 'edit_theme_options',
				'priority'   => 60,
			),

		);

		$settings['panels']   = apply_filters('dimas_customize_panels', $panels);

		return $settings;
	}

}
