<?php
/**
 * Testimonial functions and definitions.
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
 * Class Testimonial
 */
class Testimonial extends CPT_Abstract {

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
	 * Functions create testimonial post type.
	 *
	 * @return void
	 */
	public function create_post_type() {

		$labels = array(
			'all_items'          => __( 'All Testimonial', 'dimas' ),
			'name'               => __( 'Testimonial', 'dimas' ),
			'singular_name'      => __( 'Testimonial', 'dimas' ),
			'add_new'            => __( 'Add New Testimonial', 'dimas' ),
			'add_new_item'       => __( 'Add New Testimonial', 'dimas' ),
			'edit_item'          => __( 'Edit Testimonial', 'dimas' ),
			'new_item'           => __( 'New Testimonial', 'dimas' ),
			'view_item'          => __( 'View Testimonial', 'dimas' ),
			'search_items'       => __( 'Search Testimonial', 'dimas' ),
			'not_found'          => __( 'No Testimonial found', 'dimas' ),
			'not_found_in_trash' => __( 'No Testimonial found in Trash', 'dimas' ),
			'parent_item_colon'  => __( 'Parent Testimonial:', 'dimas' ),
			'menu_name'          => __( 'Testimonials', 'dimas' ),
		);

		$args = array(
			'label'                 => __( 'Testimonial', 'dimas' ),
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
			'menu_icon'             => 'data:image/svg+xml;base64,' . base64_encode( '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-dots-fill" viewBox="0 0 16 16"><path d="M16 8c0 3.866-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.584.296-1.925.864-4.181 1.234-.2.032-.352-.176-.273-.362.354-.836.674-1.95.77-2.966C.744 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7zM5 8a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm4 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/></svg>' ),
			'supports'              => array( 'title', 'thumbnail', 'excerpt' ),
			'show_in_graphql'       => true,
		);
		register_post_type( 'testimonial', $args );
	}

}

\Dimas\Core\CPT\Testimonial::instance();
