<?php

/**
 * Customize Fields
 *
 * @package Dimas
 */

namespace Dimas\Core\Customizer;

// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

class Fields {
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
	 * The class constructor
	 *
	 *
	 * @since 1.0.0
	 *
	 */
	public function __construct() {	
		add_filter( 'dimas_customize_fields', array( $this, 'customize_fields' ) );		
	}	

	/**
	 * Create Fields.
	 *
	 * @since 1.0.0
	 *
	 * @return object
	 */
	public function create_fields() {
		foreach (self::$dimas_fields_classes as $field_class => $file_class ) {
			require_once $file_class;
			$field_class::instance();
		}		
	}

	/**
	 * $dimas_fields
	 *
	 * @var $dimas_fields
	 */
	public static $dimas_fields_classes = array (
		'\Dimas\Core\Customizer\General_Boxed_Layout_Fields'			=> DIMAS_CORE_DIR . '/customizer/fields/class-dimas-general-boxed_layout.php',
		'\Dimas\Core\Customizer\General_Backtotop_Fields'				=> DIMAS_CORE_DIR . '/customizer/fields/class-dimas-general-general_backtotop.php',
		'\Dimas\Core\Customizer\Colors_Fields'							=> DIMAS_CORE_DIR . '/customizer/fields/class-dimas-colors.php',
		'\Dimas\Core\Customizer\General_Preloader_Fields'				=> DIMAS_CORE_DIR . '/customizer/fields/class-dimas-general-preloader.php',
		'\Dimas\Core\Customizer\Newsletter_Popup_Fields'				=> DIMAS_CORE_DIR . '/customizer/fields/class-dimas-newsletter-popup.php',
		'\Dimas\Core\Customizer\Header_Header_Top_Fields'				=> DIMAS_CORE_DIR . '/customizer/fields/class-dimas-header-header_top.php',
		'\Dimas\Core\Customizer\Header_Header_Topbar_Bg_Fields'			=> DIMAS_CORE_DIR . '/customizer/fields/class-dimas-header-header_topbar_bg.php',
	);

	/**
	 * Get customize fields
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function customize_fields() {	

		self::instance()->create_fields();

		$fields = array();

		foreach (self::$dimas_fields_classes as $field_class => $file_class ) {
			$fields_tmp = $field_class::get_fields();
			$fields = array_merge($fields, $fields_tmp);
		}

		$fields_root = array(		
			
			

			// Maintenance
			'maintenance_enable'             => array(
				'type'        => 'toggle',
				'label'       => esc_html__('Enable Maintenance Mode', 'dimas'),
				'description' => esc_html__('Put your site into maintenance mode', 'dimas'),
				'default'     => false,
				'section'     => 'maintenance',
			),

			'maintenance_mode'               => array(
				'type'        => 'radio',
				'label'       => esc_html__('Mode', 'dimas'),
				'description' => esc_html__('Select the correct mode for your site', 'dimas'),
				'tooltip'     => wp_kses_post(sprintf(__('If you are putting your site into maintenance mode for a longer perior of time, you should set this to "Coming Soon". Maintenance will return HTTP 503, Comming Soon will set HTTP to 200. <a href="%s" target="_blank">Learn more</a>', 'dimas'), 'https://yoast.com/http-503-site-maintenance-seo/')),
				'default'     => 'maintenance',
				'choices'     => array(
					'maintenance' => esc_attr__('Maintenance', 'dimas'),
					'coming_soon' => esc_attr__('Coming Soon', 'dimas'),
				),
				'active_callback' => array(
					array(
						'setting'  => 'maintenance_enable',
						'operator' => '==',
						'value'    => true,
					),
				),
				'section' => 'maintenance',
			),
			'maintenance_page'               => array(
				'type'            => 'dropdown-pages',
				'label'           => esc_html__('Maintenance Page', 'dimas'),
				'default'         => 0,
				'active_callback' => array(
					array(
						'setting'  => 'maintenance_enable',
						'operator' => '==',
						'value'    => true,
					),
				),
				'section' => 'maintenance',
			),

			

			

			

			// Logo
			'logo_type'                                 => array(
				'type'    => 'radio',
				'label'   => esc_html__('Logo Type', 'dimas'),
				'default' => 'text',
				'section' => 'header_logo',
				'choices' => array(
					'image' => esc_html__('Image', 'dimas'),
					'svg'   => esc_html__('SVG', 'dimas'),
					'text'  => esc_html__('Text', 'dimas'),
				),
			),
			'logo_svg'                                  => array(
				'type'              => 'textarea',
				'label'             => esc_html__('Logo SVG', 'dimas'),
				'section'           => 'header_logo',
				'description'       => esc_html__('Paste SVG code of your logo here', 'dimas'),
				'sanitize_callback' => '\Dimas\Icon::sanitize_svg',
				'output'            => array(
					array(
						'element' => '.site-branding .logo',
					),
				),
				'active_callback'   => array(
					array(
						'setting'  => 'logo_type',
						'operator' => '==',
						'value'    => 'svg',
					),
				),
			),
			'logo'                                      => array(
				'type'            => 'image',
				'label'           => esc_html__('Logo', 'dimas'),
				'default'         => '',
				'section'         => 'header_logo',
				'active_callback' => array(
					array(
						'setting'  => 'logo_type',
						'operator' => '==',
						'value'    => 'image',
					),
				),
			),
			'logo_svg_light'                            => array(
				'type'              => 'textarea',
				'label'             => esc_html__('Logo Light SVG', 'dimas'),
				'section'           => 'header_logo',
				'description'       => esc_html__('Paste SVG code of your logo here', 'dimas'),
				'sanitize_callback' => '\Dimas\Icon::sanitize_svg',
				'output'            => array(
					array(
						'element' => '.site-branding .logo',
					),
				),
				'active_callback'   => array(
					array(
						'setting'  => 'logo_type',
						'operator' => '==',
						'value'    => 'svg',
					),
				),
			),
			'logo_light'                                => array(
				'type'            => 'image',
				'label'           => esc_html__('Logo Light', 'dimas'),
				'default'         => '',
				'section'         => 'header_logo',
				'active_callback' => array(
					array(
						'setting'  => 'logo_type',
						'operator' => '==',
						'value'    => 'image',
					),
				),
			),
			'logo_text'                                 => array(
				'type'    => 'textarea',
				'label'   => esc_html__('Logo Text', 'dimas'),
				'default' => 'Dimas.',
				'section' => 'header_logo',
				'output'  => array(
					array(
						'element' => '.site-branding .logo',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'logo_type',
						'operator' => '==',
						'value'    => 'text',
					),
				),
			),
			'logo_dimension'                            => array(
				'type'    => 'dimensions',
				'label'   => esc_html__('Logo Dimension', 'dimas'),
				'default' => array(
					'width'  => '',
					'height' => '',
				),
				'section'         => 'header_logo',
				'active_callback' => array(
					array(
						'setting'  => 'logo_type',
						'operator' => '==',
						'value'    => 'image',
					),
				),
			),

			// Header Search
			'header_search_style'                       => array(
				'type'    => 'select',
				'label'   => esc_html__('Search Layout', 'dimas'),
				'default' => 'icon',
				'section' => 'header_search',
				'choices' => array(
					'form-cat' => esc_html__('Icon and categories', 'dimas'),
					'form'     => esc_html__('Icon and search field', 'dimas'),
					'icon'     => esc_html__('Icon only', 'dimas'),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_type',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
			'header_search_form_style'                  => array(
				'type'    => 'select',
				'label'   => esc_html__('Search Style', 'dimas'),
				'default' => 'boxed',
				'section' => 'header_search',
				'choices' => array(
					'boxed'      => esc_html__('Boxed', 'dimas'),
					'full-width' => esc_html__('Full Width', 'dimas'),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_search_style',
						'operator' => '==',
						'value'    => 'form',
					),
					array(
						'setting'  => 'header_type',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
			'header_search_form_skin'                  => array(
				'type'    => 'select',
				'label'   => esc_html__('Search Skin', 'dimas'),
				'default' => 'dark',
				'section' => 'header_search',
				'choices' => array(
					'dark' 		=> esc_html__('Dark', 'dimas'),
					'light'      => esc_html__('Light', 'dimas'),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_search_style',
						'operator' => '==',
						'value'    => 'form',
					),
					array(
						'setting'  => 'header_search_form_style',
						'operator' => '==',
						'value'    => 'boxed',
					),
					array(
						'setting'  => 'header_type',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
			'header_search_type'                        => array(
				'type'    => 'select',
				'label'   => esc_html__('Search For', 'dimas'),
				'default' => '',
				'section' => 'header_search',
				'choices' => array(
					''        => esc_html__('Search for everything', 'dimas'),
					'product' => esc_html__('Search for products', 'dimas'),
				),
			),
			'header_search_custom_field_1'              => array(
				'type'            => 'custom',
				'section'         => 'header_search',
				'default'         => '<hr/>',
				'active_callback' => function() {
					// return $this->display_header_search_panel();
				},
			),
			'header_search_text'                        => array(
				'type'            => 'text',
				'label'           => esc_html__('Panel Search Title', 'dimas'),
				'section'         => 'header_search',
				'default'         => '',
				'active_callback' => function() {
					// return $this->display_header_search_panel();
				},
			),
			'header_search_custom_field_2'              => array(
				'type'    => 'custom',
				'section' => 'header_search',
				'default' => '<hr/>',
			),
			'header_search_placeholder'                 => array(
				'type'    => 'text',
				'label'   => esc_html__('Placeholder', 'dimas'),
				'section' => 'header_search',
				'default' => '',
			),
			'header_search_custom_field_3'              => array(
				'type'            => 'custom',
				'section'         => 'header_search',
				'default'         => '<hr/>',
				'active_callback' => array(
					array(
						'setting'  => 'header_search_style',
						'operator' => '==',
						'value'    => 'icon',
					),
				),
			),
			'header_search_ajax'                        => array(
				'type'        => 'toggle',
				'label'       => esc_html__('AJAX Search', 'dimas'),
				'section'     => 'header_search',
				'default'     => 0,
				'description' => esc_html__('Check this option to enable AJAX search in the header', 'dimas'),
			),
			'header_search_number'                      => array(
				'type'            => 'number',
				'label'           => esc_html__('AJAX Product Numbers', 'dimas'),
				'default'         => 3,
				'section'         => 'header_search',
				'active_callback' => array(
					array(
						'setting'  => 'header_search_ajax',
						'operator' => '==',
						'value'    => '1',
					),
				),
			),
			'header_search_custom_field_5'              => array(
				'type'            => 'custom',
				'section'         => 'header_search',
				'default'         => '<hr/>',
			),
			'header_search_quick_links' => array(
				'type'            => 'toggle',
				'section'         => 'header_search',
				'label'           => esc_html__( 'Quick links', 'dimas' ),
				'description'     => esc_html__( 'Display a list of links bellow the search field', 'dimas' ),
				'default'         => false,
			),
			'header_search_links'       => array(
				'type'            => 'repeater',
				'section'         => 'header_search',
				'label'           => esc_html__( 'Links', 'dimas' ),
				'description'     => esc_html__( 'Add custom links of the quick links popup', 'dimas' ),
				'transport'       => 'postMessage',
				'default'         => array(),
				'row_label'       => array(
					'type'  => 'field',
					'value' => esc_attr__( 'Link', 'dimas' ),
					'field' => 'text',
				),
				'fields'          => array(
					'text' => array(
						'type'  => 'text',
						'label' => esc_html__( 'Text', 'dimas' ),
					),
					'url'  => array(
						'type'  => 'text',
						'label' => esc_html__( 'URL', 'dimas' ),
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_search_quick_links',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
			'header_search_custom_field_4'              => array(
				'type'            => 'custom',
				'section'         => 'header_search',
				'default'         => '<hr/>',
				'active_callback' => array(
					array(
						'setting'  => 'header_search_style',
						'operator' => '==',
						'value'    => 'form',
					),
					array(
						'setting'  => 'header_search_form_style',
						'operator' => '==',
						'value'    => 'boxed',
					),
				),
			),
			'header_search_custom_color'                => array(
				'type'            => 'toggle',
				'label'           => esc_html__('Custom Color', 'dimas'),
				'section'         => 'header_search',
				'default'         => 0,
				'active_callback' => array(
					array(
						'setting'  => 'header_search_style',
						'operator' => '!=',
						'value'    => 'icon',
					),
				),
			),
			'header_search_background_color'            => array(
				'type'            => 'color',
				'label'           => esc_html__('Background Color', 'dimas'),
				'default'         => '',
				'transport'       => 'postMessage',
				'section'         => 'header_search',
				'active_callback' => array(
					array(
						'setting'  => 'header_search_style',
						'operator' => '!=',
						'value'    => 'icon',
					),
					array(
						'setting'  => 'header_search_custom_color',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'js_vars'         => array(
					array(
						'element'  => '.header-search.search-form-type .search-fields',
						'property' => 'background-color',
					),
					array(
						'element'  => '.header-search.search-form-type .product-cat-label',
						'property' => 'background-color',
					),
					array(
						'element'  => '#site-header .header-search .form-search .search-field',
						'property' => 'background-color',
					),
				),
			),
			'header_search_text_color'                  => array(
				'type'            => 'color',
				'label'           => esc_html__('Text Color', 'dimas'),
				'default'         => '',
				'transport'       => 'postMessage',
				'section'         => 'header_search',
				'active_callback' => array(
					array(
						'setting'  => 'header_search_style',
						'operator' => '!=',
						'value'    => 'icon',
					),
					array(
						'setting'  => 'header_search_custom_color',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'js_vars'         => array(
					array(
						'element'  => '#site-header .header-search .form-search .search-field',
						'property' => '--rz-header-color-light',
					),
					array(
						'element'  => '#site-header .header-search .form-search .search-field::placeholder',
						'property' => '--rz-color-placeholder',
					),
					array(
						'element'  => '#site-header .header-search .form-search .search-field',
						'property' => '--rz-header-color-darker',
					),
					array(
						'element'  => '.header-search.search-type-form-cat .product-cat-label',
						'property' => '--rz-header-text-color-gray',
					),
				),
			),
			'header_search_button_color'                => array(
				'type'            => 'color',
				'label'           => esc_html__('Icon Color', 'dimas'),
				'default'         => '',
				'transport'       => 'postMessage',
				'section'         => 'header_search',
				'active_callback' => array(
					array(
						'setting'  => 'header_search_style',
						'operator' => '!=',
						'value'    => 'icon',
					),
					array(
						'setting'  => 'header_search_custom_color',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'js_vars'         => array(
					array(
						'element'  => '#site-header .header-search .form-search .search-submit',
						'property' => 'color',
					),
					array(
						'element'  => '#site-header .header-search .form-search .search-submit .dimas-svg-icon',
						'property' => 'color',
					),
				),
			),
			'header_search_border_color'                => array(
				'type'            => 'color',
				'label'           => esc_html__('Border Color', 'dimas'),
				'default'         => '',
				'transport'       => 'postMessage',
				'section'         => 'header_search',
				'active_callback' => array(
					array(
						'setting'  => 'header_search_style',
						'operator' => '!=',
						'value'    => 'icon',
					),
					array(
						'setting'  => 'header_search_custom_color',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'js_vars'         => array(
					array(
						'element'  => '.header-search .form-search',
						'property' => 'border-color',
					),
					array(
						'element'  => '.header-search .form-search',
						'property' => '--rz-border-color-light',
					),
					array(
						'element'  => '.header-search .form-search',
						'property' => '--rz-border-color-dark',
					),
					array(
						'element'  => '#site-header .header-search .form-search .search-field',
						'property' => 'border-color',
					),
				),
			),
			'header_search_border_color_hover'          => array(
				'type'            => 'color',
				'label'           => esc_html__('Border Color Hover', 'dimas'),
				'default'         => '',
				'transport'       => 'postMessage',
				'section'         => 'header_search',
				'active_callback' => array(
					array(
						'setting'  => 'header_search_style',
						'operator' => '==',
						'value'    => 'form-cat',
					),
					array(
						'setting'  => 'header_search_custom_color',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'js_vars'         => array(
					array(
						'element'  => '#site-header .header-search .form-search .search-field:focus',
						'property' => 'border-color',
					),
					array(
						'element'  => '#site-header .header-search .form-search .search-field:focus',
						'property' => '--rz-border-color-dark',
					),
					array(
						'element'  => '.header-search .border-color-dark',
						'property' => '--rz-border-color-dark',
					),
				),
			),
			'header_search_bg_button_color'             => array(
				'type'            => 'color',
				'label'           => esc_html__('Button Background Color', 'dimas'),
				'default'         => '',
				'transport'       => 'postMessage',
				'section'         => 'header_search',
				'active_callback' => array(
					array(
						'setting'  => 'header_search_style',
						'operator' => '==',
						'value'    => 'form-cat',
					),
					array(
						'setting'  => 'header_search_custom_color',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'js_vars'         => array(
					array(
						'element'  => '#site-header .search-type-form-cat .form-search .search-submit',
						'property' => 'background-color',
					),
				),
			),
			'header_search_border_button_color'         => array(
				'type'            => 'color',
				'label'           => esc_html__('Button Border Color', 'dimas'),
				'default'         => '',
				'transport'       => 'postMessage',
				'section'         => 'header_search',
				'active_callback' => array(
					array(
						'setting'  => 'header_search_style',
						'operator' => '==',
						'value'    => 'form-cat',
					),
					array(
						'setting'  => 'header_search_custom_color',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'js_vars'         => array(
					array(
						'element'  => '#site-header .search-type-form-cat .form-search .search-submit',
						'property' => '--rz-border-color-light',
					),
				),
			),

			// Header Account
			'header_account_behaviour'                  => array(
				'type'    => 'radio',
				'label'   => esc_html__('Account Icon Behaviour', 'dimas'),
				'default' => 'panel',
				'section' => 'header_account',
				'choices' => array(
					'panel' => esc_attr__('Open the account panel', 'dimas'),
					'link'  => esc_attr__('Open the account page', 'dimas'),
				),
			),

			// Header Wishlist
			'header_wishlist_link'                      => array(
				'type'    => 'text',
				'label'   => esc_html__('Custom Wishlist Link', 'dimas'),
				'section' => 'header_wishlist',
				'default' => '',
			),

			// Header Cart
			'header_cart_behaviour'                     => array(
				'type'    => 'radio',
				'label'   => esc_html__('Cart Icon Behaviour', 'dimas'),
				'default' => 'panel',
				'section' => 'header_cart',
				'choices' => array(
					'panel' => esc_attr__('Open the cart panel', 'dimas'),
					'link'  => esc_attr__('Open the cart page', 'dimas'),
				),
			),
			'header_cart_custom_field_1'                => array(
				'type'    => 'custom',
				'section' => 'header_cart',
				'default' => '<hr/>',
			),
			'cart_icon_source'      => array(
				'type'    => 'radio',
				'label'   => esc_html__( 'Cart Icon', 'dimas' ),
				'default' => 'icon',
				'section' => 'header_cart',
				'choices' => array(
					'icon'  => esc_attr__( 'Built-in Icon', 'dimas' ),
					'svg'   => esc_attr__( 'SVG Code', 'dimas' ),
				),
			),
			'cart_icon'             => array(
				'type'    => 'radio-image',
				'default' => 'cart',
				'section' => 'header_cart',
				'choices' => array(
					'cart'       => get_template_directory_uri() . '/assets/svg/cart.svg',
					'shop-bag'   => get_template_directory_uri() . '/assets/svg/shop-bag.svg',
					'shop-bag-2' => get_template_directory_uri() . '/assets/svg/shop-bag-2.svg',
					'shop-cart'  => get_template_directory_uri() . '/assets/svg/shop-cart.svg',
				),
				'active_callback' => array(
					array(
						'setting'  => 'cart_icon_source',
						'operator' => '==',
						'value'    => 'icon',
					),
				),
			),
			'cart_icon_svg'         => array(
				'type'              => 'textarea',
				'description'       => esc_html__( 'Icon SVG code', 'dimas' ),
				'sanitize_callback' => '\Dimas\Icon::sanitize_svg',
				'section'           => 'header_cart',
				'active_callback'   => array(
					array(
						'setting'  => 'cart_icon_source',
						'operator' => '==',
						'value'    => 'svg',
					),
				),
			),
			'cart_hr_1'          => array(
				'type'    => 'custom',
				'section' => 'header_cart',
				'default' => '<hr>',
			),
			'header_cart_custom_color'                  => array(
				'type'        => 'toggle',
				'label'       => esc_html__('Custom Color Counter', 'dimas'),
				'section'     => 'header_cart',
				'default'     => 0,
				'description' => esc_html__('Change color button counter cart', 'dimas'),
			),
			'header_cart_background_color'              => array(
				'type'            => 'color',
				'label'           => esc_html__('Background Color', 'dimas'),
				'default'         => '',
				'transport'       => 'postMessage',
				'section'         => 'header_cart',
				'active_callback' => array(
					array(
						'setting'  => 'header_cart_custom_color',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'js_vars'         => array(
					array(
						'element'  => '.header-cart .counter',
						'property' => '--rz-background-color-primary',
					),
				),
			),
			'header_cart_text_color'                    => array(
				'type'            => 'color',
				'label'           => esc_html__('Text Color', 'dimas'),
				'default'         => '',
				'transport'       => 'postMessage',
				'section'         => 'header_cart',
				'active_callback' => array(
					array(
						'setting'  => 'header_cart_custom_color',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'js_vars'         => array(
					array(
						'element'  => '.header-cart .counter',
						'property' => '--rz-background-text-color-primary',
					),
				),
			),
			'header_cart_border_color'                  => array(
				'type'            => 'color',
				'label'           => esc_html__('Border Color', 'dimas'),
				'default'         => '',
				'transport'       => 'postMessage',
				'section'         => 'header_cart',
				'active_callback' => array(
					array(
						'setting'  => 'header_cart_custom_color',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'js_vars'         => array(
					array(
						'element'  => '.header-cart .counter',
						'property' => '--rz-border-color-lighter',
					),
				),
			),
			'header_cart_custom_field_2'                => array(
				'type'    => 'custom',
				'section' => 'header_cart',
				'default' => '<hr/>',
			),
			'header_mini_cart_buttons'              => array(
				'type'            => 'multicheck',
				'label'           => esc_html__('Mini Cart Buttons', 'dimas'),
				'default'         => array('cart', 'checkout'),
				'section'         => 'header_cart',
				'choices' => array(
					'cart' => esc_attr__('Cart Button', 'dimas'),
					'checkout'  => esc_attr__('Checkout Button', 'dimas'),
				),
			),

			// Header Primary Menu
			'primary_menu_show_arrow'                      => array(
				'type'        => 'toggle',
				'label'       => esc_html__('Show Arrow Icon', 'dimas'),
				'default'     => 1,
				'section'     => 'header_primary_menu',
			),
			'primary_menu_style'                       => array(
				'type'    => 'select',
				'label'   => esc_html__('Justify Content', 'dimas'),
				'section' => 'header_primary_menu',
				'default' => 'space-between',
				'choices' => array(
					'space-between'  => esc_html__('Space Between', 'dimas'),
					'flex-start' => esc_html__('Left', 'dimas'),
					'flex-end' => esc_html__('Right', 'dimas'),
					'center' => esc_html__('Center', 'dimas'),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_type',
						'operator' => '==',
						'value'    => 'default',
					),
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'v9',
					),
				),
				'js_vars'         => array(
					array(
						'element'  => '.header-v9 .main-navigation .nav-menu',
						'property' => 'justify-content',
					),
				),
			),

			// Header Menu Hamburger
			'hamburger_side_type'                       => array(
				'type'    => 'select',
				'label'   => esc_html__('Show Menu', 'dimas'),
				'section' => 'header_hamburger',
				'default' => 'side-right',
				'choices' => array(
					'side-left'  => esc_html__('Side to right', 'dimas'),
					'side-right' => esc_html__('Side to left', 'dimas'),
				),
			),
			'hamburger_click_item'                      => array(
				'type'    => 'select',
				'label'   => esc_html__('Show Sub-Menus', 'dimas'),
				'section' => 'header_hamburger',
				'default' => 'click-item',
				'choices' => array(
					'click-item' => esc_html__('Click to item', 'dimas'),
					'click-icon' => esc_html__('Click to icon', 'dimas'),
				),
			),
			'hamburger_show_arrow'                      => array(
				'type'        => 'toggle',
				'label'       => esc_html__('Show Arrow Icon', 'dimas'),
				'default'     => '0',
				'section'     => 'header_hamburger',
			),
			'header_hamburger_custom_field_1'           => array(
				'type'    => 'custom',
				'section' => 'header_hamburger',
				'default' => '<hr/>',
			),
			'hamburger_show_socials'                    => array(
				'type'        => 'toggle',
				'label'       => esc_html__('Show Socials', 'dimas'),
				'default'     => '0',
				'section'     => 'header_hamburger',
				'description' => esc_html__('Display social menu', 'dimas'),
			),
			'header_hamburger_custom_field_2'           => array(
				'type'    => 'custom',
				'section' => 'header_hamburger',
				'default' => '<hr/>',
			),
			'hamburger_show_copyright'                  => array(
				'type'        => 'toggle',
				'label'       => esc_html__('Show Copyright', 'dimas'),
				'default'     => '0',
				'section'     => 'header_hamburger',
				'description' => esc_html__('Display copyright', 'dimas'),
			),

			// Header Department
			'header_department_hr'                      => array(
				'type'        => 'custom',
				'section'     => 'header_department',
				'default'     => '<hr>',
				'description' => esc_html__('Go to Appearance > Menus > create a new menu and check to Department Menu location', 'dimas'),
			),
			'header_department_text'                    => array(
				'type'    => 'text',
				'label'   => esc_html__('Text', 'dimas'),
				'section' => 'header_department',
				'default' => '',
			),
			'header_department_custom_field_1'          => array(
				'type'    => 'custom',
				'section' => 'header_department',
				'default' => '<hr/>',
			),
			'header_department_custom_color'            => array(
				'type'        => 'toggle',
				'label'       => esc_html__('Custom Color', 'dimas'),
				'section'     => 'header_department',
				'default'     => 0,
				'description' => esc_html__('Change color header department', 'dimas'),
			),
			'header_department_background_color'        => array(
				'type'            => 'color',
				'label'           => esc_html__('Background Color', 'dimas'),
				'default'         => '',
				'transport'       => 'postMessage',
				'section'         => 'header_department',
				'active_callback' => array(
					array(
						'setting'  => 'header_department_custom_color',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'js_vars'         => array(
					array(
						'element'  => '.header-department',
						'property' => '--rz-header-background-color-dark',
					),
				),
			),
			'header_department_text_color'              => array(
				'type'            => 'color',
				'label'           => esc_html__('Text Color', 'dimas'),
				'default'         => '',
				'transport'       => 'postMessage',
				'section'         => 'header_department',
				'active_callback' => array(
					array(
						'setting'  => 'header_department_custom_color',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'js_vars'         => array(
					array(
						'element'  => '.header-department',
						'property' => '--rz-header-color-light',
					),
				),
			),
			'header_department_border_color'            => array(
				'type'            => 'color',
				'label'           => esc_html__('Border Color', 'dimas'),
				'default'         => '',
				'transport'       => 'postMessage',
				'section'         => 'header_department',
				'active_callback' => array(
					array(
						'setting'  => 'header_department_custom_color',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'js_vars'         => array(
					array(
						'element'  => '.header-department',
						'property' => 'border-color',
					),
				),
			),
			'header_custom_text' => array(
				'type'        => 'textarea',
				'label'       => esc_html__('Custom Text', 'dimas'),
				'description' => esc_html__('The content of the Custom Text item', 'dimas'),
				'section'     => 'header_custom_text',
			),

			// Blog
			'blog_type'                                 => array(
				'type'        => 'radio',
				'label'       => esc_html__('Blog Type', 'dimas'),
				'description' => esc_html__('The layout of blog posts', 'dimas'),
				'default'     => 'listing',
				'choices'     => array(
					'listing' => esc_attr__('Listing', 'dimas'),
					'grid'    => esc_attr__('Grid', 'dimas'),
				),
				'section' => 'blog_page',
			),

			'blog_columns' => array(
				'type'     => 'select',
				'label'    => esc_html__('Columns', 'dimas'),
				'section'  => 'blog_page',
				'default'  => '3',
				'priority' => 10,
				'choices'  => array(
					'2' => esc_html__('2 Columns', 'dimas'),
					'3' => esc_html__('3 Columns', 'dimas'),
				),
				'active_callback' => array(
					array(
						'setting'  => 'blog_type',
						'operator' => '==',
						'value'    => 'grid',
					),
				),
			),

			'blog_layout' => array(
				'type'        => 'select',
				'label'       => esc_html__('Blog Layout', 'dimas'),
				'section'     => 'blog_page',
				'default'     => 'content-sidebar',
				'tooltip'     => esc_html__('Go to appearance > widgets find to blog sidebar to edit your sidebar', 'dimas'),
				'priority'    => 10,
				'description' => esc_html__('Select default sidebar for the single post page.', 'dimas'),
				'choices'     => array(
					'content-sidebar' => esc_html__('Right Sidebar', 'dimas'),
					'sidebar-content' => esc_html__('Left Sidebar', 'dimas'),
					'full-content'    => esc_html__('Full Content', 'dimas'),
				),
			),

			'excerpt_length' => array(
				'type'     => 'number',
				'label'    => esc_html__('Excerpt Length', 'dimas'),
				'section'  => 'blog_page',
				'default'  => 20,
				'priority' => 10,
			),

			'blog_view_more_text'                   => array(
				'type'     => 'text',
				'label'    => esc_html__('Loading Text', 'dimas'),
				'section'  => 'blog_page',
				'default'  => '',
				'priority' => 10,
			),

			// Categories Filter
			'blog_categories_filter_custom_field_2' => array(
				'type'    => 'custom',
				'section' => 'blog_page',
				'default' => '<hr/><h2>' . esc_html__('Categories Filter', 'dimas') . '</h2>',
			),
			'show_blog_cats'                        => array(
				'type'        => 'toggle',
				'label'       => esc_html__('Enable', 'dimas'),
				'section'     => 'blog_page',
				'default'     => 0,
				'description' => esc_html__('Display categories list above posts list', 'dimas'),
				'priority'    => 10,
			),

			'custom_blog_cats' => array(
				'type'     => 'toggle',
				'label'    => esc_html__('Custom Categories List', 'dimas'),
				'section'  => 'blog_page',
				'default'  => 0,
				'priority' => 10,
			),
			'blog_cats_slug'   => array(
				'type'            => 'select',
				'section'         => 'blog_page',
				'label'           => esc_html__('Custom Categories', 'dimas'),
				'description'     => esc_html__('Select product categories you want to show.', 'dimas'),
				'default'         => '',
				'multiple'        => 999,
				'priority'        => 10,
				// 'choices'         => $this->get_categories('category'),
				'active_callback' => array(
					array(
						'setting'  => 'custom_blog_cats',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),

			'blog_cats_view_all'     => array(
				'type'     => 'text',
				'label'    => esc_html__('View All Text', 'dimas'),
				'section'  => 'blog_page',
				'default'  => '',
				'priority' => 10,
			),
			'blog_cats_orderby'      => array(
				'type'     => 'select',
				'label'    => esc_html__('Categories Orderby', 'dimas'),
				'section'  => 'blog_page',
				'default'  => 'count',
				'priority' => 10,
				'choices'  => array(
					'count' => esc_html__('Count', 'dimas'),
					'title' => esc_html__('Title', 'dimas'),
					'id'    => esc_html__('ID', 'dimas'),
				),
			),
			'blog_cats_order'        => array(
				'type'     => 'select',
				'label'    => esc_html__('Categories Order', 'dimas'),
				'section'  => 'blog_page',
				'default'  => 'DESC',
				'priority' => 10,
				'choices'  => array(
					'DESC' => esc_html__('DESC', 'dimas'),
					'ASC'  => esc_html__('ASC', 'dimas'),
				),
			),
			'blog_cats_number'       => array(
				'type'     => 'number',
				'label'    => esc_html__('Categories Number', 'dimas'),
				'section'  => 'blog_page',
				'default'  => 6,
				'priority' => 10,
			),

			// Single Post
			'single_post_breadcrumb' => array(
				'type'     => 'toggle',
				'default'  => 1,
				'label'    => esc_html__('Enable breadcrumb', 'dimas'),
				'section'  => 'single_post',
				'priority' => 10,
			),

			'single_post_featured' => array(
				'type'        => 'toggle',
				'label'       => esc_html__('Enable featured image', 'dimas'),
				'default'     => '1',
				'section'     => 'single_post',
				'description' => esc_html__('Display the featured image on the post', 'dimas'),
			),

			'single_post_layout' => array(
				'type'        => 'select',
				'label'       => esc_html__('Layout', 'dimas'),
				'section'     => 'single_post',
				'default'     => 'full-content',
				'tooltip'     => esc_html__('Go to appearance > widgets find to blog sidebar to edit your sidebar', 'dimas'),
				'priority'    => 10,
				'description' => esc_html__('Select default sidebar for the single post page.', 'dimas'),
				'choices'     => array(
					'content-sidebar' => esc_html__('Right Sidebar', 'dimas'),
					'sidebar-content' => esc_html__('Left Sidebar', 'dimas'),
					'full-content'    => esc_html__('Full Content', 'dimas'),
				),
			),

			'post_custom_field_2' => array(
				'type'    => 'custom',
				'section' => 'single_post',
				'default' => '<hr/>',
			),

			'post_socials_toggle' => array(
				'type'        => 'toggle',
				'label'       => esc_html__('Socials Share', 'dimas'),
				'description' => esc_html__('Check this option to show socials share in the single post.', 'dimas'),
				'section'     => 'single_post',
				'default'     => 0,
				'priority'    => 10,
			),

			'post_socials_share'           => array(
				'type'    => 'multicheck',
				'label'   => esc_html__('Socials List', 'dimas'),
				'section' => 'single_post',
				'default' => array('facebook', 'twitter', 'googleplus', 'tumblr'),
				'choices' => array(
					'facebook'   => esc_html__('Facebook', 'dimas'),
					'twitter'    => esc_html__('Twitter', 'dimas'),
					'googleplus' => esc_html__('Google Plus', 'dimas'),
					'tumblr'     => esc_html__('Tumblr', 'dimas'),
					'pinterest'  => esc_html__('Pinterest', 'dimas'),
					'linkedin'   => esc_html__('Linkedin', 'dimas'),
					'reddit'     => esc_html__('Reddit', 'dimas'),
					'telegram'   => esc_html__('Telegram', 'dimas'),
					'pocket'     => esc_html__('Pocket', 'dimas'),
					'email'      => esc_html__('Email', 'dimas'),
				),
				'priority'        => 10,
				'active_callback' => array(
					array(
						'setting'  => 'post_socials_toggle',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),

			// Related Posts
			'related_posts_custom_field_1' => array(
				'type'    => 'custom',
				'section' => 'single_post',
				'default' => '<hr/><h2>' . esc_html__('Related Posts', 'dimas') . '</h2>',
			),

			'related_posts'             => array(
				'type'        => 'toggle',
				'label'       => esc_html__('Enable', 'dimas'),
				'description' => esc_html__('Check this option to show related posts.', 'dimas'),
				'section'     => 'single_post',
				'default'     => 0,
				'priority'    => 10,
			),
			'related_posts_title'       => array(
				'type'     => 'text',
				'label'    => esc_html__('Title', 'dimas'),
				'section'  => 'single_post',
				'default'  => '',
				'priority' => 10,

			),
			'related_posts_numbers'     => array(
				'type'        => 'number',
				'label'       => esc_html__('Numbers', 'dimas'),
				'description' => esc_html__('How many related posts would you like to show', 'dimas'),
				'section'     => 'single_post',
				'default'     => 3,
				'priority'    => 10,

			),
			'related_posts_columns'     => array(
				'type'    => 'select',
				'label'   => esc_html__('Columns', 'dimas'),
				'section' => 'single_post',
				'default' => '3',
				'choices' => array(
					'4' => esc_html__('4 Columns', 'dimas'),
					'3' => esc_html__('3 Columns', 'dimas'),
					'2' => esc_html__('2 Columns', 'dimas'),
				),
				'priority' => 10,

			),

			// Footer Layout
			'footer_sections'           => array(
				'type'        => 'sortable',
				'label'       => esc_html__('Footer Sections', 'dimas'),
				'description' => esc_html__('Select and order footer contents', 'dimas'),
				'default'     => '',
				'choices'     => array(
					'newsletter' => esc_attr__('Newsletter', 'dimas'),
					'extra'      => esc_attr__('Extra Content', 'dimas'),
					'widgets'    => esc_attr__('Footer Widgets', 'dimas'),
					'main'       => esc_attr__('Footer Main', 'dimas'),
				),
				'section' => 'footer_layout',
			),
			'footer_layout_custom_hr_1' => array(
				'type'    => 'custom',
				'default' => '<hr/>',
				'section' => 'footer_layout',
			),
			'footer_container'          => array(
				'type'        => 'select',
				'label'       => esc_html__('Footer Width', 'dimas'),
				'description' => esc_html__('Select the width of footer container', 'dimas'),
				'default'     => 'container',
				'choices'     => array(
					'container'       => esc_attr__('Normal', 'dimas'),
					'dimas-container' => esc_attr__('Large', 'dimas'),
					'dimas-container-wide'  => esc_html__('Wide', 'dimas'),
				),
				'section' => 'footer_layout',
			),
			'footer_layout_custom_hr_2' => array(
				'type'    => 'custom',
				'default' => '<hr/>',
				'section' => 'footer_layout',
			),
			'footer_section_border_top'             => array(
				'type'        => 'toggle',
				'label'       => esc_html__('Border Top', 'dimas'),
				'description' => esc_html__('Display a divide line on top', 'dimas'),
				'section'     => 'footer_layout',
				'default'     => '',
			),
			'footer_section_border_color' => array(
				'label'     => esc_html__('Border Color', 'dimas'),
				'type'      => 'color',
				'default'   => '',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '.site-footer.has-divider',
						'property' => 'border-color',
					),
				),
				'section' => 'footer_layout',
				'active_callback' => array(
					array(
						'setting'  => 'footer_section_border',
						'operator' => '==',
						'value'    => true,
					),
				),
			),

			// Footer Widget
			'footer_widgets_layout'     => array(
				'type'        => 'select',
				'tooltip'     => esc_html__('Go to appearance > widgets find to footer sidebar to edit your sidebar', 'dimas'),
				'label'       => esc_html__('Layout', 'dimas'),
				'description' => esc_html__('Select number of columns for displaying widgets', 'dimas'),
				'default'     => '4-columns',
				'choices'     => array(
					'2-columns'      => esc_html__('2 Columns', 'dimas'),
					'3-columns'      => esc_html__('3 Columns', 'dimas'),
					'4-columns'      => esc_html__('4 Columns', 'dimas'),
					'5-columns'      => esc_html__('5 Columns', 'dimas'),
				),
				'section' => 'footer_widget',
			),

			'footer_widget_custom_field_1' => array(
				'type'    => 'custom',
				'section' => 'footer_widget',
				'default' => '<hr/>',
			),

			'footer_widget_border'           => array(
				'type'        => 'toggle',
				'label'       => esc_html__('Border Line', 'dimas'),
				'description' => esc_html__('Display a divide line on top', 'dimas'),
				'default'     => true,
				'section'     => 'footer_widget',
			),
			'footer_widget_border_color' => array(
				'type'      => 'color',
				'label'     => esc_html__('Border Color', 'dimas'),
				'transport' => 'postMessage',
				'default'   => '',
				'js_vars'   => array(
					array(
						'element'  => '.footer-widgets.has-divider',
						'property' => '--rz-footer-widget-border-color',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'footer_widget_border',
						'operator' => '==',
						'value'    => true,
					),
				),
				'section' => 'footer_widget',
			),

			'footer_widget_custom_field_2' => array(
				'type'    => 'custom',
				'section' => 'footer_widget',
				'default' => '<hr/><h2>' . esc_html__('Custom Padding', 'dimas') . '</h2>',
			),

			'footer_widget_padding_top' => array(
				'type'      => 'slider',
				'label'     => esc_html__('Top', 'dimas'),
				'transport' => 'postMessage',
				'section'   => 'footer_widget',
				'default'   => '64',
				'choices'   => array(
					'min' => 0,
					'max' => 500,
				),
				'js_vars'   => array(
					array(
						'element'  => '.footer-widgets',
						'property' => '--rz-footer-widget-top-spacing',
						'units'    => 'px',
					),
				),
			),

			'footer_widget_padding_bottom' => array(
				'type'      => 'slider',
				'label'     => esc_html__('Bottom', 'dimas'),
				'transport' => 'postMessage',
				'section'   => 'footer_widget',
				'default'   => '64',
				'choices'   => array(
					'min' => 0,
					'max' => 500,
				),
				'js_vars'   => array(
					array(
						'element'  => '.footer-widgets',
						'property' => '--rz-footer-widget-bottom-spacing',
						'units'    => 'px',
					),
				),
			),

			// Footer Main
			'footer_main_left'             => array(
				'type'        => 'repeater',
				'label'       => esc_html__('Left Items', 'dimas'),
				'description' => esc_html__('Control left items of the footer', 'dimas'),
				'transport'   => 'postMessage',
				'default'     => array(array('item' => 'copyright')),
				'row_label'   => array(
					'type'  => 'field',
					'value' => esc_attr__('Item', 'dimas'),
					'field' => 'item',
				),
				'fields'          => array(
					'item' => array(
						'type'    => 'select',
						// 'choices' => $this->footer_items_option(),
					),
				),
				'section' => 'footer_main',
			),
			'footer_main_center'           => array(
				'type'        => 'repeater',
				'label'       => esc_html__('Center Items', 'dimas'),
				'description' => esc_html__('Control center items of the footer', 'dimas'),
				'transport'   => 'postMessage',
				'default'     => array(),
				'row_label'   => array(
					'type'  => 'field',
					'value' => esc_attr__('Item', 'dimas'),
					'field' => 'item',
				),
				'fields'          => array(
					'item' => array(
						'type'    => 'select',
						// 'choices' => $this->footer_items_option(),
					),
				),
				'section' => 'footer_main',
			),
			'footer_main_right'            => array(
				'type'        => 'repeater',
				'label'       => esc_html__('Right Items', 'dimas'),
				'description' => esc_html__('Control right items of the footer', 'dimas'),
				'transport'   => 'postMessage',
				'default'     => array(array('item' => 'menu')),
				'row_label'   => array(
					'type'  => 'field',
					'value' => esc_attr__('Item', 'dimas'),
					'field' => 'item',
				),
				'fields'          => array(
					'item' => array(
						'type'    => 'select',
						'default' => 'copyright',
						// 'choices' => $this->footer_items_option(),
					),
				),
				'section' => 'footer_main',
			),
			'footer_main_divide_1'         => array(
				'type'    => 'custom',
				'default' => '<hr>',
				'section' => 'footer_main',
			),
			'footer_main_border'           => array(
				'type'        => 'toggle',
				'label'       => esc_html__('Border Line', 'dimas'),
				'description' => esc_html__('Display a divide line on top', 'dimas'),
				'default'     => true,
				'section'     => 'footer_main',
			),
			'footer_main_border_color' => array(
				'type'      => 'color',
				'label'     => esc_html__('Border Color', 'dimas'),
				'transport' => 'postMessage',
				'default'   => '',
				'js_vars'   => array(
					array(
						'element'  => '.footer-main.has-divider',
						'property' => '--rz-footer-main-border-color',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'footer_main_border',
						'operator' => '==',
						'value'    => true,
					),
				),
				'section' => 'footer_main',
			),

			'footer_main_custom_field_1' => array(
				'type'    => 'custom',
				'section' => 'footer_main',
				'default' => '<hr/><h2>' . esc_html__('Custom Padding', 'dimas') . '</h2>',
			),

			'footer_main_padding_top' => array(
				'type'      => 'slider',
				'label'     => esc_html__('Top', 'dimas'),
				'transport' => 'postMessage',
				'section'   => 'footer_main',
				'default'   => '22',
				'choices'   => array(
					'min' => 0,
					'max' => 500,
				),
				'js_vars'   => array(
					array(
						'element'  => '.footer-main',
						'property' => '--rz-footer-main-top-spacing',
						'units'    => 'px',
					),
				),
			),

			'footer_main_padding_bottom' => array(
				'type'      => 'slider',
				'label'     => esc_html__('Bottom', 'dimas'),
				'transport' => 'postMessage',
				'section'   => 'footer_main',
				'default'   => '22',
				'choices'   => array(
					'min' => 0,
					'max' => 500,
				),
				'js_vars'   => array(
					array(
						'element'  => '.footer-main',
						'property' => '--rz-footer-main-bottom-spacing',
						'units'    => 'px',
					),
				),
			),

			// Footer Item
			'footer_copyright'           => array(
				'type'        => 'textarea',
				'label'       => esc_html__('Footer Copyright', 'dimas'),
				'description' => esc_html__('Display copyright info on the left side of footer', 'dimas'),
				'default'     => sprintf('%s %s ' . esc_html__('All rights reserved', 'dimas'), '&copy;' . date('Y'), get_bloginfo('name')),
				'section'     => 'footer_copyright',
			),

			'footer_menu'       => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Menu', 'dimas' ),
				'section'         => 'footer_menu',
				'default'         => '',
				// 'choices'         => $this->get_navigation_bar_get_menus(),

			),

			'footer_main_text' => array(
				'type'        => 'textarea',
				'label'       => esc_html__('Custom Text', 'dimas'),
				'description' => esc_html__('The content of the Custom Text item', 'dimas'),
				'section'     => 'footer_text',
			),

			'footer_main_payment_images' => array(
				'type'      => 'repeater',
				'label'     => esc_html__('Payment Images', 'dimas'),
				'section'   => 'footer_payment',
				'row_label' => array(
					'type'  => 'text',
					'value' => esc_html__('Image', 'dimas'),
				),
				'fields'    => array(
					'image' => array(
						'type'    => 'image',
						'label'   => esc_html__('Image', 'dimas'),
						'default' => '',
					),
					'link'  => array(
						'type'    => 'text',
						'label'   => esc_html__('Link', 'dimas'),
						'default' => '',
					),
				),
			),
			'footer_logo_type'       => array(
				'type'    => 'radio',
				'label'   => esc_html__('Logo Type', 'dimas'),
				'default' => 'text',
				'section' => 'footer_logo',
				'choices' => array(
					'image' => esc_html__('Image', 'dimas'),
					'svg'   => esc_html__('SVG', 'dimas'),
					'text'  => esc_html__('Text', 'dimas'),
				),
			),

			'footer_logo_svg'        => array(
				'type'              => 'textarea',
				'label'             => esc_html__('Logo SVG', 'dimas'),
				'section'           => 'footer_logo',
				'description'       => esc_html__('Paste SVG code of your logo here', 'dimas'),
				'sanitize_callback' => '\Dimas\Icon::sanitize_svg',
				'output'            => array(
					array(
						'element' => '.footer-branding .logo',
					),
				),
				'active_callback'   => array(
					array(
						'setting'  => 'footer_logo_type',
						'operator' => '==',
						'value'    => 'svg',
					),
				),
			),
			'footer_logo'            => array(
				'type'            => 'image',
				'label'           => esc_html__('Logo', 'dimas'),
				'default'         => '',
				'section'         => 'footer_logo',
				'active_callback' => array(
					array(
						'setting'  => 'footer_logo_type',
						'operator' => '==',
						'value'    => 'image',
					),
				),
			),
			'footer_logo_text'       => array(
				'type'    => 'textarea',
				'label'   => esc_html__('Logo Text', 'dimas'),
				'section' => 'footer_logo',
				'output'  => array(
					array(
						'element' => '.footer-branding .logo',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'footer_logo_type',
						'operator' => '==',
						'value'    => 'text',
					),
				),
			),
			'footer_logo_text_color' => array(
				'type'            => 'color',
				'label'           => esc_html__('Color', 'dimas'),
				'transport'       => 'postMessage',
				'default'         => '',
				'active_callback' => array(
					array(
						'setting'  => 'footer_logo_type',
						'operator' => '==',
						'value'    => 'text',
					),
				),
				'js_vars'         => array(
					array(
						'element'  => '.footer-branding',
						'property' => '--rz-color-dark',
					),
				),
				'section' => 'footer_logo',
			),
			'footer_logo_dimension'  => array(
				'type'    => 'dimensions',
				'label'   => esc_html__('Logo Dimension', 'dimas'),
				'default' => array(
					'width'  => '',
					'height' => '',
				),
				'section'         => 'footer_logo',
				'active_callback' => array(
					array(
						'setting'  => 'footer_logo_type',
						'operator' => '==',
						'value'    => 'image',
					),
				),
			),

			'general_backtotop'    => array(
				'type'        => 'toggle',
				'label'       => esc_html__('Back To Top', 'dimas'),
				'section'     => 'general_backtotop',
				'description' => esc_html__('Check this to show back to top.', 'dimas'),
				'default'     => true,
			),

			// Footer Extra
			'footer_extra_content' => array(
				'type'        => 'repeater',
				'label'       => esc_html__('Items', 'dimas'),
				'description' => esc_html__('Control items of the extra footer', 'dimas'),
				'transport'   => 'postMessage',
				'default'     => array(array('item' => 'copyright')),
				'row_label'   => array(
					'type'  => 'field',
					'value' => esc_attr__('Item', 'dimas'),
					'field' => 'item',
				),
				'fields'          => array(
					'item' => array(
						'type'    => 'select',
						// 'choices' => $this->footer_items_option(),
					),
				),
				'section' => 'footer_extra',
			),

			'footer_extra_custom_field_1' => array(
				'type'    => 'custom',
				'section' => 'footer_extra',
				'default' => '<hr/>',
			),

			'footer_extra_border'           => array(
				'type'        => 'toggle',
				'label'       => esc_html__('Border Line', 'dimas'),
				'description' => esc_html__('Display a divide line on top', 'dimas'),
				'default'     => false,
				'section'     => 'footer_extra',
			),
			'footer_extra_border_color' => array(
				'type'      => 'color',
				'label'     => esc_html__('Border Color', 'dimas'),
				'transport' => 'postMessage',
				'default'   => '',
				'js_vars'   => array(
					array(
						'element'  => '.footer-extra.has-divider',
						'property' => '--rz-footer-extra-border-color',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'footer_extra_border',
						'operator' => '==',
						'value'    => true,
					),
				),
				'section' => 'footer_extra',
			),

			'footer_extra_custom_field_2' => array(
				'type'    => 'custom',
				'section' => 'footer_extra',
				'default' => '<hr/><h2>' . esc_html__('Custom Padding', 'dimas') . '</h2>',
			),

			'footer_extra_padding_top' => array(
				'type'      => 'slider',
				'label'     => esc_html__('Top', 'dimas'),
				'transport' => 'postMessage',
				'section'   => 'footer_extra',
				'default'   => '105',
				'choices'   => array(
					'min' => 0,
					'max' => 500,
				),
				'js_vars'   => array(
					array(
						'element'  => '.footer-extra',
						'property' => '--rz-footer-extra-top-spacing',
						'units'    => 'px',
					),
				),
			),

			'footer_extra_padding_bottom' => array(
				'type'      => 'slider',
				'label'     => esc_html__('Bottom', 'dimas'),
				'transport' => 'postMessage',
				'section'   => 'footer_extra',
				'default'   => '112',
				'choices'   => array(
					'min' => 0,
					'max' => 500,
				),
				'js_vars'   => array(
					array(
						'element'  => '.footer-extra',
						'property' => '--rz-footer-extra-bottom-spacing',
						'units'    => 'px',
					),
				),
			),
			// Newsletter
			'footer_newsletter_layout'       => array(
				'type'    => 'radio',
				'label'   => esc_html__('Layout', 'dimas'),
				'default' => 'v1',
				'section' => 'footer_newsletter',
				'choices' => array(
					'v1' => esc_html__('Layout 1', 'dimas'),
					'v2' => esc_html__('Layout 2', 'dimas'),
				),
			),

			'footer_newsletter_text' => array(
				'type'            => 'text',
				'label'           => esc_html__('Title', 'dimas'),
				'section'         => 'footer_newsletter',
				'default'         => '',
			),

			'footer_newsletter_form' => array(
				'type'            => 'textarea',
				'label'           => esc_html__('Form', 'dimas'),
				'description'     => esc_html__('Enter the shortcode of MailChimp form', 'dimas'),
				'section'         => 'footer_newsletter',
				'default'         => '',
			),

			'custom_newsletter_link_to_form' => array(
				'type'            => 'custom',
				'section'         => 'footer_newsletter',
				'default'         => sprintf('<a href="%s">%s</a>', admin_url('admin.php?page=mailchimp-for-wp-forms'), esc_html__('Go to MailChimp form', 'dimas')),
			),

			'footer_newsletter_custom_field_1' => array(
				'type'    => 'custom',
				'section' => 'footer_newsletter',
				'default' => '<hr/>',
			),

			'footer_newsletter_border'           => array(
				'type'        => 'toggle',
				'label'       => esc_html__('Border Line', 'dimas'),
				'description' => esc_html__('Display a divide line on top', 'dimas'),
				'default'     => false,
				'section'     => 'footer_newsletter',
			),
			'footer_newsletter_border_color' => array(
				'type'      => 'color',
				'label'     => esc_html__('Border Color', 'dimas'),
				'transport' => 'postMessage',
				'default'   => '',
				'js_vars'   => array(
					array(
						'element'  => '.footer-newsletter.has-divider',
						'property' => '--rz-footer-newsletter-border-color',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'footer_newsletter_border',
						'operator' => '==',
						'value'    => true,
					),
				),
				'section' => 'footer_newsletter',
			),

			'footer_newsletter_custom_field_2' => array(
				'type'            => 'custom',
				'section'         => 'footer_newsletter',
				'default'         => '<hr/><h2>' . esc_html__('Custom Padding', 'dimas') . '</h2>',
			),

			'footer_newsletter_padding_top' => array(
				'type'      => 'slider',
				'label'     => esc_html__('Top', 'dimas'),
				'transport' => 'postMessage',
				'section'   => 'footer_newsletter',
				'default'   => '110',
				'choices'   => array(
					'min' => 0,
					'max' => 500,
				),
				'js_vars'         => array(
					array(
						'element'  => '.footer-newsletter',
						'property' => 'padding-top',
						'units'    => 'px',
					),
				),
			),

			'footer_newsletter_padding_bottom' => array(
				'type'      => 'slider',
				'label'     => esc_html__('Bottom', 'dimas'),
				'transport' => 'postMessage',
				'section'   => 'footer_newsletter',
				'default'   => '41',
				'choices'   => array(
					'min' => 0,
					'max' => 500,
				),
				'js_vars'         => array(
					array(
						'element'  => '.footer-newsletter',
						'property' => 'padding-bottom',
						'units'    => 'px',
					),
				),
			),
			// Background
			'footer_background_scheme'       => array(
				'type'    => 'select',
				'label'   => esc_html__('Background Scheme', 'dimas'),
				'default' => 'dark',
				'section' => 'footer_background',
				'choices' => array(
					'dark'   => esc_html__('Dark', 'dimas'),
					'light'  => esc_html__('Light', 'dimas'),
					'gray'   => esc_html__('Gray', 'dimas'),
					'custom' => esc_html__('Custom', 'dimas'),
				),
			),
			'footer_bg'                        => array(
				'type'    => 'image',
				'label'   => esc_html__('Background Image', 'dimas'),
				'default' => '',
				'section' => 'footer_background',
				'active_callback' => array(
					array(
						'setting'  => 'footer_background_scheme',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),

			'footer_bg_color' => array(
				'label'     => esc_html__('Background Color', 'dimas'),
				'type'      => 'color',
				'default'   => '',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '#site-footer',
						'property' => 'background-color',
					),
				),
				'section' => 'footer_background',
				'active_callback' => array(
					array(
						'setting'  => 'footer_background_scheme',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),

			'footer_bg_heading_color' => array(
				'type'      => 'color',
				'label'     => esc_html__('Heading Color', 'dimas'),
				'transport' => 'postMessage',
				'default'   => '',
				'js_vars'   => array(
					array(
						'element'  => '#site-footer .newsletter-title, #site-footer .widget-title, #site-footer .logo .logo-text',
						'property' => '--rz-color-lighter',
					),
				),
				'section' => 'footer_background',
				'active_callback' => array(
					array(
						'setting'  => 'footer_background_scheme',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),

			'footer_bg_text_color' => array(
				'type'      => 'color',
				'label'     => esc_html__('Text Color', 'dimas'),
				'transport' => 'postMessage',
				'default'   => '',
				'js_vars'   => array(
					array(
						'element'  => '#site-footer',
						'property' => '--rz-text-color-gray',
					),
				),
				'section' => 'footer_background',
				'active_callback' => array(
					array(
						'setting'  => 'footer_background_scheme',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),

			'footer_bg_text_color_hover' => array(
				'type'      => 'color',
				'label'     => esc_html__('Text Hover Color', 'dimas'),
				'transport' => 'postMessage',
				'default'   => '',
				'js_vars'   => array(
					array(
						'element'  => '#site-footer',
						'property' => '--rz-text-color-hover',
					),
				),
				'section' => 'footer_background',
				'active_callback' => array(
					array(
						'setting'  => 'footer_background_scheme',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),

			'footer_bg_custom_field_2' => array(
				'type'    => 'custom',
				'section' => 'footer_background',
				'default' => '<hr/>',
				'active_callback' => array(
					array(
						'setting'  => 'footer_background_scheme',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),

			'footer_extra_bg_enable' => array(
				'type'        => 'toggle',
				'label'       => esc_html__('FOOTER EXTRA', 'dimas'),
				'section'     => 'footer_background',
				'default'     => false,
				'active_callback' => array(
					array(
						'setting'  => 'footer_background_scheme',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),

			'footer_extra_bg' => array(
				'type'    => 'image',
				'label'   => esc_html__('Background Image', 'dimas'),
				'default' => '',
				'section' => 'footer_background',
				'active_callback' => array(
					array(
						'setting'  => 'footer_background_scheme',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'footer_extra_bg_enable',
						'operator' => '==',
						'value'    => true,
					),
				),
			),

			'footer_extra_bg_color' => array(
				'label'     => esc_html__('Background Color', 'dimas'),
				'type'      => 'color',
				'default'   => '',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '#site-footer .footer-extra',
						'property' => 'background-color',
					),
				),
				'section' => 'footer_background',
				'active_callback' => array(
					array(
						'setting'  => 'footer_background_scheme',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'footer_extra_bg_enable',
						'operator' => '==',
						'value'    => true,
					),
				),
			),

			'footer_extra_text_color' => array(
				'type'      => 'color',
				'label'     => esc_html__('Text Color', 'dimas'),
				'transport' => 'postMessage',
				'default'   => '',
				'js_vars'   => array(
					array(
						'element'  => '#site-footer .footer-extra',
						'property' => '--rz-text-color-gray',
					),
				),
				'section' => 'footer_background',
				'active_callback' => array(
					array(
						'setting'  => 'footer_background_scheme',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'footer_extra_bg_enable',
						'operator' => '==',
						'value'    => true,
					),
				),
			),

			'footer_extra_text_color_hover' => array(
				'type'      => 'color',
				'label'     => esc_html__('Text Hover Color', 'dimas'),
				'transport' => 'postMessage',
				'default'   => '',
				'js_vars'   => array(
					array(
						'element'  => '#site-footer .footer-extra',
						'property' => '--rz-text-color-hover',
					),
				),
				'section' => 'footer_background',
				'active_callback' => array(
					array(
						'setting'  => 'footer_background_scheme',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'footer_extra_bg_enable',
						'operator' => '==',
						'value'    => true,
					),
				),
			),

			'footer_newsletter_custom_field_10' => array(
				'type'    => 'custom',
				'section' => 'footer_background',
				'label'   => '<hr/>',
				'active_callback' => array(
					array(
						'setting'  => 'footer_background_scheme',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),

			'footer_newsletter_bg_enable' => array(
				'type'        => 'toggle',
				'label'       => esc_html__('FOOTER NEWSLETTER', 'dimas'),
				'section'     => 'footer_background',
				'default'     => false,
				'active_callback' => array(
					array(
						'setting'  => 'footer_background_scheme',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),

			'footer_newsletter_bg' => array(
				'type'    => 'image',
				'label'   => esc_html__('Background Image', 'dimas'),
				'default' => '',
				'section' => 'footer_background',
				'active_callback' => array(
					array(
						'setting'  => 'footer_background_scheme',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'footer_newsletter_bg_enable',
						'operator' => '==',
						'value'    => true,
					),
				),
			),

			'footer_newsletter_bg_color' => array(
				'label'     => esc_html__('Background Color', 'dimas'),
				'type'      => 'color',
				'default'   => '',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '#site-footer .footer-newsletter',
						'property' => 'background-color',
					),
				),
				'section' => 'footer_background',
				'active_callback' => array(
					array(
						'setting'  => 'footer_background_scheme',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'footer_newsletter_bg_enable',
						'operator' => '==',
						'value'    => true,
					),
				),
			),

			'footer_newsletter_heading_color' => array(
				'type'      => 'color',
				'label'     => esc_html__('Heading Color', 'dimas'),
				'transport' => 'postMessage',
				'default'   => '',
				'js_vars'   => array(
					array(
						'element'  => '#site-footer .newsletter-title',
						'property' => '--rz-color-lighter',
					),
				),
				'section' => 'footer_background',
				'active_callback' => array(
					array(
						'setting'  => 'footer_background_scheme',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'footer_newsletter_bg_enable',
						'operator' => '==',
						'value'    => true,
					),
				),
			),

			'footer_newsletter_form_border_color' => array(
				'type'      => 'color',
				'label'     => esc_html__('Border Color', 'dimas'),
				'transport' => 'postMessage',
				'default'   => '',
				'js_vars'   => array(
					array(
						'element'  => '#site-footer .footer-newsletter.layout-v2',
						'property' => '--rz-textbox-bg-color',
					),
				),
				'section' => 'footer_background',
				'active_callback' => array(
					array(
						'setting'  => 'footer_newsletter_layout',
						'operator' => '==',
						'value'    => 'v2',
					),
					array(
						'setting'  => 'footer_background_scheme',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'footer_newsletter_bg_enable',
						'operator' => '==',
						'value'    => true,
					),
				),
			),

			'footer_newsletter_text_field_bgcolor' => array(
				'type'      => 'color',
				'label'     => esc_html__('Text Field Background Color', 'dimas'),
				'transport' => 'postMessage',
				'default'   => '',
				'js_vars'   => array(
					array(
						'element'  => '#site-footer .footer-newsletter.layout-v1',
						'property' => '--rz-textbox-bg-color',
					),
				),
				'section' => 'footer_background',
				'active_callback' => array(
					array(
						'setting'  => 'footer_newsletter_layout',
						'operator' => '==',
						'value'    => 'v1',
					),
					array(
						'setting'  => 'footer_background_scheme',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'footer_newsletter_bg_enable',
						'operator' => '==',
						'value'    => true,
					),
				),
			),

			'footer_newsletter_text_field_placeholder_color' => array(
				'type'      => 'color',
				'label'     => esc_html__('Text Field Placehoder Color', 'dimas'),
				'transport' => 'postMessage',
				'default'   => '',
				'js_vars'   => array(
					array(
						'element'  => '#site-footer .footer-newsletter .mc4wp-form-fields',
						'property' => '--rz-textbox-color',
					),
				),
				'section' => 'footer_background',
				'active_callback' => array(
					array(
						'setting'  => 'footer_background_scheme',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'footer_newsletter_bg_enable',
						'operator' => '==',
						'value'    => true,
					),
				),
			),

			'footer_newsletter_text_field_color' => array(
				'type'      => 'color',
				'label'     => esc_html__('Text Field Color', 'dimas'),
				'transport' => 'postMessage',
				'default'   => '',
				'js_vars'   => array(
					array(
						'element'  => '#site-footer .footer-newsletter',
						'property' => '--rz-textbox-color',
					),
				),
				'section' => 'footer_background',
				'active_callback' => array(
					array(
						'setting'  => 'footer_background_scheme',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'footer_newsletter_bg_enable',
						'operator' => '==',
						'value'    => true,
					),
				),
			),

			'footer_newsletter_submit_bg_color' => array(
				'type'      => 'color',
				'label'     => esc_html__('Button Background Color', 'dimas'),
				'transport' => 'postMessage',
				'default'   => '',
				'js_vars'   => array(
					array(
						'element'  => '#site-footer .footer-newsletter.layout-v1',
						'property' => '--rz-button-bg-color',
					),
				),
				'section' => 'footer_background',
				'active_callback' => array(
					array(
						'setting'  => 'footer_newsletter_layout',
						'operator' => '==',
						'value'    => 'v1',
					),
					array(
						'setting'  => 'footer_background_scheme',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'footer_newsletter_bg_enable',
						'operator' => '==',
						'value'    => true,
					),
				),
			),

			'footer_newsletter_submit_color' => array(
				'type'      => 'color',
				'label'     => esc_html__('Button Color', 'dimas'),
				'transport' => 'postMessage',
				'default'   => '',
				'js_vars'   => array(
					array(
						'element'  => '#site-footer .footer-newsletter',
						'property' => '--rz-button-color',
					),
				),
				'section' => 'footer_background',
				'active_callback' => array(
					array(
						'setting'  => 'footer_background_scheme',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'footer_newsletter_bg_enable',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
			'footer_widgets_custom_field_10' => array(
				'type'    => 'custom',
				'section' => 'footer_background',
				'label'   => '<hr/>',
				'active_callback' => array(
					array(
						'setting'  => 'footer_background_scheme',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),

			'footer_widgets_bg_enable' => array(
				'type'        => 'toggle',
				'label'       => esc_html__('FOOTER WIDGETS', 'dimas'),
				'section'     => 'footer_background',
				'default'     => false,
				'active_callback' => array(
					array(
						'setting'  => 'footer_background_scheme',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
			'footer_widget_bg' => array(
				'type'    => 'image',
				'label'   => esc_html__('Background Image', 'dimas'),
				'default' => '',
				'section' => 'footer_background',
				'active_callback' => array(
					array(
						'setting'  => 'footer_background_scheme',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'footer_widgets_bg_enable',
						'operator' => '==',
						'value'    => true,
					),
				),
			),

			'footer_widget_bg_color' => array(
				'label'     => esc_html__('Background Color', 'dimas'),
				'type'      => 'color',
				'default'   => '',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '#site-footer .footer-widgets',
						'property' => 'background-color',
					),
				),
				'section' => 'footer_background',
				'active_callback' => array(
					array(
						'setting'  => 'footer_background_scheme',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'footer_widgets_bg_enable',
						'operator' => '==',
						'value'    => true,
					),
				),
			),

			'footer_widget_dropdown_border_color' => array(
				'label'     => esc_html__('Border Color Dropdown', 'dimas'),
				'type'      => 'color',
				'default'   => '',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '#site-footer .footer-widgets .widget.dropdown',
						'property' => 'border-color',
					),
				),
				'section' => 'footer_background',
				'active_callback' => array(
					array(
						'setting'  => 'footer_background_scheme',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'footer_widgets_bg_enable',
						'operator' => '==',
						'value'    => true,
					),
				),
			),

			'footer_widget_heading_color' => array(
				'type'      => 'color',
				'label'     => esc_html__('Heading Color', 'dimas'),
				'transport' => 'postMessage',
				'default'   => '',
				'js_vars'   => array(
					array(
						'element'  => '#site-footer .footer-widgets .widget-title, #site-footer .footer-widgets .logo-text',
						'property' => '--rz-color-lighter',
					),
				),
				'section' => 'footer_background',
				'active_callback' => array(
					array(
						'setting'  => 'footer_background_scheme',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'footer_widgets_bg_enable',
						'operator' => '==',
						'value'    => true,
					),
				),
			),

			'footer_widget_text_color' => array(
				'type'      => 'color',
				'label'     => esc_html__('Text Color', 'dimas'),
				'transport' => 'postMessage',
				'default'   => '',
				'js_vars'   => array(
					array(
						'element'  => '#site-footer .footer-widgets',
						'property' => '--rz-text-color-gray',
					),
				),
				'section' => 'footer_background',
				'active_callback' => array(
					array(
						'setting'  => 'footer_background_scheme',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'footer_widgets_bg_enable',
						'operator' => '==',
						'value'    => true,
					),
				),
			),

			'footer_widget_text_color_hover' => array(
				'type'      => 'color',
				'label'     => esc_html__('Text Hover Color', 'dimas'),
				'transport' => 'postMessage',
				'default'   => '',
				'js_vars'   => array(
					array(
						'element'  => '#site-footer .footer-widgets',
						'property' => '--rz-text-color-hover',
					),
				),
				'section' => 'footer_background',
				'active_callback' => array(
					array(
						'setting'  => 'footer_background_scheme',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'footer_widgets_bg_enable',
						'operator' => '==',
						'value'    => true,
					),
				),
			),

			'footer_main_custom_field_10' => array(
				'type'    => 'custom',
				'section' => 'footer_background',
				'label'   => '<hr/>',
				'active_callback' => array(
					array(
						'setting'  => 'footer_background_scheme',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),

			'footer_main_bg_enable' => array(
				'type'        => 'toggle',
				'label'       => esc_html__('FOOTER MAIN', 'dimas'),
				'section'     => 'footer_background',
				'default'     => false,
				'active_callback' => array(
					array(
						'setting'  => 'footer_background_scheme',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
			'footer_main_bg' => array(
				'type'    => 'image',
				'label'   => esc_html__('Background Image', 'dimas'),
				'default' => '',
				'section' => 'footer_background',
				'active_callback' => array(
					array(
						'setting'  => 'footer_background_scheme',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'footer_main_bg_enable',
						'operator' => '==',
						'value'    => true,
					),
				),
			),

			'footer_main_bg_color' => array(
				'label'     => esc_html__('Background Color', 'dimas'),
				'type'      => 'color',
				'default'   => '',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '#site-footer .footer-main',
						'property' => 'background-color',
					),
				),
				'section' => 'footer_background',
				'active_callback' => array(
					array(
						'setting'  => 'footer_background_scheme',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'footer_main_bg_enable',
						'operator' => '==',
						'value'    => true,
					),
				),
			),

			'footer_main_text_color' => array(
				'type'      => 'color',
				'label'     => esc_html__('Text Color', 'dimas'),
				'transport' => 'postMessage',
				'default'   => '',
				'js_vars'   => array(
					array(
						'element'  => '#site-footer .footer-main',
						'property' => '--rz-text-color-gray',
					),
				),
				'section' => 'footer_background',
				'active_callback' => array(
					array(
						'setting'  => 'footer_background_scheme',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'footer_main_bg_enable',
						'operator' => '==',
						'value'    => true,
					),
				),
			),

			'footer_main_text_color_hover' => array(
				'type'      => 'color',
				'label'     => esc_html__('Text Hover Color', 'dimas'),
				'transport' => 'postMessage',
				'default'   => '',
				'js_vars'   => array(
					array(
						'element'  => '#site-footer .footer-main',
						'property' => '--rz-text-color-hover',
					),
				),
				'section' => 'footer_background',
				'active_callback' => array(
					array(
						'setting'  => 'footer_background_scheme',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'footer_main_bg_enable',
						'operator' => '==',
						'value'    => true,
					),
				),
			),


			'page_header'             => array(
				'type'        => 'toggle',
				'default'     => 1,
				'label'       => esc_html__('Enable Page Header', 'dimas'),
				'section'     => 'page_header',
				'description' => esc_html__('Enable to show a page header for the page below the site header', 'dimas'),
				'priority'    => 10,
			),

			'page_header_custom_field_1' => array(
				'type'            => 'custom',
				'section'         => 'page_header',
				'default'         => '<hr/>',
				'active_callback' => array(
					array(
						'setting'  => 'page_header',
						'operator' => '==',
						'value'    => '1',
					),
				),
			),

			'page_header_els' => array(
				'type'     => 'multicheck',
				'label'    => esc_html__('Page Header Elements', 'dimas'),
				'section'  => 'page_header',
				'default'  => array('breadcrumb', 'title'),
				'priority' => 10,
				'choices'  => array(
					'breadcrumb' => esc_html__('BreadCrumb', 'dimas'),
					'title'      => esc_html__('Title', 'dimas'),
				),
				'description'     => esc_html__('Select which elements you want to show.', 'dimas'),
				'active_callback' => array(
					array(
						'setting'  => 'page_header',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),

			'page_header_custom_field_2' => array(
				'type'            => 'custom',
				'section'         => 'page_header',
				'default'         => '<hr/><h3>' . esc_html__('Custom Title', 'dimas') . '</h3>',
				'active_callback' => array(
					array(
						'setting'  => 'page_header',
						'operator' => '==',
						'value'    => '1',
					),
					array(
						'setting'  => 'page_header_els',
						'operator' => 'in',
						'value'    => 'title',
					),
				),
			),

			'page_header_padding_top' => array(
				'type'      => 'slider',
				'label'     => esc_html__('Padding Top', 'dimas'),
				'transport' => 'postMessage',
				'section'   => 'page_header',
				'default'   => 50,
				'priority'  => 20,
				'choices'   => array(
					'min' => 0,
					'max' => 500,
				),
				'js_vars'         => array(
					array(
						'element'  => '#page-header .page-header__title',
						'property' => 'padding-top',
						'units'    => 'px',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'page_header',
						'operator' => '==',
						'value'    => '1',
					),
					array(
						'setting'  => 'page_header_els',
						'operator' => 'in',
						'value'    => 'title',
					),
				),
			),

			'page_header_padding_bottom'  => array(
				'type'      => 'slider',
				'label'     => esc_html__('Padding Bottom', 'dimas'),
				'transport' => 'postMessage',
				'section'   => 'page_header',
				'default'   => 50,
				'priority'  => 20,
				'choices'   => array(
					'min' => 0,
					'max' => 500,
				),
				'js_vars'         => array(
					array(
						'element'  => '#page-header .page-header__title',
						'property' => 'padding-bottom',
						'units'    => 'px',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'page_header',
						'operator' => '==',
						'value'    => '1',
					),
					array(
						'setting'  => 'page_header_els',
						'operator' => 'in',
						'value'    => 'title',
					),
				),
			),

			// Boxed Layout
			'boxed_layout'                => array(
				'type'     => 'toggle',
				'label'    => esc_html__('Boxed Layout', 'dimas'),
				'section'  => 'boxed_layout',
				'default'  => 0,
				'priority' => 10,
			),
			'boxed_background_color'      => array(
				'type'            => 'color',
				'label'           => esc_html__('Background Color', 'dimas'),
				'default'         => '',
				'section'         => 'boxed_layout',
				'priority'        => 10,
				'active_callback' => array(
					array(
						'setting'  => 'boxed_layout',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'boxed_background_image'      => array(
				'type'            => 'image',
				'label'           => esc_html__('Background Image', 'dimas'),
				'default'         => '',
				'section'         => 'boxed_layout',
				'priority'        => 10,
				'active_callback' => array(
					array(
						'setting'  => 'boxed_layout',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'boxed_background_horizontal' => array(
				'type'     => 'select',
				'label'    => esc_html__('Background Horizontal', 'dimas'),
				'section'  => 'boxed_layout',
				'default'  => '',
				'priority' => 10,
				'choices'  => array(
					''       => esc_html__('None', 'dimas'),
					'left'   => esc_html__('Left', 'dimas'),
					'center' => esc_html__('Center', 'dimas'),
					'right'  => esc_html__('Right', 'dimas'),
				),
				'active_callback' => array(
					array(
						'setting'  => 'boxed_layout',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'boxed_background_vertical'   => array(
				'type'     => 'select',
				'label'    => esc_html__('Background Vertical', 'dimas'),
				'section'  => 'boxed_layout',
				'default'  => '',
				'priority' => 10,
				'choices'  => array(
					''       => esc_html__('None', 'dimas'),
					'top'    => esc_html__('Top', 'dimas'),
					'center' => esc_html__('Center', 'dimas'),
					'bottom' => esc_html__('Bottom', 'dimas'),
				),
				'active_callback' => array(
					array(
						'setting'  => 'boxed_layout',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'boxed_background_repeat'     => array(
				'type'     => 'select',
				'label'    => esc_html__('Background Repeat', 'dimas'),
				'section'  => 'boxed_layout',
				'default'  => '',
				'priority' => 10,
				'choices'  => array(
					''          => esc_html__('None', 'dimas'),
					'no-repeat' => esc_html__('No Repeat', 'dimas'),
					'repeat'    => esc_html__('Repeat', 'dimas'),
					'repeat-y'  => esc_html__('Repeat Vertical', 'dimas'),
					'repeat-x'  => esc_html__('Repeat Horizontal', 'dimas'),
				),
				'active_callback' => array(
					array(
						'setting'  => 'boxed_layout',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'boxed_background_attachment' => array(
				'type'     => 'select',
				'label'    => esc_html__('Background Attachment', 'dimas'),
				'section'  => 'boxed_layout',
				'default'  => '',
				'priority' => 10,
				'choices'  => array(
					''       => esc_html__('None', 'dimas'),
					'scroll' => esc_html__('Scroll', 'dimas'),
					'fixed'  => esc_html__('Fixed', 'dimas'),
				),
				'active_callback' => array(
					array(
						'setting'  => 'boxed_layout',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),
			'boxed_background_size'       => array(
				'type'     => 'select',
				'label'    => esc_html__('Background Size', 'dimas'),
				'section'  => 'boxed_layout',
				'default'  => '',
				'priority' => 10,
				'choices'  => array(
					''        => esc_html__('None', 'dimas'),
					'auto'    => esc_html__('Auto', 'dimas'),
					'cover'   => esc_html__('Cover', 'dimas'),
					'contain' => esc_html__('Contain', 'dimas'),
				),
				'active_callback' => array(
					array(
						'setting'  => 'boxed_layout',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),

			// Blog
			'page_header_blog'            => array(
				'type'        => 'toggle',
				'default'     => 1,
				'label'       => esc_html__('Enable Page Header', 'dimas'),
				'section'     => 'page_header_blog',
				'description' => esc_html__('Enable to show a page header for the page below the site header', 'dimas'),
				'priority'    => 10,
			),

			'page_header_blog_custom_field_1' => array(
				'type'            => 'custom',
				'section'         => 'page_header_blog',
				'default'         => '<hr/>',
				'active_callback' => array(
					array(
						'setting'  => 'page_header_blog',
						'operator' => '==',
						'value'    => '1',
					),
				),
			),

			'page_header_blog_els' => array(
				'type'     => 'multicheck',
				'label'    => esc_html__('Page Header Elements', 'dimas'),
				'section'  => 'page_header_blog',
				'default'  => array('breadcrumb', 'title'),
				'priority' => 10,
				'choices'  => array(
					'breadcrumb' => esc_html__('BreadCrumb', 'dimas'),
					'title'      => esc_html__('Title', 'dimas'),
				),
				'description'     => esc_html__('Select which elements you want to show.', 'dimas'),
				'active_callback' => array(
					array(
						'setting'  => 'page_header_blog',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),

			'page_header_blog_custom_field_2' => array(
				'type'            => 'custom',
				'section'         => 'page_header_blog',
				'default'         => '<hr/><h3>' . esc_html__('Custom Title', 'dimas') . '</h3>',
				'active_callback' => array(
					array(
						'setting'  => 'page_header_blog',
						'operator' => '==',
						'value'    => '1',
					),
					array(
						'setting'  => 'page_header_blog_els',
						'operator' => 'in',
						'value'    => 'title',
					),
				),
			),

			'page_header_blog_padding_top' => array(
				'type'      => 'slider',
				'label'     => esc_html__('Padding Top', 'dimas'),
				'transport' => 'postMessage',
				'section'   => 'page_header_blog',
				'default'   => 50,
				'priority'  => 20,
				'choices'   => array(
					'min' => 0,
					'max' => 500,
				),
				'js_vars'         => array(
					array(
						'element'  => '.dimas-blog-page #page-header .page-header__title',
						'property' => 'padding-top',
						'units'    => 'px',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'page_header_blog',
						'operator' => '==',
						'value'    => '1',
					),
					array(
						'setting'  => 'page_header_blog_els',
						'operator' => 'in',
						'value'    => 'title',
					),
				),
			),

			'page_header_blog_padding_bottom' => array(
				'type'      => 'slider',
				'label'     => esc_html__('Padding Bottom', 'dimas'),
				'transport' => 'postMessage',
				'section'   => 'page_header_blog',
				'default'   => 50,
				'priority'  => 20,
				'choices'   => array(
					'min' => 0,
					'max' => 500,
				),
				'js_vars'         => array(
					array(
						'element'  => '.dimas-blog-page #page-header .page-header__title',
						'property' => 'padding-bottom',
						'units'    => 'px',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'page_header_blog',
						'operator' => '==',
						'value'    => '1',
					),
					array(
						'setting'  => 'page_header_blog_els',
						'operator' => 'in',
						'value'    => 'title',
					),
				),
			),

			// Recently viewed
			'recently_viewed_enable'          => array(
				'type'        => 'toggle',
				'label'       => esc_html__('Recently Viewed', 'dimas'),
				'section'     => 'recently_viewed',
				'default'     => 0,
				'description' => esc_html__('Check this option to show the recently viewed products above the footer.', 'dimas'),
			),

			'recently_viewed_ajax' => array(
				'type'    => 'toggle',
				'label'   => esc_html__('Load With Ajax', 'dimas'),
				'section' => 'recently_viewed',
				'default' => 0,
				'active_callback' => array(
					array(
						'setting'  => 'recently_viewed_enable',
						'operator' => '==',
						'value'    => '1',
					),
				),
			),

			'recently_viewed_empty' => array(
				'type'            => 'toggle',
				'label'           => esc_html__('Hide Empty Products', 'dimas'),
				'section'         => 'recently_viewed',
				'default'         => 1,
				'description'     => esc_html__('Check this option to hide the recently viewed products when empty.', 'dimas'),
				'active_callback' => array(
					array(
						'setting'  => 'recently_viewed_enable',
						'operator' => '==',
						'value'    => '1',
					),
				),
			),

			'recently_viewed_display_page' => array(
				'type'     => 'multicheck',
				'label'    => esc_html__('Display On Page', 'dimas'),
				'section'  => 'recently_viewed',
				'default'  => array('single'),
				'priority' => 10,
				'choices'  => array(
					'single'   => esc_html__('Single Product', 'dimas'),
					'catalog'  => esc_html__('Catalog Page', 'dimas'),
					'cart'     => esc_html__('Cart Page', 'dimas'),
					'checkout' => esc_html__('Checkout Page', 'dimas'),
				),
				'active_callback' => array(
					array(
						'setting'  => 'recently_viewed_enable',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),

			'recently_viewed_custom' => array(
				'type'    => 'custom',
				'section' => 'recently_viewed',
				'default' => '<hr/>',
			),

			'recently_viewed_layout' => array(
				'type'    => 'select',
				'label'   => esc_html__('Layout', 'dimas'),
				'section' => 'recently_viewed',
				'default' => 'default',
				'choices' => array(
					'default' => esc_html__('Default', 'dimas'),
					'effect'  => esc_html__('Effect Hover', 'dimas'),
				),
				'active_callback' => array(
					array(
						'setting'  => 'recently_viewed_enable',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),

			'recently_viewed_title' => array(
				'type'            => 'text',
				'label'           => esc_html__('Title', 'dimas'),
				'section'         => 'recently_viewed',
				'default'         => '',
				'active_callback' => array(
					array(
						'setting'  => 'recently_viewed_enable',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),

			'recently_viewed_button_text' => array(
				'type'            => 'text',
				'label'           => esc_html__('Button Text', 'dimas'),
				'section'         => 'recently_viewed',
				'default'         => '',
				'active_callback' => array(
					array(
						'setting'  => 'recently_viewed_enable',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),

			'recently_viewed_button_link' => array(
				'type'            => 'text',
				'label'           => esc_html__('Button Link', 'dimas'),
				'section'         => 'recently_viewed',
				'default'         => '',
				'active_callback' => array(
					array(
						'setting'  => 'recently_viewed_enable',
						'operator' => '==',
						'value'    => 1,
					),
				),
			),

			'recently_viewed_columns' => array(
				'type'            => 'number',
				'label'           => esc_html__('Columns', 'dimas'),
				'section'         => 'recently_viewed',
				'default'         => 4,
				'active_callback' => array(
					array(
						'setting'  => 'recently_viewed_enable',
						'operator' => '==',
						'value'    => 1,
					),
				),
				'description' => esc_html__('Specify how many numbers of recently viewed products you want to show on page', 'dimas'),
			),

			'recently_viewed_numbers' => array(
				'type'            => 'number',
				'label'           => esc_html__('Numbers', 'dimas'),
				'section'         => 'recently_viewed',
				'default'         => 6,
				'active_callback' => array(
					array(
						'setting'  => 'recently_viewed_enable',
						'operator' => '==',
						'value'    => 1,
					),
				),
				'description' => esc_html__('Specify how many numbers of recently viewed products you want to show on page', 'dimas'),
			),
			// Topbar Mobile
			'mobile_topbar' => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Topbar', 'dimas' ),
				'description' => esc_html__( 'Display topbar on mobile', 'dimas' ),
				'default'     => false,
				'section'     => 'mobile_topbar',
			),

			'mobile_topbar_items'               => array(
				'type'            => 'repeater',
				'label'           => esc_html__( 'List Items', 'dimas' ),
				'description'     => esc_html__( 'Control items on the topbar mobile', 'dimas' ),
				'transport'       => 'postMessage',
				'default'         => array(),
				'section'         => 'mobile_topbar',
				'row_label'       => array(
					'type'  => 'field',
					'value' => esc_attr__( 'Item', 'dimas' ),
					'field' => 'item',
				),
				'fields'          => array(
					'item' => array(
						'type'    => 'select',
						// 'choices' => $this->topbar_items_option(),
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'mobile_topbar',
						'operator' => '==',
						'value'    => '1',
					),
				),
			),
			'mobile_topbar_custom_field_1'      => array(
				'type'    => 'custom',
				'section' => 'mobile_topbar',
				'default' => '<hr/>',
			),
			'mobile_topbar_svg_code'            => array(
				'type'              => 'textarea',
				'label'             => esc_html__( 'SVG code', 'dimas' ),
				'section'           => 'mobile_topbar',
				'description'       => esc_html__( 'The SVG before your text', 'dimas' ),
				'default'           => '',
				'sanitize_callback' => '\Dimas\Icon::sanitize_svg',
				'output'            => array(
					array(
						'element' => '.dimas-topbar__text .dimas-svg-icon',
					),
				),
				'active_callback'   => array(
					array(
						'setting'  => 'mobile_topbar',
						'operator' => '==',
						'value'    => '1',
					),
				),
			),
			'mobile_topbar_text'                => array(
				'type'            => 'editor',
				'label'           => esc_html__( 'Custom Text', 'dimas' ),
				'section'         => 'mobile_topbar',
				'description'     => esc_html__( 'The content of Custom Text item', 'dimas' ),
				'default'         => '',
				'active_callback' => array(
					array(
						'setting'  => 'mobile_topbar',
						'operator' => '==',
						'value'    => '1',
					),
				),
			),
			'mobile_header_height'              => array(
				'type'      => 'slider',
				'label'     => esc_html__( 'Header Height', 'dimas' ),
				'section'   => 'mobile_header',
				'transport' => 'postMessage',
				'default'   => '60',
				'choices'   => array(
					'min' => 40,
					'max' => 300,
				),
				'js_vars'   => array(
					array(
						'element'  => '.header-mobile',
						'property' => 'height',
						'units'    => 'px',
					),
				),
			),
			'mobile_header_custom_field_2'      => array(
				'type'    => 'custom',
				'section' => 'mobile_header',
				'default' => '<hr/>',
			),
			'mobile_header_icons'               => array(
				'type'        => 'repeater',
				'label'       => esc_html__( 'Header Icons', 'dimas' ),
				'section'     => 'mobile_header',
				'description' => esc_html__( 'Control icons on the right side of mobile header', 'dimas' ),
				'transport'   => 'postMessage',
				'default'     => array( array( 'item' => 'search' ), array( 'item' => 'cart' ) ),
				'row_label'   => array(
					'type'  => 'field',
					'value' => esc_attr__( 'Item', 'dimas' ),
					'field' => 'item',
				),
				'fields'      => array(
					'item' => array(
						'type'    => 'select',
						// 'choices' => $this->mobile_header_icons_option(),
					),
				),
			),

				// Page
				'mobile_page_header_hr'             => array(
					'type'    => 'custom',
					'section' => 'mobile_page',
					'default' => '<hr/><h2>' . esc_html__( 'Page Header', 'dimas' ) . '</h2>',
				),
				'mobile_page_header'                => array(
					'type'        => 'toggle',
					'default'     => 1,
					'label'       => esc_html__( 'Enable Page Header', 'dimas' ),
					'section'     => 'mobile_page',
					'description' => esc_html__( 'Enable to show a page header for the page below the site header', 'dimas' ),
				),
				'mobile_page_header_els'            => array(
					'type'            => 'multicheck',
					'label'           => esc_html__( 'Page Header Elements', 'dimas' ),
					'section'         => 'mobile_page',
					'default'         => array( 'breadcrumb', 'title' ),
					'priority'        => 10,
					'choices'         => array(
						'breadcrumb' => esc_html__( 'BreadCrumb', 'dimas' ),
						'title'      => esc_html__( 'Title', 'dimas' ),
					),
					'description'     => esc_html__( 'Select which elements you want to show.', 'dimas' ),
					'active_callback' => array(
						array(
							'setting'  => 'mobile_page_header',
							'operator' => '==',
							'value'    => 1,
						),
					),
				),

				// Blog
				'mobile_blog_page_header_hr'        => array(
					'type'    => 'custom',
					'section' => 'mobile_blog',
					'default' => '<hr/><h2>' . esc_html__( 'Page Header', 'dimas' ) . '</h2>',
				),
				'mobile_blog_page_header'           => array(
					'type'        => 'toggle',
					'default'     => 1,
					'label'       => esc_html__( 'Enable Page Header', 'dimas' ),
					'section'     => 'mobile_blog',
					'description' => esc_html__( 'Enable to show a page header for the page below the site header', 'dimas' ),
				),
				'mobile_blog_page_header_els'       => array(
					'type'            => 'multicheck',
					'label'           => esc_html__( 'Page Header Elements', 'dimas' ),
					'section'         => 'mobile_blog',
					'default'         => array( 'breadcrumb', 'title' ),
					'priority'        => 10,
					'choices'         => array(
						'breadcrumb' => esc_html__( 'BreadCrumb', 'dimas' ),
						'title'      => esc_html__( 'Title', 'dimas' ),
					),
					'description'     => esc_html__( 'Select which elements you want to show.', 'dimas' ),
					'active_callback' => array(
						array(
							'setting'  => 'mobile_page_header',
							'operator' => '==',
							'value'    => 1,
						),
					),
				),

				// Single Post
				'mobile_single_post_breadcrumb'    => array(
					'type'    => 'toggle',
					'default' => 1,
					'label'   => esc_html__( 'Enable breadcrumb', 'dimas' ),
					'section' => 'mobile_single_blog',
				),

				// Mobile Footer
				'mobile_footer_newsletter'          => array(
					'type'        => 'toggle',
					'label'       => esc_html__( 'Footer Newsletter', 'dimas' ),
					'description' => esc_html__( 'Display footer newsletter on mobile', 'dimas' ),
					'default'     => true,
					'section'     => 'mobile_footer',
				),
				'mobile_footer_newsletter_padding_top' => array(
					'type'      => 'slider',
					'label'     => esc_html__('Padding Top', 'dimas'),
					'transport' => 'postMessage',
					'section'   => 'mobile_footer',
					'default'   => 30,
					'choices'   => array(
						'min' => 0,
						'max' => 500,
					),
					'js_vars'         => array(
						array(
							'element'  => '.site-footer .footer-newsletter',
							'property' => '--rz-footer-newsletter-top-spacing',
							'units'    => 'px',
						),
					),
					'active_callback' => array(
						array(
							'setting'  => 'mobile_footer_newsletter',
							'operator' => '==',
							'value'    => '1',
						),
					),
				),
				'mobile_footer_newsletter_padding_bottom' => array(
					'type'      => 'slider',
					'label'     => esc_html__('Padding Bottom', 'dimas'),
					'transport' => 'postMessage',
					'section'   => 'mobile_footer',
					'default'   => 40,
					'choices'   => array(
						'min' => 0,
						'max' => 500,
					),
					'js_vars'         => array(
						array(
							'element'  => '.site-footer .footer-newsletter',
							'property' => '--rz-footer-newsletter-bottom-spacing',
							'units'    => 'px',
						),
					),
					'active_callback' => array(
						array(
							'setting'  => 'mobile_footer_newsletter',
							'operator' => '==',
							'value'    => '1',
						),
					),
				),

				'mobile_footer_custom_field_1' => array(
					'type'            => 'custom',
					'section'         => 'mobile_footer',
					'default' 		  => '<hr/>',
				),

				'mobile_footer_widget'              => array(
					'type'        => 'toggle',
					'label'       => esc_html__( 'Footer Widget', 'dimas' ),
					'description' => esc_html__( 'Display footer widget on mobile', 'dimas' ),
					'default'     => true,
					'section'     => 'mobile_footer',
				),
				'mobile_footer_widget_padding_top' => array(
					'type'      => 'slider',
					'label'     => esc_html__('Padding Top', 'dimas'),
					'transport' => 'postMessage',
					'section'   => 'mobile_footer',
					'default'   => 30,
					'choices'   => array(
						'min' => 0,
						'max' => 500,
					),
					'js_vars'         => array(
						array(
							'element'  => '.site-footer .footer-widgets',
							'property' => '--rz-footer-widget-top-spacing',
							'units'    => 'px',
						),
					),
					'active_callback' => array(
						array(
							'setting'  => 'mobile_footer_widget',
							'operator' => '==',
							'value'    => '1',
						),
					),
				),
				'mobile_footer_widget_padding_bottom' => array(
					'type'      => 'slider',
					'label'     => esc_html__('Padding Bottom', 'dimas'),
					'transport' => 'postMessage',
					'section'   => 'mobile_footer',
					'default'   => 40,
					'choices'   => array(
						'min' => 0,
						'max' => 500,
					),
					'js_vars'         => array(
						array(
							'element'  => '.site-footer .footer-widgets',
							'property' => '--rz-footer-widget-bottom-spacing',
							'units'    => 'px',
						),
					),
					'active_callback' => array(
						array(
							'setting'  => 'mobile_footer_widget',
							'operator' => '==',
							'value'    => '1',
						),
					),
				),

				'mobile_footer_custom_field_2' => array(
					'type'            => 'custom',
					'section'         => 'mobile_footer',
					'default' 		  => '<hr/>',
				),

				'mobile_footer_main'                => array(
					'type'        => 'toggle',
					'label'       => esc_html__( 'Footer Main', 'dimas' ),
					'description' => esc_html__( 'Display footer main on mobile', 'dimas' ),
					'default'     => true,
					'section'     => 'mobile_footer',
				),
				'mobile_footer_main_padding_top' => array(
					'type'      => 'slider',
					'label'     => esc_html__('Padding Top', 'dimas'),
					'transport' => 'postMessage',
					'section'   => 'mobile_footer',
					'default'   => 30,
					'choices'   => array(
						'min' => 0,
						'max' => 500,
					),
					'js_vars'         => array(
						array(
							'element'  => '.site-footer .footer-main',
							'property' => '--rz-footer-main-top-spacing',
							'units'    => 'px',
						),
					),
					'active_callback' => array(
						array(
							'setting'  => 'mobile_footer_main',
							'operator' => '==',
							'value'    => '1',
						),
					),
				),
				'mobile_footer_main_padding_bottom' => array(
					'type'      => 'slider',
					'label'     => esc_html__('Padding Bottom', 'dimas'),
					'transport' => 'postMessage',
					'section'   => 'mobile_footer',
					'default'   => 40,
					'choices'   => array(
						'min' => 0,
						'max' => 500,
					),
					'js_vars'         => array(
						array(
							'element'  => '.site-footer .footer-main',
							'property' => '--rz-footer-main-bottom-spacing',
							'units'    => 'px',
						),
					),
					'active_callback' => array(
						array(
							'setting'  => 'mobile_footer_main',
							'operator' => '==',
							'value'    => '1',
						),
					),
				),

				'mobile_footer_custom_field_3' => array(
					'type'            => 'custom',
					'section'         => 'mobile_footer',
					'default' 		  => '<hr/>',
				),

				'mobile_footer_extra'               => array(
					'type'        => 'toggle',
					'label'       => esc_html__( 'Footer Extra', 'dimas' ),
					'description' => esc_html__( 'Display footer extra on mobile', 'dimas' ),
					'default'     => true,
					'section'     => 'mobile_footer',
				),
				'mobile_footer_extra_padding_top' => array(
					'type'      => 'slider',
					'label'     => esc_html__('Padding Top', 'dimas'),
					'transport' => 'postMessage',
					'section'   => 'mobile_footer',
					'default'   => 30,
					'choices'   => array(
						'min' => 0,
						'max' => 500,
					),
					'js_vars'         => array(
						array(
							'element'  => '.site-footer .footer-extra',
							'property' => '--rz-footer-extra-top-spacing',
							'units'    => 'px',
						),
					),
					'active_callback' => array(
						array(
							'setting'  => 'mobile_footer_extra',
							'operator' => '==',
							'value'    => '1',
						),
					),
				),
				'mobile_footer_extra_padding_bottom' => array(
					'type'      => 'slider',
					'label'     => esc_html__('Padding Bottom', 'dimas'),
					'transport' => 'postMessage',
					'section'   => 'mobile_footer',
					'default'   => 40,
					'choices'   => array(
						'min' => 0,
						'max' => 500,
					),
					'js_vars'         => array(
						array(
							'element'  => '.site-footer .footer-extra',
							'property' => '--rz-footer-extra-bottom-spacing',
							'units'    => 'px',
						),
					),
					'active_callback' => array(
						array(
							'setting'  => 'mobile_footer_extra',
							'operator' => '==',
							'value'    => '1',
						),
					),
				),

				// Mobile Logo
				'mobile_menu_left'                  => array(
					'type'        => 'toggle',
					'label'       => esc_html__( 'Show Menu Left', 'dimas' ),
					'section'     => 'mobile_header',
					'default'     => true,
				),
				'mobile_header_history_back'            => array(
					'type'    => 'toggle',
					'label'   => esc_html__( 'Back to history', 'dimas' ),
					'section' => 'mobile_header',
					'description' => esc_html__( 'Show back icon in the inner pages', 'dimas' ),
					'default' => 0,
				),
				'mobile_logo_custom_field_20'        => array(
					'type'    => 'custom',
					'section' => 'mobile_header',
					'default' => '<hr/>',
				),
				'mobile_custom_logo'                => array(
					'type'        => 'toggle',
					'label'       => esc_html__( 'Mobile Logo', 'dimas' ),
					'section'     => 'mobile_header',
					'description' => esc_html__( 'Use a different logo on mobile', 'dimas' ),
					'default'     => false,
				),
				'mobile_logo'                       => array(
					'type'            => 'image',
					'section'         => 'mobile_header',
					'active_callback' => array(
						array(
							'setting'  => 'mobile_custom_logo',
							'operator' => '==',
							'value'    => true,
						),
					),
				),
				'mobile_logo_light'                       => array(
					'label'           => esc_html__( 'Logo Light', 'dimas' ),
					'type'            => 'image',
					'section'         => 'mobile_header',
					'active_callback' => array(
						array(
							'setting'  => 'mobile_custom_logo',
							'operator' => '==',
							'value'    => true,
						),
					),
				),
				'mobile_logo_dimension'                            => array(
					'type'    => 'dimensions',
					'label'   => esc_html__('Logo Dimension', 'dimas'),
					'default' => array(
						'width'  => '',
						'height' => '',
					),
					'section'         => 'mobile_header',
					'active_callback' => array(
						array(
							'setting'  => 'mobile_custom_logo',
							'operator' => '==',
							'value'    => true,
						),
					),
				),
				'mobile_logo_custom_field_2'        => array(
					'type'    => 'custom',
					'section' => 'mobile_header',
					'default' => '<hr/>',
				),
				// Mobile Menu
				'mobile_menu_custom_field_1'        => array(
					'type'    => 'custom',
					'section' => 'mobile_header',
					'default' => '<h2>' . esc_html__( 'Header Menu Panel', 'dimas' ) . '</h2>',
				),
				'mobile_menu_click_item'            => array(
					'type'    => 'select',
					'label'   => esc_html__( 'Show Sub-Menus', 'dimas' ),
					'section' => 'mobile_header',
					'default' => 'click-item',
					'choices' => array(
						'click-item' => esc_html__( 'Click to item', 'dimas' ),
						'click-icon' => esc_html__( 'Click to icon', 'dimas' ),
					),
				),
				'mobile_menu_show_socials'          => array(
					'type'    => 'toggle',
					'label'   => esc_html__( 'Show Socials', 'dimas' ),
					'default' => '0',
					'section' => 'mobile_header',
				),
				'mobile_menu_show_copyright'        => array(
					'type'    => 'toggle',
					'label'   => esc_html__( 'Show Copyright', 'dimas' ),
					'default' => '0',
					'section' => 'mobile_header',
				),
				'mobile_campaign_bar'            => array(
					'type'    => 'toggle',
					'label'   => esc_html__( 'Campaign Bar', 'dimas' ),
					'section' => 'mobile_header_campaign',
					'default' => false,
				),
				'mobile_newsletter_popup'        => array(
					'type'    => 'toggle',
					'label'   => esc_html__( 'Newsletter_Popup', 'dimas' ),
					'section' => 'mobile_newsletter_popup',
					'default' => true,
				),
				// Panel
				'mobile_panel_custom_logo'                => array(
					'type'        => 'toggle',
					'label'       => esc_html__( 'Custom Logo', 'dimas' ),
					'section'     => 'mobile_panel',
					'description' => esc_html__( 'Use a different logo on mobile panel', 'dimas' ),
					'default'     => false,
				),
				'mobile_panel_logo'                       => array(
					'type'            => 'image',
					'section'         => 'mobile_panel',
					'active_callback' => array(
						array(
							'setting'  => 'mobile_panel_custom_logo',
							'operator' => '==',
							'value'    => true,
						),
					),
				),
				'mobile_panel_logo_dimension'                            => array(
					'type'    => 'dimensions',
					'label'   => esc_html__('Logo Dimension', 'dimas'),
					'default' => array(
						'width'  => '',
						'height' => '',
					),
					'section'         => 'mobile_panel',
					'active_callback' => array(
						array(
							'setting'  => 'mobile_panel_custom_logo',
							'operator' => '==',
							'value'    => true,
						),
					),
				),
				// Catalog
				'mobile_catalog_product_loop_hr' => array(
					'type'            => 'custom',
					'section'         => 'mobile_product_catalog',
					'default'         => '<hr/><h2>' . esc_html__( 'Product Loop', 'dimas' ) . '</h2>',
					'active_callback' => array(
						array(
							'setting'  => 'product_loop_layout',
							'operator' => 'in',
							'value'    => array( '1', '2', '3', '4', '6', '7', '8', '9' ),
						),
					),
				),
				'mobile_product_featured_icons'  => array(
					'type'            => 'toggle',
					'label'           => esc_html__( 'Always Show Featured Icons', 'dimas' ),
					'default'         => '0',
					'section'         => 'mobile_product_catalog',
					'active_callback' => array(
						array(
							'setting'  => 'product_loop_layout',
							'operator' => 'in',
							'value'    => array( '1', '2', '3', '4', '6', '7', '8', '9' ),
						),
					),
				),
				'mobile_product_loop_atc'        => array(
					'type'            => 'toggle',
					'label'           => esc_html__( 'Show Add To Cart Button', 'dimas' ),
					'default'         => '0',
					'section'         => 'mobile_product_catalog',
					'active_callback' => array(
						array(
							'setting'  => 'product_loop_layout',
							'operator' => 'in',
							'value'    => array( '1', '2', '4', '7' ),
						),
					),
				),

				'shop_products_hr_4' => array(
					'type'    => 'custom',
					'default' => '<hr/><h2>' . esc_html__( 'Product Columns', 'dimas' ) . '</h2>',
					'section' => 'mobile_product_catalog',
				),

				'mobile_landscape_product_columns'     => array(
					'label'   => esc_html__( 'Mobile Landscape(767px)', 'dimas' ),
					'section' => 'mobile_product_catalog',
					'type'    => 'select',
					'default' => '3',
					'choices' => array(
						'1' => esc_attr__( '1 Column', 'dimas' ),
						'2' => esc_attr__( '2 Columns', 'dimas' ),
						'3' => esc_attr__( '3 Columns', 'dimas' ),
					),
				),
				'mobile_portrait_product_columns'      => array(
					'label'   => esc_html__( 'Mobile Portrait(479px)', 'dimas' ),
					'section' => 'mobile_product_catalog',
					'type'    => 'select',
					'default' => '2',
					'choices' => array(
						'1' => esc_attr__( '1 Column', 'dimas' ),
						'2' => esc_attr__( '2 Columns', 'dimas' ),
						'3' => esc_attr__( '3 Columns', 'dimas' ),
					),
				),
				'mobile_catalog_page_header_hr'        => array(
					'type'    => 'custom',
					'section' => 'mobile_product_catalog',
					'default' => '<hr/><h2>' . esc_html__( 'Page Header', 'dimas' ) . '</h2>',
				),
				'mobile_catalog_page_header'           => array(
					'type'        => 'toggle',
					'default'     => 1,
					'label'       => esc_html__( 'Enable Page Header', 'dimas' ),
					'section'     => 'mobile_product_catalog',
					'description' => esc_html__( 'Enable to show a page header for the shop page below the site header', 'dimas' ),
				),
				'mobile_catalog_page_header_els'       => array(
					'type'            => 'multicheck',
					'label'           => esc_html__( 'Page Header Elements', 'dimas' ),
					'section'         => 'mobile_product_catalog',
					'default'         => array( 'breadcrumb', 'title' ),
					'priority'        => 10,
					'choices'         => array(
						'breadcrumb' => esc_html__( 'BreadCrumb', 'dimas' ),
						'title'      => esc_html__( 'Title', 'dimas' ),
					),
					'description'     => esc_html__( 'Select which elements you want to show.', 'dimas' ),
					'active_callback' => array(
						array(
							'setting'  => 'mobile_catalog_page_header',
							'operator' => '==',
							'value'    => 1,
						),
					),
				),
				'shop_products_hr_5' => array(
					'type'    => 'custom',
					'default' => '<hr/><h2>' . esc_html__( 'Catalog Toolbar', 'dimas' ) . '</h2>',
					'section' => 'mobile_product_catalog',
					'active_callback' => array(
						array(
							'setting'  => 'mobile_navigation_bar',
							'operator' => 'in',
							'value'    => array( 'none', 'standard', 'simple' ),
						),
					),
				),
				'mobile_filter_label'    => array(
					'type'            => 'text',
					'label'           => esc_html__( 'Filter Label', 'dimas' ),
					'section'         => 'mobile_product_catalog',
					'active_callback' => array(
						array(
							'setting'  => 'mobile_navigation_bar',
							'operator' => 'in',
							'value'    => array( 'none', 'standard', 'simple' ),
						),
					),
				),
				// Single Product
				'mobile_single_product_breadcrumb'    => array(
					'type'        => 'toggle',
					'default'     => 1,
					'label'       => esc_html__( 'Enable Breadcrumb', 'dimas' ),
					'section'     => 'mobile_single_product',
					'description' => esc_html__( 'Enable to show a page header for the single product page below the site header', 'dimas' ),
				),
				'mobile_product_tabs_status'           => array(
					'type'    => 'select',
					'label'   => esc_html__( 'Product Tabs Status', 'dimas' ),
					'default' => 'close',
					'section' => 'mobile_single_product',
					'choices' => array(
						'close' => esc_html__( 'Close all tabs', 'dimas' ),
						'first' => esc_html__( 'Open first tab', 'dimas' ),
					),
				),

				'mobile_version'                        => array(
					'type'    => 'toggle',
					'label'   => esc_html__( 'Mobile Version', 'dimas' ),
					'section' => 'mobile_version',
					'default' => 'yes',
				),
				'mobile_version_custom_1'               => array(
					'type'    => 'custom',
					'section' => 'mobile_version',
					'default' => '<hr/>',
				),
				'custom_mobile_homepage'                       => array(
					'type'    => 'toggle',
					'label'   => esc_html__( 'Custom Homepage', 'dimas' ),
					'section' => 'mobile_version',
					'default' => 0,
				),
				'mobile_homepage_id'                       => array(
					'type'    => 'select',
					'label'   => esc_html__( 'Homepage', 'dimas' ),
					'section' => 'mobile_version',
					'default' => 'homepage-mobile',
					'choices' => class_exists( 'Kirki_Helper' ) && is_admin() ? \Kirki_Helper::get_posts( array(
						'posts_per_page' => - 1,
						'post_type'      => 'page',
					) ) : '',
					'active_callback' => array(
						array(
							'setting'  => 'custom_mobile_homepage',
							'operator' => '==',
							'value'    => 1,
						),
					),
				),
				'mobile_version_custom_2'               => array(
					'type'    => 'custom',
					'section' => 'mobile_version',
					'default' => '<hr/>',
				),
				'mobile_navigation_bar'                 => array(
					'type'    => 'select',
					'label'   => esc_html__( 'Navigation Bar', 'dimas' ),
					'section' => 'mobile_version',
					'default' => 'none',
					'choices' => array(
						'none'              => esc_html__( 'None', 'dimas' ),
						'simple'            => esc_html__( 'Simple', 'dimas' ),
						'simple_adoptive'   => esc_html__( 'Simple Adaptive', 'dimas' ),
						'standard'          => esc_html__( 'Standard', 'dimas' ),
						'standard_adoptive' => esc_html__( 'Standard Adaptive', 'dimas' ),
					),
				),
				'mobile_navigation_bar_items'           => array(
					'type'            => 'sortable',
					'label'           => esc_html__( 'Items', 'dimas' ),
					'section'         => 'mobile_version',
					'default'         => array( 'home', 'menu', 'search', 'account' ),
					// 'choices'         => $this->navigation_bar_items_option(),
					'active_callback' => array(
						array(
							'setting'  => 'mobile_navigation_bar',
							'operator' => 'in',
							'value'    => array( 'standard', 'standard_adoptive' ),
						),
					),

				),
				'mobile_navigation_bar_item'            => array(
					'type'            => 'select',
					'label'           => esc_html__( 'Item', 'dimas' ),
					'section'         => 'mobile_version',
					'default'         => 'menu',
					// 'choices'         => $this->navigation_bar_items_option(),
					'active_callback' => array(
						array(
							'setting'  => 'mobile_navigation_bar',
							'operator' => 'in',
							'value'    => array( 'simple', 'simple_adoptive' ),
						),
					),

				),
				'mobile_navigation_bar_item_align'      => array(
					'type'            => 'select',
					'label'           => esc_html__( 'Align Item', 'dimas' ),
					'section'         => 'mobile_version',
					'default'         => 'right',
					'choices'         => array(
						'left'   => esc_html__( 'Left', 'dimas' ),
						'right'  => esc_html__( 'Right', 'dimas' ),
						'center' => esc_html__( 'Center', 'dimas' ),
					),
					'active_callback' => array(
						array(
							'setting'  => 'mobile_navigation_bar',
							'operator' => 'in',
							'value'    => array( 'simple', 'simple_adoptive' ),
						),
					),
				),
				'mobile_navigation_bar_menu_item'       => array(
					'type'            => 'select',
					'label'           => esc_html__( 'Menu', 'dimas' ),
					'section'         => 'mobile_version',
					'default'         => '',
					// 'choices'         => $this->get_navigation_bar_get_menus(),

				),
				'mobile_navigation_bar_menu_side_type'  => array(
					'type'    => 'select',
					'label'   => esc_html__( 'Show Menu', 'dimas' ),
					'section' => 'mobile_version',
					'default' => 'side-left',
					'choices' => array(
						'side-left'  => esc_html__( 'Side to right', 'dimas' ),
						'side-right' => esc_html__( 'Side to left', 'dimas' ),
					),
				),
				'mobile_navigation_bar_menu_click_item' => array(
					'type'    => 'select',
					'label'   => esc_html__( 'Show Sub-Menus', 'dimas' ),
					'section' => 'mobile_version',
					'default' => 'click-item',
					'choices' => array(
						'click-item' => esc_html__( 'Click to item', 'dimas' ),
						'click-icon' => esc_html__( 'Click to icon', 'dimas' ),
					),
				),
				'mobile_floating_action_button' => array(
					'type'    => 'toggle',
					'label'   => esc_html__( 'Floating Action Button', 'dimas' ),
					'section' => 'mobile_version',
					'default' => 0,
					'active_callback' => array(
						array(
							'setting'  => 'mobile_navigation_bar',
							'operator' => 'in',
							'value'    => array( 'standard_adoptive', 'simple_adoptive' ),
						),
					),
				),
		);
		

		return $fields;
	}

	

}
