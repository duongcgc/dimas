<?php
/**
 * Base for custom post.
 *
 * @package Dimas
 */

namespace Dimas\Core;

/**
 * Class CPT_Abstract
 */
abstract class CPT_Abstract {

	/**
	 * Link image variable
	 *
	 * @var $link_image;
	 */
	public $link_image;

	/**
	 * Options variable
	 *
	 * @var $options;
	 */
	public $options;

	/**
	 * Init function
	 */
	public function __construct() {
		$this->create_post_type();
		$this->create_taxonomy();
	}

	/**
	 *
	 * The function echo body class
	 *
	 * @param string $classes The string class body.
	 * @return string
	 */
	public function body_class( $classes ) {
		return $classes;
	}

	/**
	 *
	 * The function create post type.
	 *
	 * @return void
	 */
	public function create_post_type() {
	}

	/**
	 *
	 * The function create taxonomy.
	 *
	 * @return void
	 */
	public function create_taxonomy() {
	}

	/**
	 *
	 * The function get icon.
	 *
	 * @param string $name The name of icon.
	 * @return string
	 */
	public function get_icon( $name ) {

		$name = wp_basename( $name, '.php' );
		if ( $name ) {
			return $name;
		} else {
			return 'dashicons-admin-post';
		}
	}

}
