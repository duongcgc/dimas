<?php
/**
 * Project functions and definitions.
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
 * Class Project
 */
class Project extends CPT_Abstract {

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
	 * Functions create project post type.
	 *
	 * @return void
	 */
	public function create_post_type() {

		$labels = array(
			'all_items'          => __( 'All Project', 'dimas' ),
			'name'               => __( 'Project', 'dimas' ),
			'singular_name'      => __( 'Project', 'dimas' ),
			'add_new'            => __( 'Add New Project', 'dimas' ),
			'add_new_item'       => __( 'Add New Project', 'dimas' ),
			'edit_item'          => __( 'Edit Project', 'dimas' ),
			'new_item'           => __( 'New Project', 'dimas' ),
			'view_item'          => __( 'View Project', 'dimas' ),
			'search_items'       => __( 'Search Project', 'dimas' ),
			'not_found'          => __( 'No Project found', 'dimas' ),
			'not_found_in_trash' => __( 'No Project found in Trash', 'dimas' ),
			'parent_item_colon'  => __( 'Parent Project:', 'dimas' ),
			'menu_name'          => __( 'Projects', 'dimas' ),
		);

		$args = array(
			'label'                 => __( 'Project', 'dimas' ),
			'labels'                => $labels,
			'description'           => '',
			'public'                => true,
			'publicly_queryable'    => true,
			'show_ui'               => true,
			'show_in_rest'          => true,
			'rest_base'             => '',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
			'has_archive'           => true,
			'show_in_menu'          => true,
			'show_in_nav_menus'     => true,
			'delete_with_user'      => false,
			'exclude_from_search'   => false,
			'capability_type'       => 'post',
			'map_meta_cap'          => true,
			'hierarchical'          => true,
			'rewrite'               => true,
			'query_var'             => true,
			'menu_position'         => 10,
			'menu_icon'             => 'data:image/svg+xml;base64,' . base64_encode( '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-projector-fill" viewBox="0 0 16 16"><path d="M2 4a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1h6a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H2Zm.5 2h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1 0-1ZM14 7.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm-12 1a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5Z"/></svg>' ),
			'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
			'show_in_graphql'       => true,
		);
		register_post_type( 'project', $args );
	}
	/**
	 * The function create taxonomy.
	 *
	 * @return void
	 */
	public function create_taxonomy() {

		$labels = array(
			'name'      => 'Branch Project',
			'singular'  => 'Branch Project',
			'menu_name' => 'Branch Project',
		);
		$args   = array(
			'labels'            => $labels,
			'hierarchical'      => true,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'show_in_rest'      => true,
			'show_tagcloud'     => false,
		);
		register_taxonomy( 'branch-project', 'project', $args );
	}

}

\Dimas\Core\CPT\Project::instance();
