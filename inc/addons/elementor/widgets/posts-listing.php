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
 * Posts widget
 */
class Posts_Listing extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'dimas-posts-listing';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Dimas - Posts Listing', 'dimas' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-post-list';
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
	 * Section Content
	 */
	protected function section_content() {
		$this->posts_settings_controls();
	}

	protected function posts_settings_controls() {

		// Brands Settings
		$this->start_controls_section(
			'section_blogs',
			[ 'label' => esc_html__( 'Posts', 'dimas' ) ]
		);

		$this->add_control(
			'blog_cats',
			[
				'label'       => esc_html__( 'Categories', 'dimas' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => Helper::taxonomy_list( 'category' ),
				'default'     => '',
				'multiple'    => true,
				'label_block' => true,
			]
		);

		$this->add_control(
			'limit',
			[
				'label'   => esc_html__( 'Total', 'dimas' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 8,
				'min'     => 2,
				'max'     => 50,
				'step'    => 1,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'   => esc_html__( 'Order By', 'dimas' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'date' => esc_html__( 'Date', 'dimas' ),
					'name' => esc_html__( 'Name', 'dimas' ),
					'id'   => esc_html__( 'Ids', 'dimas' ),
					'rand' => esc_html__( 'Random', 'dimas' ),
				],
				'default' => 'date',
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Order', 'dimas' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''     => esc_html__( 'Default', 'dimas' ),
					'ASC'  => esc_html__( 'Ascending', 'dimas' ),
					'DESC' => esc_html__( 'Descending', 'dimas' ),
				],
				'default' => '',
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				'default'   => 'full',
				'separator' => 'before',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Section Style
	 */
	protected function section_style() {
		$this->section_content_style();
	}

	/**
	 * Element in Tab Style
	 *
	 * Title
	 */
	protected function section_content_style() {
		// Content
		$this->start_controls_section(
			'section_content_style',
			[
				'label' => __( 'Content', 'dimas' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_style_img',
			[
				'label' => __( 'Image', 'dimas' ),
				'type'      => Controls_Manager::HEADING,
			]
		);

		$this->add_responsive_control(
			'img_spacing',
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
					'{{WRAPPER}} .dimas-posts-listing .entry-header' => 'margin-right: {{SIZE}}{{UNIT}}',
				],
			]
		);


		// Title
		$this->add_control(
			'content_style_title',
			[
				'label' => __( 'Title', 'dimas' ),
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
					'{{WRAPPER}} .dimas-posts-listing .entry-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .dimas-posts-listing .entry-title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => __( 'Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-posts-listing .entry-title a' => 'color: {{VALUE}};',
				],
			]
		);


		$this->add_control(
			'content_style_desc',
			[
				'label' => __( 'Desc', 'dimas' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
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
					'{{WRAPPER}} .dimas-posts-listing .entry-content' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'desc_typography',
				'selector' => '{{WRAPPER}} .dimas-posts-listing .entry-content',
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label'     => __( 'Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-posts-listing .entry-content' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'content_style_button_2',
			[
				'label' => __( 'Button', 'dimas' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'btn_display',
			[
				'label'     => __( 'Display', 'farmart' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'farmart' ),
				'label_on'  => __( 'Show', 'farmart' ),
				'default'   => 'yes',
				'selectors_dictionary' => [
					'' => 'display: none',
				],
				'selectors' => [
					'{{WRAPPER}} .dimas-posts-listing .dimas-button' => '{{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'btn_2_typography',
				'selector' => '{{WRAPPER}} .dimas-posts-listing .dimas-button',
			]
		);


		$this->add_control(
			'btn_2_color',
			[
				'label'     => __( 'Color', 'dimas' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimas-posts-listing .dimas-button' => 'color: {{VALUE}};',
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
			'dimas-posts-listing',
		];

		$atts = [
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
			'posts_per_page'      => $settings['limit'],
			'orderby'             => $settings['orderby']
		];

		if ( $settings['order'] != '' ) {
			$atts['order'] = $settings['order'];
		}

		if ( ! empty( $settings['blog_cats'] ) ) {
			$atts['tax_query'] = array(
				'relation' => 'OR',
				array(
					'taxonomy' => 'category',
					'field'    => 'slug',
					'terms'    => $settings['blog_cats'],
					'operator' => 'IN',
				),
			);
		}

		$query = new \WP_Query( $atts );
		$html  = array();

		$index = 0;
		while ( $query->have_posts() ) : $query->the_post();

			$post_url = array();

			$post_url['url']         = esc_url( get_permalink() );
			$post_url['is_external'] = $post_url['nofollow'] = '';

			$key_img = 'img_' . $index;

			$post_thumbnail_id = get_post_thumbnail_id( get_the_ID() );
			$image             = '';

			if ( $post_thumbnail_id ) {

				$image_src = wp_get_attachment_image_src( $post_thumbnail_id );

				$settings['image'] = array(
					'url' => $image_src ? $image_src[0] : '',
					'id'  => $post_thumbnail_id
				);

				$image = Helper::control_url( $key_img, $post_url, Group_Control_Image_Size::get_attachment_image_html( $settings ), [ 'class' => 'post-thumbnail' ] );

			}

			$day   = '<span class="field-day">' . esc_html( get_the_date( "d" ) ) . '</span>';
			$month = '<span class="field-month">' . esc_html( get_the_date( "M" ) ) . '</span>';

			$date_html = sprintf( '<div class="blog-date">%s %s</div>', $month, $day );

			$html[] = '<article class="blog-wrapper list-wrapper">';
			$html[] = '<div class="entry-header">';
			$html[] = $image;
			$html[] = $date_html;
			$html[] = '</div>';
			$html[] = '<div class="entry-summary">';
			$html[] = '<h5 class="entry-title"><a href="' . $post_url['url'] . '">' . get_the_title( get_the_ID() ) . '</a></h5>';
			$html[] = '<div class="entry-content">';
			$html[] = \Dimas\Addons\Helper::get_content_limit( 15, '' );
			$html[] = '</div>';
			$html[] = '<a class="dimas-button button-normal" href="' . esc_url( get_permalink() ) . '">' . esc_html__( 'Read more', 'dimas' ) . \Dimas\Addons\Helper::get_svg( 'arrow-right',  'dimas-icon' ) . '</a>';
			$html[] = '</div>';
			$html[] = '</article>';

			$index ++;

		endwhile;
		wp_reset_postdata();

		$this->add_render_attribute( 'wrapper', 'class', $classes );

		?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
            <div class="list-posts ">
                <div class="list-posts__inner ">
					<?php echo implode( '', $html ) ?>
                </div>
            </div>
        </div>
		<?php

	}
}
