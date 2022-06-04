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
 * Products With Banner widget
 */
class Products_With_Banner extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'dimas-products-with-banner';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Dimas - Products With Banner', 'dimas' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-inner-section';
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
		$scripts = [
			'dimas-product-shortcode'
		];

		return $scripts;
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
		$this->section_banner_settings_controls();
		$this->section_products_settings_controls();
	}

	// Tab Style
	protected function section_style() {
		$this->section_banner_style_controls();
	}

	protected function section_banner_settings_controls() {
		$this->start_controls_section(
			'section_banner',
			[ 'label' => esc_html__( 'Banner', 'dimas' ) ]
		);

		$this->add_control(
			'banner_image',
			[
				'label'   => esc_html__( 'Background Image', 'dimas' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [],
			]
		);

		$this->add_control(
			'background_overlay',
			[
				'label'      => esc_html__( 'Background Overlay', 'dimas' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .dimas-products-with-banner .masonry-banner-content .banner-image:before' => 'background-color: {{VALUE}}',
				]
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
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'This is title', 'dimas' ),
				'label_block' => true,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'description',
			[
				'label'       => esc_html__( 'Description', 'dimas' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'This is description', 'dimas' ),
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'       => esc_html__( 'Button Text', 'dimas' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
			]
		);

		$this->add_control(
			'banner_link', [
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
			'link_type',
			[
				'label'   => esc_html__( 'Link Type', 'dimas' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'only' => esc_html__( 'Only button text', 'dimas' ),
					'all'  => esc_html__( 'All banner', 'dimas' ),
				],
				'default' => 'all',
				'toggle'  => false,
			]
		);

		$this->end_controls_section();
	}

	protected function section_products_settings_controls() {
		$this->start_controls_section(
			'section_products',
			[ 'label' => esc_html__( 'Products', 'dimas' ) ]
		);

		$this->add_control(
			'limit',
			[
				'label'   => esc_html__( 'Limit', 'dimas' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 6,
				'min'     => 2,
				'max'     => 38,
				'step'    => 1,
			]
		);

		$this->add_control(
			'products',
			[
				'label'     => esc_html__( 'Product', 'dimas' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'recent'       => esc_html__( 'Recent', 'dimas' ),
					'featured'     => esc_html__( 'Featured', 'dimas' ),
					'best_selling' => esc_html__( 'Best Selling', 'dimas' ),
					'top_rated'    => esc_html__( 'Top Rated', 'dimas' ),
					'sale'         => esc_html__( 'On Sale', 'dimas' ),
				],
				'default'   => 'recent',
				'toggle'    => false,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'     => esc_html__( 'Order By', 'dimas' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''           => esc_html__( 'Default', 'dimas' ),
					'date'       => esc_html__( 'Date', 'dimas' ),
					'title'      => esc_html__( 'Title', 'dimas' ),
					'menu_order' => esc_html__( 'Menu Order', 'dimas' ),
					'rand'       => esc_html__( 'Random', 'dimas' ),
				],
				'default'   => '',
			]
		);

		$this->add_control(
			'order',
			[
				'label'     => esc_html__( 'Order', 'dimas' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''     => esc_html__( 'Default', 'dimas' ),
					'asc'  => esc_html__( 'Ascending', 'dimas' ),
					'desc' => esc_html__( 'Descending', 'dimas' ),
				],
				'default'   => '',
			]
		);

		$this->add_control(
			'product_category',
			[
				'label'       => esc_html__( 'Product Categories', 'dimas' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'dimas' ),
				'type'        => 'rzautocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'product_cat',
				'sortable'    => true,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'product_tag',
			[
				'label'       => esc_html__( 'Products Tags', 'dimas' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'dimas' ),
				'type'        => 'rzautocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'product_tag',
				'sortable'    => true,
			]
		);

		$this->add_control(
			'product_brands',
			[
				'label'       => esc_html__( 'Products Brands', 'dimas' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'dimas' ),
				'type'        => 'rzautocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'product_brand',
				'sortable'    => true,
			]
		);

		if ( taxonomy_exists( 'product_author' ) ) {
			$this->add_control(
				'product_authors',
				[
					'label'       => esc_html__( 'Products Authors', 'dimas' ),
					'placeholder' => esc_html__( 'Click here and start typing...', 'dimas' ),
					'type'        => 'rzautocomplete',
					'default'     => '',
					'label_block' => true,
					'multiple'    => true,
					'source'      => 'product_author',
					'sortable'    => true,
				]
			);
		}

		$this->add_control(
			'attributes_divider',
			[
				'label' => esc_html__( 'Attributes', 'dimas' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'show_category',
			[
				'label'     => esc_html__( 'Category', 'dimas' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'dimas' ),
				'label_on'  => __( 'Show', 'dimas' ),
				'return_value' => 'show',
				'default'   => '',
			]
		);

		$this->add_control(
			'show_rating',
			[
				'label'     => esc_html__( 'Rating', 'dimas' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'dimas' ),
				'label_on'  => __( 'Show', 'dimas' ),
				'return_value' => 'show',
				'default'   => '',
			]
		);

		$this->add_control(
			'show_quickview',
			[
				'label'     => esc_html__( 'Quick View', 'dimas' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'dimas' ),
				'label_on'  => __( 'Show', 'dimas' ),
				'return_value' => 'show',
				'default'   => '',
			]
		);

		$this->add_control(
			'show_addtocart',
			[
				'label'     => esc_html__( 'Add To Cart', 'dimas' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'dimas' ),
				'label_on'  => __( 'Show', 'dimas' ),
				'return_value' => 'show',
				'default'   => '',
			]
		);

		$this->add_control(
			'show_wishlist',
			[
				'label'     => esc_html__( 'Wishlist', 'dimas' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'dimas' ),
				'label_on'  => __( 'Show', 'dimas' ),
				'return_value' => 'show',
				'default'   => '',
			]
		);

		$this->add_control(
			'show_badges',
			[
				'label'     => esc_html__( 'Badges', 'dimas' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'dimas' ),
				'label_on'  => __( 'Show', 'dimas' ),
				'return_value' => 'show',
				'default'   => '',
			]
		);

		$this->add_control(
			'show_atc_mobile',
			[
				'label'     => esc_html__( 'Show Add to Cart Button on Mobile', 'dimas' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'dimas' ),
				'label_on'  => __( 'Show', 'dimas' ),
				'return_value' => 'show',
				'default'   => 'show',
				'conditions' => [
					'terms' => [
						[
							'name' => 'show_addtocart',
							'value' => 'show',
						],
					],
				],
			]
		);

		$this->add_control(
			'show_featured_icons_mobile',
			[
				'label'     => esc_html__( 'Show Featured Icons Mobile', 'dimas' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'dimas' ),
				'label_on'  => __( 'Show', 'dimas' ),
				'return_value' => 'show',
				'default'   => 'show',
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'show_addtocart',
							'value' => 'show',
						],
						[
							'name' => 'show_quickview',
							'value' => 'show',
						],
						[
							'name' => 'show_wishlist',
							'value' => 'show',
						],
					],
				],
			]
		);

		$this->add_control(
			'product_link_type',
			[
				'label'   => esc_html__( 'Link Type', 'dimas' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'only' => esc_html__( 'Only title product', 'dimas' ),
					'all'  => esc_html__( 'All product', 'dimas' ),
				],
				'default' => 'only',
				'toggle'  => false,
			]
		);

		$this->end_controls_section();
	}

	protected function section_banner_style_controls() {
		// Content Style
		$this->start_controls_section(
			'section_banner_style',
			[
				'label' => esc_html__( 'Banner', 'dimas' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
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
					'{{WRAPPER}} .dimas-products-with-banner .masonry-banner-content .banner-content' => 'justify-content: {{VALUE}}',
				],
				'selectors_dictionary' => [
					'top'    => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
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
					'{{WRAPPER}} .dimas-products-with-banner .masonry-banner-content .banner-content' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'content_padding_repeater',
			[
				'label'      => esc_html__( 'Padding', 'dimas' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .dimas-products-with-banner .masonry-banner-content .banner-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'title_heading_name',
			[
				'label' => esc_html__( 'Title', 'dimas' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'      => esc_html__( ' Color', 'dimas' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .dimas-products-with-banner .dimas-banner__title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .dimas-products-with-banner .dimas-banner__title',
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
					'{{WRAPPER}} .dimas-products-with-banner .dimas-banner__title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'desc_heading_name',
			[
				'label' => esc_html__( 'Description', 'dimas' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'      => esc_html__( 'Color', 'dimas' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .dimas-products-with-banner .dimas-banner__description' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .dimas-products-with-banner .dimas-banner__description',
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
					'{{WRAPPER}} .dimas-products-with-banner .dimas-banner__description' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'btn_heading_name',
			[
				'label' => esc_html__( 'Button', 'dimas' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'btn_custom_color',
			[
				'label'      => esc_html__( 'Color', 'dimas' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .dimas-products-with-banner .dimas-banner__button a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'btn_typography',
				'selector' => '{{WRAPPER}} .dimas-products-with-banner .dimas-banner__button a',
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
			'dimas-products-with-banner',
			$settings['show_category'] != '' ? 'show-category' : '',
			$settings['show_rating'] != '' ? 'show-rating' : '',
			$settings['show_quickview'] != '' ? 'show-quickview' : '',
			$settings['show_addtocart'] != '' ? 'show-addtocart' : '',
			$settings['show_wishlist'] != '' ? 'show-wishlist' : '',
			$settings['show_badges'] != '' ? 'show-badges' : '',
			$settings['show_quickview'] == '' && $settings['show_addtocart'] == '' && $settings['show_wishlist'] == '' ? 'btn-hidden' : '',
			$settings['product_link_type'] == 'only' ? '' : 'product-link-type-all',
		];

		$this->add_render_attribute( 'wrapper', [
			'class' 			=> $classes,
			'data-nonce' 		=> wp_create_nonce( 'dimas_get_products' )
		] );

		$attr = [
			'products' 			=> $settings['products'],
			'orderby'  			=> $settings['orderby'],
			'order'    			=> $settings['order'],
			'category'    		=> $settings['product_category'],
			'tag'    			=> $settings['product_tag'],
			'product_brands'    => $settings['product_brands'],
			'limit'    			=> $settings['limit'],
		];

		if ( taxonomy_exists( 'product_author' ) ) {
			$attr['product_authors'] = $settings['product_authors'];
		}

		$results = Helper::products_shortcode( $attr );
		if ( ! $results ) {
			return;
		}

		$product_ids = $results['ids'];
		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php
				self::get_template_masonry_loop( $product_ids, 'product-masonry', $settings['show_atc_mobile'], $settings['show_featured_icons_mobile'], $settings );
			?>
		</div>
		<?php
	}

	/**
	 * Loop over products
	 *
	 * @param array $products_ids
	 */
	public static function get_template_masonry_loop( $products_ids, $template, $atc_mobile, $featured_mobile, $settings ) {
		update_meta_cache( 'post', $products_ids );
		update_object_term_cache( $products_ids, 'product' );

		$original_post = $GLOBALS['post'];

		$class_mobile = '';
		if ( $atc_mobile == 'show' ) {
			$class_mobile = 'mobile-show-atc';
		}
		if ( $featured_mobile == 'show' ) {
			$class_mobile .= ' mobile-show-featured-icons';
		}

		if( class_exists('\Dimas\Helper') && method_exists('\Dimas\Helper', 'get_option') ) {
			if ( $mobile_pl_col = intval( \Dimas\Helper::get_option( 'mobile_landscape_product_columns' ) ) ) {
				$class_mobile .= ' mobile-pl-col-' . $mobile_pl_col;
			}

			if ( $mobile_pp_col = intval( \Dimas\Helper::get_option( 'mobile_portrait_product_columns' ) ) ) {
				$class_mobile .= ' mobile-pp-col-' . $mobile_pp_col;
			}
		}

		echo '<ul class="products product-loop-layout-7 product-loop-center shortcode-element layout-masonry dimas-products-with-banner__content '. esc_attr( $class_mobile ) .'">';
		$i = 0;
		foreach ( $products_ids as $product_id ) {

			if( $i == 1 ) {
				self::get_banner_html( $settings );
			}
			$i++;

			$GLOBALS['post'] = get_post( $product_id ); // WPCS: override ok.
			setup_postdata( $GLOBALS['post'] );
			wc_get_template_part( 'content', $template );
		}

		$GLOBALS['post'] = $original_post; // WPCS: override ok.

		echo '</ul>';

		wp_reset_postdata();

	}

	public static function get_banner_html( $settings ) {
		if ( empty( $settings ) ) {
			return;
		}

		$banner_html = '';

		if( $settings['link_type'] == 'all' && $settings['banner_link']['url'] ) {
			$banner_html .= '<a class="has-link masonry-banner-content" href="'. $settings['banner_link']['url'] .'">';
		} else {
			$banner_html .= '<div class="masonry-banner-content">';
		}

		if ( $settings['banner_image']['url'] ) {
			$settings['image']      = $settings['banner_image'];

			$image = Group_Control_Image_Size::get_attachment_image_html( $settings );
			$banner_html .= $image ? sprintf('<div class="banner-image">%s</div>',$image) : '';
		}

		$banner_html .= '<span class="banner-content">';

		if ( $settings['title'] ) {
			$banner_html .= '<span class="dimas-banner__title">' . $settings['title'] . '</span>';
		}

		if ( $settings['description'] ) {
			$banner_html .= '<span class="dimas-banner__description">' . $settings['description'] . '</span>';
		}

		if ( $settings['button_text'] ) {

			$button_text = $settings['button_text'] . \Dimas\Addons\Helper::get_svg('arrow-right');

			if( $settings['link_type'] == 'only' && $settings['banner_link']['url'] ) {
				$banner_html .= sprintf( '<span class="dimas-banner__button">%s</span>', Helper::control_url( 'button' ,$settings['banner_link'], $button_text, [ 'class' => 'dimas-button button-normal' ] ) );
			} else {
				$banner_html .= sprintf( '<span class="dimas-banner__button dimas-button button-normal">%s</span>', $button_text );
			}
		}

		$banner_html .= '</span>';

		if( $settings['link_type'] == 'all' && $settings['banner_link']['url'] ) {
			$banner_html .= '</a>';
		} else {
			$banner_html .= '</div>';
		}

		echo '<li class="product has-banner"><div class="dimas-banner__masonry">' . $banner_html . '</div></li>';

	}
}