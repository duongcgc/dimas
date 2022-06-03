<?php
/**
 * Dimas_Topbar functions and definitions.
 *
 * @package Dimas
 */

namespace Dimas;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Dimas_Topbar initial
 *
 */
class Dimas_Topbar {
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
		add_action( 'dimas_before_open_site_header', array( $this, 'display_topbar' ), 10 );
		add_action( 'dimas_before_open_site_header', array( $this, 'display_topbar_mobile' ), 10 );
	}


	/**
	 * Display topbar
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function display_topbar() {
		if ( ! apply_filters( 'dimas_topbar', Dimas_Helper::get_option( 'topbar' ) ) ) {
			return;
		}
		$show_header = is_page() ? ! get_post_meta( \Dimas\Dimas_Helper::get_post_ID(), 'rz_hide_header_section', true ) : true;
		if ( ! $show_header ) {
			return;
		}
		get_template_part( 'template-parts/headers/topbar' );
	}

	/**
	 * Display topbar on mobile
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function display_topbar_mobile() {
		if ( ! apply_filters( 'dimas_topbar_mobile', Dimas_Helper::get_option( 'mobile_topbar' ) ) ) {
			return;
		}

		$show_header = is_page() ? ! get_post_meta( \Dimas\Dimas_Helper::get_post_ID(), 'rz_hide_header_section', true ) : true;
		if ( ! $show_header ) {
			return;
		}

		get_template_part( 'template-parts/headers/topbar-mobile' );
	}

	/**
	 * Display topbar items
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function topbar_items( $items ) {
		if ( empty( $items ) ) {
			return;
		}

		foreach ( $items as $item ) {
			$item['item'] = $item['item'] ? $item['item'] : key( $this->topbar_items_option() );

			switch ( $item['item'] ) {
				case 'menu':
					$this->topbar_menu();
					break;

				case 'currency':
					\Dimas\Dimas_Helper::currency_switcher();
					break;

				case 'language':
					\Dimas\Dimas_Helper::language_switcher();
					break;

				case 'social':
					\Dimas\Dimas_Helper::socials_menu();
					break;

				case 'text':
					$html_svg = '';
					if ( $svg = Dimas_Helper::get_option( 'topbar_svg_code' ) ) {
						$html_svg = '<span class="dimas-svg-icon">' . \Dimas\Icon::sanitize_svg( $svg ) . '</span>';
					}

					echo '<div class="dimas-topbar__text">' . $html_svg . do_shortcode( wp_kses_post( Dimas_Helper::get_option( 'topbar_text' ) ) ) . '</div>';

					break;

				case 'close':
					echo \Dimas\Icon::get_svg( 'close', 'dimas-topbar__close' );
					break;

				default:
					do_action( 'dimas_header_topbar_item', $item['item'] );
					break;
			}
		}
	}

	/**
	 * Display topbar items
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function topbar_mobile_items( $items ) {
		if ( empty( $items ) ) {
			return;
		}

		foreach ( $items as $item ) {
			$item['item'] = $item['item'] ? $item['item'] : key( $this->topbar_items_option() );

			switch ( $item['item'] ) {
				case 'menu':
					$this->topbar_menu();
					break;

				case 'currency':
					\Dimas\Dimas_Helper::currency_switcher();
					break;

				case 'language':
					\Dimas\Dimas_Helper::language_switcher();
					break;

				case 'social':
					\Dimas\Dimas_Helper::socials_menu();
					break;

				case 'text':
					$html_svg = '';
					if ( $svg = Dimas_Helper::get_option( 'mobile_topbar_svg_code' ) ) {
						$html_svg = '<span class="dimas-svg-icon">' . \Dimas\Icon::sanitize_svg( $svg ) . '</span>';
					}

					echo '<div class="dimas-topbar__text">' . $html_svg . do_shortcode( wp_kses_post( Dimas_Helper::get_option( 'mobile_topbar_text' ) ) ) . '</div>';

					break;

				case 'close':
					echo \Dimas\Icon::get_svg( 'close', 'dimas-topbar__close' );
					break;

				default:
					do_action( 'dimas_header_topbar_mobile_item', $item['item'] );
					break;
			}
		}
	}

	/**
	 * Get topbar menu
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function topbar_menu() {
		$menu_slug =  Dimas_Helper::get_option( 'topbar_menu_item' );
		if( empty($menu_slug) ) {
			return;
		}
		wp_nav_menu( apply_filters( 'dimas_topbar_menu_content', array(
			'theme_location' => '__no_such_location',
			'menu'           => $menu_slug,
			'container'      => 'nav',
			'container_id'   => 'topbar-menu',
			'menu_class'     => 'nav-menu topbar-menu menu',
		) ) );
	}

	/**
	 * Dimas_Options of topbar items
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function topbar_items_option() {
		return apply_filters( 'dimas_topbar_items_option', array(
			'menu'     => esc_html__( 'Dimas_Menu', 'dimas' ),
			'currency' => esc_html__( 'Currency Switcher', 'dimas' ),
			'language' => esc_html__( 'Language Switcher', 'dimas' ),
			'social'   => esc_html__( 'Socials', 'dimas' ),
			'text'     => esc_html__( 'Custom Text', 'dimas' ),
			'close'    => esc_html__( 'Close Icon', 'dimas' ),
		) );
	}
}
