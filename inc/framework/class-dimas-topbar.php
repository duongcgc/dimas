<?php
/**
 * Topbar functions and definitions.
 *
 * @package Dimas
 */

namespace Dimas\Framework;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Topbar initial.
 */
class Topbar {
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
		if ( ! apply_filters( 'dimas_topbar', Helper::get_option( 'topbar' ) ) ) {
			return;
		}
		$show_header = is_page() ? ! get_post_meta( \Dimas\Helper::get_post_ID(), 'rz_hide_header_section', true ) : true;
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
		if ( ! apply_filters( 'dimas_topbar_mobile', Helper::get_option( 'mobile_topbar' ) ) ) {
			return;
		}

		$show_header = is_page() ? ! get_post_meta( Helper::get_post_ID(), 'rz_hide_header_section', true ) : true;
		if ( ! $show_header ) {
			return;
		}

		get_template_part( 'template-parts/headers/topbar-mobile' );
	}

	/**
	 * Display topbar items
	 *
	 * @since 1.0.0
	 * @param array $items     The items on topbar.
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
					\Dimas\Helper::currency_switcher();
					break;

				case 'language':
					\Dimas\Helper::language_switcher();
					break;

				case 'social':
					\Dimas\Helper::socials_menu();
					break;

				case 'text':
					$html_svg = '';
					$svg      = \Dimas\Helper::get_option( 'topbar_svg_code' );
					if ( $svg ) {
						$html_svg = '<span class="dimas-svg-icon">' . \Dimas\SVG_Icons::sanitize_svg( $svg ) . '</span>';
					}

					echo '<div class="dimas-topbar__text">' . esc_html( $html_svg ) . do_shortcode( wp_kses_post( Helper::get_option( 'topbar_text' ) ) ) . '</div>';

					break;

				case 'close':
					echo esc_html( \Dimas\SVG_Icons::get_svg( 'close', 'dimas-topbar__close', 32 ) );
					break;

				default:
					do_action( 'dimas_header_topbar_item', $item['item'] );
					break;
			}
		}
	}

	/**
	 * Display topbar items.
	 *
	 * @param array $items    The array of items.
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
					\Dimas\Helper::currency_switcher();
					break;

				case 'language':
					\Dimas\Helper::language_switcher();
					break;

				case 'social':
					\Dimas\Helper::socials_menu();
					break;

				case 'text':
					$html_svg = '';
					$svg      = \Dimas\Helper::get_option( 'mobile_topbar_svg_code' );
					if ( $svg ) {
						$html_svg = '<span class="dimas-svg-icon">' . SVG_Icons::sanitize_svg( $svg ) . '</span>';
					}

					echo '<div class="dimas-topbar__text">' . esc_html( $html_svg ) . do_shortcode( wp_kses_post( Helper::get_option( 'mobile_topbar_text' ) ) ) . '</div>';

					break;

				case 'close':
					echo esc_html( SVG_Icons::get_svg( 'close', 'dimas-topbar__close', 32 ) );
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
		$menu_slug = Helper::get_option( 'topbar_menu_item' );
		if ( empty( $menu_slug ) ) {
			return;
		}
		wp_nav_menu(
			apply_filters(
				'dimas_topbar_menu_content',
				array(
					'theme_location' => '__no_such_location',
					'menu'           => $menu_slug,
					'container'      => 'nav',
					'container_id'   => 'topbar-menu',
					'menu_class'     => 'nav-menu topbar-menu menu',
				)
			)
		);
	}

	/**
	 * Options of topbar items
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function topbar_items_option() {
		return apply_filters(
			'dimas_topbar_items_option',
			array(
				'menu'     => esc_html__( 'Menu', 'dimas' ),
				'currency' => esc_html__( 'Currency Switcher', 'dimas' ),
				'language' => esc_html__( 'Language Switcher', 'dimas' ),
				'social'   => esc_html__( 'Socials', 'dimas' ),
				'text'     => esc_html__( 'Custom Text', 'dimas' ),
				'close'    => esc_html__( 'Close Icon', 'dimas' ),
			)
		);
	}
}
