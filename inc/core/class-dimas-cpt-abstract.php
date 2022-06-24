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
		// $this->create_meta_box();.
		// $this->widgets_init();.

		// add_filter( 'dimas_customizer_buttons', array( $this, 'customizer_buttons' ) );.

		// add_action( 'widgets_init', array( $this, 'widgets_init' ), 9 );.
		// add_filter( 'template_include', array( $this, 'get_page_template_file' ), 99 );.
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
	 * The function create metabox.
	 *
	 * @return void
	 */
	public function create_meta_box() {
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

	/**
	 * Customizer Button function
	 *
	 * @param string $buttons Button name.
	 * @return string
	 */
	public function customizer_buttons( $buttons ) {
		return $buttons;
	}

	/**
	 * Wp customize function
	 *
	 * @param  array $wp_customize Wp customize.
	 * @return void
	 */
	public function customize_register( $wp_customize ) {
	}

	/**
	 * Widgets init function
	 *
	 * @return void
	 */
	public function widgets_init() {
	}

	/**
	 * Get page template file function
	 *
	 * @param  string $template Get page template file.
	 * @return string
	 */
	public function get_page_template_file( $template ) {
		return $template;
	}
}
