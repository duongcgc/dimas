<?php

namespace Dimas\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Dimas\Addons\Elementor\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon Box widget
 */
class Products_Grid extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'dimas-products-grid';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Dimas - Products Grid', 'dimas' );
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
		$this->section_pagination_settings_controls();
	}

	// Tab Style
	protected function section_style() {
		$this->section_content_style_controls();
	}

	protected function section_products_settings_controls() {
		$this->start_controls_section(
			'section_products',
			[ 'label' => esc_html__( 'Products', 'dimas' ) ]
		);

		$this->add_control(
			'per_page',
			[
				'label'   => esc_html__( 'Total Products', 'dimas' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 8,
				'min'     => 1,
				'max'     => 50,
				'step'    => 1,
				'frontend_available' => true,
				'condition' => [
					'products'            => [ 'recent', 'top_rated', 'sale', 'featured', 'best_selling' ],
				],
			]
		);

		$this->add_control(
			'columns',
			[
				'label'   => esc_html__( 'Columns', 'dimas' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 4,
				'min'     => 1,
				'max'     => 7,
				'step'    => 1,
				'frontend_available' => true,
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
					'custom'       => esc_html__( 'Custom', 'dimas' ),
				],
				'default'   => 'recent',
				'toggle'    => false,
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'ids',
			[
				'label'       => esc_html__( 'Products', 'dimas' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'dimas' ),
				'type'        => 'rzautocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'product',
				'sortable'    => true,
				'condition'   => [
					'products' => 'custom',
				],
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
				'condition' => [
					'products'            => [ 'recent', 'top_rated', 'sale', 'featured' ],
				],
				'frontend_available' => true,
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
				'condition' => [
					'products'            => [ 'recent', 'top_rated', 'sale', 'featured' ],
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'category',
			[
				'label'       => esc_html__( 'Products Category', 'dimas' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'dimas' ),
				'type'        => 'rzautocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'product_cat',
				'sortable'    => true,
				'separator' => 'before',
				'condition' => [
					'products'            => [ 'recent', 'top_rated', 'sale', 'featured' ],
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'product_tags',
			[
				'label'       => esc_html__( 'Products Tags', 'dimas' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'dimas' ),
				'type'        => 'rzautocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'product_tag',
				'sortable'    => true,
				'condition' => [
					'products'            => [ 'recent', 'top_rated', 'sale', 'featured' ],
				],
				'frontend_available' => true,
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
				'condition' => [
					'products'            => [ 'recent', 'top_rated', 'sale', 'featured' ],
				],
				'frontend_available' => true,
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
					'condition' => [
						'products'            => [ 'recent', 'top_rated', 'sale', 'featured' ],
					],
					'frontend_available' => true,
				]
			);
		}

		$this->end_controls_section();
	}

	protected function section_pagination_settings_controls() {
		// Pagination Settings
		$this->start_controls_section(
			'section_pagination',
			[
				'label' => esc_html__( 'Pagination', 'dimas' ),
			]
		);

		$this->add_control(
			'pagination_enable',
			[
				'label'        => esc_html__( 'Pagination', 'dimas' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'dimas' ),
				'label_off'    => esc_html__( 'Hide', 'dimas' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		$this->add_control(
			'pagination_type',
			[
				'label'     => esc_html__( 'Pagination Type', 'dimas' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'numeric'  => esc_html__( 'Numeric', 'dimas' ),
					'loadmore' => esc_html__( 'Load More', 'dimas' ),
					'infinite' => esc_html__( 'Infinite Scroll', 'dimas' ),
				],
				'default'   => 'loadmore',
				'toggle'    => false,
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'   => esc_html__( 'Button text', 'dimas' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Load More', 'dimas' ),
				'conditions' => [
					'terms' => [
						[
							'name'  	=> 'pagination_type',
							'operator' 	=> '!=',
							'value' 	=> 'numeric',
						],
					],
				]
			]
		);

		$this->end_controls_section(); // End Pagination Settings
	}

	protected function section_content_style_controls() {
		// Content Tab Style
		$this->start_controls_section(
			'section_content_style',
			[
				'label' => esc_html__( 'Content', 'dimas' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'button_spacing',
			[
				'label'     => esc_html__( 'Pagination Spacing', 'dimas' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 150,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimas-products-grid .woocommerce-pagination' => 'margin-top: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .dimas-products-grid .dimas-load-more' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_type',
			[
				'label'   => esc_html__( 'Button Type', 'dimas' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'button-smaller' => esc_html__( 'Smaller', 'dimas' ),
					'button-medium' => esc_html__( 'Medium', 'dimas' ),
					'button-larger'  => esc_html__( 'Larger', 'dimas' ),
					'button-big'  => esc_html__( 'Big', 'dimas' ),
					'button-outline'  => esc_html__( 'Outline', 'dimas' ),
				],
				'default' => 'button-larger',
				'toggle'  => false,
				'conditions' => [
					'terms' => [
						[
							'name'  	=> 'pagination_type',
							'operator' 	=> '!=',
							'value' 	=> 'numeric',
						],
					],
				]
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
			'dimas-products-grid woocommerce'
		];

		$this->add_render_attribute( 'wrapper', 'class', $classes );

		$attr = [
			'products' 			=> $settings['products'],
			'orderby'  			=> $settings['orderby'],
			'order'    			=> $settings['order'],
			'category'    		=> $settings['category'],
			'tag'    			=> $settings['product_tags'],
			'product_brands'    => $settings['product_brands'],
			'limit'    			=> $settings['per_page'],
			'columns'    		=> $settings['columns'],
			'product_ids'   	=> explode(',', $settings['ids']),
			'paginate'			=> true,
		];

		if ( taxonomy_exists( 'product_author' ) ) {
			$attr['product_authors'] = $settings['product_authors'];
		}

		$results = Helper::products_shortcode( $attr );
		if ( ! $results ) {
			return;
		}

		$results_ids = ! empty($results['ids']) ? $results['ids'] : 0;

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php
				echo '<div class="product-content">';

				wc_setup_loop(
					array(
						'columns'      => $settings['columns']
					)
				);

			Helper::get_template_loop( $results_ids );

				echo '</div>';

				if ( $settings['pagination_enable'] == 'yes' ) {
					if ( $settings['pagination_type'] == 'numeric') {
						self::get_pagination( $results['total_pages'], $results['current_page'] );
					} if ( $settings['pagination_type'] == 'loadmore' || $settings['pagination_type'] == 'infinite' ) {
						if ( $results['current_page'] < $results['total_pages']  ) {
							echo sprintf(
								'<a href="#" class="ajax-load-products dimas-button %s %s" data-page="%s" rel="nofollow">
									<span class="button-text">%s</span>
									<span class="dots dimas-gooey">
										<span></span>
										<span></span>
										<span></span>
									</span>
								</a>',
								$settings['button_type'],
								$settings['pagination_type'] == 'infinite' ? 'ajax-infinite' : '',
								esc_attr( $results['current_page'] + 1 ),
								$settings['button_text']
							);
						}
					}
				}
			?>
		</div>
		<?php
	}

	/**
	 * Products pagination.
	 */
	public static function get_pagination( $total_pages, $current_page ) {
		echo '<nav class="woocommerce-pagination">';
		echo paginate_links(
			array( // WPCS: XSS ok.
				'base'      => esc_url_raw( add_query_arg( 'product-page', '%#%', false ) ),
				'format'    => '?product-page=%#%',
				'add_args'  => false,
				'current'   => max( 1, $current_page ),
				'total'     => $total_pages,
				'prev_text' => \Dimas\Addons\Helper::get_svg( 'caret-right' ),
				'next_text' => \Dimas\Addons\Helper::get_svg( 'caret-right' ),
				'type'      => 'list',
			)
		);
		echo '</nav>';
	}
}