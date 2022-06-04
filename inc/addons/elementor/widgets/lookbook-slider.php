<?php

namespace Dimas\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Controls_Stack;
use Dimas\Addons\Elementor\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Lookbook slider widget
 */
class Lookbook_slider extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'dimas-lookbook-slider';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Dimas - Lookbook Slider', 'dimas' );
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
	protected function _register_controls() {
		$this->section_content();
		$this->section_style();
	}

	// Tab Content
	protected function section_content() {
		$this->section_content_slides();
		$this->section_content_option();
	}

	protected function section_content_slides() {
		$this->start_controls_section(
			'section_slides',
			[
				'label' => esc_html__( 'Slides', 'dimas' ),
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->start_controls_tabs( 'slides_repeater' );

		$repeater->start_controls_tab( 'background', [ 'label' => esc_html__( 'Content', 'dimas' ) ] );

		$repeater->add_responsive_control(
			'banner_background_img',
			[
				'label'     => __( 'Background Image', 'dimas' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => 'https://via.placeholder.com/1920X600/cccccc?text=Image',
				],
				'selectors' => [
					'{{WRAPPER}} .dimas-lookbook-slider-elementor {{CURRENT_ITEM}} .slick-slide-block__img:not(.swiper-lazy)' => 'background-image: url("{{URL}}");',
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
					'{{WRAPPER}} .dimas-lookbook-slider-elementor {{CURRENT_ITEM}} .slick-slide-block__img' => 'background-size: {{VALUE}}',
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
					'initial'       => esc_html__( 'Custom', 'dimas' ),
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-lookbook-slider-elementor {{CURRENT_ITEM}} .slick-slide-block__img' => 'background-position: {{VALUE}};',
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
				'default'            => [],
				'selectors'          => [
					'{{WRAPPER}} .dimas-lookbook-slider-elementor {{CURRENT_ITEM}} .slick-slide-block__img' => 'background-position: {{LEFT}}{{UNIT}} {{TOP}}{{UNIT}};',
				],
				'condition'          => [
					'background_position'         => [ 'initial' ],
					'banner_background_img[url]!' => '',
				],
				'required'           => true,
				'device_args'        => [
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
			'title',
			[
				'label'       => esc_html__( 'Title', 'dimas' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Slide Heading', 'dimas' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'show_default_icon',
			[
				'label'        => esc_html__( 'Show Default Icon', 'dimas' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => __( 'Off', 'dimas' ),
				'label_on'     => __( 'On', 'dimas' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$repeater->add_control(
			'button_text',
			[
				'label'   => esc_html__( 'Button Text', 'dimas' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Click Here', 'dimas' ),
			]
		);

		$repeater->add_control(
			'link',
			[
				'label'       => esc_html__( 'Link', 'dimas' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'dimas' ),
			]
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab( 'product_lookbooks', [ 'label' => esc_html__( 'Lookbooks', 'dimas' ) ] );

		$control = apply_filters( 'dimas_slider_section_product_number', 3 );
		for ( $i = 1; $i <= $control; $i ++ ) {

			$repeater->add_control(
				'product_lookbooks_heading_' . $i,
				[
					'type'  => Controls_Manager::HEADING,
					'label' => esc_html__( 'Lookbook', 'dimas' ) . ' ' . $i,
				]
			);

			$repeater->add_control(
				'product_lookbooks_ids_' . $i,
				[
					'label'       => esc_html__( 'Product', 'dimas' ),
					'placeholder' => esc_html__( 'Click here and start typing...', 'dimas' ),
					'type'        => 'rzautocomplete',
					'default'     => '',
					'label_block' => true,
					'multiple'    => false,
					'source'      => 'product',
					'sortable'    => true,
				]
			);


			$repeater->add_responsive_control(
				'product_lookbooks_position_x_' . $i,
				[
					'label'      => esc_html__( 'Point Position X', 'dimas' ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 1000,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default'    => [
						'unit' => '%',
						'size' => 30 + $i * 10,
					],
					'size_units' => [ '%', 'px' ],
					'selectors'  => [
						'{{WRAPPER}} .dimas-lookbook-slider-elementor {{CURRENT_ITEM}} .dimas-lookbook-item.item-' . $i . '' => 'left: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$repeater->add_responsive_control(
				'product_lookbooks_position_y_' . $i,
				[
					'label'      => esc_html__( 'Point Position Y', 'dimas' ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 1000,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default'    => [
						'unit' => '%',
						'size' => 30 + $i * 10,
					],
					'size_units' => [ '%', 'px' ],
					'selectors'  => [
						'{{WRAPPER}} .dimas-lookbook-slider-elementor {{CURRENT_ITEM}} .dimas-lookbook-item.item-' . $i . ' ' => 'top: {{SIZE}}{{UNIT}};',
					],
				]
			);


			$repeater->add_responsive_control(
				'product_content_lookbooks_position_x_' . $i,
				[
					'label'      => esc_html__( 'Product Position X', 'dimas' ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => [
						'px' => [
							'min' => - 1000,
							'max' => 1000,
						],
						'%'  => [
							'min' => - 100,
							'max' => 100,
						],
					],
					'default'    => [],
					'size_units' => [ 'px' ],
					'selectors'  => [
						'{{WRAPPER}} .dimas-lookbook-slider-elementor {{CURRENT_ITEM}} .dimas-lookbook-item.item-' . $i . ' .product-item' => 'left: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$repeater->add_responsive_control(
				'product_content_lookbooks_position_y_' . $i,
				[
					'label'      => esc_html__( 'Product Position Y', 'dimas' ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => [
						'px' => [
							'min' => - 1000,
							'max' => 1000,
						],
						'%'  => [
							'min' => - 100,
							'max' => 100,
						],
					],
					'default'    => [],
					'size_units' => [ 'px' ],
					'selectors'  => [
						'{{WRAPPER}} .dimas-lookbook-slider-elementor {{CURRENT_ITEM}} .dimas-lookbook-item.item-' . $i . ' .product-item' => 'top: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$repeater->add_control(
				'product_lookbooks_hr_' . $i,
				[
					'type' => Controls_Manager::DIVIDER,
				]
			);

		}

		$repeater->end_controls_tab();

		$repeater->start_controls_tab( 'style', [ 'label' => esc_html__( 'Style', 'dimas' ) ] );

		$repeater->add_control(
			'custom_style',
			[
				'label'       => esc_html__( 'Custom', 'dimas' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => esc_html__( 'Set custom style that will only affect this specific slide.', 'dimas' ),
			]
		);

		$repeater->add_responsive_control(
			'horizontal_position',
			[
				'label'                => esc_html__( 'Horizontal Position', 'dimas' ),
				'type'                 => Controls_Manager::CHOOSE,
				'label_block'          => false,
				'options'              => [
					'left'   => [
						'title' => esc_html__( 'Left', 'dimas' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'dimas' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'dimas' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'              => '',
				'selectors'            => [
					'{{WRAPPER}} .dimas-lookbook-slider-elementor {{CURRENT_ITEM}} .slick-slide-inner' => 'justify-content: {{VALUE}}',
				],
				'selectors_dictionary' => [
					'left'   => 'flex-start',
					'center' => 'center',
					'right'  => 'flex-end',
				],
				'conditions'           => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_responsive_control(
			'vertical_position',
			[
				'label'                => esc_html__( 'Vertical Position', 'dimas' ),
				'type'                 => Controls_Manager::CHOOSE,
				'label_block'          => false,
				'options'              => [
					'top'    => [
						'title' => esc_html__( 'Top', 'dimas' ),
						'icon'  => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => esc_html__( 'Middle', 'dimas' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'dimas' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'selectors'            => [
					'{{WRAPPER}} .dimas-lookbook-slider-elementor {{CURRENT_ITEM}} .slick-slide-inner' => 'align-items: {{VALUE}}',
				],
				'selectors_dictionary' => [
					'top'    => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				],
				'conditions'           => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_responsive_control(
			'text_align',
			[
				'label'       => esc_html__( 'Text Align', 'dimas' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'left'   => [
						'title' => esc_html__( 'Left', 'dimas' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'dimas' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'dimas' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'selectors'   => [
					'{{WRAPPER}} .dimas-lookbook-slider-elementor {{CURRENT_ITEM}} .slick-slide-inner' => 'text-align: {{VALUE}}',
				],
				'conditions'  => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_responsive_control(
			'blank_position',
			[
				'label'                => esc_html__( 'Blank Position', 'dimas' ),
				'type'                 => Controls_Manager::CHOOSE,
				'label_block'          => false,
				'options'              => [
					'left'   => [
						'title' => esc_html__( 'Left', 'dimas' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'dimas' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'              => '',
				'selectors'            => [
					'{{WRAPPER}} .dimas-lookbook-slider-elementor {{CURRENT_ITEM}} .slick-slide-block__blank' => 'order: {{VALUE}}',
					'{{WRAPPER}} .dimas-lookbook-slider-elementor {{CURRENT_ITEM}} .slick-slide-block__img' => 'order: 1',
				],
				'selectors_dictionary' => [
					'left'   => '1',
					'right'  => '2',
				],
				'conditions'           => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
				'separator'  => 'before',
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'slides',
			[
				'label'      => esc_html__( 'Slides Items', 'dimas' ),
				'type'       => Controls_Manager::REPEATER,
				'show_label' => true,
				'fields'     => $repeater->get_controls(),
				'default'    => [
					[
						'title'       => esc_html__( 'Slide 1 Heading', 'dimas' ),
						'description' => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'dimas' ),
						'button_text' => esc_html__( 'Click Here', 'dimas' ),
					],
					[
						'title'       => esc_html__( 'Slide 2 Heading', 'dimas' ),
						'description' => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'dimas' ),
						'button_text' => esc_html__( 'Click Here', 'dimas' ),
					],
					[
						'title'       => esc_html__( 'Slide 3 Heading', 'dimas' ),
						'description' => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'dimas' ),
						'button_text' => esc_html__( 'Click Here', 'dimas' ),
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
					'{{WRAPPER}} .dimas-lookbook-slider-elementor .item-slider' => 'height: {{SIZE}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'lazyload',
			[
				'label'              => esc_html__( 'Lazy load for images', 'dimas' ),
				'type'               => Controls_Manager::SWITCHER,
				'label_off'          => __( 'Off', 'dimas' ),
				'label_on'           => __( 'On', 'dimas' ),
				'return_value'       => 'yes',
				'default'            => 'yes',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'link_type',
			[
				'label'   => esc_html__( 'Link Type', 'dimas' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'only' => esc_html__( 'Only button text', 'dimas' ),
					'all'  => esc_html__( 'All slider', 'dimas' ),
				],
				'default' => 'only',
				'toggle'  => false,
			]
		);

		$this->end_controls_section();
	}

	protected function section_content_option() {
		$this->start_controls_section(
			'section_slider_options',
			[
				'label' => esc_html__( 'Slider Options', 'dimas' ),
				'type'  => Controls_Manager::SECTION,
			]
		);

		$this->add_control(
			'effect',
			[
				'label'              => esc_html__( 'Effect', 'dimas' ),
				'type'               => Controls_Manager::SELECT,
				'options'            => [
					'fade'      => esc_html__( 'Fade', 'dimas' ),
					'slide'     => esc_html__( 'Slide', 'dimas' ),
					'cube'      => esc_html__( 'Cube', 'dimas' ),
					'coverflow' => esc_html__( 'Coverflow', 'dimas' ),
				],
				'default'            => 'fade',
				'toggle'             => false,
				'frontend_available' => true,
			]
		);

		$this->add_responsive_control(
			'navigation',
			[
				'label'   => esc_html__( 'Navigation', 'dimas' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'none'   => esc_html__( 'None', 'dimas' ),
					'arrows' => esc_html__( 'Arrows', 'dimas' ),
					'dots'   => esc_html__( 'Dots', 'dimas' ),
				],
				'default' => 'arrows',
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'              => esc_html__( 'Autoplay', 'dimas' ),
				'type'               => Controls_Manager::SWITCHER,
				'label_off'          => __( 'Off', 'dimas' ),
				'label_on'           => __( 'On', 'dimas' ),
				'return_value'       => 'yes',
				'default'            => 'yes',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'delay',
			[
				'label'              => esc_html__( 'Delay', 'dimas' ),
				'type'               => Controls_Manager::NUMBER,
				'default'            => 3000,
				'description'        => esc_html__( 'Delay between transitions (in ms). If this parameter is not specified, auto play will be disabled', 'dimas' ),
				'conditions'         => [
					'terms' => [
						[
							'name'  => 'autoplay',
							'value' => 'yes',
						]
					],
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label'              => esc_html__( 'Autoplay Speed', 'dimas' ),
				'type'               => Controls_Manager::NUMBER,
				'default'            => 1000,
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'infinite',
			[
				'label'              => esc_html__( 'Infinite Loop', 'dimas' ),
				'type'               => Controls_Manager::SWITCHER,
				'label_off'          => __( 'Off', 'dimas' ),
				'label_on'           => __( 'On', 'dimas' ),
				'return_value'       => 'yes',
				'default'            => '',
				'frontend_available' => true,
			]
		);

		$this->end_controls_section();

	}

	// Tab Style
	protected function section_style() {
		// Tab
		$this->start_controls_section(
			'section_style_content',
			[
				'label' => esc_html__( 'Content', 'dimas' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'blank_max_width',
			[
				'label'      => esc_html__( 'Blank Width', 'dimas' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range'      => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .dimas-lookbook-slider-elementor .slick-slide-block__blank' => 'flex:0 0 {{SIZE}}%;max-width: {{SIZE}}%',
					'{{WRAPPER}} .dimas-lookbook-slider-elementor .slick-slide-block__img'   => 'flex:0 0 calc(100% - {{SIZE}}%);max-width: calc(100% - {{SIZE}}%)',
				],
			]
		);

		// Tab
		$this->add_control(
			'section_style_title',
			[
				'label'     => esc_html__( 'Title', 'dimas' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'title_display',
			[
				'label'     => esc_html__( 'Display', 'dimas' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					'block' => esc_html__( 'Show', 'dimas' ),
					'none'  => esc_html__( 'Hidden', 'dimas' ),
				],
				'selectors' => [
					'{{WRAPPER}} .dimas-lookbook-slider-elementor .slick-slide-inner .dimas-slide-heading' => 'display: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'heading_spacing',
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
					'{{WRAPPER}} .dimas-lookbook-slider-elementor .slick-slide-inner .dimas-slide-heading' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label'     => esc_html__( 'Text Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dimas-lookbook-slider-elementor .dimas-slide-heading' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .dimas-lookbook-slider-elementor .dimas-slide-heading',
			]
		);

		$this->add_control(
			'section_style_button',
			[
				'label'     => esc_html__( 'Button', 'dimas' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'btn_display',
			[
				'label'     => esc_html__( 'Display', 'dimas' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					'block' => esc_html__( 'Show', 'dimas' ),
					'none'  => esc_html__( 'Hidden', 'dimas' ),
				],
				'selectors' => [
					'{{WRAPPER}} .dimas-lookbook-slider-elementor .button-text' => 'display: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'btn_padding',
			[
				'label'      => esc_html__( 'Padding', 'dimas' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .dimas-lookbook-slider-elementor .button-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'btn_typography',
				'selector' => '{{WRAPPER}} .dimas-lookbook-slider-elementor .button-text',
			]
		);

		$this->add_control(
			'btn_color',
			[
				'label'     => esc_html__( 'Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dimas-lookbook-slider-elementor .button-text' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'btn_bgcolor',
			[
				'label'     => esc_html__( 'Background Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dimas-lookbook-slider-elementor .button-text' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
		// End tab

		$this->section_style_lookbook();

		$this->section_style_carousel();
	}

	protected function section_style_lookbook() {

		// Arrows
		$this->start_controls_section(
			'section_style_lookbook',
			[
				'label' => esc_html__( 'LookBook', 'dimas' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'lookbook_bgcolor',
			[
				'label'     => esc_html__( 'Dot Background Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dimas-lookbook-slider-elementor .dimas-lookbook-item' => ' --rz-lookbook-color-primary: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'lookbook_title_heading',
			[
				'label'     => esc_html__( 'Title', 'dimas' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'lookbook_title_typography',
				'selector' => '{{WRAPPER}} .dimas-lookbook-slider-elementor .product-item .product-name',
			]
		);

		$this->add_control(
			'lookbook_title_color',
			[
				'label'     => esc_html__( 'Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dimas-lookbook-slider-elementor .product-item .product-name' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'lookbook_price_heading',
			[
				'label'     => esc_html__( 'Price', 'dimas' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'lookbook_price_typography',
				'selector' => '{{WRAPPER}} .dimas-lookbook-slider-elementor .product-item .product-price',
			]
		);

		$this->add_control(
			'lookbook_price_color',
			[
				'label'     => esc_html__( 'Regular Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dimas-lookbook-slider-elementor .product-item .product-price' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'lookbook_price_color_1',
			[
				'label'     => esc_html__( 'Sale Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dimas-lookbook-slider-elementor .product-item .product-price ins' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function section_style_carousel() {
		// Arrows
		$this->start_controls_section(
			'section_style_slider',
			[
				'label' => esc_html__( 'Slider Options', 'dimas' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Arrows
		$this->add_control(
			'arrow_style_heading',
			[
				'label' => esc_html__( 'Arrows', 'dimas' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'arrow_position',
			[
				'label'                => esc_html__( 'Arrow Position', 'dimas' ),
				'type'                 => Controls_Manager::CHOOSE,
				'label_block'          => false,
				'options'              => [
					'bottom'    => [
						'title' => esc_html__( 'Top', 'dimas' ),
						'icon'  => 'eicon-v-align-bottom',
					],
					'both' => [
						'title' => esc_html__( 'Middle', 'dimas' ),
						'icon'  => 'eicon-h-align-stretch',
					],
				],
				'prefix_class' => 'dimas-lookbook-slider-nav-position-',
			]
		);

		$this->add_responsive_control(
			'sliders_arrows_size',
			[
				'label'     => __( 'Size', 'dimas' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimas-lookbook-slider-elementor .rz-swiper-button' => 'font-size: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .dimas-lookbook-slider-elementor .rz-swiper-button' => 'width: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .dimas-lookbook-slider-elementor .rz-swiper-button' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .dimas-lookbook-slider-elementor .rz-swiper-button' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .dimas-lookbook-slider-elementor .rz-swiper-button' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .dimas-lookbook-slider-elementor .rz-swiper-button:hover' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .dimas-lookbook-slider-elementor .rz-swiper-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		// Dots
		$this->add_control(
			'dots_style_heading',
			[
				'label'     => esc_html__( 'Dots', 'dimas' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'dots_style',
			[
				'label'        => __( 'Options', 'dimas' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'dimas' ),
				'label_on'     => __( 'Custom', 'dimas' ),
				'return_value' => 'yes',
			]
		);

		$this->start_popover();

		$this->add_responsive_control(
			'sliders_dots_gap',
			[
				'label'     => __( 'Gap', 'dimas' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimas-lookbook-slider-elementor .swiper-pagination-bullet' => 'margin: 0 {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'sliders_dots_size',
			[
				'label'     => __( 'Size', 'dimas' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimas-lookbook-slider-elementor .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'sliders_dots_offset_ver',
			[
				'label'     => esc_html__( 'Spacing Top', 'dimas' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => - 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimas-lookbook-slider-elementor .swiper-pagination' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_popover();

		$this->start_controls_tabs( 'sliders_dots_normal_settings' );

		$this->start_controls_tab( 'sliders_dots_normal', [ 'label' => esc_html__( 'Normal', 'dimas' ) ] );

		$this->add_control(
			'sliders_dots_bgcolor',
			[
				'label'     => esc_html__( 'Background Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-lookbook-slider-elementor .swiper-pagination-bullet:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'sliders_dots_active', [ 'label' => esc_html__( 'Active', 'dimas' ) ] );

		$this->add_control(
			'sliders_dots_ac_bgcolor',
			[
				'label'     => esc_html__( 'Background Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-lookbook-slider-elementor .swiper-pagination-bullet-active:before, {{WRAPPER}} .dimas-lookbook-slider-elementor .swiper-pagination-bullet:hover:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Render icon box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['slides'] ) ) {
			return;
		}

		$nav        = $settings['navigation'];
		$nav_tablet = empty( $settings['navigation_tablet'] ) ? $nav : $settings['navigation_tablet'];
		$nav_mobile = empty( $settings['navigation_mobile'] ) ? $nav : $settings['navigation_mobile'];

		$classes = [
			'dimas-lookbook-slider-elementor swiper-container',
			'dimas-swiper-carousel-elementor',
			'navigation-' . $nav,
			'navigation-tablet-' . $nav_tablet,
			'navigation-mobile-' . $nav_mobile,
		];

		$slides      = [];
		$slide_count = 0;

		foreach ( $settings['slides'] as $slide ) {
			$slide_html       = '';
			$btn_attributes   = '';
			$slide_attributes = '';
			$slide_element    = 'div';
			$btn_element      = 'div';

			$slide_html .= '<div class="dimas-slide-content">';

			if ( $slide['title'] ) {
				$slide_html .= '<div class="dimas-slide-heading">' . $slide['title'] . '</div>';
			}

			// Button
			$link_icon = $slide['show_default_icon'] ? \Dimas\Addons\Helper::get_svg( 'arrow-right', 'dimas-icon' ) : '';

			$button_text = $slide['button_text'] ? sprintf( '<span class="button-text dimas-button">%s %s</span>', $slide['button_text'], $link_icon ) : '';

			$key_btn   = 'btn_' . $slide_count;
			$key_btn_2 = 'btn2_' . $slide_count;

			$btn_full = '';

			if ( $slide['link']['url'] ) :

				$btn_full = $settings['link_type'] == 'all' ? Helper::control_url( $key_btn_2, $slide['link'], '', [ 'class' => 'full-box-button' ] ) : '';

				$button_text = Helper::control_url( $key_btn, $slide['link'], $button_text, [ 'class' => 'button-link' ] );

			endif;

			$slide_html .= $button_text;

			$slide_html .= '</div>';

			$control = apply_filters( 'dimas_slider_section_product_number', 3 );

			for ( $i = 1; $i <= $control; $i ++ ) {

				$product = '';

				$products_html = [];
				$product_id    = $slide["product_lookbooks_ids_$i"];
				$product       = wc_get_product( $product_id );

				if ( empty( $product ) ) {
					continue;
				}

				if ( $product_id ) {
					$products_html[] = sprintf(
						'<div class="product-item">
							<div class="product-image">%s</div>
							<div class="product-summary">
								<h6 class="product-name">%s</h6>
								<div class="product-price">%s</div>
							</div>
							<a class="dimas-slide-button" href="%s"></a>
						</div>',
						$product->get_image( 'single_product_archive_thumbnail_size' ),
						$product->get_name(),
						$product->get_price_html(),
						get_permalink( $product_id )
					);
				}

				$slide_html .= $product_id ? sprintf(
					'<div class="dimas-lookbook-item item-%s">%s</div>',
					esc_attr( $i ),
					implode( '', $products_html )
				) : '';
			}

			$slide_html .= $btn_full;

			$slide_html = '<div class="slick-slide-inner container">' . $slide_html . '</div>';

			$data_lazy_url = $data_lazy_class = '';

			if ( $settings['lazyload'] ) {

				$data_lazy_url   = 'data-background="' . $slide['banner_background_img']['url'] . '"';
				$data_lazy_class = 'swiper-lazy';

			}

			$output_arrow = \Dimas\Addons\Helper::get_svg( 'chevron-left', 'rz-swiper-button-prev rz-swiper-button' );
			$output_arrow .= \Dimas\Addons\Helper::get_svg( 'chevron-right', 'rz-swiper-button-next rz-swiper-button' );

			$slide_other_html = '<div class="slick-slide-block row-flex">';
			$slide_other_html .= '<div class="slick-slide-block__blank col-flex col-flex-md-4"></div>';
			$slide_other_html .= '<div ' . $data_lazy_url . ' class="slick-slide-block__img col-flex col-flex-md-8 ' . $data_lazy_class . '">' . $output_arrow . '</div>';
			$slide_other_html .= $btn_full;
			$slide_other_html .= '</div>';

			$slides[] = '<div class="elementor-repeater-item-' . $slide['_id'] . ' item-slider swiper-slide">' . $slide_html . $slide_other_html . '</div>';

			$slide_count ++;
		}

		$this->add_render_attribute( 'wrapper', 'class', $classes );

		echo sprintf(
			'<div %s>
				<div class="dimas-lookbook-slider-elementor__inner swiper-wrapper">%s</div>
				<div class="swiper-pagination"></div>
			</div>',
			$this->get_render_attribute_string( 'wrapper' ),
			implode( '', $slides )
		);
	}
}