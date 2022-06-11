<?php
/**
 * Custom Header.
 *
 * @package Dimas
 * @version 1.0.0
 */

namespace Dimas\CPT;

use Dimas\CPT_Abstract;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class GO_Header
 */
class GO_Header extends CPT_Abstract {

	/**
	 * @return void
	 */
	public function create_post_type() {

		$labels = array(
			'name'               => __( 'Header', 'dimas' ),
			'singular_name'      => __( 'Header', 'dimas' ),
			'add_new'            => __( 'Add New Header', 'dimas' ),
			'add_new_item'       => __( 'Add New Header', 'dimas' ),
			'edit_item'          => __( 'Edit Header', 'dimas' ),
			'new_item'           => __( 'New Header', 'dimas' ),
			'view_item'          => __( 'View Header', 'dimas' ),
			'search_items'       => __( 'Search Headers', 'dimas' ),
			'not_found'          => __( 'No Headers found', 'dimas' ),
			'not_found_in_trash' => __( 'No Headers found in Trash', 'dimas' ),
			'parent_item_colon'  => __( 'Parent Header:', 'dimas' ),
			'menu_name'          => __( 'Header Builder', 'dimas' ),
		);

		$args = array(
			'labels'              => $labels,
			'hierarchical'        => true,
			'description'         => __( 'List Header', 'dimas' ),
			'supports'            => array( 'title', 'editor', 'thumbnail' ), // page-attributes, post-formats
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 5,
			'menu_icon'           => $this->get_icon( __FILE__ ),
			'show_in_nav_menus'   => false,
			'publicly_queryable'  => true,
			'exclude_from_search' => true,
			'has_archive'         => true,
			'query_var'           => true,
			'can_export'          => true,
			'rewrite'             => true,
			'capability_type'     => 'post',
		);
		register_post_type( 'header', $args );
	}

}

new CPT_Header();

