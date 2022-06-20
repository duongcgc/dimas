<?php

namespace Dimas\Addons\Elementor\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Controls_Stack ;
use Dimas\Addons\Elementor\Helper;

/**
 * Elementor isolate slider widget.
 *
 * Elementor widget that displays an eye-catching headlines.
 *
 * @since 1.0.0
 */
class Isolate_Slider extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve isolate slider widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'dimas-isolate-slides';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve isolate slider widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Dimas - Isolate Slider', 'dimas' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve isolate slider widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-post-slider';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the isolate slider widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'dimas' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'isolate', 'slider' ];
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

		$repeater->start_controls_tab( 'background', [ 'label' => esc_html__( 'Background', 'dimas' ) ] );

		$repeater->add_responsive_control(
			'banner_background_img',
			[
				'label'    => __( 'Background Slider', 'dimas' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://via.placeholder.com/768X535/cccccc?text=768x535',
				],
				'selectors' => [
					'{{WRAPPER}} .dimas-isolate-slides {{CURRENT_ITEM}}:not(.swiper-lazy) .dimas-isolate-slides__image' => 'background-image: url("{{URL}}");',
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
					'{{WRAPPER}} .dimas-isolate-slides {{CURRENT_ITEM}} .dimas-isolate-slides__image' => 'background-size: {{VALUE}}',
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
					'{{WRAPPER}} .dimas-isolate-slides {{CURRENT_ITEM}} .dimas-isolate-slides__image' => 'background-position: {{VALUE}};',
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
					'{{WRAPPER}} .dimas-isolate-slides {{CURRENT_ITEM}} .dimas-isolate-slides__image' => 'background-position: {{LEFT}}{{UNIT}} {{TOP}}{{UNIT}};',
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

		$repeater->add_responsive_control(
			'banner_background_content',
			[
				'label'    => __( 'Background Content', 'dimas' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [],
				'selectors' => [
					'{{WRAPPER}} .dimas-isolate-slides {{CURRENT_ITEM}} .dimas-isolate-slides__wrapper' => 'background-image: url("{{URL}}");',
				],
				'separator'    => 'before',
			]
		);

		$repeater->add_responsive_control(
			'background_size_content',
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
					'{{WRAPPER}} .dimas-isolate-slides {{CURRENT_ITEM}} .dimas-isolate-slides__wrapper' => 'background-size: {{VALUE}}',
				],
				'condition' => [
					'banner_background_content[url]!' => '',
				],
			]
		);

		$repeater->add_responsive_control(
			'background_position_content',
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
					'{{WRAPPER}} .dimas-isolate-slides {{CURRENT_ITEM}} .dimas-isolate-slides__wrapper' => 'background-position: {{VALUE}};',
				],
				'condition' => [
					'banner_background_content[url]!' => '',
				],

			]
		);

		$repeater->add_responsive_control(
			'background_position_xy_content',
			[
				'label'              => esc_html__( 'Custom Background Position', 'dimas' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'allowed_dimensions' => [ 'top', 'left' ],
				'size_units'         => [ 'px', '%' ],
				'default'            => [ ],
				'selectors'          => [
					'{{WRAPPER}} .dimas-isolate-slides {{CURRENT_ITEM}} .dimas-isolate-slides__wrapper' => 'background-position: {{LEFT}}{{UNIT}} {{TOP}}{{UNIT}};',
				],
				'condition' => [
					'background_position_content' => [ 'initial' ],
					'banner_background_content[url]!' => '',
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

		$repeater->add_responsive_control(
			'banner_background_title',
			[
				'label'    => __( 'Background Title', 'dimas' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [],
				'selectors' => [
					'{{WRAPPER}} .dimas-isolate-slides {{CURRENT_ITEM}} .dimas-isolate-slides__title' => 'background-image: url("{{URL}}");',
				],
				'separator'    => 'before',
			]
		);

		$repeater->add_responsive_control(
			'background_size_title',
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
					'{{WRAPPER}} .dimas-isolate-slides {{CURRENT_ITEM}} .dimas-isolate-slides__title' => 'background-size: {{VALUE}}',
				],
				'condition' => [
					'banner_background_title[url]!' => '',
				],
			]
		);

		$repeater->add_responsive_control(
			'background_position_title',
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
					'{{WRAPPER}} .dimas-isolate-slides {{CURRENT_ITEM}} .dimas-isolate-slides__title' => 'background-position: {{VALUE}};',
				],
				'condition' => [
					'banner_background_title[url]!' => '',
				],

			]
		);

		$repeater->add_responsive_control(
			'background_position_xy_title',
			[
				'label'              => esc_html__( 'Custom Background Position', 'dimas' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'allowed_dimensions' => [ 'top', 'left' ],
				'size_units'         => [ 'px', '%' ],
				'default'            => [ ],
				'selectors'          => [
					'{{WRAPPER}} .dimas-isolate-slides {{CURRENT_ITEM}} .dimas-isolate-slides__title' => 'background-position: {{LEFT}}{{UNIT}} {{TOP}}{{UNIT}};',
				],
				'condition' => [
					'background_position_title' => [ 'initial' ],
					'banner_background_title[url]!' => '',
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

		$repeater->end_controls_tab();

		$repeater->start_controls_tab( 'text_content', [ 'label' => esc_html__( 'Content', 'dimas' ) ] );

		$repeater->add_control(
			'before_title',
			[
				'label'       => esc_html__( 'Before Title', 'dimas' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Before Title', 'dimas' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'dimas' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Title', 'dimas' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'after_title',
			[
				'label'       => esc_html__( 'After Title', 'dimas' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'After Title', 'dimas' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'description',
			[
				'label'   => esc_html__( 'Description', 'dimas' ),
				'type'    => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'I am slide content. Click edit button to change this text. ', 'dimas' ),
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
				'label'       => esc_html__( 'Button Link', 'dimas' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'dimas' ),
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'slides',
			[
				'label'      => esc_html__( 'Slides', 'dimas' ),
				'type'       => Controls_Manager::REPEATER,
				'show_label' => true,
				'fields'     => $repeater->get_controls(),
				'default'    => [
					[
						'title'            => esc_html__( 'Slide 1 Heading', 'dimas' ),
						'description'      => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'dimas' ),
					],
					[
						'title'            => esc_html__( 'Slide 2 Heading', 'dimas' ),
						'description'      => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'dimas' ),
					],
					[
						'title'            => esc_html__( 'Slide 3 Heading', 'dimas' ),
						'description'      => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'dimas' ),
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
					'size' => 535,
				],
				'size_units' => [ 'px', 'vh', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .dimas-isolate-slides .item-slider' => 'height: {{SIZE}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'lazyload',
			[
				'label'     => esc_html__( 'Show Lazyload', 'dimas' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'dimas' ),
				'label_on'  => __( 'On', 'dimas' ),
				'return_value' => 'yes',
				'default'   => '',
				'frontend_available' => true,
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
				'label'   => esc_html__( 'Effect', 'dimas' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'fade'   	 => esc_html__( 'Fade', 'dimas' ),
					'slide' 	 => esc_html__( 'Slide', 'dimas' ),
					'cube' 	 	 => esc_html__( 'Cube', 'dimas' ),
					'coverflow'	 => esc_html__( 'Coverflow', 'dimas' ),
				],
				'default' => 'fade',
				'toggle'  => false,
				'frontend_available' => true,
			]
		);

		$this->add_responsive_control(
			'navigation',
			[
				'label'     => esc_html__( 'Navigation', 'dimas' ),
				'type'      => Controls_Manager::SELECT,
				'options' => [
					'none'   => esc_html__( 'None', 'dimas' ),
					'arrows' => esc_html__( 'Arrows', 'dimas' ),
					'dots' 	 => esc_html__( 'Dots', 'dimas' ),
				],
				'default' => 'dots',
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'   => esc_html__( 'Autoplay', 'dimas' ),
				'type'    => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'dimas' ),
				'label_off'    => __( 'No', 'dimas' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'delay',
			[
				'label'     => esc_html__( 'Delay', 'dimas' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 3000,
				'description' => esc_html__('Delay between transitions (in ms). If this parameter is not specified, auto play will be disabled', 'dimas'),
				'conditions' => [
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
				'label'     => esc_html__( 'Autoplay Speed', 'dimas' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 1000,
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'infinite',
			[
				'label'   => esc_html__( 'Infinite Loop', 'dimas' ),
				'type'    => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'dimas' ),
				'label_off'    => __( 'No', 'dimas' ),
				'return_value' => 'yes',
				'default'      => '',
				'frontend_available' => true,
			]
		);

		$this->end_controls_section();

	}

	// Tab Style
	protected function section_style() {
		$this->section_style_content();
		$this->section_style_carousel();
	}

	protected function section_style_content() {
		$this->start_controls_section(
			'section_style_content',
			[
				'label' => esc_html__( 'Content', 'dimas' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'slides_vertical_position',
			[
				'label'        => esc_html__( 'Vertical Position', 'dimas' ),
				'type'         => Controls_Manager::CHOOSE,
				'label_block'  => false,
				'default'      => 'center',
				'options'      => [
					'flex-start'    => [
						'title' => esc_html__( 'Top', 'dimas' ),
						'icon'  => 'eicon-v-align-top',
					],
					'center' => [
						'title' => esc_html__( 'Middle', 'dimas' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'flex-end' => [
						'title' => esc_html__( 'Bottom', 'dimas' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'selectors'   => [
					'{{WRAPPER}} .dimas-isolate-slides__wrapper' => 'align-items: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'slides_text_align',
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
				'default'     => 'center',
				'selectors'   => [
					'{{WRAPPER}} .dimas-isolate-slides__wrapper' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'content_width',
			[
				'label'     => esc_html__( 'Content Width', 'dimas' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' 	=> [],
				'selectors' => [
					'{{WRAPPER}} .dimas-isolate-slides__wrapper' => 'flex: 1 1 {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .dimas-isolate-slides__image' => 'flex: 1 1 calc( 100% - {{SIZE}}{{UNIT}} )',
				],
			]
		);

		$this->add_responsive_control(
			'content_bg_color',
			[
				'label'     => __( 'Background Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-isolate-slides__wrapper:before' => 'background-color: {{VALUE}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'slides_padding',
			[
				'label'      => esc_html__( 'Padding', 'dimas' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .dimas-isolate-slides__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .dimas-isolate-slides__wrapper:before' => 'top: {{TOP}}{{UNIT}}; left: {{LEFT}}{{UNIT}}; width: calc( 100% - ( {{RIGHT}}{{UNIT}} + {{LEFT}}{{UNIT}} ) ); height: calc( 100% - ( {{TOP}}{{UNIT}} + {{BOTTOM}}{{UNIT}} ) );',
				],
			]
		);

		$this->add_control(
			'content_before_title',
			[
				'label'     => esc_html__( 'Before Title', 'dimas' ),
				'type'      => Controls_Manager::HEADING,
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'content_before_title_color',
			[
				'label'     => esc_html__( 'Text Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dimas-isolate-slides__before-title' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'content_before_title_typography',
				'selector' => '{{WRAPPER}} .dimas-isolate-slides__before-title',
			]
		);

		$this->add_responsive_control(
			'content_before_title_spacing',
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
					'{{WRAPPER}} .dimas-isolate-slides__before-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'content_title',
			[
				'label'     => esc_html__( 'Title', 'dimas' ),
				'type'      => Controls_Manager::HEADING,
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'content_title_color',
			[
				'label'     => esc_html__( 'Text Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dimas-isolate-slides__title' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'content_title_typography',
				'selector' => '{{WRAPPER}} .dimas-isolate-slides__title',
			]
		);

		$this->add_responsive_control(
			'content_title_spacing',
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
					'{{WRAPPER}} .dimas-isolate-slides__title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'content_after_title',
			[
				'label'     => esc_html__( 'After Title', 'dimas' ),
				'type'      => Controls_Manager::HEADING,
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'content_after_title_color',
			[
				'label'     => esc_html__( 'Text Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dimas-isolate-slides__after-title' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'content_after_title_typography',
				'selector' => '{{WRAPPER}} .dimas-isolate-slides__after-title',
			]
		);

		$this->add_responsive_control(
			'content_after_title_spacing',
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
					'{{WRAPPER}} .dimas-isolate-slides__after-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'content_description',
			[
				'label'     => esc_html__( 'Description', 'dimas' ),
				'type'      => Controls_Manager::HEADING,
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'content_description_color',
			[
				'label'     => esc_html__( 'Text Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dimas-isolate-slides__description' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'content_description_typography',
				'selector' => '{{WRAPPER}} .dimas-isolate-slides__description',
			]
		);

		$this->add_control(
			'content_buton',
			[
				'label'     => esc_html__( 'Button', 'dimas' ),
				'type'      => Controls_Manager::HEADING,
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'btn_padding',
			[
				'label'      => esc_html__( 'Padding', 'dimas' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .dimas-isolate-slides__button .button-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'btn_typography',
				'selector' => '{{WRAPPER}} .dimas-isolate-slides__button .button-text',
			]
		);

		$this->add_control(
			'btn_color',
			[
				'label'      => esc_html__( 'Color', 'dimas' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .dimas-isolate-slides__button .button-text' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'btn_bgcolor',
			[
				'label'      => esc_html__( 'Background Color', 'dimas' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .dimas-isolate-slides__button .button-text' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'border_style',
			[
				'label'        => __( 'Border', 'dimas' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'dimas' ),
				'label_on'     => __( 'Custom', 'dimas' ),
				'return_value' => 'yes',
			]
		);
		$this->start_popover();

		$this->add_control(
			'content_border_style',
			[
				'label'     => esc_html__( 'Border Style', 'dimas' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'dotted' => esc_html__( 'Dotted', 'dimas' ),
					'dashed' => esc_html__( 'Dashed', 'dimas' ),
					'solid'  => esc_html__( 'Solid', 'dimas' ),
					'none'   => esc_html__( 'None', 'dimas' ),
				],
				'default'   => '',
				'toggle'    => false,
				'selectors' => [
					'{{WRAPPER}} .dimas-isolate-slides__button .button-text' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_border_width',
			[
				'label'     => __( 'Border Width', 'dimas' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 7,
						'min' => 0,
					],
				],
				'default'   => [ ],
				'selectors' => [
					'{{WRAPPER}} .dimas-isolate-slides__button .button-text' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'content_border_color',
			[
				'label'     => __( 'Border Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-isolate-slides__button .button-text' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_popover();

		$this->end_controls_section();

	}

	protected function section_style_carousel() {
		// Arrows
		$this->start_controls_section(
			'section_style_arrows',
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
				'separator' => 'before',
			]
		);

		$this->add_control(
			'arrows_style',
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
					'{{WRAPPER}} .dimas-isolate-slides .rz-swiper-button' => 'font-size: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .dimas-isolate-slides .rz-swiper-button' => 'width: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .dimas-isolate-slides .rz-swiper-button' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrows_spacing',
			[
				'label'      => esc_html__( 'Horizontal Position', 'dimas' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => -100,
						'max' => 200,
					],
				],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .dimas-isolate-slides .rz-swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .dimas-isolate-slides .rz-swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrows_spacing_vertical',
			[
				'label'      => esc_html__( 'Vertical Position', 'dimas' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => -100,
						'max' => 200,
					],
				],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .dimas-isolate-slides .rz-swiper-button-prev' => 'top: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .dimas-isolate-slides .rz-swiper-button-next' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_popover();

		$this->start_controls_tabs( 'sliders_normal_settings' );

		$this->start_controls_tab( 'sliders_normal', [ 'label' => esc_html__( 'Normal', 'dimas' ) ] );

		$this->add_control(
			'sliders_arrow_color',
			[
				'label'     => esc_html__( 'Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-isolate-slides .rz-swiper-button' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .dimas-isolate-slides .rz-swiper-button' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .dimas-isolate-slides .rz-swiper-button:hover' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .dimas-isolate-slides .rz-swiper-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->add_control(
			'sliders_arrow_border',
			[
				'label'        => __( 'Border', 'dimas' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'dimas' ),
				'label_on'     => __( 'Custom', 'dimas' ),
				'return_value' => 'yes',
			]
		);
		$this->start_popover();

		$this->add_control(
			'arrow_border_style',
			[
				'label'     => esc_html__( 'Border Style', 'dimas' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'dotted' => esc_html__( 'Dotted', 'dimas' ),
					'dashed' => esc_html__( 'Dashed', 'dimas' ),
					'solid'  => esc_html__( 'Solid', 'dimas' ),
					'none'   => esc_html__( 'None', 'dimas' ),
				],
				'default'   => '',
				'toggle'    => false,
				'selectors' => [
					'{{WRAPPER}} .dimas-isolate-slides .rz-swiper-button' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrow_border_width',
			[
				'label'     => __( 'Border Width', 'dimas' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 7,
						'min' => 0,
					],
				],
				'default'   => [ ],
				'selectors' => [
					'{{WRAPPER}} .dimas-isolate-slides .rz-swiper-button' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'arrow_content_border_color',
			[
				'label'     => __( 'Border Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-isolate-slides .rz-swiper-button' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_popover();

		$this->end_controls_tabs();

		// Dots
		$this->add_control(
			'dots_style_heading',
			[
				'label' => esc_html__( 'Dots', 'dimas' ),
				'type'  => Controls_Manager::HEADING,
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
			'sliders_dots_position',
			[
				'label'     => esc_html__( 'Position', 'dimas' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'right' => esc_html__( 'Right', 'dimas' ),
					'bottom' => esc_html__( 'Bottom', 'dimas' ),
				],
				'default'   => 'right',
				'toggle'    => false,
			]
		);

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
					'{{WRAPPER}} .dimas-isolate-slides .swiper-pagination-bullet' => 'margin: {{SIZE}}{{UNIT}} 0',
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
					'{{WRAPPER}} .dimas-isolate-slides .swiper-pagination-bullet:before' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'sliders_dots_offset_ver',
			[
				'label'     => esc_html__( 'Spacing', 'dimas' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => -100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimas-isolate-slides.dots-position-right .swiper-pagination,
					{{WRAPPER}} .dimas-isolate-slides.dots-position-tablet-right .swiper-pagination,
					{{WRAPPER}} .dimas-isolate-slides.dots-position-mobile-right .swiper-pagination' => 'right: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .dimas-isolate-slides.dots-position-bottom .swiper-pagination,
					{{WRAPPER}} .dimas-isolate-slides.dots-position-tablet-bottom .swiper-pagination,
					{{WRAPPER}} .dimas-isolate-slides.dots-position-mobile-bottom .swiper-pagination' => 'bottom: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .dimas-isolate-slides .swiper-pagination-bullet:before' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .dimas-isolate-slides .swiper-pagination-bullet-active:before, {{WRAPPER}} .dimas-isolate-slides .swiper-pagination-bullet:hover:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Render isolate slider widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['slides'] ) ) {
			return;
		}

		$nav        = $settings['navigation'];
		$nav_tablet = empty( $settings['navigation_tablet'] ) ? $nav : $settings['navigation_tablet'];
		$nav_mobile = empty( $settings['navigation_mobile'] ) ? $nav : $settings['navigation_mobile'];

		$dots_position  = $settings['sliders_dots_position'];
		$dots_tablet 	= empty( $settings['sliders_dots_position_tablet'] ) ? $dots_position : $settings['sliders_dots_position_tablet'];
		$dots_mobile 	= empty( $settings['sliders_dots_position_mobile'] ) ? $dots_position : $settings['sliders_dots_position_mobile'];

		$classes = [
			'dimas-isolate-slides',
			'dimas-swiper-carousel-elementor',
			'dimas-swiper-slider-elementor',
			'navigation-' . $nav,
			'navigation-tablet-' . $nav_tablet,
			'navigation-mobile-' . $nav_mobile,
			'dots-position-' . $dots_position,
			'dots-position-tablet-' . $dots_tablet,
			'dots-position-mobile-' . $dots_mobile,
		];

		$slides      = [];
		$slide_count = 0;

		foreach ( $settings['slides'] as $slide ) {
			$slide_html       = '';

			$slide_html .= '<div class="dimas-isolate-slides__wrapper">';
			$slide_html .= '<div class="dimas-isolate-slides__content">';

			if ( $slide['before_title'] ) {
				$slide_html .= '<div class="dimas-isolate-slides__before-title">' . $slide['before_title'] . '</div>';
			}

			if ( $slide['title'] ) {
				$img_active = $slide['banner_background_title']['url'] != '' ? 'has-background' : '';
				$slide_html .= '<div class="dimas-isolate-slides__title '. esc_attr( $img_active ) .'">' . $slide['title'] . '</div>';
			}

			if ( $slide['after_title'] ) {
				$slide_html .= '<div class="dimas-isolate-slides__after-title">' . $slide['after_title'] . '</div>';
			}

			if ( $slide['description'] ) {
				$slide_html .= '<div class="dimas-isolate-slides__description">' . $slide['description'] . '</div>';
			}

			// Button
			$button_text = $slide['button_text'] ? sprintf('<span class="button-text dimas-button">%s %s</span>', $slide['button_text'], \Dimas\Addons\Helper::get_svg('arrow-right', 'dimas-icon') ) : '';

			$key_btn = 'btn_' . $slide_count;

			$button_text = $slide['link']['url'] ? Helper::control_url( $key_btn, $slide['link'], $button_text, ['class' => 'button-link'] ) : $button_text;

			$slide_html .= '<div class="dimas-isolate-slides__button">';
			if ( $slide['button_text'] ) {
				$slide_html .= $button_text;
			}

			$slide_html .= '</div>';
			$slide_html .= '</div>';

			$slide_html .= '</div>';

			if ( $slide['banner_background_img'] ) {
				$slide_html .= '<div class="dimas-isolate-slides__image"></div>';
			}

			$slide_html = '<div class="slick-slide-inner">' . $slide_html . '</div>';

			$data_lazy_url = $data_lazy_class = $data_lazy_loading = '';

			if ($settings['lazyload'] ) {

				$data_lazy_url = 'data-background="'.$slide['banner_background_img']['url'].'"';
				$data_lazy_loading =  '	<div class="swiper-lazy-preloader"></div>';
				$data_lazy_class = 'swiper-lazy';

			}

			$slides[]   = '<div '. $data_lazy_url .' class="elementor-repeater-item-' . $slide['_id'] . ' item-slider swiper-slide '.$data_lazy_class.'">' . $slide_html . $data_lazy_loading .'</div>';

			$slide_count ++;
		}

		if ($slide_count > 1) {
			$output_pagination	=  \Dimas\Addons\Helper::get_svg('chevron-left','rz-swiper-button-prev rz-swiper-button');
			$output_pagination .= \Dimas\Addons\Helper::get_svg('chevron-right','rz-swiper-button-next rz-swiper-button');
			$output_pagination .= '<div class="swiper-pagination container"></div>';
		} else {
			$output_pagination = '';
		}

		$this->add_render_attribute( 'wrapper', 'class', $classes );

		echo sprintf(
			'<div %s>
				<div class="dimas-isolate-slides__content-wrapper swiper-container">
					<div class="dimas-isolate-slides__inner swiper-wrapper">%s</div>
				</div>
				%s
			</div>',
			$this->get_render_attribute_string( 'wrapper' ),
			implode( '', $slides ),
			$output_pagination
		);
	}
}
