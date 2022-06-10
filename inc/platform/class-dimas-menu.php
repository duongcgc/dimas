<?php
/**
 * Functions and filters related to the menus.
 *
 * Makes the default WordPress navigation use an HTML structure similar
 * to the Navigation block.
 *
 * @package Dimas
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Menu initial
 */
class Dimas_Menu {
	/**
	 * Instance
	 *
	 * @var $instance
	 */
	protected static $instance = null;

	/**
	 * Initiator
	 *
	 * @since 1.0.0
	 * @return object
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Instantiate the object.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		add_action( 'dimas_before_open_site_header', array( $this, 'show_header_sticky_minimized' ) );

		add_action( 'dimas_after_open_site_header', array( $this, 'show_header' ) );

		// Menu functions
		add_filter( 'walker_nav_menu_start_el', array( $this, 'dimas_add_sub_menu_toggle' ), 10, 4 );
		add_filter( 'walker_nav_menu_start_el', array( $this, 'dimas_nav_menu_social_icons' ), 10, 4 );
		add_filter( 'nav_menu_item_args', array( $this, 'dimas_add_menu_description_args' ), 10, 3 );

		// Mobile
		add_action( 'dimas_after_open_site_header', array( $this, 'mobile_header' ), 99 );

		add_filter( 'dimas_header_mobile_class', array( $this, 'mobile_header_classes' ) );

		add_action( 'dimas_header_mobile_content', array( $this, 'mobile_header_left' ), 10 );
		add_action( 'dimas_header_mobile_content', array( $this, 'mobile_header_logo' ), 30 );
		add_action( 'dimas_header_mobile_content', array( $this, 'mobile_header_icons' ), 50 );

		add_action( 'wp_footer', array( $this, 'menu_mobile_modal' ) );

		add_action( 'wp_footer', array( $this, 'menu_hamburger_modal' ) );

	}


	/**
	 * Add a button to top-level menu items that has sub-menus.
	 * An icon is added using CSS depending on the value of aria-expanded.
	 *
	 * @since Dimas 1.0
	 *
	 * @param string $output Nav menu item start element.
	 * @param object $item   Nav menu item.
	 * @param int    $depth  Depth.
	 * @param object $args   Nav menu args.
	 * @return string Nav menu item start element.
	 */
	public function dimas_add_sub_menu_toggle( $output, $item, $depth, $args ) {
		if ( 0 === $depth && in_array( 'menu-item-has-children', $item->classes, true ) ) {

			// Add toggle button.
			$output .= '<button class="sub-menu-toggle" aria-expanded="false" onClick="dimasExpandSubMenu(this)">';
			$output .= '<span class="icon-plus">' . dimas_get_icon_svg( 'ui', 'plus', 18 ) . '</span>';
			$output .= '<span class="icon-minus">' . dimas_get_icon_svg( 'ui', 'minus', 18 ) . '</span>';
			$output .= '<span class="screen-reader-text">' . esc_html__( 'Open menu', 'dimas' ) . '</span>';
			$output .= '</button>';
		}
		return $output;
	}

	/**
	 * Detects the social network from a URL and returns the SVG code for its icon.
	 *
	 * @since Dimas 1.0
	 *
	 * @param string $uri  Social link.
	 * @param int    $size The icon size in pixels.
	 * @return string
	 */
	public function dimas_get_social_link_svg( $uri, $size = 24 ) {
		return \Dimas\SVG_Icons::get_social_link_svg( $uri, $size );
	}

	/**
	 * Displays SVG icons in the footer navigation.
	 *
	 * @since Dimas 1.0
	 *
	 * @param string   $item_output The menu item's starting HTML output.
	 * @param WP_Post  $item        Menu item data object.
	 * @param int      $depth       Depth of the menu. Used for padding.
	 * @param stdClass $args        An object of wp_nav_menu() arguments.
	 * @return string The menu item output with social icon.
	 */
	public function dimas_nav_menu_social_icons( $item_output, $item, $depth, $args ) {
		// Change SVG icon inside social links menu if there is supported URL.
		if ( 'footer' === $args->theme_location ) {
			$svg = dimas_get_social_link_svg( $item->url, 24 );
			if ( ! empty( $svg ) ) {
				$item_output = str_replace( $args->link_before, $svg, $item_output );
			}
		}

		return $item_output;
	}


	/**
	 * Filters the arguments for a single nav menu item.
	 *
	 * @since Dimas 1.0
	 *
	 * @param stdClass $args  An object of wp_nav_menu() arguments.
	 * @param WP_Post  $item  Menu item data object.
	 * @param int      $depth Depth of menu item. Used for padding.
	 * @return stdClass
	 */
	public function dimas_add_menu_description_args( $args, $item, $depth ) {
		if ( '</span>' !== $args->link_after ) {
			$args->link_after = '';
		}

		if ( 0 === $depth && isset( $item->description ) && $item->description ) {
			// The extra <span> element is here for styling purposes: Allows the description to not be underlined on hover.
			$args->link_after = '<p class="menu-item-description"><span>' . $item->description . '</span></p>';
		}

		return $args;
	}


	/**
	 * Enqueue scripts and styles.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		wp_register_style( 'dimas-fonts', Helper::get_fonts_url(), array(), '20200928' );

		$style_file = is_rtl() ? 'style-rtl.css' : 'style.css';
		wp_enqueue_style(
			'dimas',
			apply_filters( 'dimas_get_style_directory_uri', get_template_directory_uri() ) . '/' . $style_file,
			array(
				'dimas-fonts',
			),
			'20220126'
		);

		do_action( 'dimas_after_enqueue_style' );

		/**
		 * Register and enqueue scripts
		 */

		wp_enqueue_script( 'html5shiv', get_template_directory_uri() . '/assets/js/plugins/html5shiv.min.js', array(), '3.7.2' );
		wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );

		wp_enqueue_script( 'respond', get_template_directory_uri() . '/assets/js/plugins/respond.min.js', array(), '1.4.2' );
		wp_script_add_data( 'respond', 'conditional', 'lt IE 9' );

		wp_register_script( 'notify', get_template_directory_uri() . '/assets/js/plugins/notify.min.js', array(), '1.0.0', true );
		wp_register_script( 'swiper', get_template_directory_uri() . '/assets/js/plugins/swiper.min.js', array( 'jquery' ), '5.3.8', true );
		wp_register_script( 'isInViewport', get_template_directory_uri() . '/assets/js/plugins/isInViewport.min.js', array(), '20201012', true );

		$debug = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		wp_enqueue_script(
			'dimas',
			get_template_directory_uri() . '/assets/js/scripts' . $debug . '.js',
			array(
				'jquery',
				'isInViewport',
				'swiper',
				'notify',
				'imagesloaded',
			),
			'20220125',
			true
		);

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		$dimas_data = array(
			'direction'            => is_rtl() ? 'true' : 'false',
			'ajax_url'             => class_exists( 'WC_AJAX' ) ? \WC_AJAX::get_endpoint( '%%endpoint%%' ) : '',
			'nonce'                => wp_create_nonce( '_dimas_nonce' ),
			'search_content_type'  => Helper::get_option( 'header_search_type' ),
			'header_search_number' => Helper::get_option( 'header_search_number' ),
			'header_ajax_search'   => intval( Helper::get_option( 'header_search_ajax' ) ),
			'sticky_header'        => intval( Helper::get_option( 'header_sticky' ) ),
			'mobile_landscape'     => Helper::get_option( 'mobile_landscape_product_columns' ),
			'mobile_portrait'      => Helper::get_option( 'mobile_portrait_product_columns' ),
			'popup'                => Helper::get_option( 'newsletter_popup_enable' ),
			'popup_frequency'      => Helper::get_option( 'newsletter_popup_frequency' ),
			'popup_visible'        => Helper::get_option( 'newsletter_popup_visible' ),
			'popup_visible_delay'  => Helper::get_option( 'newsletter_popup_visible_delay' ),
		);

		$dimas_data = apply_filters( 'dimas_wp_script_data', $dimas_data );

		wp_localize_script(
			'dimas',
			'dimasData',
			$dimas_data
		);

	}

	/**
	 * Display the site header sticky minimized
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */

	public function show_header_sticky_minimized() {
		$show_header = is_page() ? ! get_post_meta( \Dimas\Helper::get_post_ID(), 'rz_hide_header_section', true ) : true;
		if ( ! apply_filters( 'dimas_get_header', $show_header ) ) {
			return;
		}

		if ( ! intval( Helper::get_option( 'header_sticky' ) ) ) {
			return;
		}

		if ( get_post_meta( Helper::get_post_ID(), 'rz_header_background', true ) == 'transparent' ) {
			return;
		}

		echo '<div id="site-header-minimized"></div>';
	}

	/**
	 * Display the site header
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */

	public function show_header() {
		$show_header = is_page() ? ! get_post_meta( \Dimas\Helper::get_post_ID(), 'rz_hide_header_section', true ) : true;
		if ( ! apply_filters( 'dimas_get_header', $show_header ) ) {
			return;
		}

		$custom_header_layout = get_post_meta( Helper::get_post_ID(), 'rz_header_layout', true );
		if ( ! empty( $custom_header_layout ) && 'default' != $custom_header_layout ) {
			$this->prebuild_header( $custom_header_layout );
		} else {
			if ( 'default' == Helper::get_option( 'header_type' ) ) {
				$this->prebuild_header( Helper::get_option( 'header_layout' ) );
			} else {
				$options = array();

				// Menu main.
				$sections = array(
					'left'   => Helper::get_option( 'header_main_left' ),
					'center' => Helper::get_option( 'header_main_center' ),
					'right'  => Helper::get_option( 'header_main_right' ),
				);

				$classes = array( 'header-main', 'header-contents', 'hidden-md hidden-xs hidden-sm' );

				$this->get_header_contents( $sections, $options, array( 'class' => $classes ) );

				// Menu bottom.
				$sections = array(
					'left'   => Helper::get_option( 'header_bottom_left' ),
					'center' => Helper::get_option( 'header_bottom_center' ),
					'right'  => Helper::get_option( 'header_bottom_right' ),
				);

				$border = Helper::get_option( 'header_bottom_border_top' );
				$border = $border ? 'has-border' : '';

				$sticky_bottom = in_array( 'header_main', (array) Helper::get_option( 'header_sticky_el' ) ) ? 'rz-sticky-main' : '';

				$classes = array(
					'header-bottom',
					'header-contents',
					'hidden-md hidden-xs hidden-sm',
					$border,
					$sticky_bottom,
				);

				$this->get_header_contents( $sections, $options, array( 'class' => $classes ) );
			}
		}

	}

	/**
	 * Display pre-build header
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	protected function prebuild_header( $version = 'v1' ) {
		switch ( $version ) {
			case 'v1':
				$main_sections   = array(
					'left'   => array(
						array( 'item' => 'logo' ),
					),
					'center' => array(
						array( 'item' => 'menu-primary' ),
					),
					'right'  => array(
						array( 'item' => 'search' ),
						array( 'item' => 'account' ),
						array( 'item' => 'wishlist' ),
						array( 'item' => 'cart' ),
					),
				);
				$main_options    = array(
					'search' => array(
						'search_style' => 'icon',
					),
				);
				$bottom_sections = array();
				$bottom_options  = array();
				break;

			case 'v2':
				$main_sections   = array(
					'left'   => array(
						array( 'item' => 'menu-primary' ),
					),
					'center' => array(
						array( 'item' => 'logo' ),
					),
					'right'  => array(
						array( 'item' => 'currencies' ),
						array( 'item' => 'languages' ),
						array( 'item' => 'search' ),
						array( 'item' => 'account' ),
						array( 'item' => 'wishlist' ),
						array( 'item' => 'cart' ),
					),
				);
				$main_options    = array(
					'search' => array(
						'search_style' => 'icon',
					),
				);
				$bottom_sections = array();
				$bottom_options  = array();
				break;

			case 'v3':
				$main_sections   = array(
					'left'   => array(
						array( 'item' => 'menu-secondary' ),
					),
					'center' => array(
						array( 'item' => 'logo' ),
					),
					'right'  => array(
						array( 'item' => 'account' ),
						array( 'item' => 'wishlist' ),
						array( 'item' => 'cart' ),
					),
				);
				$main_options    = array();
				$bottom_sections = array(
					'left'   => array(
						array( 'item' => 'menu-primary' ),
					),
					'center' => array(),
					'right'  => array(
						array( 'item' => 'search' ),
					),
				);
				$bottom_options  = array(
					'search' => array(
						'search_style'      => 'form',
						'search_form_style' => 'boxed',
					),
				);
				break;

			case 'v4':
				$main_sections   = array(
					'left'   => array(
						array( 'item' => 'logo' ),
					),
					'center' => array(
						array( 'item' => 'menu-primary' ),
					),
					'right'  => array(
						array( 'item' => 'account' ),
						array( 'item' => 'wishlist' ),
						array( 'item' => 'cart' ),
					),
				);
				$main_options    = array();
				$bottom_sections = array(
					'left'   => array(),
					'center' => array(
						array( 'item' => 'department' ),
						array( 'item' => 'search' ),
					),
					'right'  => array(),
				);
				$bottom_options  = array(
					'search' => array(
						'search_style' => 'form-cat',
					),
				);
				break;

			case 'v5':
				$main_sections   = array(
					'left'   => array(
						array( 'item' => 'logo' ),
					),
					'center' => array(),
					'right'  => array(
						array( 'item' => 'search' ),
						array( 'item' => 'account' ),
						array( 'item' => 'wishlist' ),
						array( 'item' => 'cart' ),
						array( 'item' => 'hamburger' ),
					),
				);
				$main_options    = array(
					'search' => array(
						'search_style' => 'icon',
					),
				);
				$bottom_sections = array();
				$bottom_options  = array();
				break;

			case 'v6':
				$main_sections   = array(
					'left'   => array(
						array( 'item' => 'logo' ),
					),
					'center' => array(
						array( 'item' => 'menu-primary' ),
					),
					'right'  => array(
						array( 'item' => 'socials' ),
					),
				);
				$main_options    = array();
				$bottom_sections = array(
					'left'   => array(
						array( 'item' => 'search' ),
					),
					'center' => array(),
					'right'  => array(
						array( 'item' => 'account' ),
						array( 'item' => 'wishlist' ),
						array( 'item' => 'cart' ),
					),
				);
				$bottom_options  = array(
					'search' => array(
						'search_style'      => 'form',
						'search_form_style' => 'full-width',
					),
				);
				break;

			case 'v7':
				$main_sections   = array(
					'left'   => array(
						array( 'item' => 'logo' ),
					),
					'center' => array(),
					'right'  => array(
						array( 'item' => 'menu-primary' ),
						array( 'item' => 'cart' ),
					),
				);
				$main_options    = array();
				$bottom_sections = array();
				$bottom_options  = array();
				break;

			case 'v8':
				$main_sections   = array(
					'left'   => array(
						array( 'item' => 'menu-primary' ),
					),
					'center' => array(
						array( 'item' => 'logo' ),
					),
					'right'  => array(
						array( 'item' => 'search' ),
						array( 'item' => 'account' ),
						array( 'item' => 'wishlist' ),
						array( 'item' => 'cart' ),
					),
				);
				$main_options    = array(
					'search' => array(
						'search_style' => 'icon',
					),
				);
				$bottom_sections = array();
				$bottom_options  = array();
				break;

			case 'v9':
				$main_sections   = array(
					'left'   => array(
						array( 'item' => 'logo' ),
					),
					'center' => array(
						array( 'item' => 'search' ),
					),
					'right'  => array(
						array( 'item' => 'account' ),
						array( 'item' => 'wishlist' ),
						array( 'item' => 'cart' ),
					),
				);
				$main_options    = array(
					'search' => array(
						'search_style'      => 'form',
						'search_form_style' => 'boxed',
					),
				);
				$bottom_sections = array(
					'left'   => array(
						array( 'item' => 'menu-primary' ),
					),
					'center' => array(),
					'right'  => array(),
				);
				$bottom_options  = array();
				break;

			default:
				$main_sections   = array();
				$main_options    = array();
				$bottom_sections = array();
				$bottom_options  = array();
				break;
		}

		$classes = array( 'header-main', 'header-contents', 'hidden-xs hidden-sm' );
		$this->get_header_contents( $main_sections, $options['main_options'] = $main_options, array( 'class' => $classes ) );

		$classes = array( 'header-bottom', 'header-contents', 'hidden-xs hidden-sm' );
		$this->get_header_contents( $bottom_sections, $options['bottom_options'] = $bottom_options, array( 'class' => $classes ) );
	}

	/**
	 * Display header items
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	protected function get_header_contents( $sections, $options, $atts = array() ) {
		if ( false == array_filter( $sections ) ) {
			return;
		}

		$classes = array();
		if ( isset( $atts['class'] ) ) {
			$classes = (array) $atts['class'];
			unset( $atts['class'] );
		}

		if ( empty( $sections['left'] ) && empty( $sections['right'] ) ) {
			unset( $sections['left'] );
			unset( $sections['right'] );
		}

		if ( ! empty( $sections['center'] ) ) {
			$classes[]    = 'has-center';
			$center_items = wp_list_pluck( $sections['center'], 'item' );

			if ( in_array( 'logo', $center_items ) ) {
				$classes[] = 'logo-center';
			}

			if ( in_array( 'menu-primary', $center_items ) ) {
				$classes[] = 'menu-center';
			}

			if ( empty( $sections['left'] ) && empty( $sections['right'] ) ) {
				$classes[] = 'no-sides';
			}
		} else {
			$classes[] = 'no-center';
			unset( $sections['center'] );

			if ( empty( $sections['left'] ) ) {
				unset( $sections['left'] );
			}

			if ( empty( $sections['right'] ) ) {
				unset( $sections['right'] );
			}
		}
		$attr = '';
		foreach ( $atts as $name => $value ) {
			$attr .= ' ' . $name . '=' . esc_attr( $value ) . '';
		}

		$container_width = 'container';

		if ( Helper::get_header_layout() == 'v6' ) {
			$container_width = 'header-container';
		} elseif ( Helper::get_option( 'header_width' ) == 'large' ) {
			$container_width = 'dimas-container';
		} elseif ( Helper::get_option( 'header_width' ) == 'wide' ) {
			$container_width = 'dimas-container-wide';
		}

		?>
		<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>" <?php echo esc_attr( $attr ); ?>>
			<div class="dimas-header-container <?php echo esc_attr( apply_filters( 'dimas_header_container_class', $container_width ) ); ?>">

				<?php foreach ( $sections as $section => $items ) : ?>
					<?php
					$class      = '';
					$item_names = wp_list_pluck( $items, 'item' );

					if ( in_array( 'menu-primary', $item_names ) ) {
						$class .= ' has-menu';
					}

					if ( in_array( 'language-currency', $item_names ) ) {
						$class .= ' has-list-dropdown';
					}

					?>
					<div class="header-<?php echo esc_attr( $section ); ?>-items header-items <?php echo esc_attr( $class ); ?>">
						<?php $this->get_header_items( $items, $options ); ?>
					</div>

				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Display header items
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	protected function get_header_items( $items, $options ) {
		if ( empty( $items ) ) {
			return;
		}

		$args = array();

		foreach ( $items as $item ) {
			if ( ! isset( $item['item'] ) ) {
				continue;
			}

			$item['item']  = $item['item'] ? $item['item'] : key( $this->get_header_items_option() );
			$template_file = $item['item'];

			switch ( $item['item'] ) {
				case 'hamburger':
					\Dimas\Dimas_Theme::instance()->set_prop( 'modals', $item['item'] );
					break;

				case 'cart':
					if ( ! class_exists( 'Initial' ) ) {
						$template_file = '';
						break;
					}

					if ( 'panel' == Helper::get_option( 'header_cart_behaviour' ) ) {
						\Dimas\Dimas_Theme::instance()->set_prop( 'modals', $item['item'] );
					}

					break;

				case 'search':
					$args = $this->search_options( $options );
					break;

				case 'account':
					if ( 'panel' == Helper::get_option( 'header_account_behaviour' ) ) {
						\Dimas\Dimas_Theme::instance()->set_prop( 'modals', $item['item'] );
					}
					break;
			}

			if ( $template_file ) {
				get_template_part( 'template-parts/headers/' . $template_file, '', $args );
			}
		}
	}

	/**
	 * Options of header items
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	protected function get_header_items_option() {
		return apply_filters(
			'dimas_header_items_option',
			array(
				'0'              => esc_html__( 'Select a item', 'dimas' ),
				'logo'           => esc_html__( 'Logo', 'dimas' ),
				'menu-primary'   => esc_html__( 'Primary Menu', 'dimas' ),
				'menu-secondary' => esc_html__( 'Secondary Menu', 'dimas' ),
				'hamburger'      => esc_html__( 'Hamburger Icon', 'dimas' ),
				'search'         => esc_html__( 'Search Icon', 'dimas' ),
				'cart'           => esc_html__( 'Cart Icon', 'dimas' ),
				'account'        => esc_html__( 'Account Icon', 'dimas' ),
				'languages'      => esc_html__( 'Languages', 'dimas' ),
				'currencies'     => esc_html__( 'Currencies', 'dimas' ),
				'department'     => esc_html__( 'Department', 'dimas' ),
				'socials'        => esc_html__( 'Socials', 'dimas' ),
			)
		);
	}

	/**
	 * Options of header items
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	protected function get_mobile_header_icons_option() {
		return apply_filters(
			'dimas_mobile_header_icons_option',
			array(
				'cart'     => esc_html__( 'Cart Icon', 'dimas' ),
				'wishlist' => esc_html__( 'Wishlist Icon', 'dimas' ),
				'account'  => esc_html__( 'Account Icon', 'dimas' ),
				'menu'     => esc_html__( 'Menu Icon', 'dimas' ),
				'search'   => esc_html__( 'Search Icon', 'dimas' ),
			)
		);
	}

	/**
	 * Get nav menu
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function primary_menu( $mega_menu = true ) {
		$arrow_class = Helper::get_option( 'primary_menu_show_arrow' ) ? 'has-arrow' : '';
		$class       = array( 'nav-menu', Helper::get_option( 'hamburger_click_item' ), $arrow_class );
		$classes     = implode( ' ', $class );

		$primary_menu   = get_post_meta( \Dimas\Helper::get_post_ID(), 'rz_header_primary_menu', true );
		$theme_location = $primary_menu ? '__no_such_location' : 'primary';

		if ( empty( $primary_menu ) && ! has_nav_menu( $theme_location ) ) {
			return;
		}

		if ( $mega_menu == true && Helper::get_header_layout() != 'v6' && class_exists( '\Dimas\Addons\Modules\Mega_Menu\Walker' ) ) {
			wp_nav_menu(
				apply_filters(
					'dimas_navigation_primary_content',
					array(
						'theme_location' => $theme_location,
						'container'      => false,
						'menu_class'     => $classes,
						'menu'           => $primary_menu,
						'walker'         => new \Dimas\Addons\Modules\Mega_Menu\Walker(),
					)
				)
			);

		} else {
			wp_nav_menu(
				apply_filters(
					'dimas_navigation_primary_content',
					array(
						'theme_location' => $theme_location,
						'container'      => false,
						'menu_class'     => $classes,
						'menu'           => $primary_menu,
					)
				)
			);
		}
	}

	/**
	 * Display header extra class
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function classes( $classes ) {
		if ( intval( Helper::get_option( 'header_sticky' ) ) && Helper::get_header_layout() != 'v6' ) {
			$header_sticky_el = (array) Helper::get_option( 'header_sticky_el' );

			if ( Helper::get_option( 'header_type' ) == 'custom' ) {
				if ( ! in_array( 'header_main', $header_sticky_el ) ) {
					$classes .= ' header-main-no-sticky';
				}

				if ( ! in_array( 'header_bottom', $header_sticky_el ) ) {
					$classes .= ' header-bottom-no-sticky';
				}
			} else {
				if ( in_array( Helper::get_option( 'header_layout' ), array( 'v3', 'v4', 'v9' ) ) ) {
					if ( ! in_array( 'header_main', $header_sticky_el ) ) {
						$classes .= ' header-main-no-sticky';
					}

					if ( ! in_array( 'header_bottom', $header_sticky_el ) ) {
						$classes .= ' header-bottom-no-sticky';
					}
				} else {
					$classes .= ' header-bottom-no-sticky';
				}
			}
		}

		if ( ! get_post_meta( \Dimas\Helper::get_post_ID(), 'rz_hide_header_border', true ) ) {
			$classes .= ' site-header__border';
		}

		echo esc_attr( apply_filters( 'dimas_site_header_class', $classes ) );
	}

	/**
	 * Mobile header.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function mobile_header() {
		if ( ! apply_filters( 'dimas_get_header_mobile', true ) ) {
			return;
		}

		$show_header = is_page() ? ! get_post_meta( \Dimas\Helper::get_post_ID(), 'rz_hide_header_section', true ) : true;
		if ( ! $show_header ) {
			return;
		}

		?>
		<?php get_template_part( 'template-parts/mobile/header-mobile' ); ?>

		<?php
	}

	/**
	 * Mobile header classes
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function mobile_header_classes( $classes ) {
		$mobile_logo = Helper::get_option( 'mobile_custom_logo' ) ? 'custom' : 'default';
		$classes    .= ' header-contents';
		$classes    .= ' logo-' . $mobile_logo;
		$classes    .= ' hidden-md hidden-lg';

		if ( ! intval( Helper::get_option( 'mobile_menu_left' ) ) ) {
			$classes .= ' header-no-menu';
		}

		return $classes;
	}

	/**
	 * Display mobile header icons
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function mobile_header_icons() {
		$icons = Helper::get_option( 'mobile_header_icons' );

		if ( empty( $icons ) ) {
			return;
		}

		echo ' <div class="mobile-header-icons">';

		foreach ( $icons as $icon ) {
			$icon['item'] = $icon['item'] ? $icon['item'] : key( $this->get_mobile_header_icons_option() );

			switch ( $icon['item'] ) {
				case 'cart':
					\Dimas\Dimas_Theme::instance()->set_prop( 'modals', 'cart' );
					get_template_part( 'template-parts/headers/cart' );
					break;

				case 'wishlist':
					get_template_part( 'template-parts/headers/wishlist' );
					break;

				case 'account':
					\Dimas\Dimas_Theme::instance()->set_prop( 'modals', 'account' );
					get_template_part( 'template-parts/headers/account' );
					break;

				case 'menu':
					get_template_part( 'template-parts/mobile/header-menu' );
					break;

				case 'search':
					\Dimas\Dimas_Theme::instance()->set_prop( 'modals', 'search' );
					get_template_part( 'template-parts/mobile/header-search' );
					break;

				default:
					do_action( 'dimas_mobile_header_icon', $icon['item'] );
					break;
			}
		}

		echo '</div>';
	}

	/**
	 * Add menu mobile modal
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function menu_mobile_modal() {
		?>
		<div id="mobile-menu-modal"
			 class="mobile-menu rz-modal ra-menu-mobile-modal ra-hamburger-modal side-left" tabindex="-1">
			<div class="off-modal-layer"></div>
			<div class="menu-mobile-panel-content panel-content">
				<div class="modal-header">
					<div class="mobile-logo">
					<?php if ( Helper::get_option( 'mobile_panel_custom_logo' ) ) : ?>
							<?php get_template_part( 'template-parts/mobile/header-panel-logo' ); ?>
					<?php else : ?>
						<?php get_template_part( 'template-parts/headers/logo' ); ?>
					<?php endif; ?>
					</div>
					<a href="#"
					   class="close-account-panel button-close"><?php echo \Dimas\Icon::get_svg( 'close' ); ?></a>
				</div>
				<div class="modal-content">
					<nav class="hamburger-navigation menu-mobile-navigation">
						<?php

						$class = array( 'nav-menu', 'menu', Helper::get_option( 'mobile_menu_click_item' ) );

						$classes = implode( ' ', $class );

						$menu = has_nav_menu( 'mobile' ) ? 'mobile' : 'primary';

						$arg = array(
							'theme_location' => $menu,
							'container'      => null,
							'fallback_cb'    => 'wp_page_menu',
							'menu_class'     => $classes,
						);

						if ( class_exists( '\Dimas\Addons\Modules\Mega_Menu\Mobile_Walker' ) ) {
							$arg['walker'] = new \Dimas\Addons\Modules\Mega_Menu\Mobile_Walker();
						}

						wp_nav_menu( $arg );
						?>
					</nav>
					<div class="content-footer">
						<?php
						if ( intval( Helper::get_option( 'mobile_menu_show_socials' ) ) ) {
							if ( has_nav_menu( 'socials' ) ) {
								$args = array(
									'container'       => 'div',
									'container_class' => 'topbar-socials-menu socials-menu',
									'theme_location'  => 'socials',
									'menu_class'      => 'menu',
									'link_before'     => '<span>',
									'link_after'      => '</span>',
								);

								if ( class_exists( '\Dimas\Addons\Modules\Mega_Menu\Socials_Walker' ) ) {
									$args['walker'] = new \Dimas\Addons\Modules\Mega_Menu\Socials_Walker();
								}

								wp_nav_menu( $args );
							}
						}

						if ( intval( Helper::get_option( 'mobile_menu_show_copyright' ) ) ) {
							echo '<div class="menu-copyright">' . do_shortcode( wp_kses_post( Helper::get_option( 'footer_copyright' ) ) ) . '</div>';
						}
						?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Add Menu Hamburger Modal
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function menu_hamburger_modal() {
		$modals = Dimas_Theme::instance()->get_prop( 'modals' );

		if ( ! in_array( 'hamburger', $modals ) ) {
			return;
		}

		?>
		<div id="hamburger-modal"
			 class="hamburger-modal rz-modal ra-hamburger-modal <?php echo esc_attr( Helper::get_option( 'hamburger_side_type' ) == 'side-left' ? 'side-left' : '' ); ?>"
			 tabindex="-1" role="dialog">
			<div class="off-modal-layer"></div>
			<div class="hamburger-panel-content panel-content">
				<?php get_template_part( 'template-parts/modals/menu' ); ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Get header mobile logo
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function mobile_header_logo() {
		?>
		<?php if ( Helper::get_option( 'mobile_custom_logo' ) ) : ?>
			<?php get_template_part( 'template-parts/mobile/header-logo' ); ?>
		<?php else : ?>
			<?php get_template_part( 'template-parts/headers/logo' ); ?>
		<?php endif; ?>
		<?php
	}

	/**
	 * Get header mobile menu
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function mobile_header_left() {
		if ( is_front_page() || is_home() ) {
			if ( intval( Helper::get_option( 'mobile_menu_left' ) ) ) {
				get_template_part( 'template-parts/mobile/header-menu' );
			}
		} else {
			if ( ! intval( Helper::get_option( 'mobile_header_history_back' ) ) && intval( Helper::get_option( 'mobile_menu_left' ) ) ) {
				get_template_part( 'template-parts/mobile/header-menu' );
			} elseif ( intval( Helper::get_option( 'mobile_header_history_back' ) ) ) {
				get_template_part( 'template-parts/mobile/header-history-back' );
			}
		}
	}


	/**
	 * Display search quick links.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function search_quicklinks( $post_type = 'product' ) {
		if ( ! Helper::get_option( 'header_search_quick_links' ) ) {
			return;
		}

		$links = (array) Helper::get_option( 'header_search_links' );

		if ( empty( $links ) ) {
			return;
		}
		?>
		<div class="quick-links">
			<p class="label"><?php esc_html_e( 'Quick Links', 'dimas' ); ?></p>

			<ul class="links">
				<?php
				foreach ( $links as $link ) {
					$url = $link['url'];

					if ( ! $url ) {
						$query = array( 's' => $link['text'] );

						if ( $post_type ) {
							$query['post_type'] = $post_type;
						}

						$url = add_query_arg( $query, home_url( '/' ) );
					}

					printf(
						'<li><a href="%s" class="underline-hover">%s</a>',
						esc_url( $url ),
						esc_html( $link['text'] )
					);
				}
				?>
			</ul>
		</div>
		<?php
	}

	/**
	 * Search options
	 *
	 * @since 1.0.0
	 *
	 * @param array $options
	 * @return array $args
	 */
	public function search_options( $options ) {
		$options = isset( $options['search'] ) ? $options['search'] : '';
		$args    = array();

		$args['search_style'] = ! empty( $options ) && isset( $options['search_style'] ) ? $options['search_style'] : Helper::get_option( 'header_search_style' );

		$args['search_class'] = 'ra-search-form search-type-' . $args['search_style'];

		$args['search_form_style'] = ! empty( $options ) && isset( $options['search_form_style'] ) ? $options['search_form_style'] : Helper::get_option( 'header_search_form_style' );
		$args['search_type']       = ! empty( $options ) && isset( $options['search_type'] ) ? $options['search_type'] : Helper::get_option( 'header_search_type' );
		$args['header_type']       = ! empty( $options ) && isset( $options['header_type'] ) ? $options['header_type'] : Helper::get_option( 'header_type' );

		if ( 'icon' == $args['search_style'] ) {
			\Dimas\Dimas_Theme::instance()->set_prop( 'modals', 'search' );
		}

		if ( $args['search_style'] == 'form' || $args['search_style'] == 'form-cat' ) {
			$args['search_class'] .= ' search-form-type';
		}

		if ( $args['search_style'] == 'form' ) {
			$args['search_class'] .= ' form-type-' . $args['search_form_style'];
		}

		return $args;
	}

}