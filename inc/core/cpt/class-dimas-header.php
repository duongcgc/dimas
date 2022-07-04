<?php
/**
 * Custom Header.
 *
 * @package Dimas
 * @version 1.0.0
 */

namespace Dimas\Core\CPT;

use Dimas\Core\CPT_Abstract;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Header
 */
class Header extends CPT_Abstract {

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
	 *
	 * Functions create header post type.
	 *
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
			'supports'            => array( 'title', 'editor', 'thumbnail' ),
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 10,
			'menu_icon'           => $this->get_icon( 'dashicons-admin-page' ),
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

\Dimas\Core\CPT\Header::instance();
