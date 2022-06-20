<?php

namespace Dimas\Addons\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Advanced Tabs widget
 */
class Advanced_Tabs extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'dimas-advanced-tabs';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Dimas - Advanced Tabs', 'dimas' );
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
			'dimas-frontend'
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

	/**
	 * Register content controls.
	 *
	 * @access protected
	 */
	protected function section_content() {
		$this->tabs_controls();
		$this->section_carousel_settings_controls();
	}

	protected function tabs_controls() {
		$count = apply_filters( 'dimas_advanced_tabs_count', 4 );

		if ( $count > 0 ) {
			for ( $i = 1; $i <= $count; $i ++ ) {
				$this->start_controls_section(
					'section_content_' . $i,
					[ 'label' => sprintf( '%s %s', esc_html__( 'Advanced Tab', 'dimas' ), $i ) ]
				);

				$this->add_control(
					'enable_tab_' . $i,
					[
						'label'     => esc_html__( 'Enable', 'dimas' ),
						'type'      => Controls_Manager::SWITCHER,
						'label_on'  => esc_html__( 'Yes', 'dimas' ),
						'label_off' => esc_html__( 'No', 'dimas' ),
						'default'   => 'no',
						'options'   => [
							'yes' => esc_html__( 'Yes', 'dimas' ),
							'no'  => esc_html__( 'No', 'dimas' ),
						],
					]
				);

				$this->add_control(
					'tab_title_' . $i, [
						'label'       => esc_html__( 'Title', 'dimas' ),
						'type'        => Controls_Manager::TEXT,
						'default'     => '',
						'label_block' => true,
					]
				);

				$repeater = new \Elementor\Repeater();

				$repeater->add_control(
					'icon_type',
					[
						'label' => esc_html__( 'Icon type', 'dimas' ),
						'type' => Controls_Manager::SELECT,
						'options' => [
							'image' => esc_html__( 'Image', 'dimas' ),
							'icon' 	=> esc_html__( 'Icon', 'dimas' ),
							'external' 	=> esc_html__( 'External', 'dimas' ),
						],
						'default' => 'icon',
					]
				);

				$repeater->add_control(
					'selected_icon',
					[
						'label' => esc_html__( 'Icon', 'dimas' ),
						'type' => Controls_Manager::ICONS,
						'fa4compatibility' => 'icon',
						'default' => [
							'value' => 'fas fa-star',
							'library' => 'fa-solid',
						],
						'conditions' => [
							'terms' => [
								[
									'name' => 'icon_type',
									'value' => 'icon',
								],
							],
						],
					]
				);

				$repeater->add_control(
					'image',
					[
						'label' => esc_html__( 'Choose Image', 'dimas' ),
						'type' => Controls_Manager::MEDIA,
						'dynamic' => [
							'active' => true,
						],
						'conditions' => [
							'terms' => [
								[
									'name' => 'icon_type',
									'value' => 'image',
								],
							],
						],
					]
				);


				$repeater->add_control(
					'external_url',
					[
						'label' => esc_html__( 'External URL', 'dimas' ),
						'type' => Controls_Manager::TEXT,
						'label_block' => true,
						'dynamic' => [
							'active' => true,
						],
						'conditions' => [
							'terms' => [
								[
									'name' => 'icon_type',
									'value' => 'external',
								],
							],
						],
					]
				);

				$repeater->add_control(
					'title_tag', [
						'label'       => esc_html__( 'Title', 'dimas' ),
						'type'        => Controls_Manager::TEXT,
						'default'     => '',
						'label_block' => true,
					]
				);

				$repeater->add_control(
					'link_tag', [
						'label'         => esc_html__( 'Link', 'dimas' ),
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
					'item_' . $i,
					[
						'label'         => esc_html__( 'Items', 'dimas' ),
						'type'          => Controls_Manager::REPEATER,
						'fields'        => $repeater->get_controls(),
						'default'       => array(),
						'title_field'   => '{{{ title_tag }}}',
						'prevent_empty' => false
					]
				);

				$this->end_controls_section();
			}
		}
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
				'default' 		=> 5,
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
				'default' 		=> 5,
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
					'arrows' => esc_html__( 'Arrows', 'dimas' ),
					'dots' => esc_html__( 'Dots', 'dimas' ),
				],
				'default'   => 'arrows',
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

	/**
	 * Register style controls.
	 *
	 * @access protected
	 */
	protected function section_style() {
		$this->register_tab_header_style_controls();
		$this->register_tab_content_style_controls();
		$this->section_carousel_style_controls();
	}

	/**
	 * Register the widget tab header style controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
	protected function register_tab_header_style_controls() {

		$this->start_controls_section(
			'section_tab_header_style',
			[
				'label' => esc_html__( 'Tab Header', 'dimas' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'tab_header_title_align',
			[
				'label'   => esc_html__( 'Alignment', 'dimas' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
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
				'selectors' => [
					'{{WRAPPER}} .dimas-advanced-tabs .dimas-advanced-tabs__nav' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'tab_header_title_typography',
				'selector' => '{{WRAPPER}} .dimas-advanced-tabs .dimas-advanced-tabs__title',
			]
		);

		$this->add_control(
			'tab_header_color',
			[
				'label'     => esc_html__( 'Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-advanced-tabs .dimas-advanced-tabs__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tab_header_active_item_color',
			[
				'label'     => esc_html__( 'Color Active', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-advanced-tabs .dimas-advanced-tabs__title.active' => 'color: {{VALUE}};',
					'{{WRAPPER}} .dimas-advanced-tabs .dimas-advanced-tabs__title:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .dimas-advanced-tabs .dimas-advanced-tabs__title.active::after' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .dimas-advanced-tabs .dimas-advanced-tabs__title:hover::after' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'tab_header_title_spacing',
			[
				'label'     => esc_html__( 'Spacing Between Titles', 'dimas' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'unit' => 'px',
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimas-advanced-tabs .dimas-advanced-tabs__nav li' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .dimas-advanced-tabs .dimas-advanced-tabs__nav' => 'margin-left: -{{SIZE}}{{UNIT}}; margin-right: -{{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tab_header_title_spacing_bottom',
			[
				'label'     => esc_html__( 'Spacing Bottom', 'dimas' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'unit' => 'px',
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimas-advanced-tabs .dimas-advanced-tabs__nav' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register the widget tab content style controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
	protected function register_tab_content_style_controls() {

		$this->start_controls_section(
			'section_tab_content_style',
			[
				'label' => esc_html__( 'Tab Content', 'dimas' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'tab_content_item',
			[
				'label'     => esc_html__( 'Items', 'dimas' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'tab_content_item_padding',
			[
				'label'      => esc_html__( 'Padding', 'dimas' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .dimas-advanced-tabs .dimas-advanced-tabs__item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'tab_content_item_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dimas-advanced-tabs .dimas-advanced-tabs__item' => 'background-color: {{VALUE}};',
				],
				'default'   => '',
			]
		);

		$this->add_control(
			'tab_content_item_background_color_hover',
			[
				'label'     => esc_html__( 'Background Color Hover', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dimas-advanced-tabs .dimas-advanced-tabs__item:hover' => 'background-color: {{VALUE}};',
				],
				'default'   => '',
			]
		);

		$this->add_control(
			'tab_content_item_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dimas-advanced-tabs .dimas-advanced-tabs__item' => 'border-color: {{VALUE}};',
				],
				'default'   => '',
			]
		);

		$this->add_control(
			'tab_content_item_border_color_hover',
			[
				'label'     => esc_html__( 'Border Color Hover', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dimas-advanced-tabs .dimas-advanced-tabs__item:hover' => 'border-color: {{VALUE}};',
				],
				'default'   => '',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'img_box_box_shadow_hover',
				'label' => __( 'Box Shadow Hover', 'dimas' ),
				'selector' => '{{WRAPPER}} .dimas-advanced-tabs .dimas-advanced-tabs__item:hover',
			]
		);

		$this->add_control(
			'tab_content_icon',
			[
				'label'     => esc_html__( 'Icon', 'dimas' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'tab_content_icon_size',
			[
				'label'     => esc_html__( 'Size', 'dimas' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'unit' => 'px',
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 250,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimas-advanced-tabs .dimas-advanced-tabs__icon' => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'tab_content_icon_color',
			[
				'label'     => esc_html__( 'Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-advanced-tabs .dimas-advanced-tabs__icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tab_content_icon_hover_color',
			[
				'label'     => esc_html__( 'Hover Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-advanced-tabs .dimas-advanced-tabs__item:hover .dimas-advanced-tabs__icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'tab_content_icon_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'dimas' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'unit' => 'px',
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimas-advanced-tabs .dimas-advanced-tabs__icon' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'tab_content_title',
			[
				'label'     => esc_html__( 'Title', 'dimas' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'tab_content_title_typography',
				'selector' => '{{WRAPPER}} .dimas-advanced-tabs .dimas-advanced-tabs__content-title',
			]
		);

		$this->add_control(
			'tab_content_title_color',
			[
				'label'     => esc_html__( 'Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-advanced-tabs .dimas-advanced-tabs__content-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tab_content_hover_title_color',
			[
				'label'     => esc_html__( 'Hover Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-advanced-tabs .dimas-advanced-tabs__item:hover .dimas-advanced-tabs__content-title' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .dimas-advanced-tabs .rz-swiper-button' => 'font-size: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .dimas-advanced-tabs .rz-swiper-button' => 'width: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .dimas-advanced-tabs .rz-swiper-button' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .dimas-advanced-tabs .rz-swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .dimas-advanced-tabs .rz-swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .dimas-advanced-tabs .rz-swiper-button' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .dimas-advanced-tabs .rz-swiper-button' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .dimas-advanced-tabs .rz-swiper-button:hover' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .dimas-advanced-tabs .rz-swiper-button:hover' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .dimas-advanced-tabs .swiper-pagination .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .dimas-advanced-tabs .swiper-pagination .swiper-pagination-bullet:before' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .dimas-advanced-tabs .swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active:before, {{WRAPPER}} .dimas-advanced-tabs .swiper-pagination .swiper-pagination-bullet:hover:before' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .dimas-advanced-tabs .swiper-container-horizontal > .swiper-pagination-bullets .swiper-pagination-bullet' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .dimas-advanced-tabs .swiper-pagination' => 'margin-top: {{SIZE}}{{UNIT}};',
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
		$settings   = $this->get_settings_for_display();

		$nav        = $settings['navigation'];
		$nav_tablet = empty( $settings['navigation_tablet'] ) ? $nav : $settings['navigation_tablet'];
		$nav_mobile = empty( $settings['navigation_mobile'] ) ? $nav : $settings['navigation_mobile'];

		$classes = [
			'dimas-advanced-tabs dimas-swiper-carousel-elementor',
			'navigation-' . $nav,
			'navigation-tablet-' . $nav_tablet,
			'navigation-mobile-' . $nav_mobile,
		];

		$this->add_render_attribute( 'wrapper', 'class', $classes );
		$this->add_render_attribute( 'icon', 'class', [ 'dimas-advanced-tabs__icon', 'dimas-svg-icon' ] );

		$tabs_count = apply_filters( 'dimas_advanced_tabs_count', 4 );

		?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
            <div class="dimas-advanced-tabs__wrapper">
				<ul class="dimas-advanced-tabs__nav">
					<?php
					for ( $i = 1; $i <= $tabs_count; $i ++ ) {

						if ( isset( $settings[ 'enable_tab_' . $i ] ) && $settings[ 'enable_tab_' . $i ] != 'yes' ) {
							continue;
						}

						echo sprintf(
							'<li><a href="#" class="dimas-advanced-tabs__title %s" data-tabs="tabs-%s">%s</a></li>',
							$i == 1 ? 'active' : '',
							$i,
							isset( $settings[ 'tab_title_' . $i ] ) ? $settings[ 'tab_title_' . $i ] : ''
						);
					}
					?>
				</ul>
                <div class="dimas-advanced-tabs__content">
					<?php for ( $i = 1; $i <= $tabs_count; $i ++ ) {

						if ( isset( $settings[ 'enable_tab_' . $i ] ) && $settings[ 'enable_tab_' . $i ] != 'yes' ) {
							continue;
						}

						$tags = isset( $settings[ 'item_' . $i ] ) ? $settings[ 'item_' . $i ] : '';

						if ( $tags ) {
							echo sprintf(
										'<div class="dimas-advanced-tabs__panel tabs-%s %s"><div class="swiper-container"><div class="swiper-wrapper">',
											$i,
											$i == 1 ? 'tab-loaded active' : ''
										);
							foreach ( $tags as $index => $item ) {
								if ( ! empty( $item['link_tag']['url'] ) ) {
									$this->add_link_attributes( 'link_'.$index.'_tag_'.$i, $item['link_tag'] );
								}

								echo '<a class="dimas-advanced-tabs__item swiper-slide" ' . $this->get_render_attribute_string( 'link_'.$index.'_tag_'.$i ) . '>';
									if ( ! isset( $item['icon_'.$index.'_'.$i] ) && ! Icons_Manager::is_migration_allowed() ) {
										$item['icon_'.$index.'_'.$i] = 'fa fa-star';
									}

									$has_icon = ! empty( $item['icon_'.$index.'_'.$i] );

									if ( $has_icon ) {
										$this->add_render_attribute( 'i', 'class', $item['icon_'.$index.'_'.$i] );
										$this->add_render_attribute( 'i', 'aria-hidden', 'true' );
									}

									if ( ! $has_icon && ! empty( $item['selected_icon']['value'] ) ) {
										$has_icon = true;
									}

									$migrated = isset( $item['__fa4_migrated']['selected_icon'] );
									$is_new = ! isset( $item['icon_'.$index.'_'.$i] ) && Icons_Manager::is_migration_allowed();

									if ( $has_icon || ! empty( $item['image']['url'] ) || ! empty( $item['external_url'] ) ) {
										if ( $item['icon_type'] === 'image' ) {
											?><span <?php $this->print_render_attribute_string( 'icon' ); ?>><?php
												echo sprintf( '<img alt="%s" src="%s">', esc_attr( $item['title_tag'] ), esc_url( $item['image']['url'] ) );
											?></span><?php
										} if ( $item['icon_type'] === 'external' ) {
											?><span <?php $this->print_render_attribute_string( 'icon' ); ?>><?php
												echo '<img src="' . $item['external_url'] . '" alt="' . $item['title_tag'] . '" />';
											?></span><?php
										} else {
											if ( $is_new || $migrated ) {
												?><span <?php $this->print_render_attribute_string( 'icon' ); ?>><?php
													Icons_Manager::render_icon( $item['selected_icon'], [ 'aria-hidden' => 'true' ] );
												?></span><?php
											} elseif ( ! empty( $item['icon_'.$index.'_'.$i] ) ) {
												?>
												<span <?php $this->print_render_attribute_string( 'icon' ); ?>>
													<i <?php $this->print_render_attribute_string( 'i' ); ?>></i>
												</span>
												<?php
											}
										}
									}

									echo '<span class="dimas-advanced-tabs__content-title">' . esc_attr( $item['title_tag'] ) . '</span>';
								echo '</a>';
							}
							echo '</div></div></div>';
						}
					} ?>
                </div>
            </div>

        </div>
		<?php

	}
}
