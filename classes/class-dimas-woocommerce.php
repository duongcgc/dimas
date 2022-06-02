<?php
/**
 * Woocommerce functions and definitions.
 *
 * @package Dimas
 */

namespace Dimas;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Woocommerce initial
 *
 */
class WooCommerce {
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
	 * WooCommerce Init
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
	 * Get WooCommerce Class Init.
	 *
	 * @since 1.0.0
	 *
	 * @return object
	 */
	public function get( $class ) {
		switch ( $class ) {
			case 'setup':
				return \Dimas\WooCommerce\Setup::instance();
				break;
			case 'sidebars':
				return \Dimas\WooCommerce\Sidebars::instance();
				break;
			case 'customizer':
				return \Dimas\WooCommerce\Customizer::instance();
				break;
			case 'cache':
				return \Dimas\WooCommerce\Cache::instance();
				break;
			case 'dynamic_css':
				return \Dimas\WooCommerce\Dynamic_CSS::instance();
				break;
			case 'cat_settings':
				if ( is_admin() ) {
					return \Dimas\WooCommerce\Settings\Category::instance();
				}
				break;

			case 'product_settings':
				if ( is_admin() ) {
					return \Dimas\WooCommerce\Settings\Product::instance();
				}
				break;
		}
	}

	/**
	 * Get WooCommerce Template Class.
	 *
	 * @since 1.0.0
	 *
	 * @return object
	 */
	public function get_template( $class ) {
		switch ( $class ) {
			case 'general':
				return \Dimas\WooCommerce\Template\General::instance();
				break;
			case 'product_loop':
				return \Dimas\WooCommerce\Template\Product_Loop::instance();
				break;
			case 'catalog':
				if ( \Dimas\Helper::is_catalog() ) {
					return \Dimas\WooCommerce\Template\Catalog::instance();
				}
				break;
			case 'single_product':
				if ( is_singular( 'product' ) ) {
					return \Dimas\WooCommerce\Template\Single_Product::instance();
				}
				break;
			case 'account':
				return \Dimas\WooCommerce\Template\Account::instance();
				break;
			case 'cart':
				if ( function_exists('is_cart') && is_cart() ) {
					return \Dimas\WooCommerce\Template\Cart::instance();
				}
				break;
			case 'checkout':
				if ( function_exists('is_checkout') && is_checkout() ) {
					return \Dimas\WooCommerce\Template\Checkout::instance();
				}
				break;
			default :
				break;
		}
	}

	/**
	 * Get WooCommerce Elements.
	 *
	 * @since 1.0.0
	 *
	 * @return object
	 */
	public function get_element( $class ) {
		switch ( $class ) {
			case 'deal':
				return \Dimas\WooCommerce\Elements\Product_Deal::instance();
				break;
			case 'masonry':
				return \Dimas\WooCommerce\Elements\Product_Masonry::instance();
				break;
			case 'showcase':
				return \Dimas\WooCommerce\Elements\Product_ShowCase::instance();
				break;
			case 'summary':
				return \Dimas\WooCommerce\Elements\Product_Summary::instance();
				break;
			case 'product_with_thumbnails':
				return \Dimas\WooCommerce\Elements\Product_With_Thumbnails::instance();
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
				return \Dimas\WooCommerce\Modules\Badges::instance();
				break;
			case 'quick_view':
				return \Dimas\WooCommerce\Modules\Quick_View::instance();
				break;
			case 'notices':
				return \Dimas\WooCommerce\Modules\Notices::instance();
				break;
			case 'recently_viewed':
				return \Dimas\WooCommerce\Modules\Recently_Viewed::instance();
				break;
			case 'login_ajax':
				return \Dimas\WooCommerce\Modules\Login_AJAX::instance();
				break;
			case 'mini_cart':
				return \Dimas\WooCommerce\Modules\Mini_Cart::instance();
				break;
			case 'sticky_atc':
				if ( is_singular( 'product' ) && intval( apply_filters( 'dimas_product_add_to_cart_sticky', Helper::get_option( 'product_add_to_cart_sticky' ) ) ) ) {
					return \Dimas\WooCommerce\Modules\Sticky_ATC::instance();
				}
				break;
		}
	}
}
