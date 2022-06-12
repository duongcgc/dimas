<?php
/**
 * Functions which enhance the theme by hooking into WordPress hooks.
 * => all functions that return value or hang on into WordPress hooks.
 *
 * @package Dimas
 */

namespace Dimas\Framework;

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
		add_filter( 'body_class', array( $this, 'dimas_body_classes' ) );
		add_filter( 'post_class', array( $this, 'dimas_post_classes' ), 10, 3 );
		add_action( 'wp_head', array( $this, 'dimas_pingback_header' ) );
		add_action( 'wp_footer', array( $this, 'dimas_supports_js' ) );
		add_filter( 'comment_form_defaults', array( $this, 'dimas_comment_form_defaults' ) );

		// Filter the excerpt more link.
		add_filter( 'excerpt_more', array( $this, 'dimas_continue_reading_link_excerpt' ) );

		// Filter the content more link.
		add_filter( 'the_content_more_link', array( $this, 'dimas_continue_reading_link' ) );

		add_filter( 'the_title', array( $this, 'dimas_post_title' ) );
		add_filter( 'get_calendar', array( $this, 'dimas_change_calendar_nav_arrows' ) );
		add_filter( 'the_password_form', array( $this, 'dimas_password_form' ), 10, 2 );
		add_filter( 'wp_get_attachment_image_attributes', array( $this, 'dimas_get_attachment_image_attributes' ), 10, 3 );

		add_action( 'wp_footer', array( $this, 'dimas_add_ie_class' ) );

	}
	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @since Dimas 1.0
	 *
	 * @param array $classes Classes for the body element.
	 * @return array
	 */
	public function dimas_body_classes( $classes ) {

		// Helps detect if JS is enabled or not.
		$classes[] = 'no-js';

		// Adds `singular` to singular pages, and `hfeed` to all other pages.
		$classes[] = is_singular() ? 'singular' : 'hfeed';

		// Add a body class if main navigation is active.
		if ( has_nav_menu( 'primary' ) ) {
			$classes[] = 'has-main-navigation';
		}

		// Add a body class if there are no footer widgets.
		if ( ! is_active_sidebar( 'sidebar-1' ) ) {
			$classes[] = 'no-widgets';
		}

		return $classes;
	}

	/**
	 * Adds custom class to the array of posts classes.
	 *
	 * @since Dimas 1.0
	 *
	 * @param array $classes An array of CSS classes.
	 * @return array
	 */
	public function dimas_post_classes( $classes ) {
		$classes[] = 'entry';

		return $classes;
	}

	/**
	 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
	 *
	 * @since Dimas 1.0
	 *
	 * @return void
	 */
	public function dimas_pingback_header() {
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
	public function dimas_supports_js() {
		echo '<script>document.body.classList.remove("no-js");</script>';
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
		return 60;
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
	 * @param int    $size  The icon size in pixels.
	 * @return string
	 */
	public function dimas_get_icon_svg( $group, $icon, $size = 24 ) {
		return \Dimas\SVG_Icons::get_svg( $group, $icon, $size );
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
	 * Get custom CSS.
	 *
	 * Return CSS for non-latin language, if available, or null
	 *
	 * @since Dimas 1.0
	 *
	 * @param string $type Whether to return CSS for the "front-end", "block-editor", or "classic-editor".
	 * @return string
	 */
	public function dimas_get_non_latin_css( $type = 'front-end' ) {

		// Fetch site locale.
		$locale = get_bloginfo( 'language' );

		/**
		 * Filters the fallback fonts for non-latin languages.
		 *
		 * @since Dimas 1.0
		 *
		 * @param array $font_family An array of locales and font families.
		 */
		$font_family = apply_filters(
			'dimas_get_localized_font_family_types',
			array(

				// Arabic.
				'ar'    => array( 'Tahoma', 'Arial', 'sans-serif' ),
				'ary'   => array( 'Tahoma', 'Arial', 'sans-serif' ),
				'azb'   => array( 'Tahoma', 'Arial', 'sans-serif' ),
				'ckb'   => array( 'Tahoma', 'Arial', 'sans-serif' ),
				'fa-IR' => array( 'Tahoma', 'Arial', 'sans-serif' ),
				'haz'   => array( 'Tahoma', 'Arial', 'sans-serif' ),
				'ps'    => array( 'Tahoma', 'Arial', 'sans-serif' ),

				// Chinese Simplified (China) - Noto Sans SC.
				'zh-CN' => array( '\'PingFang SC\'', '\'Helvetica Neue\'', '\'Microsoft YaHei New\'', '\'STHeiti Light\'', 'sans-serif' ),

				// Chinese Traditional (Taiwan) - Noto Sans TC.
				'zh-TW' => array( '\'PingFang TC\'', '\'Helvetica Neue\'', '\'Microsoft YaHei New\'', '\'STHeiti Light\'', 'sans-serif' ),

				// Chinese (Hong Kong) - Noto Sans HK.
				'zh-HK' => array( '\'PingFang HK\'', '\'Helvetica Neue\'', '\'Microsoft YaHei New\'', '\'STHeiti Light\'', 'sans-serif' ),

				// Cyrillic.
				'bel'   => array( '\'Helvetica Neue\'', 'Helvetica', '\'Segoe UI\'', 'Arial', 'sans-serif' ),
				'bg-BG' => array( '\'Helvetica Neue\'', 'Helvetica', '\'Segoe UI\'', 'Arial', 'sans-serif' ),
				'kk'    => array( '\'Helvetica Neue\'', 'Helvetica', '\'Segoe UI\'', 'Arial', 'sans-serif' ),
				'mk-MK' => array( '\'Helvetica Neue\'', 'Helvetica', '\'Segoe UI\'', 'Arial', 'sans-serif' ),
				'mn'    => array( '\'Helvetica Neue\'', 'Helvetica', '\'Segoe UI\'', 'Arial', 'sans-serif' ),
				'ru-RU' => array( '\'Helvetica Neue\'', 'Helvetica', '\'Segoe UI\'', 'Arial', 'sans-serif' ),
				'sah'   => array( '\'Helvetica Neue\'', 'Helvetica', '\'Segoe UI\'', 'Arial', 'sans-serif' ),
				'sr-RS' => array( '\'Helvetica Neue\'', 'Helvetica', '\'Segoe UI\'', 'Arial', 'sans-serif' ),
				'tt-RU' => array( '\'Helvetica Neue\'', 'Helvetica', '\'Segoe UI\'', 'Arial', 'sans-serif' ),
				'uk'    => array( '\'Helvetica Neue\'', 'Helvetica', '\'Segoe UI\'', 'Arial', 'sans-serif' ),

				// Devanagari.
				'bn-BD' => array( 'Arial', 'sans-serif' ),
				'hi-IN' => array( 'Arial', 'sans-serif' ),
				'mr'    => array( 'Arial', 'sans-serif' ),
				'ne-NP' => array( 'Arial', 'sans-serif' ),

				// Greek.
				'el'    => array( '\'Helvetica Neue\', Helvetica, Arial, sans-serif' ),

				// Gujarati.
				'gu'    => array( 'Arial', 'sans-serif' ),

				// Hebrew.
				'he-IL' => array( '\'Arial Hebrew\'', 'Arial', 'sans-serif' ),

				// Japanese.
				'ja'    => array( 'sans-serif' ),

				// Korean.
				'ko-KR' => array( '\'Apple SD Gothic Neo\'', '\'Malgun Gothic\'', '\'Nanum Gothic\'', 'Dotum', 'sans-serif' ),

				// Thai.
				'th'    => array( '\'Sukhumvit Set\'', '\'Helvetica Neue\'', 'Helvetica', 'Arial', 'sans-serif' ),

				// Vietnamese.
				'vi'    => array( '\'Libre Franklin\'', 'sans-serif' ),

			)
		);

		// Return if the selected language has no fallback fonts.
		if ( empty( $font_family[ $locale ] ) ) {
			return '';
		}

		/**
		 * Filters the elements to apply fallback fonts to.
		 *
		 * @since Dimas 1.0
		 *
		 * @param array $elements An array of elements for "front-end", "block-editor", or "classic-editor".
		 */
		$elements = apply_filters(
			'dimas_get_localized_font_family_elements',
			array(
				'front-end'      => array( 'body', 'input', 'textarea', 'button', '.button', '.faux-button', '.wp-block-button__link', '.wp-block-file__button', '.has-drop-cap:not(:focus)::first-letter', '.entry-content .wp-block-archives', '.entry-content .wp-block-categories', '.entry-content .wp-block-cover-image', '.entry-content .wp-block-latest-comments', '.entry-content .wp-block-latest-posts', '.entry-content .wp-block-pullquote', '.entry-content .wp-block-quote.is-large', '.entry-content .wp-block-quote.is-style-large', '.entry-content .wp-block-archives *', '.entry-content .wp-block-categories *', '.entry-content .wp-block-latest-posts *', '.entry-content .wp-block-latest-comments *', '.entry-content p', '.entry-content ol', '.entry-content ul', '.entry-content dl', '.entry-content dt', '.entry-content cite', '.entry-content figcaption', '.entry-content .wp-caption-text', '.comment-content p', '.comment-content ol', '.comment-content ul', '.comment-content dl', '.comment-content dt', '.comment-content cite', '.comment-content figcaption', '.comment-content .wp-caption-text', '.widget_text p', '.widget_text ol', '.widget_text ul', '.widget_text dl', '.widget_text dt', '.widget-content .rssSummary', '.widget-content cite', '.widget-content figcaption', '.widget-content .wp-caption-text' ),
				'block-editor'   => array( '.editor-styles-wrapper > *', '.editor-styles-wrapper p', '.editor-styles-wrapper ol', '.editor-styles-wrapper ul', '.editor-styles-wrapper dl', '.editor-styles-wrapper dt', '.editor-post-title__block .editor-post-title__input', '.editor-styles-wrapper .wp-block h1', '.editor-styles-wrapper .wp-block h2', '.editor-styles-wrapper .wp-block h3', '.editor-styles-wrapper .wp-block h4', '.editor-styles-wrapper .wp-block h5', '.editor-styles-wrapper .wp-block h6', '.editor-styles-wrapper .has-drop-cap:not(:focus)::first-letter', '.editor-styles-wrapper cite', '.editor-styles-wrapper figcaption', '.editor-styles-wrapper .wp-caption-text' ),
				'classic-editor' => array( 'body#tinymce.wp-editor', 'body#tinymce.wp-editor p', 'body#tinymce.wp-editor ol', 'body#tinymce.wp-editor ul', 'body#tinymce.wp-editor dl', 'body#tinymce.wp-editor dt', 'body#tinymce.wp-editor figcaption', 'body#tinymce.wp-editor .wp-caption-text', 'body#tinymce.wp-editor .wp-caption-dd', 'body#tinymce.wp-editor cite', 'body#tinymce.wp-editor table' ),
			)
		);

		// Return if the specified type doesn't exist.
		if ( empty( $elements[ $type ] ) ) {
			return '';
		}

		// Include file class create dynamic css.
		require_once get_theme_file_path( 'inc/class-dimas-dynamic-css.php' ); // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound				

		// Return the specified styles.
		return Dynamic_CSS::dimas_generate_css( // @phpstan-ignore-line.
			implode( ',', $elements[ $type ] ),
			'font-family',
			implode( ',', $font_family[ $locale ] ),
			null,
			null,
			false
		);
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
	 * Calculate classes for the main <html> element.
	 *
	 * @since Dimas 1.0
	 *
	 * @return void
	 */
	public static function dimas_the_html_classes() {
		/**
		 * Filters the classes for the main <html> element.
		 *
		 * @since Dimas 1.0
		 *
		 * @param string The list of classes. Default empty string.
		 */
		$classes = apply_filters( 'dimas_html_classes', '' );
		if ( ! $classes ) {
			return;
		}
		echo 'class="' . esc_attr( $classes ) . '"';
	}

	/**
	 * Custom Excerpt Function
	 *
	 * @param [type] $limit
	 * @param string $afterlimit
	 * @return void
	 */
	public static function dimas_fnc_excerpt( $limit, $afterlimit = '[...]' ) {
		$excerpt = get_the_excerpt();
		$limit   = empty( $limit ) ? 20 : $limit;
		if ( $excerpt != '' ) {
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
	 * @param [type] $tag
	 * @param array  $atts
	 * @param [type] $content
	 * @return void
	 */
	public static function dimas_do_shortcode( $tag, array $atts = array(), $content = null ) {
		global $shortcode_tags;

		if ( ! isset( $shortcode_tags[ $tag ] ) ) {
			return false;
		}

		return call_user_func( $shortcode_tags[ $tag ], $atts, $content, $tag );
	}


}
