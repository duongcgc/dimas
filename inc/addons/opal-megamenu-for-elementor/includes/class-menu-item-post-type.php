<?php

defined( 'ABSPATH' ) || exit();

/**
 * Dimas_Megamenu_Walker
 *
 * extends Walker_Nav_Menu
 */
class Dimas_Menu_Item_Post_Type {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'template_include', array( $this, 'template_include' ), 99 );
	}

	/**
	 * register post types
	 */
	public function register_post_types() {
		$labels = array(
			'name'               => _x( 'Menu Item', 'post type general name', 'dimas' ),
			'singular_name'      => _x( 'Menu', 'post type singular name', 'dimas' ),
			'menu_name'          => _x( 'Menu Items', 'admin menu', 'dimas' ),
			'name_admin_bar'     => _x( 'Menu', 'add new on admin bar', 'dimas' ),
			'add_new'            => _x( 'Add New', 'book', 'dimas' ),
			'add_new_item'       => __( 'Add New Menu', 'dimas' ),
			'new_item'           => __( 'New Menu', 'dimas' ),
			'edit_item'          => __( 'Edit Menu', 'dimas' ),
			'view_item'          => __( 'View Menu', 'dimas' ),
			'all_items'          => __( 'All Menu', 'dimas' ),
			'search_items'       => __( 'Search Items', 'dimas' ),
			'parent_item_colon'  => __( 'Parent Items:', 'dimas' ),
			'not_found'          => __( 'No menus found.', 'dimas' ),
			'not_found_in_trash' => __( 'No menus found in Trash.', 'dimas' )
		);

		$args = array(
			'labels'              => $labels,
			'hierarchical'        => false,
			'description'         => 'description',
			'taxonomies'          => array(),
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => false,
			'show_in_admin_bar'   => true,
			'menu_position'       => null,
			'menu_icon'           => null,
			'show_in_nav_menus'   => false,
			'publicly_queryable'  => true,
			'exclude_from_search' => true,
			'has_archive'         => false,
			'query_var'           => true,
			'can_export'          => true,
			'capability_type'     => 'post',
			'supports'            => array( 'title', 'editor' ),
			'rewrite'             => array( 'slug' => 'opal-menus' )
		);

		register_post_type( 'opal_menu_item', apply_filters( 'opal_elementor_menu_item_post_type', $args ) );

		add_post_type_support( 'opal_menu_item', 'elementor' );
	}

	/**
	 * template include function callback
	 */
	public function template_include( $template ) {
		if ( get_query_var( 'post_type' ) !== 'opal_menu_item' ) {
			return $template;
		}

		$template = locate_template( $this->get_templates() );


		if ( ! $template ) {
			$template = OM_PLUGIN_TEMPLATE_DIR . 'single-menu.php';
		}

		return $template;
	}

	/**
	 * templates
	 */
	public function get_templates() {
		$templates   = array();
		$object      = get_queried_object();
		$templates[] = 'single-menu-' . $object->post_name . '.php';
		$templates[] = 'single-menu.php';

		return $templates;
	}

}

new Dimas_Menu_Item_Post_Type();