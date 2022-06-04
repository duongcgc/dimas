<?php

namespace Dimas\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Brands widget
 */
class Brands_Grid extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'dimas-brands-grid';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Dimas - Brands Grid', 'dimas' );
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

	/**
	 * Section Content
	 */
	protected function section_content() {

		// Brands Settings
		$this->start_controls_section(
			'section_blogs',
			[ 'label' => esc_html__( 'Content', 'dimas' ) ]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'   => esc_html__( 'Columns', 'dimas' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 6,
				'default' => 6,
				'tablet_default' => 3,
				'mobile_default' => 2,
				'separator' => 'before',
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
			'limit',
			[
				'label'     => esc_html__( 'Total', 'dimas' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 8,
				'min'       => 2,
				'max'       => 50,
				'step'      => 1,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'      => esc_html__( 'Order By', 'dimas' ),
				'type'       => Controls_Manager::SELECT,
				'options'    => [
					'date'       => esc_html__( 'Date', 'dimas' ),
					'count'      => esc_html__( 'Count', 'dimas' ),
					'name'       => esc_html__( 'Name', 'dimas' ),
					'id'         => esc_html__( 'Ids', 'dimas' ),
					'menu_order' => esc_html__( 'Menu Order', 'dimas' ),
				],
				'default'    => 'date',
			]
		);

		$this->add_control(
			'order',
			[
				'label'      => esc_html__( 'Order', 'dimas' ),
				'type'       => Controls_Manager::SELECT,
				'options'    => [
					''     => esc_html__( 'Default', 'dimas' ),
					'ASC'  => esc_html__( 'Ascending', 'dimas' ),
					'DESC' => esc_html__( 'Descending', 'dimas' ),
				],
				'default'    => '',
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'orderby',
							'operator' => '!=',
							'value' => 'menu_order',
						],
					],
				],

			]
		);


		$this->end_controls_section();
	}

	/**
	 * Section Style
	 */
	protected function section_style() {

		$this->start_controls_section(
			'section_content_styles',
			[
				'label' => __( 'Brands', 'dimas' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'items_spacing',
			[
				'label'      => __( 'Padding', 'dimas' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .dimas-brands-grid .brand-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .dimas-brands-grid.dimas-brands-grid__border-none .list-brands' => 'margin-left: -{{LEFT}}{{UNIT}}; margin-right: -{{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'item_min_height',
			[
				'label'     => esc_html__( 'Min Height', 'dimas' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 250,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimas-brands-grid .brand-item a' => 'min-height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'items_background',
			[
				'label'     => __( 'Background Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-brands-grid .brand-item a' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .dimas-brands-grid .brand-item' => 'border-style: {{VALUE}};',
					'{{WRAPPER}} .dimas-brands-grid .list-brands' => 'border-style: {{VALUE}};',
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
					'{{WRAPPER}} .dimas-brands-grid .brand-item' => 'border-width: 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0;',
					'{{WRAPPER}} .dimas-brands-grid .list-brands' => 'border-width: {{SIZE}}{{UNIT}} 0 0 {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .dimas-brands-grid .brand-item' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .dimas-brands-grid .list-brands' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_popover();

		$this->add_control(
			'show_box_shadow',
			[
				'label'        => esc_html__( 'Show Box Shadow', 'dimas' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => __( 'Off', 'dimas' ),
				'label_on'     => __( 'On', 'dimas' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'prefix_class' => 'dimas-brands-grid-box-shadow-'
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
			'dimas-brands-grid',
			$settings['content_border_style'] == 'none' ? 'dimas-brands-grid__border-none' : ''
		];

		$atts = [
			'taxonomy'   	=> 'product_brand',
			'hide_empty' 	=> 1,
			'number'     	=> $settings['limit'],
			'orderby'     	=> $settings['orderby']
		];

		$atts['menu_order'] = false;

		if ( $settings['orderby'] == 'menu_order' ) {
			$atts['menu_order'] = 'asc';
		} elseif ($settings['order'] != ''){
			$atts['order'] = $settings['order'];
		}

		$columns = isset( $settings['columns'] ) ? $settings['columns'] : '6';
		$columns_tablet = isset( $settings['columns_tablet'] ) && ! empty( $settings['columns_tablet'] ) ? $settings['columns_tablet'] : $settings['columns'];
		$columns_mobile = isset( $settings['columns_mobile'] ) && ! empty( $settings['columns_mobile'] ) ? $settings['columns_mobile'] : $settings['columns'];

		$add_col_class = $columns != '5' ? 'col-flex-md-'.(12/$columns) : 'col-flex-md-1-5';
		$add_col_class .= $columns_tablet != '5' ? ' col-flex-sm-'.(12/$columns_tablet) : ' col-flex-sm-1-5';
		$add_col_class .= $columns_mobile != '5' ? ' col-flex-xs-'.(12/$columns_mobile) : ' col-flex-xs-1-5';


		$terms   = get_terms( $atts );

		$output  = array();

		if ( is_wp_error( $terms ) ) {
			return;
		}

		if ( empty( $terms ) || ! is_array( $terms ) ) {
			return;
		}

		foreach ( $terms as $term ) {

			$thumbnail_id = absint( get_term_meta( $term->term_id, 'brand_thumbnail_id', true ) );

			if ( $thumbnail_id ) {

				$settings['image'] = array(
					'url' => wp_get_attachment_image_src( $thumbnail_id )[0],
					'id'  => $thumbnail_id
				);

				$html = Group_Control_Image_Size::get_attachment_image_html( $settings );

			} else {
				$html = $term->name;
			}

			$output[] = sprintf(
				'<div class="brand-item %s">' .
				'<a href="%s">%s</a>' .
				'</div>',
				esc_attr($add_col_class),
				esc_url(get_term_link( $term->term_id, 'product_brand' )),
			 	$html
			);
		}


		$this->add_render_attribute('wrapper', 'class', $classes );

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div class="list-brands" >
				<?php echo implode('', $output ) ?>
			</div>
		</div>
		<?php

	}
}
