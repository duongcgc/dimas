<?php

/**
 * Customize Fields
 *
 * @package Dimas
 */

namespace Dimas\Core\Customizer;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Typography_Typo_Posts_Fields {
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
	 * Section name.
	 *
	 * @var string
	 */
	private static $section = 'typo_posts';

	/**
	 * Section priority variable
	 *
	 * @var integer
	 */
	private static $section_priority = 10;

	/**
	 * Get section fields
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function get_fields() {

		$priority = self::$section_priority;

		$fields = array(

			// Typography
			'typo_blog_header_title'              => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Blog Header Title', 'dimas' ),
				'description' => esc_html__( 'Customize the font of blog header', 'dimas' ),
				'section'     => self::$section,
				'default'     => array(
					'font-family'    => '',
					'variant'        => '500',
					'font-size'      => '32px',
					'line-height'    => '1.33',
					'text-transform' => 'none',
					'color'          => '#111',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport' => 'postMessage',
				'js_vars'      => array(
					array(
						'element' => '.blog .page-header__title',
					),
				),
			),
			'typo_blog_post_title'              => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Blog Post Title', 'dimas' ),
				'description' => esc_html__( 'Customize the font of blog post title', 'dimas' ),
				'section'     => self::$section,
				'default'     => array(
					'font-family'    => '',
					'variant'        => '500',
					'font-size'      => '24px',
					'line-height'    => '1.33',
					'text-transform' => 'none',
					'color'          => '#111',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport' => 'postMessage',
				'js_vars'      => array(
					array(
						'element' => '.hentry .entry-title a',
					),
				),
			),
			'typo_blog_post_excerpt'              => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Blog Post Excerpt', 'dimas' ),
				'description' => esc_html__( 'Customize the font of blog post excerpt', 'dimas' ),
				'section'     => self::$section,
				'default'     => array(
					'font-family'    => '',
					'variant'        => 'regular',
					'font-size'      => '16px',
					'line-height'    => '1.5',
					'text-transform' => 'none',
					'color'          => '#525252',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport' => 'postMessage',
				'js_vars'      => array(
					array(
						'element' => '.blog-wrapper .entry-content',
					),
				),
			),

		);

		return $fields;
	}



}
