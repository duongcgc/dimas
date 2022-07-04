<?php
/**
 * Skill functions and definitions.
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
 * Class Skill
 */
class Skill extends CPT_Abstract {

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
	 * Functions create skill post type.
	 *
	 * @return void
	 */
	public function create_post_type() {

		$labels = array(
			'all_items'          => __( 'All Skill', 'dimas' ),
			'name'               => __( 'Skill', 'dimas' ),
			'singular_name'      => __( 'Skill', 'dimas' ),
			'add_new'            => __( 'Add New Skill', 'dimas' ),
			'add_new_item'       => __( 'Add New Skill', 'dimas' ),
			'edit_item'          => __( 'Edit Skill', 'dimas' ),
			'new_item'           => __( 'New Skill', 'dimas' ),
			'view_item'          => __( 'View Skill', 'dimas' ),
			'search_items'       => __( 'Search Skill', 'dimas' ),
			'not_found'          => __( 'No Skill found', 'dimas' ),
			'not_found_in_trash' => __( 'No Skill found in Trash', 'dimas' ),
			'parent_item_colon'  => __( 'Parent Skill:', 'dimas' ),
			'menu_name'          => __( 'Skills', 'dimas' ),
		);

		$args = array(
			'label'                 => __( 'Skill', 'dimas' ),
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
			'menu_icon'             => 'data:image/svg+xml;base64,' . base64_encode( '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-stars" viewBox="0 0 16 16"><path d="M7.657 6.247c.11-.33.576-.33.686 0l.645 1.937a2.89 2.89 0 0 0 1.829 1.828l1.936.645c.33.11.33.576 0 .686l-1.937.645a2.89 2.89 0 0 0-1.828 1.829l-.645 1.936a.361.361 0 0 1-.686 0l-.645-1.937a2.89 2.89 0 0 0-1.828-1.828l-1.937-.645a.361.361 0 0 1 0-.686l1.937-.645a2.89 2.89 0 0 0 1.828-1.828l.645-1.937zM3.794 1.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387A1.734 1.734 0 0 0 4.593 5.69l-.387 1.162a.217.217 0 0 1-.412 0L3.407 5.69A1.734 1.734 0 0 0 2.31 4.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387A1.734 1.734 0 0 0 3.407 2.31l.387-1.162zM10.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732L9.1 2.137a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L10.863.1z"/></svg>' ),
			'supports'              => array( 'title', 'thumbnail', 'excerpt' ),
			'show_in_graphql'       => true,
		);
		register_post_type( 'skill', $args );
	}

	/**
	 * New modify skill table function.
	 *
	 * @param array $columns The columns of skill.
	 * @return array
	 */
	public static function new_modify_skill_table( $columns ) {
		$n_columns = array();
		foreach ( $columns as $key => $value ) {
			if ( array_key_first( $columns ) == $key ) {
				$n_columns['featured_image'] = 'Featured Image';
				$n_columns['title'] = 'Title';
			} elseif ( 'date' == $key ) {
				$n_columns['progress_skill'] = 'Progress Skill';
				$n_columns['date'] = 'Date';
			}
		}
		return $n_columns;
	}

	/**
	 * New modify skill table short function.
	 *
	 * @param array $column The column of skill.
	 * @return array
	 */
	public static function new_modify_skill_table_short( $column ) {
		$column['progress_skill'] = 'progress_skill';
		return $column;
	}

	/**
	 * New modify skill table short function.
	 *
	 * @param array $query The query of fillter skill.
	 * @return void
	 */
	public static function dimas_skill_custom_orderby( $query ) {
		if ( 'progress_skill' === $query->get( 'orderby' ) ) {
			$query->set( 'orderby', 'meta_value' );
			$query->set( 'meta_key', 'skill_progress' );
		}
	}

	/**
	 * Undocumented function
	 *
	 * @param string $column_name The name of column.
	 * @param int    $post_ID The skill id.
	 * @return void
	 */
	public static function new_modify_skill_table_row( $column_name, $post_ID ) {

		switch ( $column_name ) {
			case 'progress_skill':
				$progress_skill = get_post_field( 'skill_progress', $post_ID );
				echo esc_html( $progress_skill );
				break;
			case 'featured_image':
				$featured_img_id = get_post_thumbnail_id( $post_ID );
				echo wp_get_attachment_image( $featured_img_id, '80x80', true, '' );
				break;
		}
	}

}

\Dimas\Core\CPT\Skill::instance();


add_filter( 'manage_skill_posts_columns', array( \Dimas\Core\CPT\Skill::instance(), 'new_modify_skill_table' ) );
add_filter( 'manage_edit-skill_sortable_columns', array( \Dimas\Core\CPT\Skill::instance(), 'new_modify_skill_table_short' ) );
add_action( 'pre_get_posts', array( \Dimas\Core\CPT\Skill::instance(), 'dimas_skill_custom_orderby' ) );
add_filter( 'manage_skill_posts_custom_column', array( \Dimas\Core\CPT\Skill::instance(), 'new_modify_skill_table_row' ), 10, 3 );
