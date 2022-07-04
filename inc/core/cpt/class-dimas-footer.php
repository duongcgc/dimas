<?php
/**
 * Custom Footer.
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
 * Class Footer
 */
class Footer extends CPT_Abstract {

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
	 * Functions create footer post type.
	 *
	 * @return void
	 */
	public function create_post_type() {

		$labels = array(
			'name'               => __( 'Footer', 'dimas' ),
			'singular_name'      => __( 'Footer', 'dimas' ),
			'add_new'            => __( 'Add New Footer', 'dimas' ),
			'add_new_item'       => __( 'Add New Footer', 'dimas' ),
			'edit_item'          => __( 'Edit Footer', 'dimas' ),
			'new_item'           => __( 'New Footer', 'dimas' ),
			'view_item'          => __( 'View Footer', 'dimas' ),
			'search_items'       => __( 'Search Footers', 'dimas' ),
			'not_found'          => __( 'No Footers found', 'dimas' ),
			'not_found_in_trash' => __( 'No Footers found in Trash', 'dimas' ),
			'parent_item_colon'  => __( 'Parent Footer:', 'dimas' ),
			'menu_name'          => __( 'Footer Builder', 'dimas' ),
		);

		$args = array(
			'labels'              => $labels,
			'hierarchical'        => true,
			'description'         => __( 'List Footer', 'dimas' ),
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
		register_post_type( 'footer', $args );
	}


}

\Dimas\Core\CPT\Footer::instance();
