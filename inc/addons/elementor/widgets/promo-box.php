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
 * Banner Medium widget
 */
class Promo_Box extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'dimas-promo-box';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Dimas - Promo Box', 'dimas' );
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
			[ 'label' => esc_html__( 'Promo Box', 'dimas' ) ]
		);

		$this->add_control(
			'image',
			[
				'label'   => esc_html__( 'Image', 'dimas' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://via.placeholder.com/1170X600/cccccc?text=Image',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				'default'   => 'full',
			]
		);


		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'dimas' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'This is title', 'dimas' ),
			]
		);

		$this->add_control(
			'description_text',
			[
				'label' => esc_html__( 'Description', 'dimas' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => '',
				'placeholder' => esc_html__( 'Enter your description', 'dimas' ),
				'separator' => 'none',
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'       => esc_html__( 'Button Text', 'dimas' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Button Text', 'dimas' ),
			]
		);

		$this->add_control(
			'show_default_icon',
			[
				'label'     => esc_html__( 'Show Button Icon', 'dimas' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'dimas' ),
				'label_on'  => __( 'On', 'dimas' ),
				'return_value' => 'yes',
				'default'   => 'yes'
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
				'label'       => esc_html__( 'Before Text', 'dimas' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your text', 'dimas' ),
				'label_block' => true,
				'default'     => __( '$99.00', 'dimas' ),
			]
		);

		$this->add_control(
			'sale_price',
			[
				'label'       => esc_html__( 'Text', 'dimas' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your text', 'dimas' ),
				'label_block' => true,
				'default'     => __( '$59.00', 'dimas' ),
			]
		);

		$this->add_control(
			'content_position',
			[
				'label'        => esc_html__( 'Position Content', 'dimas' ),
				'type'         => Controls_Manager::CHOOSE,
				'default'      => 'bottom',
				'options'      => [
					'left'   => [
						'title' => esc_html__( 'Left', 'dimas' ),
						'icon'  => 'eicon-h-align-left',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'dimas' ),
						'icon'  => 'eicon-v-align-bottom',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'dimas' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'prefix_class' => 'dimas-promo-box__content-position--',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'price_box_position',
			[
				'label'     => esc_html__( 'Position Sale', 'dimas' ),
				'type'         => Controls_Manager::CHOOSE,
				'options' => [
					'left'   => [
						'title' => esc_html__( 'Left', 'dimas' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'dimas' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default' => 'left',
				'prefix_class' => 'dimas-promo-box__price-position--',
			]
		);

		$this->add_control(
			'link_type',
			[
				'label'   => esc_html__( 'Link Type', 'dimas' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'only'   => esc_html__( 'Only button text', 'dimas' ),
					'all' 	 => esc_html__( 'All banner', 'dimas' ),
				],
				'default' => 'only',
				'toggle'  => false,

			]
		);

		$this->end_controls_section();
	}

	// Tab Style
	protected function section_style(){
		$this->section_style_banner();
		$this->section_style_content();
		$this->section_style_sale();
	}

	protected function section_style_banner(){
		// Banner
		$this->start_controls_section(
			'section_style_banner',
			[
				'label' => esc_html__( 'Promo Box', 'dimas' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'badge_min_width',
			[
				'label'     => esc_html__( 'Width (%)', 'dimas' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => ['%' ],
				'range'     => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimas-promo-box' => 'width: {{SIZE}}%',
				],
			]
		);

		$this->add_responsive_control(
			'content_margin',
			[
				'label'      => esc_html__( 'Margin', 'dimas' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => [],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .dimas-promo-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function section_style_content() {
		// Content
		$this->start_controls_section(
			'section_content_style',
			[
				'label' => __( 'Content', 'dimas' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'banner_text_align',
			[
				'label'       => esc_html__( 'Vertical Align', 'dimas' ),
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
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}} .dimas-promo-box__content' => 'align-items: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'banner_content_align',
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
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}} .dimas-promo-box__content' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'content_bg_color',
			[
				'label'     => __( 'Background Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-promo-box__content' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => esc_html__( 'Padding', 'dimas' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => [],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .dimas-promo-box__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_spacing_top',
			[
				'label'     => esc_html__( 'Spacing Top', 'dimas' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [],
				'range'     => [
					'px' => [
						'min' => -400,
						'max' => 500,
					],
				],
				'size_units'         => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .dimas-promo-box__content' => 'top: {{SIZE}}{{UNIT}};',
				],
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
						'name' => 'content_position',
						'operator' => '==',
						'value' => 'left',
						],
						[
						'name' => 'content_position',
						'operator' => '==',
						'value' => 'right',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'content_spacing_bottom',
			[
				'label'     => esc_html__( 'Spacing Bottom', 'dimas' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [],
				'range'     => [
					'px' => [
						'min' => -400,
						'max' => 500,
					],
				],
				'size_units'         => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .dimas-promo-box__content' => 'bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_spacing_left',
			[
				'label'     => esc_html__( 'Spacing Left', 'dimas' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [],
				'range'     => [
					'px' => [
						'min' => -400,
						'max' => 500,
					],
				],
				'size_units'         => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .dimas-promo-box__content' => 'left: {{SIZE}}{{UNIT}};',
				],
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
						'name' => 'content_position',
						'operator' => '==',
						'value' => 'left',
						],
						[
						'name' => 'content_position',
						'operator' => '==',
						'value' => 'bottom',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'content_spacing_right',
			[
				'label'     => esc_html__( 'Spacing Right', 'dimas' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [],
				'range'     => [
					'px' => [
						'min' => -400,
						'max' => 500,
					],
				],
				'size_units'         => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .dimas-promo-box__content' => 'right: {{SIZE}}{{UNIT}};',
				],
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
						'name' => 'content_position',
						'operator' => '==',
						'value' => 'bottom',
						],
						[
						'name' => 'content_position',
						'operator' => '==',
						'value' => 'right',
						],
					],
				],
			]
		);

		// Title
		$this->add_control(
			'heading_content_style_title',
			[
				'label' => esc_html__( 'Title', 'dimas' ),
				'type' => Controls_Manager::HEADING,
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
					'{{WRAPPER}} .dimas-promo-box__title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .dimas-promo-box__title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => __( 'Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-promo-box .dimas-promo-box__title' => 'color: {{VALUE}};',
				],
			]
		);

		// Description
		$this->add_control(
			'heading_description',
			[
				'label' => esc_html__( 'Description', 'dimas' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'description_spacing',
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
					'{{WRAPPER}} .dimas-promo-box__description' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .dimas-promo-box__description',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'     => __( 'Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-promo-box .dimas-promo-box__description' => 'color: {{VALUE}};',
				],
			]
		);

		// btn
		$this->add_control(
			'heading_content_btn_style',
			[
				'label' => esc_html__( 'Button', 'dimas' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'note_typography',
				'selector' => '{{WRAPPER}} .dimas-promo-box__button',
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label'     => __( 'Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-promo-box__button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function section_style_sale(){
		$this->start_controls_section(
			'section_style_sale',
			[
				'label' => esc_html__( 'Sale', 'dimas' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'     => esc_html__( 'Before Text', 'dimas' ),
				'name'     => 'regular_typography',
				'selector' => '{{WRAPPER}} .dimas-promo-box__sale .regular-price',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'     => esc_html__( 'Text', 'dimas' ),
				'name'     => 'sale_price_typography',
				'selector' => '{{WRAPPER}} .dimas-promo-box__sale .sale-price',
			]
		);

		$this->add_control(
			'sale_color',
			[
				'label'     => esc_html__( 'Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dimas-promo-box__sale' => 'color: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'sale_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dimas-promo-box__sale' => 'background-color: {{VALUE}}',

				],
			]
		);

		$this->add_responsive_control(
			'price_box_position_top',
			[
				'label'     => esc_html__( 'Spacing Top', 'dimas' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'     => [
					'px' => [
						'max' => 150,
						'min' => 0,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimas-promo-box__sale' => 'top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'price_box_position_left',
			[
				'label'     => esc_html__( 'Spacing Left', 'dimas' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'     => [
					'px' => [
						'max' => 150,
						'min' => 0,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimas-promo-box__sale' => 'left: {{SIZE}}{{UNIT}}',
				],
				'conditions' => [
					'terms' => [
						[
						'name' => 'price_box_position',
						'value' => 'left',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'price_box_position_right',
			[
				'label'     => esc_html__( 'Spacing Right', 'dimas' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'     => [
					'px' => [
						'max' => 150,
						'min' => 0,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimas-promo-box__sale' => 'right: {{SIZE}}{{UNIT}}',
				],
				'conditions' => [
					'terms' => [
						[
						'name' => 'price_box_position',
						'value' => 'right',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'price_box_width',
			[
				'label'     => esc_html__( 'Width (px)', 'dimas' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'     => [
					'px' => [
						'max' => 250,
						'min' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimas-promo-box__sale' => 'width: {{SIZE}}{{UNIT}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'price_box_height',
			[
				'label'     => esc_html__( 'Height (px)', 'dimas' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'     => [
					'px' => [
						'max' => 250,
						'min' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimas-promo-box__sale' => 'height: {{SIZE}}{{UNIT}}',
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
			'dimas-promo-box',
		];

		$this->add_render_attribute( 'wrapper', 'class', $classes );

		$link_icon = $settings['show_default_icon'] ? \Dimas\Addons\Helper::get_svg('arrow-right', 'dimas-icon') : '';

		$button_text = $settings['button_text'] ? sprintf('%s%s',$settings['button_text'], $link_icon) : '';

		$btn_full ='';
		if ( $settings['link']['url'] ) :
			$btn_full = $settings['link_type'] == 'all' ? Helper::control_url( 'btn_full', $settings['link'], '', [ 'class' => 'dimas-promo-box__link' ] ) : '';
			$button_text = Helper::control_url( 'btn', $settings['link'], $button_text, ['class' => 'dimas-promo-box__button dimas-button button-normal'] );
		endif;

		$title = $settings['title'] ? sprintf('<h3 class="dimas-promo-box__title">%s</h3>',$settings['title']) : '';

		$description = $settings['description_text'] ? sprintf('<p class="dimas-promo-box__description">%s</p>',$settings['description_text']) : '';

		// Sale
		$regular_price = $settings['regular_price'] ? sprintf('<div class="regular-price">%s</div>',$settings['regular_price']) : '';
		$sale_price = $settings['sale_price'] ? sprintf('<div class="sale-price">%s</div>',$settings['sale_price']) : '';

		$html_sale =  $regular_price == '' && $sale_price == '' ? '' : sprintf('<div class="dimas-promo-box__sale">%s %s</div>',$regular_price,$sale_price);

		$image = Group_Control_Image_Size::get_attachment_image_html( $settings );
		$image = $image ? sprintf('<div class="dimas-promo-box__image image-zoom">%s</div>',$image) : '';

		$output  = $image;
		$output .= '<div class="dimas-promo-box__content">';
		$output .= $title;
		$output .= $description;
		$output .= $button_text;
		$output .= '</div>';
		$output .= $html_sale;
		$output .= $btn_full;

		echo sprintf(
			'<div %s> %s</div>',
			$this->get_render_attribute_string( 'wrapper' ),
			$output
		);
	}
}
