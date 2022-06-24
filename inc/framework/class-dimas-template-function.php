<?php
/**
 * Functions which enhance the theme by hooking into WordPress hooks.
 * => all functions that return value or hang on into WordPress hooks.
 *
 * @package Dimas
 */

 namespace Dimas\Framework;

use \Dimas\SVG_Icons;
use \Dimas\Dynamic_CSS;
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Hooks initial
 */
class Template_Function {
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

		add_filter( 'comment_form_defaults', array( $this, 'dimas_comment_form_defaults' ) );

		// Filter the excerpt more link.
		add_filter( 'excerpt_more', array( $this, 'dimas_continue_reading_link_excerpt' ) );

		// Filter the content more link.
		add_filter( 'the_content_more_link', array( $this, 'dimas_continue_reading_link' ) );

		add_filter( 'the_title', array( $this, 'dimas_post_title' ) );
		add_filter( 'get_calendar', array( $this, 'dimas_change_calendar_nav_arrows' ) );
		add_filter( 'the_password_form', array( $this, 'dimas_password_form' ), 10, 2 );
		// add_filter( 'wp_get_attachment_image_attributes', array( $this, 'dimas_get_attachment_image_attributes' ), 10, 3 );.

		add_action( 'wp_footer', array( $this, 'dimas_add_ie_class' ) );

	}


	/**
	 * Changes comment form default fields.
	 *
	 * @since Dimas 1.0
	 *
	 * @param array $defaults The form defaults.
	 * @return array
	 */
	public function dimas_comment_form_defaults( $defaults ) {

		// Adjust height of comment form.
		$defaults['comment_field'] = preg_replace( '/rows="\d+"/', 'rows="5"', $defaults['comment_field'] );

		return $defaults;
	}

	/**
	 * Determines if post thumbnail can be displayed.
	 *
	 * @since Dimas 1.0
	 *
	 * @return bool
	 */
	public function dimas_can_show_post_thumbnail() {
		/**
		 * Filters whether post thumbnail can be displayed.
		 *
		 * @since Dimas 1.0
		 *
		 * @param bool $show_post_thumbnail Whether to show post thumbnail.
		 */
		return apply_filters(
			'dimas_can_show_post_thumbnail',
			! post_password_required() && ! is_attachment() && has_post_thumbnail()
		);
	}

	/**
	 * Returns the size for avatars used in the theme.
	 *
	 * @since Dimas 1.0
	 *
	 * @return int
	 */
	public function dimas_get_avatar_size() {
		return 80;
	}

	/**
	 * Creates continue reading text.
	 *
	 * @since Dimas 1.0
	 */
	public function dimas_continue_reading_text() {
		$continue_reading = sprintf(
		/* translators: %s: Post title. Only visible to screen readers. */
			esc_html__( 'Continue reading %s', 'dimas' ),
			the_title( '<span class="screen-reader-text">', '</span>', false )
		);

		return $continue_reading;
	}

	/**
	 * Creates the continue reading link for excerpt.
	 *
	 * @since Dimas 1.0
	 */
	public function dimas_continue_reading_link_excerpt() {
		if ( ! is_admin() ) {
			return '&hellip; <a class="more-link" href="' . esc_url( get_permalink() ) . '">' . $this->dimas_continue_reading_text() . '</a>';
		}
	}

	/**
	 * Creates the continue reading link.
	 *
	 * @since Dimas 1.0
	 */
	public function dimas_continue_reading_link() {
		if ( ! is_admin() ) {
			return '<div class="more-link-container"><a class="more-link" href="' . esc_url( get_permalink() ) . '#more-' . esc_attr( get_the_ID() ) . '">' . dimas_continue_reading_text() . '</a></div>';
		}
	}

	/**
	 * Adds a title to posts and pages that are missing titles.
	 *
	 * @since Dimas 1.0
	 *
	 * @param string $title The title.
	 * @return string
	 */
	public function dimas_post_title( $title ) {
		return '' === $title ? esc_html_x( 'Untitled', 'Added to posts and pages that are missing titles', 'dimas' ) : $title;
	}


	/**
	 * Gets the SVG code for a given icon.
	 *
	 * @since Dimas 1.0
	 *
	 * @param string $group The icon group.
	 * @param string $icon  The icon.
	 * @param int    $width The icon-width in pixels.
	 * @param int    $height The icon-height in pixels.
	 * @return string
	 */
	public function dimas_get_icon_svg( $group, $icon, $width = 24, $height = 24 ) {
		return SVG_Icons::get_svg( $group, $icon, $width, $height );
	}

	/**
	 * Changes the default navigation arrows to svg icons
	 *
	 * @since Dimas 1.0
	 *
	 * @param string $calendar_output The generated HTML of the calendar.
	 * @return string
	 */
	public function dimas_change_calendar_nav_arrows( $calendar_output ) {
		$calendar_output = str_replace( '&laquo; ', is_rtl() ? dimas_get_icon_svg( 'ui', 'arrow_right' ) : dimas_get_icon_svg( 'ui', 'arrow_left' ), $calendar_output );
		$calendar_output = str_replace( ' &raquo;', is_rtl() ? dimas_get_icon_svg( 'ui', 'arrow_left' ) : dimas_get_icon_svg( 'ui', 'arrow_right' ), $calendar_output );
		return $calendar_output;
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
	public function dimas_print_first_instance_of_block( $block_name, $content = null, $instances = 1 ) {
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
	 * Retrieve protected post password form content.
	 *
	 * @since Dimas 1.0
	 * @since Dimas 1.4 Corrected parameter name for `$output`,
	 *                              added the `$post` parameter.
	 *
	 * @param string      $output The password form HTML output.
	 * @param int|WP_Post $post   Optional. Post ID or WP_Post object. Default is global $post.
	 * @return string HTML content for password form for password protected post.
	 */
	public function dimas_password_form( $output, $post = 0 ) {
		$post   = get_post( $post );
		$label  = 'pwbox-' . ( empty( $post->ID ) ? wp_rand() : $post->ID );
		$output = '<p class="post-password-message">' . esc_html__( 'This content is password protected. Please enter a password to view.', 'dimas' ) . '</p>
	<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" class="post-password-form" method="post">
	<label class="post-password-form__label" for="' . esc_attr( $label ) . '">' . esc_html_x( 'Password', 'Post password form', 'dimas' ) . '</label><input class="post-password-form__input" name="post_password" id="' . esc_attr( $label ) . '" type="password" size="20" /><input type="submit" class="post-password-form__submit" name="' . esc_attr_x( 'Submit', 'Post password form', 'dimas' ) . '" value="' . esc_attr_x( 'Enter', 'Post password form', 'dimas' ) . '" /></form>
	';
		return $output;
	}

	/**
	 * Filters the list of attachment image attributes.
	 *
	 * @since Dimas 1.0
	 *
	 * @param string[]     $attr       Array of attribute values for the image markup, keyed by attribute name.
	 *                                 See wp_get_attachment_image().
	 * @param WP_Post      $attachment Image attachment post.
	 * @param string|int[] $size       Requested image size. Can be any registered image size name, or
	 *                                 an array of width and height values in pixels (in that order).
	 * @return string[] The filtered attributes for the image markup.
	 */
	public function dimas_get_attachment_image_attributes( $attr, $attachment, $size ) {

		if ( is_admin() ) {
			return $attr;
		}

		if ( isset( $attr['class'] ) && false !== strpos( $attr['class'], 'custom-logo' ) ) {
			return $attr;
		}

		$width  = false;
		$height = false;

		if ( is_array( $size ) ) {
			$width  = (int) $size[0];
			$height = (int) $size[1];
		} elseif ( $attachment && is_object( $attachment ) && $attachment->ID ) {
			$meta = wp_get_attachment_metadata( $attachment->ID );
			if ( isset( $meta['width'] ) && isset( $meta['height'] ) ) {
				$width  = (int) $meta['width'];
				$height = (int) $meta['height'];
			}
		}

		if ( $width && $height ) {

			// Add style.
			$attr['style'] = isset( $attr['style'] ) ? $attr['style'] : '';
			$attr['style'] = 'width:100%;height:' . round( 100 * $height / $width, 2 ) . '%;max-width:' . $width . 'px;' . $attr['style'];
		}

		return $attr;
	}

	/**
	 * Add "is-IE" class to body if the user is on Internet Explorer.
	 *
	 * @since Dimas 1.0
	 *
	 * @return void
	 */
	public function dimas_add_ie_class() {
		?>
	<script>
	if ( -1 !== navigator.userAgent.indexOf( 'MSIE' ) || -1 !== navigator.appVersion.indexOf( 'Trident/' ) ) {
		document.body.classList.add( 'is-IE' );
	}
	</script>
		<?php
	}

	/**
	 * Retrieves the list item separator based on the locale.
	 *
	 * Added for backward compatibility to support pre-6.0.0 WordPress versions.
	 *
	 * @since 6.0.0
	 */
	public static function wp_get_list_item_separator() {
		/* translators: Used between list items, there is a space after the comma. */
		return __( ', ', 'dimas' );
	}

	/**
	 * Custom Excerpt Function
	 *
	 * @param   int    $limit The number of limit excerpt words.
	 * @param   string $afterlimit The string after excerpt content.
	 * @return  string
	 */
	public static function dimas_fnc_excerpt( $limit, $afterlimit = '[...]' ) {
		$excerpt = get_the_excerpt();
		$limit   = empty( $limit ) ? 20 : $limit;
		if ( '' != $excerpt ) {
			$excerpt = @explode( ' ', strip_tags( $excerpt ), $limit );
		} else {
			$excerpt = @explode( ' ', strip_tags( get_the_content() ), $limit );
		}
		if ( count( $excerpt ) >= $limit ) {
			@array_pop( $excerpt );
			$excerpt = @implode( ' ', $excerpt ) . ' ' . $afterlimit;
		} else {
			$excerpt = @implode( ' ', $excerpt );
		}
		$excerpt = preg_replace( '`[[^]]*]`', '', $excerpt );

		return strip_shortcodes( $excerpt );
	}

	/**
	 * Do custom Shortcodes.
	 *
	 * @param string $tag The tag name.
	 * @param array  $atts The atts array.
	 * @param string $content The content.
	 * @return string
	 */
	public static function dimas_do_shortcode( $tag, array $atts = array(), $content = null ) {
		global $shortcode_tags;

		if ( ! isset( $shortcode_tags[ $tag ] ) ) {
			return false;
		}

		return call_user_func( $shortcode_tags[ $tag ], $atts, $content, $tag );
	}

	/**
	 * Do get dimas menu args.
	 *
	 * @param array $args The args of menu.
	 *
	 * @return array
	 */
	public static function dimas_menu_args( $args ) {
		$defaults_args = array(
			'theme_location'  => 'primary-menu',
			'menu_class'      => 'dimas-menu',
			'container'       => 'nav',
			'fallback_cb'     => false,
			'echo'            => false,
			'container_class' => 'dimas-offcanvas-menu__navigation',
		);

		foreach ( $args as $key => $value ) {
			if ( $defaults_args[ $key ] ) {
				$defaults_args[ $key ] = $value;
			}
		}
		return $defaults_args;
	}

	/**
	 * Get post pagination function.
	 *
	 * @return string
	 */
	public static function dimas_get_post_pagination() {
		global $wp_query;
		$max_page = $wp_query->max_num_pages;
		$big      = 9999999;
		$arr_pag  = paginate_links(
			array(
				'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format'    => '?paged=%#%',
				'next_text' => '<svg width="20" height="36" viewBox="0 0 20 36" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.66699 34L17.667 18L1.66699 2" stroke="currentColor" stroke-width="2" stroke-linecap="square"></path></svg>',
				'prev_text' => '<svg width="20" height="36" viewBox="0 0 20 36" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18.333 34L2.33301 18L18.333 2" stroke="currentColor" stroke-width="2" stroke-linecap="square"></path></svg>',
				'current'   => max( 1, get_query_var( 'paged' ) ),
				'total'     => $max_page,
				'end_size'  => 1,
				'mid_size'  => 1,
				'type'      => 'array',
			)
		);
		$out      = '<ul class="dimas-pagination__wrap">';
		foreach ( $arr_pag as $key => $value ) :
			if ( str_contains( $value, 'prev' ) ) :
				$out .= '<li class="dimas-pagination__item prev-page">' . $value;
				$out .= '</li>';
			elseif ( str_contains( $value, 'next' ) ) :
				$out .= '<li class="dimas-pagination__item next-page">' . $value;
				$out .= '</li>';
			elseif ( str_contains( $value, 'current' ) ) :
				$out .= '<li class="dimas-pagination__item current-page">' . $value;
				$out .= '</li>';
			elseif ( str_contains( $value, 'dots' ) ) :
				$out .= '<li class="dimas-pagination__item dot-page">' . $value;
				$out .= '</li>'; else :
					$out .= '<li class="dimas-pagination__item">' . $value;
					$out .= '</li>';
			endif;
		endforeach;
		$out .= '</ul>';
		return $out;
	}
}
