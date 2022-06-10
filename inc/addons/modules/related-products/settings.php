<?php

namespace Dimas\Addons\Modules\Related_Products;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main class of plugin for admin
 */
class Settings  {

	/**
	 * Instance
	 *
	 * @var $instance
	 */
	private static $instance;


	/**
	 * Initiator
	 *
	 * @since 1.0.0
	 * @return object
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) ) {
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
		add_filter( 'woocommerce_get_sections_products', array( $this, 'related_products_section' ), 30, 2 );
		add_filter( 'woocommerce_get_settings_products', array( $this, 'related_products_settings' ), 30, 2 );

		add_action('woocommerce_settings_save_', array($this, 'remove_'));
	}

	/**
	 * Related Products section
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function related_products_section( $sections ) {
		$sections['rz_related_products'] = esc_html__( 'Related Products', 'dimas' );

		return $sections;
	}

	/**
	 * Adds settings to product display settings
	 *
	 * @since 1.0.0
	 *
	 * @param array $settings
	 * @param string $section
	 *
	 * @return array
	 */
	public function related_products_settings( $settings, $section ) {
		if ( 'rz_related_products' == $section ) {
			$settings = array();

			$settings[] = array(
				'id'    => 'rz_related_products_options',
				'title' => esc_html__( 'Related Products', 'dimas' ),
				'type'  => 'title',
			);

			$settings[] = array(
				'id'      => 'rz_related_products',
				'title'   => esc_html__( 'Related Products', 'dimas' ),
				'desc'    => esc_html__( 'Enable Related Products', 'dimas' ),
				'type'    => 'checkbox',
				'default' => 'yes',
			);

			$settings[] = array(
				'id'      => 'rz_custom_related_products',
				'title'   => esc_html__( 'Custom Related Products', 'dimas' ),
				'desc'    => esc_html__( 'Enable', 'dimas' ),
				'type'    => 'checkbox',
				'desc_tip' => esc_html__( 'Display custom related products options for individual products (by categories, tags, or products)', 'dimas' ),
				'default' => 'no',
			);

			$settings[] = array(
				'name'    => esc_html__( 'Related Products Title', 'dimas' ),
				'id'      => 'rz_related_products_title',
				'type'    => 'text',
				'default' => esc_html__( 'Related Products', 'dimas' ),
			);

			$settings[] = array(
				'id'      => 'rz_related_products_by_categories',
				'title'   => esc_html__( 'Related Products By Categories', 'dimas' ),
				'desc'    => esc_html__( 'Enable', 'dimas' ),
				'type'    => 'checkbox',
				'default' => 'yes',
			);

			$settings[] = array(
				'id'      => 'rz_related_products_by_parent_category',
				'title'   => esc_html__( 'Related Products By Parent Category', 'dimas' ),
				'desc'    => esc_html__( 'Enable', 'dimas' ),
				'type'    => 'checkbox',
				'default' => 'no',
			);

			$settings[] = array(
				'id'      => 'rz_related_products_by_tags',
				'title'   => esc_html__( 'Related Products By Tags', 'dimas' ),
				'desc'    => esc_html__( 'Enable', 'dimas' ),
				'type'    => 'checkbox',
				'default' => 'yes',
			);

			$settings[] = array(
				'name'    => esc_html__( 'Related Products Numbers', 'dimas' ),
				'id'      => 'rz_related_products_number',
				'type'    => 'text',
				'default' => '6',
				'desc_tip' => esc_html__( 'Enter the number of products to display. Default value is 6.', 'dimas' ),
			);

			$settings[] = array(
				'name'    => esc_html__( 'Related Products Navigation', 'dimas' ),
				'id'      => 'rz_related_products_navigation',
				'default' => 'scrollbar',
				'class'   => 'wc-enhanced-select',
				'type'    => 'select',
				'options' => array(
					'scrollbar'   => esc_html__( 'Scrollbar', 'dimas' ),
					'arrows' => esc_html__( 'Arrows', 'dimas' ),
					'dots' => esc_html__( 'Dots', 'dimas' ),
				),
			);

			$settings[] = array(
				'id'   => 'rz_related_products_options',
				'type' => 'sectionend',
			);
		}

		return $settings;
	}

}