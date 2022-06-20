<?php
/**
 * Metaboxes functions
 *
 * @package Dimas
 */

namespace Dimas\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Metaboxes initial
 */
class Metaboxes_Register {
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
		add_action( 'admin_enqueue_scripts', array( $this, 'meta_box_scripts' ) );
		add_filter( 'rwmb_meta_boxes', array( $this, 'register_meta_boxes' ) );
	}

	/**
	 * Enqueue scripts
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function meta_box_scripts( $hook ) {
		if ( in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {
			// wp_enqueue_script( 'dimas-meta-boxes', get_template_directory_uri() . '/assets/js/backend/meta-boxes.js', array( 'jquery' ), '20201012', true );
		}
	}

	/**
	 * Registering meta boxes
	 *
	 * @since 1.0.0
	 *
	 * Using Meta Box plugin: http://www.deluxeblogtips.com/meta-box/
	 *
	 * @see http://www.deluxeblogtips.com/meta-box/docs/define-meta-boxes
	 *
	 * @param array $meta_boxes Default meta boxes. By default, there are no meta boxes.
	 *
	 * @return array All registered meta boxes
	 */
	public function register_meta_boxes( $meta_boxes ) {
		// Header CPT.
		$meta_boxes[] = $this->register_header_settings();

		// Page Header CPT.
		$meta_boxes[] = $this->register_page_header_settings();

		// Content CPT.
		$meta_boxes[] = $this->register_content_settings();

		// Page Boxed CPT.
		$meta_boxes[] = $this->register_page_boxed_settings();

		// Footer CPT.
		$meta_boxes[] = $this->register_footer_settings();

		return $meta_boxes;
	}

	/**
	 * Register header settings
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function register_header_settings() {

		return array(
			'id'       => 'header-settings',
			'title'    => esc_html__( 'Header Settings', 'dimas' ),
			'pages'    => array( 'page' ),
			'context'  => 'normal',
			'priority' => 'high',
			'fields'   => array(
				array(
					'name' => esc_html__( 'Hide Header Section', 'dimas' ),
					'id'   => 'rz_hide_header_section',
					'type' => 'select',
					'type' => 'checkbox',
					'std'  => false,
				),
				array(
					'name'    => esc_html__( 'Header Layout', 'dimas' ),
					'id'      => 'rz_header_layout',
					'type'    => 'select',
					'options' => array(
						'default' => esc_html__( 'Default', 'dimas' ),
						'v1'      => esc_html__( 'Header v1', 'dimas' ),
						'v2'      => esc_html__( 'Header v2', 'dimas' ),
						'v3'      => esc_html__( 'Header v3', 'dimas' ),
						'v4'      => esc_html__( 'Header v4', 'dimas' ),
						'v5'      => esc_html__( 'Header v5', 'dimas' ),
						'v6'      => esc_html__( 'Header v6', 'dimas' ),
						'v7'      => esc_html__( 'Header v7', 'dimas' ),
						'v8'      => esc_html__( 'Header v8', 'dimas' ),
						'v9'      => esc_html__( 'Header v9', 'dimas' ),
					),
				),
				array(
					'name'    => esc_html__( 'Header Background', 'dimas' ),
					'id'      => 'rz_header_background',
					'type'    => 'select',
					'options' => array(
						'default'     => esc_html__( 'Default', 'dimas' ),
						'transparent' => esc_html__( 'Transparent', 'dimas' ),
					),
				),
				array(
					'name'    => esc_html__( 'Header Text Color', 'dimas' ),
					'id'      => 'rz_header_text_color',
					'class'   => 'header-text-color hidden',
					'type'    => 'select',
					'options' => array(
						'default' => esc_html__( 'Default', 'dimas' ),
						'dark'    => esc_html__( 'Dark', 'dimas' ),
						'light'   => esc_html__( 'Light', 'dimas' ),
					),
				),
				array(
					'name' => esc_html__( 'Hide Border Bottom', 'dimas' ),
					'id'   => 'rz_hide_header_border',
					'type' => 'checkbox',
					'std'  => false,
				),
				array(
					'name'       => esc_html__( 'Header Spacing', 'dimas' ),
					'id'         => 'rz_header_bottom_spacing_bottom',
					'type'       => 'slider',
					'suffix'     => esc_html__( ' px', 'dimas' ),
					'js_options' => array(
						'min' => 0,
						'max' => 300,
					),
					'std'        => '20',
				),
				array(
					'name'    => esc_html__( 'Primary Menu', 'dimas' ),
					'id'      => 'rz_header_primary_menu',
					'type'    => 'select',
					'options' => $this->get_menus(),
				),
				array(
					'name'    => esc_html__( 'Department Menu Display', 'dimas' ),
					'id'      => 'rz_department_menu_display',
					'type'    => 'select',
					'options' => array(
						'default'    => esc_html__( 'On Hover', 'dimas' ),
						'onpageload' => esc_html__( 'On Page Load', 'dimas' ),
					),
				),
			),
		);
	}

	/**
	 * Get nav menus
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_menus() {
		if ( ! is_admin() ) {
			return array();
		}

		$menus = wp_get_nav_menus();
		if ( ! $menus ) {
			return array();
		}

		$output = array(
			0 => esc_html__( 'Default', 'dimas' ),
		);
		foreach ( $menus as $menu ) {
			$output[ $menu->slug ] = $menu->name;
		}

		return $output;
	}

	/**
	 * Register page header settings
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function register_page_header_settings() {
		return array(
			'id'       => 'page-header-settings',
			'title'    => esc_html__( 'Page Header Settings', 'dimas' ),
			'pages'    => array( 'page' ),
			'context'  => 'normal',
			'priority' => 'high',
			'fields'   => array(
				array(
					'name' => esc_html__( 'Hide Page Header', 'dimas' ),
					'id'   => 'rz_hide_page_header',
					'type' => 'checkbox',
					'std'  => false,
				),

				array(
					'name'  => esc_html__( 'Hide Title', 'dimas' ),
					'id'    => 'rz_hide_title',
					'type'  => 'checkbox',
					'std'   => false,
					'class' => 'page-header-hide-title',
				),

				array(
					'name'  => esc_html__( 'Hide Breadcrumb', 'dimas' ),
					'id'    => 'rz_hide_breadcrumb',
					'type'  => 'checkbox',
					'std'   => false,
					'class' => 'page-header-hide-breadcrumb',
				),

				array(
					'name'    => esc_html__( 'Spacing', 'dimas' ),
					'id'      => 'rz_page_header_spacing',
					'type'    => 'select',
					'options' => array(
						'default' => esc_html__( 'Default', 'dimas' ),
						'custom'  => esc_html__( 'Custom', 'dimas' ),
					),
				),

				array(
					'name'       => esc_html__( 'Top Spacing', 'dimas' ),
					'id'         => 'rz_page_header_top_padding',
					'class'      => 'custom-page-header-spacing hidden',
					'type'       => 'slider',
					'suffix'     => esc_html__( ' px', 'dimas' ),
					'js_options' => array(
						'min' => 0,
						'max' => 300,
					),
					'std'        => '50',
				),

				array(
					'name'       => esc_html__( 'Bottom Spacing', 'dimas' ),
					'id'         => 'rz_page_header_bottom_padding',
					'class'      => 'custom-page-header-spacing hidden',
					'type'       => 'slider',
					'suffix'     => esc_html__( ' px', 'dimas' ),
					'js_options' => array(
						'min' => 0,
						'max' => 300,
					),
					'std'        => '50',
				),
			),
		);
	}

	/**
	 * Register content settings
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function register_content_settings() {
		return array(
			'id'       => 'content-settings',
			'title'    => esc_html__( 'Content Settings', 'dimas' ),
			'pages'    => array( 'page' ),
			'context'  => 'normal',
			'priority' => 'high',
			'fields'   => array(
				array(
					'name'    => esc_html__( 'Content Width', 'dimas' ),
					'id'      => 'rz_content_width',
					'type'    => 'select',
					'options' => array(
						''      => esc_html__( 'Normal', 'dimas' ),
						'large' => esc_html__( 'Large', 'dimas' ),
					),
				),
				array(
					'name'    => esc_html__( 'Content Top Spacing', 'dimas' ),
					'id'      => 'rz_content_top_spacing',
					'type'    => 'select',
					'options' => array(
						'default' => esc_html__( 'Default', 'dimas' ),
						'no'      => esc_html__( 'No spacing', 'dimas' ),
						'custom'  => esc_html__( 'Custom', 'dimas' ),
					),
				),
				array(
					'name'       => '&nbsp;',
					'id'         => 'rz_content_top_padding',
					'class'      => 'custom-spacing hidden',
					'type'       => 'slider',
					'suffix'     => esc_html__( ' px', 'dimas' ),
					'js_options' => array(
						'min' => 0,
						'max' => 300,
					),
					'std'        => '80',
				),
				array(
					'name'    => esc_html__( 'Content Bottom Spacing', 'dimas' ),
					'id'      => 'rz_content_bottom_spacing',
					'type'    => 'select',
					'options' => array(
						'default' => esc_html__( 'Default', 'dimas' ),
						'no'      => esc_html__( 'No spacing', 'dimas' ),
						'custom'  => esc_html__( 'Custom', 'dimas' ),
					),
				),
				array(
					'name'       => '&nbsp;',
					'id'         => 'rz_content_bottom_padding',
					'class'      => 'custom-spacing hidden',
					'type'       => 'slider',
					'suffix'     => esc_html__( ' px', 'dimas' ),
					'js_options' => array(
						'min' => 0,
						'max' => 300,
					),
					'std'        => '80',
				),
			),
		);
	}

	/**
	 * Register page boxed settings
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function register_page_boxed_settings() {
		return array(
			'id'       => 'page-boxed-settings',
			'title'    => esc_html__( 'Boxed Layout Settings', 'dimas' ),
			'pages'    => array( 'page', 'post', 'product' ),
			'context'  => 'normal',
			'priority' => 'high',
			'fields'   => array(
				array(
					'name' => esc_html__( 'Disable Boxed Layout', 'dimas' ),
					'id'   => 'rz_disable_page_boxed',
					'type' => 'checkbox',
					'std'  => false,
				),
				array(
					'name' => esc_html__( 'Background Color', 'dimas' ),
					'id'   => 'rz_page_boxed_bg_color',
					'type' => 'color',
					'std'  => false,
				),
				array(
					'name'             => esc_html__( 'Background Image', 'dimas' ),
					'id'               => 'rz_page_boxed_bg_image',
					'type'             => 'image_advanced',
					'max_file_uploads' => 1,
					'std'              => false,
				),
				array(
					'name'    => esc_html__( 'Background Horizontal', 'dimas' ),
					'id'      => 'rz_page_boxed_bg_horizontal',
					'type'    => 'select',
					'options' => array(
						''       => esc_html__( 'Default', 'dimas' ),
						'left'   => esc_html__( 'Left', 'dimas' ),
						'center' => esc_html__( 'Center', 'dimas' ),
						'right'  => esc_html__( 'Right', 'dimas' ),
					),
				),
				array(
					'name'    => esc_html__( 'Background Vertical', 'dimas' ),
					'id'      => 'rz_page_boxed_bg_vertical',
					'type'    => 'select',
					'options' => array(
						''       => esc_html__( 'Default', 'dimas' ),
						'top'    => esc_html__( 'Top', 'dimas' ),
						'center' => esc_html__( 'Center', 'dimas' ),
						'bottom' => esc_html__( 'Bottom', 'dimas' ),
					),
				),
				array(
					'name'    => esc_html__( 'Background Repeat', 'dimas' ),
					'id'      => 'rz_page_boxed_bg_repeat',
					'type'    => 'select',
					'options' => array(
						''          => esc_html__( 'Default', 'dimas' ),
						'no-repeat' => esc_html__( 'No Repeat', 'dimas' ),
						'repeat'    => esc_html__( 'Repeat', 'dimas' ),
						'repeat-y'  => esc_html__( 'Repeat Vertical', 'dimas' ),
						'repeat-x'  => esc_html__( 'Repeat Horizontal', 'dimas' ),
					),
				),
				array(
					'name'    => esc_html__( 'Background Attachment', 'dimas' ),
					'id'      => 'rz_page_boxed_bg_attachment',
					'type'    => 'select',
					'options' => array(
						''       => esc_html__( 'Default', 'dimas' ),
						'scroll' => esc_html__( 'Scroll', 'dimas' ),
						'fixed'  => esc_html__( 'Fixed', 'dimas' ),
					),
				),
				array(
					'name'    => esc_html__( 'Background Size', 'dimas' ),
					'id'      => 'rz_page_boxed_bg_size',
					'type'    => 'select',
					'options' => array(
						''        => esc_html__( 'Default', 'dimas' ),
						'auto'    => esc_html__( 'Auto', 'dimas' ),
						'cover'   => esc_html__( 'Cover', 'dimas' ),
						'contain' => esc_html__( 'Contain', 'dimas' ),
					),
				),
			),
		);
	}

	/**
	 * Register footer settings
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function register_footer_settings() {
		return array(
			'id'       => 'footer-settings',
			'title'    => esc_html__( 'Footer Settings', 'dimas' ),
			'pages'    => array( 'page' ),
			'context'  => 'normal',
			'priority' => 'high',
			'fields'   => array(
				array(
					'name' => esc_html__( 'Hide Footer Section', 'dimas' ),
					'id'   => 'rz_hide_footer_section',
					'type' => 'select',
					'type' => 'checkbox',
					'std'  => false,
				),
				array(
					'name'    => esc_html__( 'Footer Border', 'dimas' ),
					'id'      => 'rz_footer_section_border_top',
					'type'    => 'select',
					'desc'    => esc_html__( 'Show/hide a divide line on top of the footer', 'dimas' ),
					'options' => array(
						'default' => esc_html__( 'Default', 'dimas' ),
						'0'       => esc_html__( 'Hide', 'dimas' ),
						'1'       => esc_html__( 'Show', 'dimas' ),
					),
				),
				array(
					'name'    => esc_html__( 'Border Color', 'dimas' ),
					'id'      => 'rz_footer_section_border_color',
					'type'    => 'select',
					'options' => array(
						'default' => esc_html__( 'Default', 'dimas' ),
						'custom'  => esc_html__( 'Custom', 'dimas' ),
					),
				),
				array(
					'name'  => esc_html__( 'Color', 'dimas' ),
					'id'    => 'rz_footer_section_custom_border_color',
					'class' => 'footer-section-custom-border-color hidden',
					'type'  => 'color',
					'std'   => false,
				),
			),
		);
	}
}
