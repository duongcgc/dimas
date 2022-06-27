<?php
/**
 * Dimas Options
 * => Init options
 *
 * @package Dimas
 */

namespace Dimas\Core;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Options class
 */
class Options_Default {

	/**
	 * Instance
	 *
	 * @var $instance
	 */
	protected static $instance = null;

	/**
	 * $dimas_customize
	 *
	 * @var $dimas_customize
	 */
	protected static $dimas_customize = null;

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
	 * The class constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		 add_filter( 'dimas_customize_config', array( $this, 'customize_settings' ) );
		// self::$dimas_customize = \Dimas\Theme::instance()->get('customizer');.
	}


	/**
	 * This is a short hand function for getting setting value from customizer
	 *
	 * @since 1.0.0
	 *
	 * @param string $name The option name.
	 *
	 * @return bool|string
	 */
	public function get_option( $name ) {
		if ( is_object( self::$dimas_customize ) ) {
			$value = self::$dimas_customize->get_option( $name );
		} elseif ( false !== get_theme_mod( $name ) ) {
			$value = get_theme_mod( $name );
		} else {
			$value = $this->get_option_default( $name );
		}

		return apply_filters( 'dimas_get_option', $value, $name );
	}

	/**
	 * Get default option values
	 *
	 * @since 1.0.0
	 *
	 * @param string $name The default option name.
	 *
	 * @return mixed
	 */
	public static function get_option_default( $name ) {
		if ( empty( self::$dimas_customize ) ) {
			return false;
		}

		return self::$dimas_customize->get_option_default( $name );
	}

	/**
	 * Get categories
	 *
	 * @since 1.0.0
	 *
	 * @param string $taxonomies The taxonomy.
	 * @param string $default The default taxonomy.
	 *
	 * @return array
	 */
	public function get_categories( $taxonomies, $default = false ) {
		if ( ! taxonomy_exists( $taxonomies ) ) {
			return array();
		}

		if ( ! is_admin() ) {
			return array();
		}

		$output = array();

		if ( $default ) {
			$output[0] = esc_html__( 'Select Category',  );
		}

		global $wpdb;
		$post_meta_infos = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT a.term_id AS id, b.name as name, b.slug AS slug
						FROM {$wpdb->term_taxonomy} AS a
						INNER JOIN {$wpdb->terms} AS b ON b.term_id = a.term_id
						WHERE a.taxonomy                            = '%s'",
				$taxonomies
			),
			ARRAY_A
		);

		if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
			foreach ( $post_meta_infos as $value ) {
				$output[ $value['slug'] ] = $value['name'];
			}
		}

		return $output;
	}

	/**
	 * Options of footer items
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function footer_items_option() {
		return apply_filters(
			'dimas_footer_items_option',
			array(
				'copyright' => esc_html__( 'Copyright',  ),
				'menu'      => esc_html__( 'Menu',  ),
				'text'      => esc_html__( 'Custom text',  ),
				'payment'   => esc_html__( 'Payments',  ),
				'social'    => esc_html__( 'Socials',  ),
				'logo'      => esc_html__( 'Logo',  ),
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
	public function header_items_option() {
		return apply_filters(
			'dimas_header_items_option',
			array(
				'0'              => esc_html__( 'Select a item',  ),
				'logo'           => esc_html__( 'Logo',  ),
				'menu-primary'   => esc_html__( 'Primary Menu',  ),
				'menu-secondary' => esc_html__( 'Secondary Menu',  ),
				'hamburger'      => esc_html__( 'Hamburger Icon',  ),
				'search'         => esc_html__( 'Search Icon',  ),
				'cart'           => esc_html__( 'Cart Icon',  ),
				'wishlist'       => esc_html__( 'Wishlist Icon',  ),
				'account'        => esc_html__( 'Account Icon',  ),
				'languages'      => esc_html__( 'Languages',  ),
				'currencies'     => esc_html__( 'Currencies',  ),
				'department'     => esc_html__( 'Department',  ),
				'socials'        => esc_html__( 'Socials',  ),
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
				'menu'     => esc_html__( 'Menu',  ),
				'currency' => esc_html__( 'Currency Switcher',  ),
				'language' => esc_html__( 'Language Switcher',  ),
				'social'   => esc_html__( 'Socials',  ),
				'text'     => esc_html__( 'Custom Text',  ),
				'close'    => esc_html__( 'Close Icon',  ),
			)
		);
	}

	/**
	 * Options of navigation bar items
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function navigation_bar_items_option() {
		return apply_filters(
			'dimas_navigation_bar_items_option',
			array(
				'home'     => esc_html__( 'Home',  ),
				'menu'     => esc_html__( 'Menu',  ),
				'search'   => esc_html__( 'Search',  ),
				'cart'     => esc_html__( 'Cart',  ),
				'wishlist' => esc_html__( 'Wishlist',  ),
				'account'  => esc_html__( 'Account',  ),
			)
		);
	}


	/**
	 * Options of mobile header icons
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function mobile_header_icons_option() {
		return apply_filters(
			'dimas_mobile_header_icons_option',
			array(
				'cart'     => esc_html__( 'Cart Icon',  ),
				'wishlist' => esc_html__( 'Wishlist Icon',  ),
				'account'  => esc_html__( 'Account Icon',  ),
				'menu'     => esc_html__( 'Menu Icon',  ),
				'search'   => esc_html__( 'Search Icon',  ),
			)
		);
	}

	/**
	 * Get customize settings
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function customize_settings() {
		$settings = array(
			'theme' => ,
		);

		$panels = array(
			'general'    => array(
				'priority' => 10,
				'title'    => esc_html__( 'General',  ),
			),

			// Typography.
			'typography' => array(
				'priority' => 30,
				'title'    => esc_html__( 'Typography',  ),
			),
		);

		$sections = array();

		$fields = array();

		$settings['panels']   = apply_filters( 'dimas_customize_panels', $panels );
		$settings['sections'] = apply_filters( 'dimas_customize_sections', $sections );
		$settings['fields']   = apply_filters( 'dimas_customize_fields', $fields );

		return $settings;
	}

	/**
	 * Get nav menus
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_navigation_bar_get_menus() {
		if ( ! is_admin() ) {
			return array();
		}

		$menus = wp_get_nav_menus();
		if ( ! $menus ) {
			return array();
		}

		$output = array(
			0 => esc_html__( 'Select Menu',  ),
		);
		foreach ( $menus as $menu ) {
			$output[ $menu->slug ] = $menu->name;
		}

		return $output;
	}

	/**
	 * Display header sticky
	 *
	 * @since 1.0.0
	 *
	 * @return boolean
	 */
	public function display_header_sticky() {
		if ( empty( get_theme_mod( 'header_sticky' ) ) ) {
			return false;
		}

		if ( 'default' == get_theme_mod( 'header_type' ) ) {
			if ( ! in_array( get_theme_mod( 'header_layout' ), array( 'v3', 'v4', 'v9' ) ) ) {
				return false;
			}

			return true;
		} else {
			return true;
		}
	}

	/**
	 * Display header search panel
	 *
	 * @since 1.0.0
	 *
	 * @return boolean
	 */
	public function display_header_search_panel() {
		if ( 'custom' == get_theme_mod( 'header_type' ) ) {
			if ( get_theme_mod( 'header_search_style' ) != 'icon' ) {
				return false;
			}

			return true;
		} else {
			if ( ! in_array( get_theme_mod( 'header_layout' ), array( 'v1', 'v2', 'v5', 'v8' ) ) ) {
				return false;
			}

			return true;
		}
	}
}