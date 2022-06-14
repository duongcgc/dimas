<?php

/**
 * Customize Sections
 *
 * @package Dimas
 */

namespace Dimas\Core\Customizer;

// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

class Sections {
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
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}

		return self:: $instance;
	}

	/**
	 * $dimas_sections
	 *
	 * @var $dimas_sections
	 */
	protected static $dimas_sections = null;

	/**
	 * The class constructor
	 *
	 *
	 * @since 1.0.0
	 *
	 */
	public function __construct() {
		add_filter( 'dimas_customize_sections', array( $this, 'customize_sections' ) );				
		\Dimas\Core\Core_Init::instance()->get('customizer/sections');		
	}	

	/**
	 * Get customize sections
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function customize_sections( $sections ) {	

		$sections = array(
			// Maintenance
			'maintenance'  => array(
				'title'      => esc_html__('Maintenance', 'dimas'),
				'priority'   => 10,
				'capability' => 'edit_theme_options',
			),
			// Boxed
			'boxed_layout' => array(
				'title'       => esc_html__('Boxed Layout', 'dimas'),
				'description' => '',
				'priority'    => 20,
				'capability'  => 'edit_theme_options',
				'panel'       => 'general',
			),

			'general_backtotop' => array(
				'title'       => esc_html__('Back To Top', 'dimas'),
				'description' => '',
				'capability'  => 'edit_theme_options',
				'panel'       => 'general',
				'priority'    => 20,
			),
			'colors'            => array(
				'title'    => esc_html__( 'Colors', 'dimas' ),
				'priority' => 20,
			),

			// Typography
			'typo_main'         => array(
				'title'    => esc_html__( 'Main', 'dimas' ),
				'panel'    => 'typography',
			),
			'typo_headings'     => array(
				'title'    => esc_html__( 'Headings', 'dimas' ),
				'panel'    => 'typography',
			),
			'typo_header'       => array(
				'title'    => esc_html__( 'Header', 'dimas' ),
				'panel'    => 'typography',
			),
			'typo_page'         => array(
				'title'    => esc_html__( 'Page', 'dimas' ),
				'panel'    => 'typography',
			),
			'typo_posts'        => array(
				'title'    => esc_html__( 'Blog', 'dimas' ),
				'panel'    => 'typography',
			),
			'typo_widget'       => array(
				'title'    => esc_html__( 'Widgets', 'dimas' ),
				'panel'    => 'typography',
			),
			'typo_footer'       => array(
				'title'    => esc_html__( 'Footer', 'dimas' ),
				'panel'    => 'typography',
			),

			// Newsletter
			'newsletter_popup'  => array(
				'title'      => esc_html__('Newsletter Popup', 'dimas'),
				'capability' => 'edit_theme_options',
				'priority'   => 20,
			),

			'preloader'         => array(
				'title'    => esc_html__( 'Preloader', 'dimas' ),
				'priority' => 20,
				'panel'    => 'general',
			),

			// Header
			'header_top'        => array(
				'title' => esc_html__('Topbar', 'dimas'),
				'panel' => 'header',
			),
			'header_topbar_bg'  => array(
				'title' => esc_html__('Topbar Background', 'dimas'),
				'panel' => 'header',
			),
			'header_layout'     => array(
				'title' => esc_html__('Header Layout', 'dimas'),
				'panel' => 'header',
			),
			'header_main'       => array(
				'title' => esc_html__('Header Main', 'dimas'),
				'panel' => 'header',
			),
			'header_bottom'     => array(
				'title' => esc_html__('Header Bottom', 'dimas'),
				'panel' => 'header',
			),
			'header_background' => array(
				'title' => esc_html__('Header Background', 'dimas'),
				'panel' => 'header',
			),
			'header_campaign'   => array(
				'title' => esc_html__('Campaign Bar', 'dimas'),
				'panel' => 'header',
			),
			'header_logo'       => array(
				'title' => esc_html__('Logo', 'dimas'),
				'panel' => 'header',
			),
			'header_search'     => array(
				'title' => esc_html__('Search', 'dimas'),
				'panel' => 'header',
			),
			'header_account'    => array(
				'title' => esc_html__('Account', 'dimas'),
				'panel' => 'header',
			),
			'header_wishlist'   => array(
				'title' => esc_html__('Wishlist', 'dimas'),
				'panel' => 'header',
			),
			'header_cart'       => array(
				'title' => esc_html__('Cart', 'dimas'),
				'panel' => 'header',
			),
			'header_primary_menu'  => array(
				'title' => esc_html__('Primary Menu', 'dimas'),
				'panel' => 'header',
			),
			'header_hamburger'  => array(
				'title' => esc_html__('Hamburger Menu', 'dimas'),
				'panel' => 'header',
			),
			'header_department' => array(
				'title' => esc_html__('Department', 'dimas'),
				'panel' => 'header',
			),

			// Page
			'page_header'       => array(
				'title'       => esc_html__('Page Header', 'dimas'),
				'description' => '',
				'priority'    => 10,
				'capability'  => 'edit_theme_options',
				'panel'       => 'page',
			),

			// Blog
			'blog_page'         => array(
				'title'       => esc_html__('Blog Page', 'dimas'),
				'description' => '',
				'capability'  => 'edit_theme_options',
				'panel'       => 'blog',
			),

			'page_header_blog'  => array(
				'title'       => esc_html__('Blog Page Header', 'dimas'),
				'description' => '',
				'priority'    => 10,
				'capability'  => 'edit_theme_options',
				'panel'       => 'blog',
			),

			// Single Post
			'single_post'       => array(
				'title'       => esc_html__('Single Post', 'dimas'),
				'description' => '',
				'priority'    => 10,
				'capability'  => 'edit_theme_options',
				'panel'       => 'blog',
			),

			// Footer
			'footer_layout'     => array(
				'title'       => esc_html__('Footer Layout', 'dimas'),
				'description' => '',
				'capability'  => 'edit_theme_options',
				'panel'       => 'footer',
			),
			'footer_newsletter' => array(
				'title'       => esc_html__('Footer Newsletter', 'dimas'),
				'description' => '',
				'capability'  => 'edit_theme_options',
				'panel'       => 'footer',
			),
			'footer_widget'		=> array(
				'title'       => esc_html__('Footer Widget', 'dimas'),
				'description' => '',
				'capability'  => 'edit_theme_options',
				'panel'       => 'footer',
			),
			'footer_extra'      => array(
				'title'       => esc_html__('Footer Extra', 'dimas'),
				'description' => '',
				'capability'  => 'edit_theme_options',
				'panel'       => 'footer',
			),
			'footer_main'       => array(
				'title'       => esc_html__('Footer Main', 'dimas'),
				'description' => '',
				'capability'  => 'edit_theme_options',
				'panel'       => 'footer',
			),
			'footer_background' => array(
				'title'       => esc_html__('Footer Background', 'dimas'),
				'description' => '',
				'capability'  => 'edit_theme_options',
				'panel'       => 'footer',
			),
			'footer_copyright'  => array(
				'title'       => esc_html__('Copyright', 'dimas'),
				'description' => '',
				'capability'  => 'edit_theme_options',
				'panel'       => 'footer',
			),
			'footer_menu'  => array(
				'title'       => esc_html__('Menu', 'dimas'),
				'description' => '',
				'capability'  => 'edit_theme_options',
				'panel'       => 'footer',
			),
			'footer_text'       => array(
				'title'       => esc_html__('Custom Text', 'dimas'),
				'description' => '',
				'capability'  => 'edit_theme_options',
				'panel'       => 'footer',
			),
			'footer_payment'    => array(
				'title'       => esc_html__('Payments', 'dimas'),
				'description' => '',
				'capability'  => 'edit_theme_options',
				'panel'       => 'footer',
			),
			'footer_logo'       => array(
				'title'       => esc_html__('Logo', 'dimas'),
				'description' => '',
				'capability'  => 'edit_theme_options',
				'panel'       => 'footer',
			),

			'recently_viewed'  => array(
				'title'      => esc_html__('Recently Viewed', 'dimas'),
				'capability' => 'edit_theme_options',
				'priority'   => 50,
			),
			// Mobile
			'mobile_newsletter_popup' => array(
				'title' => esc_html__( 'Newsletter Popup', 'dimas' ),
				'panel' => 'mobile',
			),
			'mobile_topbar'           => array(
				'title' => esc_html__( 'Topbar', 'dimas' ),
				'panel' => 'mobile',
			),
			'mobile_header'           => array(
				'title' => esc_html__( 'Header', 'dimas' ),
				'panel' => 'mobile',
			),
			'mobile_header_campaign'  => array(
				'title' => esc_html__( 'Campaign Bar', 'dimas' ),
				'panel' => 'mobile',
			),
			'mobile_footer'           => array(
				'title' => esc_html__( 'Footer', 'dimas' ),
				'panel' => 'mobile',
			),
			'mobile_panel'           => array(
				'title' => esc_html__( 'Panel', 'dimas' ),
				'panel' => 'mobile',
			),
			'mobile_page'             => array(
				'title' => esc_html__( 'Page', 'dimas' ),
				'panel' => 'mobile',
			),
			'mobile_blog'             => array(
				'title' => esc_html__( 'Blog', 'dimas' ),
				'panel' => 'mobile',
			),
			'mobile_single_blog'             => array(
				'title' => esc_html__( 'Single Blog', 'dimas' ),
				'panel' => 'mobile',
			),
			'mobile_product_catalog'  => array(
				'title' => esc_html__( 'Product Catalog', 'dimas' ),
				'panel' => 'mobile',
			),
			'mobile_single_product'  => array(
				'title' => esc_html__( 'Single Product', 'dimas' ),
				'panel' => 'mobile',
			),
			'mobile_version'          => array(
				'priority' => 50,
				'title'    => esc_html__( 'Mobile Version', 'dimas' ),
				'panel'    => 'mobile',
			)

		);

		return $sections;
	}

}
