<?php

namespace Dimas\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Controls_Stack				;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Products Slider widget
 */
class Products_Slider extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'dimas-products-slider';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Dimas - Products Slider', 'dimas' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-post-slider';
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

	// Contetnt
	protected function section_content() {
		$this->section_products_settings_controls();
		$this->section_carousel_settings_controls();
	}

	protected function section_products_settings_controls() {
		$this->start_controls_section(
			'section_slides',
			[
				'label' => esc_html__( 'Slides', 'dimas' ),
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_responsive_control(
			'banner_background_img',
			[
				'label'    => __( 'Background Image', 'dimas' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://via.placeholder.com/1920X580/cccccc?text=1920x600',
				],
				'selectors' => [
					'{{WRAPPER}} .dimas-products-slider {{CURRENT_ITEM}}' => 'background-image: url("{{URL}}");',
				],
			]
		);

		$repeater->add_responsive_control(
			'background_size',
			[
				'label'     => esc_html__( 'Background Size', 'dimas' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'cover',
				'options'   => [
					'cover'   => esc_html__( 'Cover', 'dimas' ),
					'contain' => esc_html__( 'Contain', 'dimas' ),
					'auto'    => esc_html__( 'Auto', 'dimas' ),
				],
				'selectors' => [
					'{{WRAPPER}} .dimas-products-slider {{CURRENT_ITEM}}' => 'background-size: {{VALUE}}',
				],
				'condition' => [
					'banner_background_img[url]!' => '',
				],
			]
		);

		$repeater->add_responsive_control(
			'background_position',
			[
				'label'     => esc_html__( 'Background Position', 'dimas' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''              => esc_html__( 'Default', 'dimas' ),
					'left top'      => esc_html__( 'Left Top', 'dimas' ),
					'left center'   => esc_html__( 'Left Center', 'dimas' ),
					'left bottom'   => esc_html__( 'Left Bottom', 'dimas' ),
					'right top'     => esc_html__( 'Right Top', 'dimas' ),
					'right center'  => esc_html__( 'Right Center', 'dimas' ),
					'right bottom'  => esc_html__( 'Right Bottom', 'dimas' ),
					'center top'    => esc_html__( 'Center Top', 'dimas' ),
					'center center' => esc_html__( 'Center Center', 'dimas' ),
					'center bottom' => esc_html__( 'Center Bottom', 'dimas' ),
					'initial' 		=> esc_html__( 'Custom', 'dimas' ),
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-products-slider {{CURRENT_ITEM}}' => 'background-position: {{VALUE}};',
				],
				'condition' => [
					'banner_background_img[url]!' => '',
				],

			]
		);

		$repeater->add_responsive_control(
			'background_position_xy',
			[
				'label'              => esc_html__( 'Custom Background Position', 'dimas' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'allowed_dimensions' => [ 'top', 'left' ],
				'size_units'         => [ 'px', '%' ],
				'default'            => [ ],
				'selectors'          => [
					'{{WRAPPER}} .dimas-products-slider {{CURRENT_ITEM}}' => 'background-position: {{LEFT}}{{UNIT}} {{TOP}}{{UNIT}};',
				],
				'condition' => [
					'background_position' => [ 'initial' ],
					'banner_background_img[url]!' => '',
				],
				'required' => true,
				'device_args' => [
					Controls_Stack::RESPONSIVE_TABLET => [
						'condition' => [
							'background_position_tablet' => [ 'initial' ],
						],
					],
					Controls_Stack::RESPONSIVE_MOBILE => [
						'condition' => [
							'background_position_mobile' => [ 'initial' ],
						],
					],
				],
			]
		);

		$repeater->add_control(
			'background_overlay',
			[
				'label'      => esc_html__( 'Background Overlay', 'dimas' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .dimas-products-slider {{CURRENT_ITEM}}.item-slider::before' => 'background-color: {{VALUE}}',
				],
			]
		);

		$repeater->add_control(
			'ids',
			[
				'label'       => esc_html__( 'Products', 'dimas' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'dimas' ),
				'type'        => 'rzautocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => false,
				'source'      => 'product',
				'sortable'    => true,
			]
		);

		$repeater->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'dimas' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => '',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'deal',
			[
				'label' => esc_html__( 'Deal', 'dimas' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'before_text',
			[
				'label'   => esc_html__( 'Before Text', 'dimas' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
			]
		);

		$repeater->add_control(
			'text',
			[
				'label'   => esc_html__( 'Text', 'dimas' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
			]
		);

		$this->add_control(
			'slides',
			[
				'label'      => esc_html__( 'Slides', 'dimas' ),
				'type'       => Controls_Manager::REPEATER,
				'show_label' => true,
				'fields'     => $repeater->get_controls(),
				'default'    => [
					[
						'title' => esc_html__( 'Slide 1 Heading', 'dimas' ),
					],
					[
						'title' => esc_html__( 'Slide 2 Heading', 'dimas' ),
					],
				],
			]
		);

		$this->add_responsive_control(
			'slides_height',
			[
				'label'      => esc_html__( 'Height', 'dimas' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 100,
						'max' => 1000,
					],
					'vh' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'default'    => [
					'size' => 580,
				],
				'size_units' => [ 'px', 'vh', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .dimas-products-slider .dimas-products-slider__item' => 'height: {{SIZE}}{{UNIT}};',
				],
				'separator'  => 'before',
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
			'navigation',
			[
				'label'     => esc_html__( 'Navigation', 'dimas' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'none'     => esc_html__( 'None', 'dimas' ),
					'arrows' => esc_html__( 'Arrows', 'dimas' ),
					'dots' => esc_html__( 'Dots', 'dimas' ),
				],
				'default'   => 'dots',
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

	// Style
	protected function section_style() {
		$this->section_content_style_controls();
		$this->section_carousel_style_controls();
	}

	protected function section_content_style_controls() {
		// Content Settings
		$this->start_controls_section(
			'section_content_style',
			[
				'label' => esc_html__( 'Content', 'dimas' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => esc_html__( 'Padding', 'dimas' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .dimas-products-slider .dimas-products-slider__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label'     => esc_html__( 'Background Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-products-slider .dimas-products-slider__content' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'style_title_heading',
			[
				'label' => esc_html__( 'Title', 'dimas' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-products-slider .dimas-products-slider__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .dimas-products-slider .dimas-products-slider__title',
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
						'max' => 250,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimas-products-slider .dimas-products-slider__title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'style_sale_heading',
			[
				'label' => esc_html__( 'Sale', 'dimas' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'sale_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-products-slider .dimas-products-slider__sale' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'sale_color',
			[
				'label'     => esc_html__( 'Text Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-products-slider .dimas-products-slider__sale span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'     => esc_html__( 'Before Text', 'dimas' ),
				'name'     => 'sale_before_text_typography',
				'selector' => '{{WRAPPER}} .dimas-products-slider .dimas-products-slider__sale .dimas-products-slider__sale-before-text',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'     => esc_html__( 'Text', 'dimas' ),
				'name'     => 'sale_text_typography',
				'selector' => '{{WRAPPER}} .dimas-products-slider .dimas-products-slider__sale .dimas-products-slider__sale-text',
			]
		);

		$this->end_controls_section();
	}

	protected function section_carousel_style_controls() {
		// Carousel Settings
		$this->start_controls_section(
			'section_carousel_style',
			[
				'label' => esc_html__( 'Carousel Style', 'dimas' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'carousel_divider',
			[
				'label' => __( 'Arrows', 'dimas' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'arrows_font_size',
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
					'{{WRAPPER}} .dimas-products-slider .rz-swiper-button' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'sliders_arrows_width',
			[
				'label'     => __( 'Width', 'dimas' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimas-products-slider .rz-swiper-button' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'sliders_arrows_height',
			[
				'label'     => __( 'Height', 'dimas' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimas-products-slider .rz-swiper-button' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrows_spacing_horizontal',
			[
				'label'      => __( 'Horizontal Position', 'dimas' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => - 200,
						'max' => 300,
					],
				],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .dimas-products-slider .rz-swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .dimas-products-slider .rz-swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'sliders_normal_settings' );

		$this->start_controls_tab( 'sliders_normal', [ 'label' => esc_html__( 'Normal', 'dimas' ) ] );

		$this->add_control(
			'sliders_arrow_color',
			[
				'label'     => esc_html__( 'Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-products-slider .rz-swiper-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'sliders_arrow_bgcolor',
			[
				'label'     => esc_html__( 'Background Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-products-slider .rz-swiper-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'sliders_hover', [ 'label' => esc_html__( 'Hover', 'dimas' ) ] );

		$this->add_control(
			'sliders_arrow_hover_color',
			[
				'label'     => esc_html__( 'Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-products-slider .rz-swiper-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'sliders_arrow_hover_bgcolor',
			[
				'label'     => esc_html__( 'Background Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-products-slider .rz-swiper-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();

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
					'{{WRAPPER}} .dimas-products-slider .swiper-pagination .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .dimas-products-slider .swiper-pagination .swiper-pagination-bullet:before' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .dimas-products-slider .swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active:before, {{WRAPPER}} .dimas-products-slider .swiper-pagination .swiper-pagination-bullet:hover:before' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .dimas-products-slider .swiper-container-horizontal > .swiper-pagination-bullets .swiper-pagination-bullet' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .dimas-products-slider .swiper-pagination' => 'margin-top: {{SIZE}}{{UNIT}};',
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
			'dimas-products-slider dimas-swiper-carousel-elementor woocommerce dimas-swiper-slider-elementor',
			'navigation-' . $nav,
			'navigation-tablet-' . $nav_tablet,
			'navigation-mobile-' . $nav_mobile,
		];

		$this->add_render_attribute( 'wrapper', 'class', $classes );

		echo '<div '. $this->get_render_attribute_string( 'wrapper' ) . '>';
			echo '<div class="dimas-products-slider__wrapper swiper-container">';
				echo '<div class="dimas-products-slider__inner swiper-wrapper">';
					foreach ( $settings['slides'] as $slides ) {
						echo '<div class="elementor-repeater-item-' . $slides['_id'] . ' item-slider swiper-slide">';

							$id = $slides['ids'];
							$product = wc_get_product( $id );

							echo '<div class="dimas-products-slider__item container">';
								echo '<div class="dimas-products-slider__content">';
									if( $slides['title'] ) {
										echo sprintf( '<div class="dimas-products-slider__title">%s</div>', esc_html( $slides['title'] ) );
									}
									if( $slides['text'] ) {
										echo sprintf( '<div class="dimas-products-slider__sale"><span class="dimas-products-slider__sale-before-text">%s</span><span class="dimas-products-slider__sale-text">%s</span></div>', esc_html( $slides['before_text'] ) ,esc_html( $slides['text'] ) );
									}
									if ( !empty( $product ) ) {
										$original_post = $GLOBALS['post'];

										$GLOBALS['post'] = get_post( $id ); // WPCS: override ok.
										setup_postdata( $GLOBALS['post'] );
										wc_get_template_part( 'content', 'product-slider' );

										$GLOBALS['post'] = $original_post; // WPCS: override ok.

										wp_reset_postdata();
									}
								echo '</div>';
							echo '</div>';

						echo '</div>';
					}
				echo '</div>';
				echo \Dimas\Addons\Helper::get_svg('chevron-left', 'rz-swiper-button-prev rz-swiper-button');
				echo \Dimas\Addons\Helper::get_svg('chevron-right','rz-swiper-button-next rz-swiper-button');
				echo '<div class="swiper-pagination"></div>';
			echo '</div>';
		echo '</div>';
	}
}