<?php
/**
 * Custom template tags for this theme
 * => all functions that echo content to theme.
 *
 * @package Dimas
 */

namespace Dimas\Framework;

use \Dimas\Framework\Template_Function;
use \Dimas\SVG_Icons;
use \Dimas\HTML;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Hooks initial
 */
class Template_Tag {



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
	 * Instantiate the object.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		 add_action( 'wp_head', array( $this, 'dimas_pingback_header' ) );
		add_action( 'wp_footer', array( $this, 'dimas_supports_js' ) );
	}

	/**
	 * Prints HTML with meta information for the current post-date/time.
	 *
	 * @since Dimas 1.0
	 *
	 * @return void
	 */
	public static function dimas_posted_on() {
		HTML::instance()->open(
			'dimas_post_info__post_date',
			array(
				'tag'  => 'h4',
				'attr' => array(
					'class' => 'dimas-post-info__post-date has-color-main label-header label-content mb-32',
				),
			)
		);

		echo esc_html( get_the_date( 'F j, Y' ) );

		HTML::instance()->close( 'dimas_post_info__post_date' );
	}

	/**
	 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
	 *
	 * @since Dimas 1.0
	 *
	 * @return void
	 */
	public static function dimas_pingback_header() {
		if ( is_singular() && pings_open() ) {
			echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
		}
	}

	/**
	 * Remove the `no-js` class from body if JS is supported.
	 *
	 * @since Dimas 1.0
	 *
	 * @return void
	 */
	public static function dimas_supports_js() {
		echo '<script>document.body.classList.remove("no-js");</script>';
	}


	/**
	 * Calculate classes for the main <html> element.
	 *
	 * @since Dimas 1.0
	 *
	 * @return void
	 */
	public static function dimas_the_html_classes() {
		$classes = apply_filters( 'dimas_html_classes', '' );
		if ( ! $classes ) {
			return;
		}
		echo 'class="' . esc_attr( $classes ) . '"';
	}

	/**
	 * Print the first instance of a block in the content, and then break away.
	 *
	 * @since Dimas 1.0
	 *
	 * @param string      $block_name The full block type name, or a partial match.
	 *                                Example: `core/image`, `core-embed/*`.
	 * @param string|null $content    The content to search in. Use null for get_the_content().
	 * @param int         $instances  How many instances of the block will be printed (max). Default  1.
	 * @return bool Returns true if a block was located & printed, otherwise false.
	 */
	public static function dimas_print_first_instance_of_block( $block_name, $content = null, $instances = 1 ) {
		$instances_count = 0;
		$blocks_content  = '';

		if ( ! $content ) {
			$content = get_the_content();
		}

		// Parse blocks in the content.
		$blocks = parse_blocks( $content );

		// Loop blocks.
		foreach ( $blocks as $block ) {

			// Sanity check.
			if ( ! isset( $block['blockName'] ) ) {
				continue;
			}

			// Check if this the block matches the $block_name.
			$is_matching_block = false;

			// If the block ends with *, try to match the first portion.
			if ( '*' === $block_name[-1] ) {
				$is_matching_block = 0 === strpos( $block['blockName'], rtrim( $block_name, '*' ) );
			} else {
				$is_matching_block = $block_name === $block['blockName'];
			}

			if ( $is_matching_block ) {
				// Increment count.
				$instances_count++;

				// Add the block HTML.
				$blocks_content .= render_block( $block );

				// Break the loop if the $instances count was reached.
				if ( $instances_count >= $instances ) {
					break;
				}
			}
		}

		if ( $blocks_content ) {
			/** This filter is documented in wp-includes/post-template.php */
			echo apply_filters( 'the_content', $blocks_content ); // phpcs:ignore WordPress.Security.EscapeOutput
			return true;
		}

		return false;
	}

	/**
	 * Display menu
	 *
	 * @param array $args The args of menu.
	 * @return void
	 * @since  1.0.0
	 */
	public static function dimas_menu( $args ) {
		$args = Template_Function::dimas_menu_args( $args );

		echo wp_kses_post( wp_nav_menu( $args ) );
	}

	/**
	 * Display logo
	 *
	 * @param array  $attrs The arrt of logo.
	 * @param string $size The size of logo.
	 * @return void
	 * @since  1.0.0
	 */
	public static function dimas_logo( $attrs, $size = 'full' ) {
		$url_logo = get_theme_mod( 'logo' );
		$id_logo  = self::dimas_get_attachment_id_from_url( $url_logo );

		if ( ! isset( $attrs['class'] ) ) {
			$attrs['class'] = 'dimas-navbar-logo';
		}
		$attrs['href'] = home_url();

		HTML::instance()->self_close_tag(
			'dimas_logo',
			array(
				'tag'  => 'a',
				'attr' => $attrs,
			),
			wp_get_attachment_image( $id_logo, $size, false, array( 'alt' => 'Dimas Logo' ) ),
		);
	}

	/**
	 * Display div open container
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function dimas_bootstrap_container_open() {
		HTML::instance()->open(
			'bootstrap_container',
			array(
				'attr'    => array(
					'class' => 'container',
				),
				'actions' => false,
			)
		);
	}

	/**
	 * Display div close container
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function dimas_bootstrap_container_close() {
		HTML::instance()->close( 'bootstrap_container' );
	}

	/**
	 * Display icon svg in class dimas svg icons
	 *
	 * @param array  $attrs The array of links to display. defaults null.
	 * @param string $group The name of the group svg.
	 * @param string $name The name of the svg.
	 * @param int    $width In the size of the svg.
	 * @param int    $heigth In the size of the svg.
	 * @return void
	 */
	public static function dimas_icon( $attrs = null, $group, $name, $width = 24, $heigth = 24 ) {
		if ( isset( $attrs ) ) {
			if ( ! isset( $attrs['class'] ) ) {
				$attrs['class'] = 'dimas-social-icon';
			}
			if ( ! isset( $attrs['href'] ) ) {
				$attrs['href'] = '##';
			}
			HTML::instance()->open(
				'dimas_icon',
				array(
					'tag'     => 'a',
					'attr'    => $attrs,
					'actions' => false,
				)
			);
		}

		SVG_Icons::sanitize_svg( Template_Function::instance()->dimas_get_icon_svg( $group, $name, $width, $heigth ) );

		if ( isset( $attrs ) ) {
			HTML::instance()->close( 'dimas_icon' );
		}
	}


	/**
	 * Html loop open function.
	 *
	 * @param array $args The arg of tag html.
	 * @return void
	 */
	public static function dimas_html_loop_open( $args ) {
		foreach ( $args as $key => $val ) {

			if ( isset( $val['tag'] ) ) {
				$arr_out[ $key ]['tag'] = $val['tag'];
			}

			if ( isset( $val['attr'] ) ) {
				$arr_out[ $key ]['attr'] = $val['attr'];
			}

			$arr_out[ $key ]['actions'] = false;

			HTML::instance()->open(
				$key,
				$arr_out[ $key ],
			);
		}
	}

	/**
	 * Html loop close function.
	 *
	 * @param array $args The arg of tag html.
	 * @return void
	 */
	public static function dimas_html_loop_close( $args ) {
		foreach ( $args as $key => $val ) {

			HTML::instance()->close(
				$key,
			);
		}
	}

	/**
	 * Swiper slide function.
	 *
	 * @param array $args The array name of swiper slide.
	 * @param int   $swiper_slide_count The count of swiper slide.
	 * @return void
	 */
	public static function dimas_swiper_loop( $args, $swiper_slide_count ) {
		$swiper_tag = array(
			'swiper',
			'swiper-wrapper',
			'swiper-slide',
		);

		foreach ( $swiper_tag as $value ) {

			if ( isset( $args[ $value ] ) ) {

				$swiper[ $value ] = $args[ $value ];

				if ( isset( $args[ $value ]['name'] ) ) {
					$swiper[ $value ]['name'] = $args[ $value ]['name'];
				} else {
					$swiper[ $value ]['name'] = $value;
				}

				if ( isset( $args[ $value ]['class'] ) ) {
					$swiper[ $value ]['class'] = $args[ $value ]['class'];
				} else {
					$swiper[ $value ]['class'] = $value;
				}

				if ( isset( $args[ $value ]['actions'] ) ) {
					$swiper[ $value ]['actions'] = $args[ $value ]['actions'];
				} else {
					$swiper[ $value ]['actions'] = false;
				}
			} else {
				$swiper[ $value ]['name']    = $value;
				$swiper[ $value ]['class']   = $value;
				$swiper[ $value ]['actions'] = false;
			}

			if ( 'swiper-slide' != $value ) {
				HTML::instance()->open(
					$swiper[ $value ]['name'],
					array(
						'attr'    => array(
							'class' => $swiper[ $value ]['class'],
						),
						'actions' => $swiper[ $value ]['actions'],
					)
				);
			}
		}

		for ( $i = 1; $i <= $swiper_slide_count; $i++ ) {

			HTML::instance()->open(
				$swiper[ $value ]['name'] . '_' . $i,
				array(
					'attr'    => array(
						'class' => $swiper[ $value ]['class'],
					),
					'actions' => $swiper[ $value ]['actions'],
				)
			);

			HTML::instance()->close( $swiper[ $value ]['name'] . '_' . $i );
		}

		foreach ( $swiper_tag as $value ) {

			if ( 'swiper-slide' != $value ) {
				HTML::instance()->close( $swiper[ $value ]['name'] );
			}
		}
	}

	/**
	 * Post link open function.
	 *
	 * @return void
	 */
	public static function dimas_post_link_open() {
		HTML::instance()->open(
			'post__link',
			array(
				'tag'  => 'a',
				'attr' => array(
					'class' => 'dimas-post__link',
					'href'  => get_the_permalink(),
				),
			)
		);
	}

	/**
	 * Post link close function.
	 *
	 * @return void
	 */
	public static function dimas_post_link_close() {
		HTML::instance()->close( 'post__link' );
	}

	/**
	 * Post info date function.
	 *
	 * @return void
	 */
	public static function dimas_post_date() {
		HTML::instance()->self_close_tag(
			'post__date',
			array(
				'tag'  => 'h6',
				'attr' => array(
					'class' => 'dimas-post__date has-color-main label-content mb-3',
				),
			),
			get_the_date(),
		);
	}

	/**
	 * Post title function.
	 *
	 * @return void
	 */
	public static function dimas_post_title() {
		HTML::instance()->self_close_tag(
			'post__title',
			array(
				'tag'  => 'h3',
				'attr' => array(
					'class' => 'dimas-post__title has-color-white mb-3',
				),
			),
			get_the_title(),
		);
	}

	/**
	 * Post excerpt function.
	 *
	 * @return void
	 */
	public static function dimas_post_excerpt() {
		HTML::instance()->self_close_tag(
			'post__excerpt',
			array(
				'tag'  => 'p',
				'attr' => array(
					'class' => 'dimas-post__description mb-0 has-color-subtitle',
				),
			),
			get_the_excerpt(),
		);
	}

	/**
	 * Post pagination function.
	 *
	 * @return void
	 */
	public static function dimas_post_pagination() {

		$pagination = Template_Function::dimas_get_post_pagination();

		echo wp_kses(
			$pagination,
			array(
				'ul'   => array(
					'class' => array(),
				),
				'li'   => array(
					'class' => array(),
				),
				'span' => array(
					'class' => array(),
				),
				'a'    => array(
					'href'  => array(),
					'title' => array(),
					'rel'   => array(),
				),
				'svg'  => array(
					'width'   => array(),
					'height'  => array(),
					'fill'    => array(),
					'xmlns'   => array(),
					'viewbox' => array(),
				),
				'path' => array(
					'd'              => array(),
					'stroke'         => array(),
					'stroke-width'   => array(),
					'stroke-linecap' => array(),
				),
			)
		);
	}

	/**
	 * Post tags function.
	 *
	 * @return void
	 */
	public static function dimas_post_tags() {
		$arr_tags = get_the_tags();
		if ( $arr_tags ) :

			HTML::instance()->open(
				'post__tag',
				array(
					'attr' => array(
						'class' => 'dimas-post__tag d-flex flex-wrap mt-3 mt-md-8 col-md-8 mx-auto',
					),
				)
			);

			HTML::instance()->self_close_tag(
				'post__tag_title',
				array(
					'tag'  => 'h3',
					'attr' => array(
						'class' => 'me-3 mb-3 has-color-white',
					),
				),
				__( 'Tags:', 'dimas' ),
			);

			foreach ( $arr_tags as  $value ) :

				HTML::instance()->open(
					'post__tag_link',
					array(
						'tag'  => 'a',
						'attr' => array(
							'href' => get_term_link( $value->term_id, 'post_tag' ),
						),
					)
				);

				HTML::instance()->self_close_tag(
					'tag',
					array(
						'tag'  => 'p',
						'attr' => array(
							'class' => 'post-tag',
						),
					),
					$value->name,
				);

				HTML::instance()->close( 'post__tag_link' );

			endforeach;

			HTML::instance()->close( 'post__tag' );

		endif;
	}

	/**
	 * Home page navigation function.
	 *
	 * @param string $menu_name The name of the menu.
	 * @return void|boolean
	 */
	public static function dimas_home_page_navigation( $menu_name ) {
		$locations = get_nav_menu_locations();

		if ( isset( $locations[ $menu_name ] ) ) {

			$menu_main = wp_get_nav_menu_object( $locations[ $menu_name ] );

			$menu_items = wp_get_nav_menu_items( $menu_main->term_id );

			$menu_list_prev = '<li><a class="prev" href="##"><svg width="28" height="16" viewBox="0 0 28 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2 14L14 2L26 14" stroke="currentColor" stroke-width="2" stroke-linecap="square"/></svg></a></li>';

			$menu_list = '';

			foreach ( $menu_items as $key => $menu_item ) {
				$title_item = $menu_item->title;
				$url        = $menu_item->url;
				$menu_list .= '<li><a href="' . $url . '" data-menuanchor="' . ucfirst( $title_item ) . '"></a></li>';
			}

			$menu_list_next = '<li><a class="next" href="#"><svg width="28" height="16" viewBox="0 0 28 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2 2L14 14L26 2" stroke="currentColor" stroke-width="2" stroke-linecap="square"/></svg></a></li>';

			SVG_Icons::sanitize_svg( $menu_list_prev );

			echo wp_kses_post( $menu_list );

			SVG_Icons::sanitize_svg( $menu_list_next );
		} else {
			return false;
		}
	}

	/**
	 * Get attachment id from url function
	 *
	 * @param string $attachment_url The url of the attachment.
	 * @return void
	 */
	public static function dimas_get_attachment_id_from_url( $attachment_url = '' ) {

		global $wpdb;
		$attachment_id = false;

		// If there is no url, return.
		if ( '' == $attachment_url ) {
			return;
		}

		// Get the upload directory paths.
		$upload_dir_paths = wp_upload_dir();

		// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image.
		if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {

			// If this is the URL of an auto-generated thumbnail, get the URL of the original image.
			$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );

			// Remove the upload path base directory from the attachment URL.
			$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );

			// Finally, run a custom database query to get the attachment ID from the modified attachment URL.
			$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );
		}
		return $attachment_id;
	}
}
