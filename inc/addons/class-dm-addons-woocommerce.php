<?php
/**
 * Woocommerce functions and definitions.
 * => connection template logic woocommerce into this theme.
 *
 * @package Dimas
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Woocommerce initial
 */
class GO_Addons_Woocommerce {
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
		$this->init();
		add_action( 'wp', array( $this, 'add_actions' ), 10 );
	}

	/**
	 * Initial Init
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function init() {
		$this->get( 'setup' );
		$this->get( 'sidebars' );
		$this->get( 'customizer' );
		$this->get( 'cache' );
		$this->get( 'dynamic_css' );
		$this->get( 'cat_settings' );
		$this->get( 'product_settings' );

		$this->get_template( 'general' );
		$this->get_template( 'product_loop' );

		$this->get_element( 'deal' );
		$this->get_element( 'masonry' );
		$this->get_element( 'showcase' );
		$this->get_element( 'summary' );
		$this->get_element( 'product_with_thumbnails' );
	}

	/**
	 * Add Actions
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function add_actions() {
		$this->get_template( 'catalog' );
		$this->get_template( 'single_product' );
		$this->get_template( 'account' );
		$this->get_template( 'cart' );
		$this->get_template( 'checkout' );

		$this->get_module( 'badges' );
		$this->get_module( 'quick_view' );
		$this->get_module( 'notices' );
		$this->get_module( 'recently_viewed' );
		$this->get_module( 'sticky_atc' );
		$this->get_module( 'login_ajax' );
		$this->get_module( 'mini_cart' );
	}

	/**
	 * Get Initial Class Init.
	 *
	 * @since 1.0.0
	 *
	 * @return object
	 */
	public function get( $class ) {
		switch ( $class ) {
			case 'setup':
				return GO_Woo_Setup::instance();
				break;
			case 'sidebars':
				return GO_Woo_Sidebars::instance();
				break;
			case 'customizer':
				return GO_Woo_Customizer::instance();
				break;
			case 'cache':
				return GO_Woo_Cache::instance();
				break;
			case 'dynamic_css':
				return GO_Woo_GO_Dynamic_CSS::instance();
				break;
			case 'cat_settings':
				if ( is_admin() ) {
					return GO_Woo_Settings_Category::instance();
				}
				break;

			case 'product_settings':
				if ( is_admin() ) {
					return GO_Woo_Settings_Product::instance();
				}
				break;
		}
	}

	/**
	 * Get Initial Template Class.
	 *
	 * @since 1.0.0
	 *
	 * @return object
	 */
	public function get_template( $class ) {
		switch ( $class ) {
			case 'general':
				return GO_Woo_Template_General::instance();
				break;
			case 'product_loop':
				return GO_Woo_Template_Product_Loop::instance();
				break;
			case 'catalog':
				if ( GO_Helper::is_catalog() ) {
					return GO_Woo_Template_Catalog::instance();
				}
				break;
			case 'single_product':
				if ( is_singular( 'product' ) ) {
					return GO_Woo_Template_Single_Product::instance();
				}
				break;
			case 'account':
				return GO_Woo_Template_Account::instance();
				break;
			case 'cart':
				if ( function_exists( 'is_cart' ) && is_cart() ) {
					return GO_Woo_Template_Cart::instance();
				}
				break;
			case 'checkout':
				if ( function_exists( 'is_checkout' ) && is_checkout() ) {
					return GO_Woo_Template_Checkout::instance();
				}
				break;
			default:
				break;
		}
	}

	/**
	 * Get Initial Elements.
	 *
	 * @since 1.0.0
	 *
	 * @return object
	 */
	public function get_element( $class ) {
		switch ( $class ) {
			case 'deal':
				return GO_Woo_Elements_Product_Deal::instance();
				break;
			case 'masonry':
				return GO_Woo_Elements_Product_Masonry::instance();
				break;
			case 'showcase':
				return GO_Woo_Elements_Product_ShowCase::instance();
				break;
			case 'summary':
				return GO_Woo_Elements_Product_Summary::instance();
				break;
			case 'product_with_thumbnails':
				return GO_Woo_Elements_Product_With_Thumbnails::instance();
				break;
		}
	}

	/**
	 * Get Module.
	 *
	 * @since 1.0.0
	 *
	 * @return object
	 */
	public function get_module( $class ) {
		switch ( $class ) {
			case 'badges':
				return GO_Woo_Modules_Badges::instance();
				break;
			case 'quick_view':
				return GO_Woo_Modules_Quick_View::instance();
				break;
			case 'notices':
				return GO_Woo_Modules_Notices::instance();
				break;
			case 'recently_viewed':
				return GO_Woo_Modules_Recently_Viewed::instance();
				break;
			case 'login_ajax':
				return GO_Woo_Modules_Login_AJAX::instance();
				break;
			case 'mini_cart':
				return GO_Woo_Modules_Mini_Cart::instance();
				break;
			case 'sticky_atc':
				if ( is_singular( 'product' ) && intval( apply_filters( 'dimas_product_add_to_cart_sticky', GO_Helper::get_option( 'product_add_to_cart_sticky' ) ) ) ) {
					return GO_Woo_Modules_Sticky_ATC::instance();
				}
				break;
		}
	}
}
