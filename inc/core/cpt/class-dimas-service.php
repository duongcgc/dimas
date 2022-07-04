<?php
/**
 * Services functions and definitions.
 * => Custom Post Type Template
 *
 * @package Dimas
 */

namespace Dimas\Core\CPT;

use Dimas\Core\CPT_Abstract;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Services
 */
class Services extends CPT_Abstract {

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
	 * Functions create service post type.
	 *
	 * @return void
	 */
	public function create_post_type() {

		$labels = array(
			'all_items'          => __( 'All Service', 'dimas' ),
			'name'               => __( 'Service', 'dimas' ),
			'singular_name'      => __( 'Service', 'dimas' ),
			'add_new'            => __( 'Add New Service', 'dimas' ),
			'add_new_item'       => __( 'Add New Service', 'dimas' ),
			'edit_item'          => __( 'Edit Service', 'dimas' ),
			'new_item'           => __( 'New Service', 'dimas' ),
			'view_item'          => __( 'View Service', 'dimas' ),
			'search_items'       => __( 'Search Service', 'dimas' ),
			'not_found'          => __( 'No Service found', 'dimas' ),
			'not_found_in_trash' => __( 'No Service found in Trash', 'dimas' ),
			'parent_item_colon'  => __( 'Parent Service:', 'dimas' ),
			'menu_name'          => __( 'Services', 'dimas' ),
		);

		$args = array(
			'label'                 => __( 'Services', 'dimas' ),
			'labels'                => $labels,
			'description'           => '',
			'public'                => false,
			'publicly_queryable'    => true,
			'show_ui'               => true,
			'show_in_rest'          => true,
			'rest_base'             => '',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
			'has_archive'           => false,
			'show_in_menu'          => true,
			'show_in_nav_menus'     => true,
			'delete_with_user'      => false,
			'exclude_from_search'   => false,
			'capability_type'       => 'post',
			'map_meta_cap'          => true,
			'hierarchical'          => false,
			'rewrite'               => true,
			'query_var'             => true,
			'menu_position'         => 10,
			'menu_icon'             => 'data:image/svg+xml;base64,' . base64_encode( '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-table" viewBox="0 0 16 16"><path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm15 2h-4v3h4V4zm0 4h-4v3h4V8zm0 4h-4v3h3a1 1 0 0 0 1-1v-2zm-5 3v-3H6v3h4zm-5 0v-3H1v2a1 1 0 0 0 1 1h3zm-4-4h4V8H1v3zm0-4h4V4H1v3zm5-3v3h4V4H6zm4 4H6v3h4V8z"/></svg>' ),
			'supports'              => array( 'title', 'thumbnail', 'excerpt' ),
			'show_in_graphql'       => true,
		);
		register_post_type( 'service', $args );
	}

}

\Dimas\Core\CPT\Services::instance();
