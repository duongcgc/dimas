<?php

namespace Dimas\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Group_Control_Image_Size;
use Dimas\Addons\Elementor\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Product Banner widget
 */
class Product_Banner extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'dimas-product-banner';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Dimas - Product Banner', 'dimas' );
	}

	/**
	 * Retrieve the widget circle.
	 *
	 * @return string Widget circle.
	 */
	public function get_icon() {
		return 'eicon-banner';
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
			'dimas-elementor'
		];
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
	protected function register_controls() {
		$this->section_content();
		$this->section_style();
	}

	protected function section_content() {
		$this->start_controls_section(
			'section_content',
			[ 'label' => esc_html__( 'Product Banner', 'dimas' ) ]
		);

		$this->add_control(
			'image',
			[
				'label'   => esc_html__( 'Image', 'dimas' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://via.placeholder.com/300X399/cccccc?text=Image',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				'default'   => 'full',
				'separator' => 'none',
			]
		);

		$this->add_control(
			'title',
			[
				'label'   => esc_html__( 'Title', 'dimas' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'This is title', 'dimas' ),
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'   => esc_html__( 'Button Text', 'dimas' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Button Text', 'dimas' ),
			]
		);

		$this->add_control(
			'show_default_icon',
			[
				'label'        => esc_html__( 'Show Button Icon', 'dimas' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => __( 'Off', 'dimas' ),
				'label_on'     => __( 'On', 'dimas' ),
				'return_value' => 'yes',
				'default'      => 'yes'
			]
		);

		$this->add_control(
			'link', [
				'label'         => esc_html__( 'Button Link', 'dimas' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'dimas' ),
				'description'   => esc_html__( 'Just works if the value of Lightbox is No', 'dimas' ),
				'show_external' => true,
				'default'       => [
					'url'         => '#',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);

		$this->add_control(
			'regular_price',
			[
				'label'       => esc_html__( 'Regular Price', 'dimas' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your price', 'dimas' ),
				'label_block' => true,
				'default'     => __( '$99.00', 'dimas' ),
			]
		);

		$this->add_control(
			'sale_price',
			[
				'label'       => esc_html__( 'Sale Price', 'dimas' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your price', 'dimas' ),
				'label_block' => true,
				'default'     => __( '$59.00', 'dimas' ),
			]
		);


		$this->add_control(
			'badges',
			[
				'label'       => esc_html__( 'Badge Text', 'dimas' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your text', 'dimas' ),
				'label_block' => true,
				'default'     => __( 'Sale', 'dimas' ),
			]
		);

		$this->add_control(
			'link_type',
			[
				'label'     => esc_html__( 'Link Type', 'dimas' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'only' => esc_html__( 'Only button text', 'dimas' ),
					'all'  => esc_html__( 'All banner', 'dimas' ),
				],
				'default'   => 'all',
				'toggle'    => false,
				'separator' => 'before',
			]
		);

		$this->end_controls_section();
	}

	// Tab Style
	protected function section_style() {
		$this->section_style_img();
		$this->section_style_content();
		$this->section_style_price();
		$this->section_style_badge();
	}

	protected function section_style_img() {
		$this->start_controls_section(
			'section_style_img',
			[
				'label' => __( 'Image', 'dimas' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'image_max_width',
			[
				'label'      => esc_html__( 'Max Width', 'dimas' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range'      => [
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .dimas-product-banner .banner-image' => 'max-width: {{SIZE}}%',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function section_style_price() {
		$this->start_controls_section(
			'section_style_price',
			[
				'label' => __( 'Price', 'dimas' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'content_sale_padding',
			[
				'label'      => esc_html__( 'Padding', 'dimas' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => [],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .dimas-product-banner .banner-price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'sale_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dimas-product-banner .banner-price' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'sale_style_hr_1',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->start_controls_tabs( 'sale_price_tabs' );

		$this->start_controls_tab( 'sale_price_tab_normal', [ 'label' => esc_html__( 'Regular Price', 'dimas' ) ] );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'regular_typography',
				'selector' => '{{WRAPPER}} .dimas-product-banner .regular-price',
			]
		);

		$this->add_control(
			'regular_color',
			[
				'label'     => esc_html__( 'Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dimas-product-banner .regular-price' => 'color: {{VALUE}}',

				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'sale_price_tab', [ 'label' => esc_html__( 'Sale Price', 'dimas' ) ] );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'sale_price_typography',
				'selector' => '{{WRAPPER}} .dimas-product-banner .sale-price',
			]
		);

		$this->add_control(
			'sale_color',
			[
				'label'     => esc_html__( 'Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dimas-product-banner .sale-price' => 'color: {{VALUE}}',

				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function section_style_badge() {
		$this->start_controls_section(
			'section_style_badge',
			[
				'label' => __( 'Badge', 'dimas' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'content_badges_padding',
			[
				'label'      => esc_html__( 'Padding', 'dimas' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => [],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .dimas-product-banner .product-badges' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'badges_color',
			[
				'label'     => esc_html__( 'Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dimas-product-banner .product-badges' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_control(
			'sale_badges_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dimas-product-banner .product-badges' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'badges_typography',
				'selector' => '{{WRAPPER}} .dimas-product-banner .product-badges',
			]
		);

		$this->end_controls_section();
	}

	protected function section_style_content() {
		$this->start_controls_section(
			'section_content_style',
			[
				'label' => __( 'Content', 'dimas' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'content_position',
			[
				'label'        => esc_html__( 'Content Position', 'dimas' ),
				'type'         => Controls_Manager::SELECT,
				'options'      => [
					''       => esc_html__( 'Center', 'dimas' ),
					'bottom' => esc_html__( 'Bottom', 'dimas' ),
				],
				'default'      => '',
				'toggle'       => false,
				'prefix_class' => 'content-position%s-',
			]
		);

		$this->add_responsive_control(
			'content_spacing_bottom',
			[
				'label'      => esc_html__( 'Spacing Bottom', 'dimas' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .dimas-product-banner .banner-content' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'content_style_title',
			[
				'label'     => esc_html__( 'Title', 'dimas' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'dimas' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimas-product-banner .banner-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .dimas-product-banner .banner-title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => __( 'Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-product-banner .banner-title' => 'color: {{VALUE}};',
				],
			]
		);

		// btn
		$this->add_control(
			'content_style_button',
			[
				'label'     => esc_html__( 'Button', 'dimas' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'note_typography',
				'selector' => '{{WRAPPER}} .dimas-product-banner .button-text',
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label'     => __( 'Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-product-banner .button-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render circle box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$classes = [
			'dimas-product-banner',
			$settings['link_type'] == 'all' ? 'has-hover' : ''
		];

		$this->add_render_attribute( 'wrapper', 'class', $classes );

		$link_icon = $settings['show_default_icon'] ? \Dimas\Addons\Helper::get_svg( 'arrow-right', 'dimas-icon' ) : '';

		$button_text = $settings['button_text'] ? sprintf( '<span class="button-text dimas-button button-normal">%s%s</span>', $settings['button_text'], $link_icon ) : '';

		$btn_full = '';
		if ( $settings['link']['url'] ) :

			$btn_full = $settings['link_type'] == 'all' ? Helper::control_url( 'btn_full', $settings['link'], '', [ 'class' => 'full-box-button' ] ) : '';

			$button_text = Helper::control_url( 'btn', $settings['link'], $button_text, [ 'class' => 'button-link' ] );
		endif;

		$title = $settings['title'] ? sprintf( '<h2 class="banner-title">%s</h2>', $settings['title'] ) : '';

		// Sale
		$regular_price = $settings['regular_price'] ? sprintf( '<div class="regular-price">%s</div>', $settings['regular_price'] ) : '';
		$sale_price    = $settings['sale_price'] ? sprintf( '<div class="sale-price">%s</div>', $settings['sale_price'] ) : '';

		$badges = $settings['badges'] ? sprintf( '<div class="product-badges">%s</div>', $settings['badges'] ) : '';

		$banner_price = $regular_price == '' && $sale_price == '' ? '' : sprintf( '<div class="banner-price">%s %s</div>', $sale_price, $regular_price );
		$html_sale    = $badges == '' && $banner_price == '' ? '' : sprintf( '<div class="banner-content__sale">%s %s</div>', $banner_price, $badges );

		$image = Group_Control_Image_Size::get_attachment_image_html( $settings );
		$image = $image ? $image : '';

		$output = '<div class="banner-image">';
		$output .= $image;
		$output .= $html_sale;
		$output .= '</div>';
		$output .= '<div class="banner-content">';
		$output .= $title;
		$output .= $button_text;
		$output .= '</div>';
		$output .= $btn_full;

		echo sprintf(
			'<div %s> %s</div>',
			$this->get_render_attribute_string( 'wrapper' ),
			$output
		);
	}
}
