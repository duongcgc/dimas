<?php

namespace Dimas\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Dimas\Addons\Elementor\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Products Recently Viewed Carousel widget
 */
class Products_Recently_Viewed_Carousel extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'dimas-products-recently-viewed-carousel';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Dimas - Products Recently Viewed Carousel', 'dimas' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-posts-carousel';
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
		$this->section_carousel_style_controls();
	}

	protected function section_products_settings_controls() {
		$this->start_controls_section(
			'section_products',
			[ 'label' => esc_html__( 'Products', 'dimas' ) ]
		);

		$this->add_control(
			'layout',
			[
				'label'   => esc_html__( 'Layout', 'dimas' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'default'      => esc_html__( 'Default', 'dimas' ),
					'effect_hover' => esc_html__( 'Effect Hover', 'dimas' ),
				],
				'default' => 'default',
			]
		);

		$this->add_control(
			'limit',
			[
				'label'   => esc_html__( 'Limit', 'dimas' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 8,
				'min'     => 2,
				'max'     => 50,
				'step'    => 1,
			]
		);

		$this->add_control(
			'load_ajax',
			[
				'label'        => __( 'Load With Ajax', 'dimas' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => __( 'Off', 'dimas' ),
				'label_on'     => __( 'On', 'dimas' ),
				'default'      => '',
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'hide_empty',
			[
				'label'              => __( 'Hide Recently Viewed Empty', 'dimas' ),
				'type'               => Controls_Manager::SWITCHER,
				'label_off'          => __( 'Off', 'dimas' ),
				'label_on'           => __( 'On', 'dimas' ),
				'return_value'       => 'yes',
				'default'            => '',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'section_empty_heading',
			[
				'label'     => esc_html__( 'Empty Product', 'dimas' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'empty_product_description',
			[
				'label'       => esc_html__( 'Description', 'dimas' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter your text', 'dimas' ),
				'label_block' => true,
				'default'     => esc_html__( 'Recently Viewed Products is a function which helps you keep track of your recent viewing history.', 'dimas' ),
			]
		);

		$this->add_control(
			'empty_product_text',
			[
				'label'       => esc_html__( 'Button Text', 'dimas' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your text', 'dimas' ),
				'label_block' => true,
				'default'     => esc_html__( 'Shop Now', 'dimas' ),
			]
		);

		$this->add_control(
			'empty_product_link',
			[
				'label'       => esc_html__( 'Button Link', 'dimas' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'Enter your link', 'dimas' ),
				'label_block' => true,
				'default'     => [
					'url'         => '#',
					'is_external' => false,
					'nofollow'    => false,
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
				'label'              => esc_html__( 'Slides to show', 'dimas' ),
				'type'               => Controls_Manager::NUMBER,
				'min'                => 2,
				'max'                => 10,
				'desktop_default'    => 4,
				'tablet_default'     => 3,
				'mobile_default'     => 2,
				'frontend_available' => true,
			]
		);
		$this->add_responsive_control(
			'slidesToScroll',
			[
				'label'              => esc_html__( 'Slides to scroll', 'dimas' ),
				'type'               => Controls_Manager::NUMBER,
				'min'                => 1,
				'max'                => 7,
				'default'            => 3,
				'frontend_available' => true,
			]
		);
		$this->add_responsive_control(
			'navigation',
			[
				'label'              => esc_html__( 'Navigation', 'dimas' ),
				'type'               => Controls_Manager::SELECT,
				'options'            => [
					'none'      => esc_html__( 'None', 'dimas' ),
					'scrollbar' => esc_html__( 'Scrollbar', 'dimas' ),
					'arrows'    => esc_html__( 'Arrows', 'dimas' ),
					'dots'      => esc_html__( 'Dots', 'dimas' ),
				],
				'default'            => 'arrows',
				'frontend_available' => true,
			]
		);
		$this->add_control(
			'infinite',
			[
				'label'              => __( 'Infinite Loop', 'dimas' ),
				'type'               => Controls_Manager::SWITCHER,
				'label_off'          => __( 'Off', 'dimas' ),
				'label_on'           => __( 'On', 'dimas' ),
				'return_value'       => 'yes',
				'default'            => '',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'              => __( 'Autoplay', 'dimas' ),
				'type'               => Controls_Manager::SWITCHER,
				'label_off'          => __( 'Off', 'dimas' ),
				'label_on'           => __( 'On', 'dimas' ),
				'return_value'       => 'yes',
				'default'            => '',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label'              => __( 'Autoplay Speed (in ms)', 'dimas' ),
				'type'               => Controls_Manager::NUMBER,
				'default'            => 1000,
				'min'                => 100,
				'step'               => 100,
				'frontend_available' => true,
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
				'label'     => __( 'Scrollbar', 'dimas' ),
				'type'      => Controls_Manager::HEADING,
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
					'{{WRAPPER}} .dimas-products-recently-viewed-carousel .swiper-scrollbar' => 'margin-top: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .dimas-products-recently-viewed-carousel .swiper-scrollbar' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .dimas-products-recently-viewed-carousel .swiper-scrollbar-drag' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'carousel_divider',
			[
				'label'     => __( 'Arrows', 'dimas' ),
				'type'      => Controls_Manager::HEADING,
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
					'{{WRAPPER}} .dimas-products-recently-viewed-carousel .rz-swiper-button' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrows_spacing_horizontal',
			[
				'label'      => __( 'Horizontal Position', 'dimas' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .dimas-products-recently-viewed-carousel .rz-swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .dimas-products-recently-viewed-carousel .rz-swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrows_spacing_vertical ',
			[
				'label'      => __( 'Vertical Position', 'dimas' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .dimas-products-recently-viewed-carousel .rz-swiper-button' => 'top: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .dimas-products-recently-viewed-carousel .rz-swiper-button' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .dimas-products-recently-viewed-carousel .rz-swiper-button' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .dimas-products-recently-viewed-carousel .rz-swiper-button:hover' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .dimas-products-recently-viewed-carousel .rz-swiper-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'carousel_style_divider_2',
			[
				'label'     => __( 'Dots', 'dimas' ),
				'type'      => Controls_Manager::HEADING,
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
					'{{WRAPPER}} .dimas-products-recently-viewed-carousel .swiper-pagination .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .dimas-products-recently-viewed-carousel .swiper-pagination .swiper-pagination-bullet:before' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .dimas-products-recently-viewed-carousel .swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active:before, {{WRAPPER}} .dimas-products-recently-viewed-carousel .swiper-pagination .swiper-pagination-bullet:hover:before' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .dimas-products-recently-viewed-carousel .swiper-pagination-bullets .swiper-pagination-bullet' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .dimas-products-recently-viewed-carousel .swiper-pagination' => 'margin-top: {{SIZE}}{{UNIT}};',
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
			'dimas-products-recently-viewed-carousel dimas-swiper-carousel-elementor dimas-swiper-slider-elementor dimas-history-products',
			'navigation-' . $nav,
			'navigation-tablet-' . $nav_tablet,
			'navigation-mobile-' . $nav_mobile,
		];

		$product_ids     = Helper::get_product_recently_viewed_ids();
		if( empty($product_ids) ) {
			$classes[] = $settings['hide_empty'] ? 'hide-empty' : '';
		}

		$classes[] = $settings['load_ajax'] ? 'has-ajax' : 'no-ajax';


		$this->add_render_attribute( 'wrapper', 'class', $classes );

		$atts = array(
			'limit'       => isset( $settings['limit'] ) ? intval( $settings['limit'] ) : '',
			'desc'        => isset( $settings['empty_product_description'] ) ? $settings['empty_product_description'] : '',
			'button_text' => isset( $settings['empty_product_text'] ) ? $settings['empty_product_text'] : '',
			'button_link' => isset( $settings['empty_product_link'] ) ? $settings['empty_product_link'] : '',
			'load_ajax'   => isset( $settings['load_ajax'] ) ? $settings['load_ajax'] : '',
			'layout'      => $settings['layout'],
		);

		$this->add_render_attribute( 'wrapper', 'data-settings', wp_json_encode( $atts ) );

		?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
            <div class="products-content swiper-container">
				<?php
				if ( '' == $settings['load_ajax'] ) {
					Helper::get_recently_viewed_products( $atts );
				} else {
					?>
                    <div class="dimas-posts__loading">
                        <div class="dimas-loading"></div>
                    </div>
					<?php
				}
				?>
            </div>
            <?php if( ! empty($product_ids) ) { ?>
                <?php echo \Dimas\Addons\Helper::get_svg( 'chevron-left', 'rz-swiper-button-prev rz-swiper-button' ); ?>
                <?php echo \Dimas\Addons\Helper::get_svg( 'chevron-right', 'rz-swiper-button-next rz-swiper-button' ); ?>
                <div class="swiper-pagination"></div>
                <div class="swiper-scrollbar"></div>
			<?php } ?>
        </div>
		<?php
	}
}
