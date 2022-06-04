<?php

namespace Dimas\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Widget_Base;
use Dimas\Addons\Elementor\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Testimonials Grid widget
 */
class Testimonials_Grid extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'dimas-testimonials-grid';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Dimas - Testimonials Grid', 'dimas' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-posts-grid';
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
			'imagesloaded',
			'dimas-masonry',
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
		$this->section_style_content();
	}

	/**
	 * Section Content
	 */
	protected function section_content() {

		// Brands Settings
		$this->start_controls_section(
			'section_blogs',
			[ 'label' => esc_html__( 'Testimonials', 'dimas' ) ]
		);


		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'image',
			[
				'label'   => esc_html__( 'Image', 'dimas' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://via.placeholder.com/100x100/f5f5f5?text=100x100',
				],
			]
		);

		$repeater->add_control(
			'desc',
			[
				'label'   => esc_html__( 'Description', 'dimas' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'This is desc', 'dimas' ),
			]
		);

		$repeater->add_control(
			'rate',
			[
				'label'   => __( 'Rate', 'dimas' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 5,
				'step'    => 1,
				'default' => 5,
			]
		);

		$repeater->add_control(
			'customer',
			[
				'label'   => esc_html__( 'Customer', 'dimas' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Customer Name', 'dimas' ),
			]
		);

		$repeater->add_control(
			'date',
			[
				'label'   => esc_html__( 'Date', 'dimas' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'This is Date', 'dimas' ),
			]
		);


		$this->add_control(
			'elements',
			[
				'label'         => esc_html__( 'Testimonials Lists', 'dimas' ),
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'default'       => [
					[
						'desc' => esc_html__( 'This is the desc', 'dimas' ),
					],
					[
						'desc' => esc_html__( 'This is the desc', 'dimas' ),
					],
					[
						'desc' => esc_html__( 'This is the desc', 'dimas' ),
					],
					[
						'desc' => esc_html__( 'This is the desc', 'dimas' ),
					],
					[
						'desc' => esc_html__( 'This is the desc', 'dimas' ),
					],
					[
						'desc' => esc_html__( 'This is the desc', 'dimas' ),
					]
				],
				'title_field'   => '{{{ customer }}}',
				'prevent_empty' => false
			]
		);

		$this->add_control(
			'columns',
			[
				'label'              => esc_html__( 'Columns', 'dimas' ),
				'type'               => Controls_Manager::NUMBER,
				'min'                => 1,
				'max'                => 8,
				'default'            => 3,
				'separator'          => 'before',
				'frontend_available' => true,
			]
		);

		$this->end_controls_section();
	}

	protected function section_style_content() {

		$this->start_controls_section(
			'section_content_styles',
			[
				'label' => __( 'Content', 'dimas' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'summary_header_padding',
			[
				'label'      => esc_html__( 'Padding', 'dimas' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => [],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .dimas-testimonials-grid' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .dimas-testimonials-grid  .testimonial-item__inner' => 'background-color: {{VALUE}};',
				],
			]
		);


		$this->add_control(
			'content_style_img',
			[
				'label'     => __( 'Image', 'dimas' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'img_border_ra',
			[
				'label'     => esc_html__( 'Border Radius', 'dimas' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimas-testimonials-grid .testi-image img' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_control(
			'content_style_desc',
			[
				'label'     => __( 'Description', 'dimas' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'desc_typography',
				'selector' => '{{WRAPPER}} .dimas-testimonials-grid .testi-desc',
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label'     => __( 'Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-testimonials-grid .testi-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'desc_spacing',
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
					'{{WRAPPER}} .dimas-testimonials-grid .testi-desc' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'content_style_rating',
			[
				'label'     => __( 'Rating', 'dimas' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'rate_spacing',
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
					'{{WRAPPER}} .dimas-testimonials-grid .testi-rate' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'staring_font',
			[
				'label'     => esc_html__( 'Font Size', 'dimas' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 30,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimas-testimonials-grid .dimas-svg-icon' => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'staring_color',
			[
				'label'     => __( 'Normal Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-testimonials-grid .dimas-svg-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'staring_color_ac',
			[
				'label'     => __( 'Active Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-testimonials-grid .dimas-svg-icon.rate-active' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'content_style_meta',
			[
				'label'     => __( 'Meta', 'dimas' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'meta_typography',
				'selector' => '{{WRAPPER}} .dimas-testimonials-grid .testi-meta',
			]
		);

		$this->add_control(
			'meta_color',
			[
				'label'     => __( 'Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-testimonials-grid .testi-meta' => 'color: {{VALUE}};',
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

		$classes = [
			'dimas-testimonials-grid',
		];

		$els         = $settings['elements'];
		$item_lenght = 0;

		if ( ! empty ( $els ) ) {
			foreach ( $els as $index => $item ) {

				$settings['image']      = $item['image'];
				$settings['image_size'] = 'thumbnail';

				$image = Group_Control_Image_Size::get_attachment_image_html( $settings );
				$image = $image ? sprintf( '<div class="testi-image">%s</div>', $image ) : '';

				$desc = $item['desc'] ? sprintf( '<div class="testi-desc">%s</div>', $item['desc'] ) : '';

				$customer  = $item['customer'] ? sprintf( '<span class="testi-customer">%s</span>', $item['customer'] ) : '';
				$date      = $item['date'] ? sprintf( '<span class="testi-date">%s</span>', $item['date'] ) : '';
				$meta_html = $customer == '' && $date == '' ? '' : sprintf( '<div class="testi-meta">%s %s</div>', $customer, $date );

				// rate

				$rate_content = '<div class="testi-rate">';
				for ( $i = 0; $i < 5; $i ++ ) {
					if ( $i < intval( $item['rate'] ) ) {
						$rate_content .= \Dimas\Addons\Helper::get_svg( 'staring', 'rate-active', 'widget' );
					} else {
						$rate_content .= \Dimas\Addons\Helper::get_svg( 'staring', '', 'widget' );
					}
				}
				$rate_content .= '</div>';

				$output_content   = [];
				$output_content[] = '<div class="testimonial-item__inner">';
				$output_content[] = $image;
				$output_content[] = $desc;
				$output_content[] = $rate_content;
				$output_content[] = $meta_html;
				$output_content[] = '</div>';

				$output[] = sprintf( '<div class="testimonial-item">%s</div>', implode( '', $output_content ) );

				$item_lenght ++;
			}

		}

		$this->add_render_attribute( 'wrapper', 'class', $classes );
		$this->add_render_attribute( 'wrapper', 'data-columns', intval( $settings['columns'] ) );

		?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
            <div class="testimonials-wrapper">
				<?php echo implode( '', $output ) ?>
            </div>
        </div>
		<?php

	}
}