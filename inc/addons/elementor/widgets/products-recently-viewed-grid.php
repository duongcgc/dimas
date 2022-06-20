<?php

namespace Dimas\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Dimas\Addons\Elementor\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Products Recently Viewed Grid widget
 */
class Products_Recently_Viewed_Grid extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'dimas-products-recently-viewed-grid';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Dimas - Products Recently Viewed Grid', 'dimas' );
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
	protected function register_controls() {
		$this->section_content();
	}

	protected function section_content() {
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
			'per_page',
			[
				'label'   => esc_html__( 'Per Page', 'dimas' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 8,
				'min'     => 2,
				'max'     => 50,
				'step'    => 1,
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
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'              => esc_html__( 'Order By', 'dimas' ),
				'type'               => Controls_Manager::SELECT,
				'options'            => [
					''      => esc_html__( 'Default', 'dimas' ),
					'date'  => esc_html__( 'Date', 'dimas' ),
					'title' => esc_html__( 'Title', 'dimas' ),
					'rand'  => esc_html__( 'Random', 'dimas' ),
				],
				'default'            => '',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'order',
			[
				'label'              => esc_html__( 'Order', 'dimas' ),
				'type'               => Controls_Manager::SELECT,
				'options'            => [
					''     => esc_html__( 'Default', 'dimas' ),
					'asc'  => esc_html__( 'Ascending', 'dimas' ),
					'desc' => esc_html__( 'Descending', 'dimas' ),
				],
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

		$this->add_control(
			'pagination_enable',
			[
				'label'        => esc_html__( 'Pagination', 'dimas' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'dimas' ),
				'label_off'    => esc_html__( 'Hide', 'dimas' ),
				'return_value' => 'yes',
				'default'      => '',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'toolbar_enable',
			[
				'label'        => esc_html__( 'Toolbar', 'dimas' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'dimas' ),
				'label_off'    => esc_html__( 'Hide', 'dimas' ),
				'return_value' => 'yes',
				'default'      => '',
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
			'dimas-products-recently-viewed-grid dimas-history-products grid-type',
		];


		wc_setup_loop(
			array(
				'columns' => $settings['columns']
			)
		);

		$product_ids     = Helper::get_product_recently_viewed_ids();

		if ( ! empty( $product_ids ) ) {
			$query_args = array(
				'post_type'      => 'product',
				'post_status'    => 'publish',
				'post__in'       => $product_ids,
				'posts_per_page' => isset( $settings['per_page'] ) ? absint( $settings['per_page'] ) : - 1,
				'orderby'        => $settings['orderby'],
				'order'          => $settings['order'],
				'fields'         => 'ids'
			);

			$query_args['paged'] = isset( $_GET['recently_page'] ) ? $_GET['recently_page'] : 1;

			$query = new \WP_Query( $query_args );

			$paginated = ! $query->get( 'no_found_rows' );

			$results = array(
				'total'        => $paginated ? (int) $query->found_posts : count( $query->posts ),
				'total_pages'  => $paginated ? (int) $query->max_num_pages : 1,
				'current_page' => $paginated ? (int) max( 1, $query->get( 'paged', 1 ) ) : 1
			);
		} else {
			$results['total'] = false;
		}

		if ( $results['total'] ) {
			$classes[] = 'has-products';
		}

		$this->add_render_attribute( 'wrapper', 'class', $classes );

		?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php
			echo sprintf(
				'<ul class="product-list no-products">' .
				'<li class="text-center">%s <br> %s</li>' .
				'</ul>',
				wp_kses( $settings['empty_product_description'], wp_kses_allowed_html( 'post' ) ),
				Helper::control_url( 'empty_button', $settings['empty_product_link'], $settings['empty_product_text'], [ 'class' => 'dimas-button' ] )
			);
			?>
            <div class="products-content">
				<?php
				if ( $results['total'] ) { ?>
				<?php
				if ( 'yes' == $settings['toolbar_enable'] ) { ?>
                    <div class="products-tool">
                        <div class="dimas-products__found">
							<?php esc_html_e( 'Showing', 'dimas' ); ?>
                            <span class="current-post"> <?php echo $query->post_count; ?> </span>
							<?php esc_html_e( 'of', 'dimas' ); ?>
                            <span class="found-post"> <?php echo $query->found_posts; ?>  </span>
							<?php $results['total'] > 1 ? esc_html_e( 'Products', 'dimas' ) : esc_html_e( 'Product', 'dimas' ); ?>
                        </div>
                        <a href="#" class="reset-button"><?php esc_html_e( 'Clear', 'dimas' ); ?></a>
                    </div>
				<?php } ?>
				<?php $this->get_recently_viewed_products( $settings, $query ); ?>
            </div>
		<?php
            if ( $settings['pagination_enable'] == 'yes' && $results['total'] ) {
                $this->get_pagination( $results['total_pages'], $results['current_page'] );
            }
		}

		?>
        </div>
		<?php
		wp_reset_postdata();
	}

	/**
	 * Products pagination.
	 */
	protected function get_pagination( $total_pages, $current_page ) {
		echo '<nav class="woocommerce-pagination">';
		echo paginate_links(
			array( // WPCS: XSS ok.
				'base'      => esc_url_raw( add_query_arg( 'recently_page', '%#%', false ) ),
				'format'    => '?recently_page=%#%',
				'add_args'  => false,
				'current'   => isset( $_GET['recently_page'] ) ? $_GET['recently_page'] : max( 1, $current_page ),
				'total'     => $total_pages,
				'prev_text' => \Dimas\Addons\Helper::get_svg( 'caret-right' ),
				'next_text' => \Dimas\Addons\Helper::get_svg( 'caret-right' ),
				'type'      => 'list',
			)
		);
		echo '</nav>';
	}

	protected function get_recently_viewed_products( $settings, $query ) {

		if ( ! $query->posts ) {
			return;
		}

		if ( 'default' == $settings['layout'] ) {
			woocommerce_product_loop_start();
			$original_post = $GLOBALS['post'];
			foreach ( $query->posts as $post_id ) {
				$GLOBALS['post'] = get_post( $post_id ); // WPCS: override ok.
				setup_postdata( $GLOBALS['post'] );
				wc_get_template_part( 'content', 'product' );
			}
			$GLOBALS['post'] = $original_post;
			woocommerce_product_loop_end();
			wc_reset_loop();

		} else {
			echo '<ul class="product-list products columns-' . esc_attr( $settings['columns'] ) . '"">';

			$original_post = $GLOBALS['post'];
			foreach ( $query->posts as $post_id ) {
				$GLOBALS['post'] = get_post( $post_id ); // WPCS: override ok.
				setup_postdata( $GLOBALS['post'] );
				wc_get_template_part( 'content', 'product-recently-viewed' );
			}
			$GLOBALS['post'] = $original_post;

			echo '</ul>';
		}

	}
}
