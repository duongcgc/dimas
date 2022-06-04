<?php

namespace Dimas\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Dimas\Addons\Elementor\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon Box widget
 */
class Products_Tab_Carousel extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'dimas-product-tab';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Dimas - Product Tabs Carousel', 'dimas' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-tabs';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'dimas' ];
	}

	public function get_script_depends() {
		return [
			'dimas-product-shortcode'
		];
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
	protected function _register_controls() {
		$this->section_content();
		$this->section_style();
	}

	// Tab Content
	protected function section_content() {
		$this->section_products_settings_controls();
		$this->section_carousel_settings_controls();
	}

	// Tab Style
	protected function section_style() {
		$this->section_tab_header_style_controls();
		$this->section_carousel_style_controls();
		$this->section_button_style_controls();
	}

	protected function section_products_settings_controls() {
		$this->start_controls_section(
			'section_products',
			[ 'label' => esc_html__( 'Products', 'dimas' ) ]
		);

		$this->add_control(
			'per_page',
			[
				'label'   => esc_html__( 'Total Products', 'dimas' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 8,
				'min'     => 1,
				'max'     => 50,
				'step'    => 1,
			]
		);

		$this->add_control(
			'product_tabs_source',
			[
				'label'   => esc_html__( 'Source', 'dimas' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'special_products' => esc_html__( 'Special Products', 'dimas' ),
					'product_cats'     => esc_html__( 'Product Categories', 'dimas' ),
				],
				'default' => 'special_products',
				'toggle'  => false,
				'separator' => 'before',
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'title', [
				'label'       => esc_html__( 'Title', 'dimas' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'This is heading', 'dimas' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'tab_products',
			[
				'label'   => esc_html__( 'Products', 'dimas' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'recent'       => esc_html__( 'Recent', 'dimas' ),
					'featured'     => esc_html__( 'Featured', 'dimas' ),
					'best_selling' => esc_html__( 'Best Selling', 'dimas' ),
					'top_rated'    => esc_html__( 'Top Rated', 'dimas' ),
					'sale'         => esc_html__( 'On Sale', 'dimas' ),
				],
				'default' => 'recent',
				'toggle'  => false,
			]
		);

		$repeater->add_control(
			'tab_orderby',
			[
				'label'     => esc_html__( 'Order By', 'dimas' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''           => esc_html__( 'Default', 'dimas' ),
					'date'       => esc_html__( 'Date', 'dimas' ),
					'title'      => esc_html__( 'Title', 'dimas' ),
					'menu_order' => esc_html__( 'Menu Order', 'dimas' ),
					'rand'       => esc_html__( 'Random', 'dimas' ),
				],
				'default'   => '',
				'toggle'    => false,
				'condition' => [
					'tab_products' => [ 'recent', 'top_rated', 'sale', 'featured' ],
				],
			]
		);

		$repeater->add_control(
			'tab_order',
			[
				'label'     => esc_html__( 'Order', 'dimas' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''     => esc_html__( 'Default', 'dimas' ),
					'asc'  => esc_html__( 'Ascending', 'dimas' ),
					'desc' => esc_html__( 'Descending', 'dimas' ),
				],
				'default'   => '',
				'toggle'    => false,
				'condition' => [
					'tab_products' => [ 'recent', 'top_rated', 'sale', 'featured' ],
				],
			]
		);

		$repeater->add_control(
			'tab_button_text',
			[
				'label'       => esc_html__( 'Button Text', 'dimas' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
			]
		);

		$repeater->add_control(
			'tab_button_link', [
				'label'         => esc_html__( 'Button Link', 'dimas' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'dimas' ),
				'show_external' => true,
				'default'       => [
					'url'         => '#',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);

		$this->add_control(
			'special_products_tabs',
			[
				'label'         => '',
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'default'       => [
					[
						'title'        => esc_html__( 'New Arrivals', 'dimas' ),
						'tab_products' => 'recent',
						'tab_button_text' => ''
					],
					[
						'title'        => esc_html__( 'Features', 'dimas' ),
						'tab_products' => 'featured',
						'tab_button_text' => ''
					],
					[
						'title'        => esc_html__( 'Top Rated', 'dimas' ),
						'tab_products' => 'top_rated',
						'tab_button_text' => ''
					]
				],
				'title_field'   => '{{{ title }}}',
				'prevent_empty' => false,
				'condition'     => [
					'product_tabs_source' => 'special_products',
				],
			]
		);

		$this->add_control(
			'view_all_cats',
			[
				'label'        => esc_html__( 'View All Categories', 'dimas' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'dimas' ),
				'label_off'    => esc_html__( 'Hide', 'dimas' ),
				'return_value' => 'yes',
				'default'      => '',
				'condition' => [
					'product_tabs_source' => 'product_cats',
				],
			]
		);

		$this->add_control(
			'view_all_cats_text',
			[
				'label'       => esc_html__( 'View All Text', 'dimas' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'All', 'dimas' ),
				'condition' => [
					'product_tabs_source' => 'product_cats',
					'view_all_cats' => 'yes',
				],
			]
		);

		$product_cats = Helper::taxonomy_list();
		$repeater     = new \Elementor\Repeater();

		$repeater->add_control(
			'product_cat', [
				'label'       => esc_html__( 'Category Tab', 'dimas' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => $product_cats,
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'product_cat_btn_text',
			[
				'label'       => esc_html__( 'Button Text', 'dimas' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
			]
		);

		$this->add_control(
			'product_cats_tabs',
			[
				'label'         => esc_html__( 'Category Tabs', 'dimas' ),
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'default'       => [ ],
				'prevent_empty' => false,
				'condition'     => [
					'product_tabs_source' => 'product_cats',
				],
				'title_field'   => '{{{ product_cat }}}',
			]
		);

		$this->add_control(
			'category',
			[
				'label'       => esc_html__( 'Products Category', 'dimas' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'dimas' ),
				'type'        => 'rzautocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'product_cat',
				'sortable'    => true,
				'condition'   => [
					'product_tabs_source' => 'special_products',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'product_tags',
			[
				'label'       => esc_html__( 'Products Tags', 'dimas' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'dimas' ),
				'type'        => 'rzautocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'product_tag',
				'sortable'    => true,
				'condition'   => [
					'product_tabs_source' => 'special_products',
				],
			]
		);

		$this->add_control(
			'product_brands',
			[
				'label'       => esc_html__( 'Products Brands', 'dimas' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'dimas' ),
				'type'        => 'rzautocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'product_brand',
				'sortable'    => true,
				'condition'   => [
					'product_tabs_source' => 'special_products',
				],
			]
		);

		if ( taxonomy_exists( 'product_author' ) ) {
			$this->add_control(
				'product_authors',
				[
					'label'       => esc_html__( 'Products Authors', 'dimas' ),
					'placeholder' => esc_html__( 'Click here and start typing...', 'dimas' ),
					'type'        => 'rzautocomplete',
					'default'     => '',
					'label_block' => true,
					'multiple'    => true,
					'source'      => 'product_author',
					'sortable'    => true,
					'condition'   => [
						'product_tabs_source' => 'special_products',
					],
				]
			);
		}

		$this->add_control(
			'products',
			[
				'label'     => esc_html__( 'Product', 'dimas' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'recent'       => esc_html__( 'Recent', 'dimas' ),
					'featured'     => esc_html__( 'Featured', 'dimas' ),
					'best_selling' => esc_html__( 'Best Selling', 'dimas' ),
					'top_rated'    => esc_html__( 'Top Rated', 'dimas' ),
					'sale'         => esc_html__( 'On Sale', 'dimas' ),
				],
				'default'   => 'recent',
				'toggle'    => false,
				'condition' => [
					'product_tabs_source' => 'product_cats',
				],
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'     => esc_html__( 'Order By', 'dimas' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''           => esc_html__( 'Default', 'dimas' ),
					'date'       => esc_html__( 'Date', 'dimas' ),
					'title'      => esc_html__( 'Title', 'dimas' ),
					'menu_order' => esc_html__( 'Menu Order', 'dimas' ),
					'rand'       => esc_html__( 'Random', 'dimas' ),
				],
				'default'   => '',
				'condition' => [
					'products'            => [ 'recent', 'top_rated', 'sale', 'featured' ],
					'product_tabs_source' => 'product_cats',
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label'     => esc_html__( 'Order', 'dimas' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''     => esc_html__( 'Default', 'dimas' ),
					'asc'  => esc_html__( 'Ascending', 'dimas' ),
					'desc' => esc_html__( 'Descending', 'dimas' ),
				],
				'default'   => '',
				'condition' => [
					'products'            => [ 'recent', 'top_rated', 'sale', 'featured' ],
					'product_tabs_source' => 'product_cats',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function section_carousel_settings_controls() {
		$this->start_controls_section(
			'section_carousel_settings',
			[ 'label' => esc_html__( 'Carousel Settings', 'dimas' ) ]
		);

		$this->add_responsive_control(
			'slidesToShow',
			[
				'label'           => esc_html__( 'Slides to show', 'dimas' ),
				'type'            => Controls_Manager::NUMBER,
				'min'             => 1,
				'max'             => 7,
				'default' 		  => 4,
				'frontend_available' => true,
			]
		);
		$this->add_responsive_control(
			'slidesToScroll',
			[
				'label'           => esc_html__( 'Slides to scroll', 'dimas' ),
				'type'            => Controls_Manager::NUMBER,
				'min'             => 1,
				'max'             => 7,
				'default' 		  => 4,
				'frontend_available' => true,
			]
		);
		$this->add_responsive_control(
			'navigation',
			[
				'label'     => esc_html__( 'Navigation', 'dimas' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'none'     => esc_html__( 'None', 'dimas' ),
					'scrollbar'  => esc_html__( 'Scrollbar', 'dimas' ),
					'dots' => esc_html__( 'Dots', 'dimas' ),
				],
				'default'   => 'scrollbar',
				'frontend_available' => true,
			]
		);
		$this->add_control(
			'infinite',
			[
				'label'     => __( 'Infinite Loop', 'dimas' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'dimas' ),
				'label_on'  => __( 'On', 'dimas' ),
				'default'   => '',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'     => __( 'Autoplay', 'dimas' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'dimas' ),
				'label_on'  => __( 'On', 'dimas' ),
				'default'   => '',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'speed',
			[
				'label'       => __( 'Speed', 'dimas' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 800,
				'min'         => 100,
				'step'        => 50,
				'description' => esc_html__( 'Slide animation speed (in ms)', 'dimas' ),
				'frontend_available' => true,
			]
		);

		$this->end_controls_section();
	}

	protected function section_tab_header_style_controls() {
		$this->start_controls_section(
			'section_tab_header_style',
			[
				'label' => esc_html__( 'Tab Header', 'dimas' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'tab_header_space',
			[
				'label'     => __( 'Space', 'dimas' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 150,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimas-products-tabs .tabs-header' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tab_header_space_left',
			[
				'label'     => __( 'Space Left', 'dimas' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 150,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimas-products-tabs .tabs-header' => 'padding-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tab_header_item_space',
			[
				'label'     => __( 'Item Space', 'dimas' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 150,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimas-products-tabs ul.tabs li:not(:first-child)' => 'padding-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .dimas-products-tabs ul.tabs li:not(:last-child)' => 'padding-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tab_header_align',
			[
				'label'       => esc_html__( 'Align', 'dimas' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'flex-start'   => [
						'title' => esc_html__( 'Left', 'dimas' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'dimas' ),
						'icon'  => 'eicon-text-align-center',
					],
					'flex-end'  => [
						'title' => esc_html__( 'Right', 'dimas' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'selectors'   => [
					'{{WRAPPER}} .dimas-products-tabs ul.tabs' => 'justify-content: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'tab_header_divider',
			[
				'label' => '',
				'type'  => Controls_Manager::DIVIDER,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'tab_header_title',
				'selector' => '{{WRAPPER}} .dimas-products-tabs ul.tabs li a',
			]
		);
		$this->add_control(
			'tab_header_title_color',
			[
				'label'     => esc_html__( 'Text Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-products-tabs ul.tabs li a' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'tab_header_active_color',
			[
				'label'     => esc_html__( 'Active Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-products-tabs ul.tabs li a.active' => 'color: {{VALUE}};',
					'{{WRAPPER}} .dimas-products-tabs ul.tabs li a:after' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function section_carousel_style_controls() {
		// Carousel Settings
		$this->start_controls_section(
			'section_carousel_style',
			[
				'label' => esc_html__( 'Carousel Settings', 'dimas' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'carousel_style_divider',
			[
				'label' => __( 'Scrollbar', 'dimas' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'scrollbar_spacing',
			[
				'label'     => __( 'Spacing', 'dimas' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 150,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimas-products-tabs .swiper-scrollbar' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'scrollbar_color',
			[
				'label'     => esc_html__( 'Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-products-tabs .swiper-scrollbar' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'scrollbar_active_color',
			[
				'label'     => esc_html__( 'Active Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-products-tabs .swiper-scrollbar-drag' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'carousel_style_divider_2',
			[
				'label' => __( 'Dots', 'dimas' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'dots_font_size',
			[
				'label'     => __( 'Size', 'dimas' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimas-products-tabs .swiper-pagination .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'dots_color',
			[
				'label'     => esc_html__( 'Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-products-tabs .swiper-pagination .swiper-pagination-bullet:before' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'dots_active_color',
			[
				'label'     => esc_html__( 'Active Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-products-tabs .swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active:before, {{WRAPPER}} .dimas-products-tabs .swiper-pagination .swiper-pagination-bullet:hover:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'dots_spacing_item',
			[
				'label'      => __( 'Item Space', 'dimas' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .dimas-products-tabs .swiper-container-horizontal > .swiper-pagination-bullets .swiper-pagination-bullet' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'dots_spacing',
			[
				'label'      => __( 'Space', 'dimas' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .dimas-products-tabs .swiper-pagination' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function section_button_style_controls() {
		// Button Tab Style
		$this->start_controls_section(
			'section_button_style',
			[
				'label' => esc_html__( 'Button', 'dimas' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'button_spacing',
			[
				'label'     => __( 'Spacing', 'dimas' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 150,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimas-products-tabs .tabs-panel .dimas-tabs-button' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_divider',
			[
				'label' => '',
				'type'  => Controls_Manager::DIVIDER,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_text',
				'selector' => '{{WRAPPER}} .dimas-products-tabs .tabs-panel .dimas-tabs-button a',
			]
		);
		$this->add_control(
			'button_color',
			[
				'label'     => esc_html__( 'Text Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-products-tabs .tabs-panel .dimas-tabs-button a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render icon box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$nav        = $settings['navigation'];
		$nav_tablet = empty( $settings['navigation_tablet'] ) ? $nav : $settings['navigation_tablet'];
		$nav_mobile = empty( $settings['navigation_mobile'] ) ? $nav : $settings['navigation_mobile'];

		$classes = [
			'dimas-products-tabs dimas-tabs dimas-elementor-product-carousel dimas-swiper-carousel-elementor woocommerce',
			'navigation-' . $nav,
			'navigation-tablet-' . $nav_tablet,
			'navigation-mobile-' . $nav_mobile,
		];

		$this->add_render_attribute( 'wrapper', 'class', $classes );

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php self::get_products_tab( $settings ); ?>
		</div>
		<?php
	}

	public static function get_products_tab( $settings ) {

		$output      = [ ];
		$header_tabs = [ ];
		$tab_content = [ ];

		$header_tabs[] = '<ul class="tabs-header tabs-nav tabs">';
		$i             = 0;
		if ( $settings['product_tabs_source'] == 'special_products' ) {
			$tabs = $settings['special_products_tabs'];

			if ( $tabs ) {
				foreach ( $tabs as $index => $item ) {
					$button_view = $class_active = '';

					if ( $i == 0 ) {
						$class_active = 'active';
					}

					if ( isset( $item['title'] ) ) {
						$header_tabs[] = sprintf( '<li><a href="#" data-href="%s" class="%s">%s</a></li>', esc_attr( $item['tab_products'] ), $class_active, esc_html( $item['title'] ) );
					}

					if ( $item['tab_button_text'] ) {
						$button_view = sprintf( '<div class="dimas-tabs-button">%s</div>', Helper::control_url( $index, $item['tab_button_link'], $item['tab_button_text'], [ 'class' => 'dimas-button--underlined' ] ) );
					}

					$tab_atts = [
						'products'     		=> $item['tab_products'],
						'orderby'      		=> ! empty( $item['tab_orderby'] ) ? $item['tab_orderby'] : '',
						'order'        		=> ! empty( $item['tab_order'] ) ? $item['tab_order'] : '',
						'category'    		=> $settings['category'],
						'tag'    			=> $settings['product_tags'],
						'product_brands'    => $settings['product_brands'],
						'per_page'    		=> $settings['per_page'],
						'paginate'			=> true,
					];

					if ( taxonomy_exists( 'product_author' ) ) {
						$tab_atts['product_authors'] = $settings['product_authors'];
					}

					$results = Helper::products_shortcode( $tab_atts );
					if ( ! $results ) {
						return;
					}

					$product_ids = $results['ids'];

					if ( $i == 0 ) {
						$tab_content[] = sprintf(
										'<div class="tabs-panel tabs-%s tab-loaded active" data-settings="%s">',
										esc_attr( $item['tab_products'] ),
										esc_attr( wp_json_encode( $tab_atts ) )
									);

						ob_start();
						Helper::get_template_loop( $product_ids );
						$tab_content[] = ob_get_clean();

						$tab_content[] = wp_kses_post( $button_view );

						$tab_content[] = '</div>';
					} else {
						$tab_content[] = sprintf(
							'<div class="tabs-panel tabs-%s" data-settings="%s">%s</div>',
							esc_attr( $item['tab_products'] ),
							esc_attr( wp_json_encode( $tab_atts ) ),
							wp_kses_post( $button_view )
						);
					}

					$i ++;
				}
			}
		} else {
			if ( $settings['view_all_cats'] ) {
				$header_tabs[] = sprintf( '<li><a href="#" data-href="all" class="active">%s</a></li>', $settings['view_all_cats_text'] );

				$tab_atts = [
					'products'     		=> $settings['products'],
					'orderby'      		=> $settings['orderby'],
					'order'        		=> $settings['order'],
					'category'    		=> '',
					'tag'    			=> $settings['product_tags'],
					'product_brands'    => $settings['product_brands'],
					'per_page'    		=> $settings['per_page'],
					'paginate'			=> true,
				];

				if ( taxonomy_exists( 'product_author' ) ) {
					$tab_atts['product_authors'] = $settings['product_authors'];
				}

				$results = Helper::products_shortcode( $tab_atts );
				if ( ! $results ) {
					return;
				}

				$product_ids = $results['ids'];

				$tab_content[] = sprintf(
					'<div class="tabs-panel tabs-all tab-loaded active" data-settings="%s">',
					esc_attr( wp_json_encode( $tab_atts ) )
				);

				ob_start();

				Helper::get_template_loop( $product_ids );

				$tab_content[] = ob_get_clean();

				$tab_content[] = '</div>';
			}

			$cats = $settings['product_cats_tabs'];
			if ( $cats ) {
				foreach ( $cats as $tab ) {
					$class_active = '';
					if ( $i == 0 && $settings['view_all_cats'] == '' ) {
						$class_active = 'active';
					}

					$term = get_term_by( 'slug', $tab['product_cat'], 'product_cat' );
					if ( ! is_wp_error( $term ) && $term ) {
						$header_tabs[] = sprintf( '<li><a href="#" data-href="%s" class="%s">%s</a></li>', esc_attr( $tab['product_cat'] ), esc_attr($class_active), esc_html( $term->name ) );
					}

					$tab_atts = array(
						'products'     => $settings['products'],
						'order'        => $settings['order'],
						'orderby'      => $settings['orderby'],
						'per_page'     => intval( $settings['per_page'] ),
						'category'    	=> $tab['product_cat'],
						'paginate'		=> true,
					);

					$results = Helper::products_shortcode( $tab_atts );
					if ( ! $results ) {
						return;
					}

					$product_ids = $results['ids'];

					$button_view = '';

					if ( $tab['product_cat_btn_text'] ) {
						$button_view = sprintf( '<div class="dimas-tabs-button"><a class="dimas-button--underlined" href="%s">%s</a></div>', get_category_link( $term->term_id ), esc_html( $tab['product_cat_btn_text'] ) );
					}

					if ( $i == 0 && $settings['view_all_cats'] == '' ) {
						$tab_content[] = sprintf(
							'<div class="tabs-panel tabs-%s tab-loaded active" data-settings="%s">',
							esc_attr( $tab['product_cat'] ),
							esc_attr( wp_json_encode( $tab_atts ) )
						);

						ob_start();

						if(isset($settings['columns'])) {
							wc_setup_loop(
								array(
									'columns'      => $settings['columns']
								)
							);
                        }

						Helper::get_template_loop( $product_ids );
						$tab_content[] = ob_get_clean();

						$tab_content[] = wp_kses_post( $button_view );

						$tab_content[] = '</div>';
					} else {
						$tab_content[] = sprintf(
							'<div class="tabs-panel tabs-%s" data-settings="%s">%s</div>',
							esc_attr( $tab['product_cat'] ),
							esc_attr( wp_json_encode( $tab_atts ) ),
							wp_kses_post( $button_view )
						);
					}

					$i ++;

				}
			}
		}

		$header_tabs[] = '</ul>';

		$output[] = sprintf( '%s<div class="tabs-content">%s</div>', implode( ' ', $header_tabs ), implode( ' ', $tab_content ) );

		echo implode( '', $output );
	}
}