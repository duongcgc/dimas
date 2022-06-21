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
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() )
		);
		echo '<span class="posted-on">';
		printf(
		/* translators: %s: Publish date. */
			esc_html__( 'Published %s', 'dimas' ),
			$time_string // phpcs:ignore WordPress.Security.EscapeOutput
		);
		echo '</span>';
	}

	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 *
	 * @since Dimas 1.0
	 *
	 * @return void
	 */
	public static function dimas_post_thumbnail() {
		if ( ! Template_Function::instance()->dimas_can_show_post_thumbnail() ) {
			return;
		}
		?>

		<?php if ( is_singular() ) : ?>

			<figure class="post-thumbnail">
				<?php
				// Lazy-loading attributes should be skipped for thumbnails since they are immediately in the viewport.
				the_post_thumbnail( 'post-thumbnail', array( 'loading' => false ) );
				?>
				<?php if ( wp_get_attachment_caption( get_post_thumbnail_id() ) ) : ?>
					<figcaption class="wp-caption-text"><?php echo wp_kses_post( wp_get_attachment_caption( get_post_thumbnail_id() ) ); ?></figcaption>
				<?php endif; ?>
			</figure><!-- .post-thumbnail -->

		<?php else : ?>

			<figure class="post-thumbnail">
				<a class="post-thumbnail-inner alignwide" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
					<?php the_post_thumbnail( 'post-thumbnail' ); ?>
				</a>
				<?php if ( wp_get_attachment_caption( get_post_thumbnail_id() ) ) : ?>
					<figcaption class="wp-caption-text"><?php echo wp_kses_post( wp_get_attachment_caption( get_post_thumbnail_id() ) ); ?></figcaption>
				<?php endif; ?>
			</figure>

		<?php endif; ?>
				<?php
	}

	/**
	 * Print the next and previous posts navigation.
	 *
	 * @since Dimas 1.0
	 *
	 * @return void
	 */
	public static function dimas_the_posts_navigation() {
		the_posts_pagination(
			array(
				'before_page_number' => esc_html__( 'Page', 'dimas' ) . ' ',
				'mid_size'           => 0,
				'prev_text'          => sprintf(
					'%s <span class="nav-prev-text">%s</span>',
					is_rtl() ? Template_Function::instance()->dimas_get_icon_svg( 'ui', 'arrow_right' ) : Template_Function::instance()->dimas_get_icon_svg( 'ui', 'arrow_left' ),
					wp_kses(
						__( 'Newer <span class="nav-short">posts</span>', 'dimas' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					)
				),
				'next_text'          => sprintf(
					'<span class="nav-next-text">%s</span> %s',
					wp_kses(
						__( 'Older <span class="nav-short">posts</span>', 'dimas' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					is_rtl() ? Template_Function::instance()->dimas_get_icon_svg( 'ui', 'arrow_left' ) : Template_Function::instance()->dimas_get_icon_svg( 'ui', 'arrow_right' )
				),
			)
		);
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
	 * Display Vertical Navigation
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public static function dimas_vertical_navigation() {

		if ( isset( get_nav_menu_locations()['vertical'] ) ) {

			$menu_location  = 'vertical';
			$menu_locations = get_nav_menu_locations();
			$menu_object    = ( isset( $menu_locations[ $menu_location ] ) ? wp_get_nav_menu_object( $menu_locations[ $menu_location ] ) : null );
			$menu_name      = ( isset( $menu_object->name ) ? $menu_object->name : esc_html__( 'Vertical Menu', 'dm' ) );

			?>
			<nav class="vertical-navigation" aria-label="<?php esc_html_e( 'Vertical Navigation', 'dm' ); ?>">
				<div class="vertical-navigation-header">
					<i class="fa fa-bars"></i>
					<span class="vertical-navigation-title"><?php echo esc_html( $menu_name ); ?></span>
				</div>
			<?php

			$args = apply_filters(
				'opal_nav_menu_args',
				array(
					'fallback_cb'     => '__return_empty_string',
					'theme_location'  => 'vertical',
					'container_class' => 'vertical-menu',
				)
			);

				wp_nav_menu( $args );
			?>
			</nav>
				<?php
		}
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
	 * Display menu
	 *
	 * @param array $args The args of menu.
	 * @return void
	 * @since  1.0.0
	 */
	public static function dimas_menu( $args ) {

		$args = Template_Function::instance()->dimas_menu_args( $args );

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
		$id_logo = get_theme_mod( 'custom_logo' );

		if ( ! isset( $attrs['class'] ) ) {
			$attrs['class'] = 'dimas-navbar-logo';
		}
		$attrs['href'] = home_url();

		HTML::instance()->open(
			'dimas_logo',
			array(
				'tag'     => 'a',
				'attr'    => $attrs,
			)
		);

		echo wp_get_attachment_image( $id_logo, $size, false, array( 'alt' => 'Dimas Logo' ) );

		HTML::instance()->close( 'dimas_logo' );
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
	 * Sanitize SVG code.
	 *
	 * @since 1.0.0
	 *
	 * @param string $svg SVG code.
	 *
	 * @return void
	 */
	public static function sanitize_svg( $svg ) {
		$allowed   = array();
		$whitelist = array(
			'a'              => array(
				'class',
				'clip-path',
				'clip-rule',
				'fill',
				'fill-opacity',
				'fill-rule',
				'filter',
				'id',
				'mask',
				'opacity',
				'stroke',
				'stroke-dasharray',
				'stroke-dashoffset',
				'stroke-linecap',
				'stroke-linejoin',
				'stroke-miterlimit',
				'stroke-opacity',
				'stroke-width',
				'style',
				'systemLanguage',
				'transform',
				'href',
				'xlink:href',
				'xlink:title',
			),
			'circle'         => array(
				'class',
				'clip-path',
				'clip-rule',
				'cx',
				'cy',
				'fill',
				'fill-opacity',
				'fill-rule',
				'filter',
				'id',
				'mask',
				'opacity',
				'r',
				'requiredFeatures',
				'stroke',
				'stroke-dasharray',
				'stroke-dashoffset',
				'stroke-linecap',
				'stroke-linejoin',
				'stroke-miterlimit',
				'stroke-opacity',
				'stroke-width',
				'style',
				'systemLanguage',
				'transform',
			),
			'clipPath'       => array( 'class', 'clipPathUnits', 'id' ),
			'defs'           => array(),
			'style'          => array( 'type' ),
			'desc'           => array(),
			'ellipse'        => array(
				'class',
				'clip-path',
				'clip-rule',
				'cx',
				'cy',
				'fill',
				'fill-opacity',
				'fill-rule',
				'filter',
				'id',
				'mask',
				'opacity',
				'requiredFeatures',
				'rx',
				'ry',
				'stroke',
				'stroke-dasharray',
				'stroke-dashoffset',
				'stroke-linecap',
				'stroke-linejoin',
				'stroke-miterlimit',
				'stroke-opacity',
				'stroke-width',
				'style',
				'systemLanguage',
				'transform',
			),
			'feGaussianBlur' => array(
				'class',
				'color-interpolation-filters',
				'id',
				'requiredFeatures',
				'stdDeviation',
			),
			'filter'         => array(
				'class',
				'color-interpolation-filters',
				'filterRes',
				'filterUnits',
				'height',
				'id',
				'primitiveUnits',
				'requiredFeatures',
				'width',
				'x',
				'xlink:href',
				'y',
			),
			'foreignObject'  => array(
				'class',
				'font-size',
				'height',
				'id',
				'opacity',
				'requiredFeatures',
				'style',
				'transform',
				'width',
				'x',
				'y',
			),
			'g'              => array(
				'class',
				'clip-path',
				'clip-rule',
				'id',
				'display',
				'fill',
				'fill-opacity',
				'fill-rule',
				'filter',
				'mask',
				'opacity',
				'requiredFeatures',
				'stroke',
				'stroke-dasharray',
				'stroke-dashoffset',
				'stroke-linecap',
				'stroke-linejoin',
				'stroke-miterlimit',
				'stroke-opacity',
				'stroke-width',
				'style',
				'systemLanguage',
				'transform',
				'font-family',
				'font-size',
				'font-style',
				'font-weight',
				'text-anchor',
			),
			'image'          => array(
				'class',
				'clip-path',
				'clip-rule',
				'filter',
				'height',
				'id',
				'mask',
				'opacity',
				'requiredFeatures',
				'style',
				'systemLanguage',
				'transform',
				'width',
				'x',
				'xlink:href',
				'xlink:title',
				'y',
			),
			'line'           => array(
				'class',
				'clip-path',
				'clip-rule',
				'fill',
				'fill-opacity',
				'fill-rule',
				'filter',
				'id',
				'marker-end',
				'marker-mid',
				'marker-start',
				'mask',
				'opacity',
				'requiredFeatures',
				'stroke',
				'stroke-dasharray',
				'stroke-dashoffset',
				'stroke-linecap',
				'stroke-linejoin',
				'stroke-miterlimit',
				'stroke-opacity',
				'stroke-width',
				'style',
				'systemLanguage',
				'transform',
				'x1',
				'x2',
				'y1',
				'y2',
			),
			'linearGradient' => array(
				'class',
				'id',
				'gradientTransform',
				'gradientUnits',
				'requiredFeatures',
				'spreadMethod',
				'systemLanguage',
				'x1',
				'x2',
				'xlink:href',
				'y1',
				'y2',
			),
			'marker'         => array(
				'id',
				'class',
				'markerHeight',
				'markerUnits',
				'markerWidth',
				'orient',
				'preserveAspectRatio',
				'refX',
				'refY',
				'systemLanguage',
				'viewBox',
			),
			'mask'           => array(
				'class',
				'height',
				'id',
				'maskContentUnits',
				'maskUnits',
				'width',
				'x',
				'y',
			),
			'metadata'       => array( 'class', 'id' ),
			'path'           => array(
				'class',
				'clip-path',
				'clip-rule',
				'd',
				'fill',
				'fill-opacity',
				'fill-rule',
				'filter',
				'id',
				'marker-end',
				'marker-mid',
				'marker-start',
				'mask',
				'opacity',
				'requiredFeatures',
				'stroke',
				'stroke-dasharray',
				'stroke-dashoffset',
				'stroke-linecap',
				'stroke-linejoin',
				'stroke-miterlimit',
				'stroke-opacity',
				'stroke-width',
				'style',
				'systemLanguage',
				'transform',
			),
			'pattern'        => array(
				'class',
				'height',
				'id',
				'patternContentUnits',
				'patternTransform',
				'patternUnits',
				'requiredFeatures',
				'style',
				'systemLanguage',
				'viewBox',
				'width',
				'x',
				'xlink:href',
				'y',
			),
			'polygon'        => array(
				'class',
				'clip-path',
				'clip-rule',
				'id',
				'fill',
				'fill-opacity',
				'fill-rule',
				'filter',
				'id',
				'class',
				'marker-end',
				'marker-mid',
				'marker-start',
				'mask',
				'opacity',
				'points',
				'requiredFeatures',
				'stroke',
				'stroke-dasharray',
				'stroke-dashoffset',
				'stroke-linecap',
				'stroke-linejoin',
				'stroke-miterlimit',
				'stroke-opacity',
				'stroke-width',
				'style',
				'systemLanguage',
				'transform',
			),
			'polyline'       => array(
				'class',
				'clip-path',
				'clip-rule',
				'id',
				'fill',
				'fill-opacity',
				'fill-rule',
				'filter',
				'marker-end',
				'marker-mid',
				'marker-start',
				'mask',
				'opacity',
				'points',
				'requiredFeatures',
				'stroke',
				'stroke-dasharray',
				'stroke-dashoffset',
				'stroke-linecap',
				'stroke-linejoin',
				'stroke-miterlimit',
				'stroke-opacity',
				'stroke-width',
				'style',
				'systemLanguage',
				'transform',
			),
			'radialGradient' => array(
				'class',
				'cx',
				'cy',
				'fx',
				'fy',
				'gradientTransform',
				'gradientUnits',
				'id',
				'r',
				'requiredFeatures',
				'spreadMethod',
				'systemLanguage',
				'xlink:href',
			),
			'rect'           => array(
				'class',
				'clip-path',
				'clip-rule',
				'fill',
				'fill-opacity',
				'fill-rule',
				'filter',
				'height',
				'id',
				'mask',
				'opacity',
				'requiredFeatures',
				'rx',
				'ry',
				'stroke',
				'stroke-dasharray',
				'stroke-dashoffset',
				'stroke-linecap',
				'stroke-linejoin',
				'stroke-miterlimit',
				'stroke-opacity',
				'stroke-width',
				'style',
				'systemLanguage',
				'transform',
				'width',
				'x',
				'y',
			),
			'stop'           => array(
				'class',
				'id',
				'offset',
				'requiredFeatures',
				'stop-color',
				'stop-opacity',
				'style',
				'systemLanguage',
			),
			'svg'            => array(
				'class',
				'clip-path',
				'clip-rule',
				'filter',
				'id',
				'mask',
				'fill',
				'stroke',
				'preserveaspectRatio',
				'requiredfeatures',
				'style',
				'systemlanguage',
				'viewbox',
				'width',
				'height',
				'xmlns',
				'xmlns:se',
				'xmlns:xlink',
				'x',
				'y',
				'enable-background',
				'stroke-linecap',
				'stroke-linejoin',
				'stroke-width',
			),
			'switch'         => array( 'class', 'id', 'requiredFeatures', 'systemLanguage' ),
			'symbol'         => array(
				'class',
				'fill',
				'fill-opacity',
				'fill-rule',
				'filter',
				'font-family',
				'font-size',
				'font-style',
				'font-weight',
				'id',
				'opacity',
				'preserveAspectRatio',
				'requiredFeatures',
				'stroke',
				'stroke-dasharray',
				'stroke-dashoffset',
				'stroke-linecap',
				'stroke-linejoin',
				'stroke-miterlimit',
				'stroke-opacity',
				'stroke-width',
				'style',
				'systemLanguage',
				'transform',
				'viewBox',
			),
			'text'           => array(
				'class',
				'clip-path',
				'clip-rule',
				'fill',
				'fill-opacity',
				'fill-rule',
				'filter',
				'font-family',
				'font-size',
				'font-style',
				'font-weight',
				'id',
				'mask',
				'opacity',
				'requiredFeatures',
				'stroke',
				'stroke-dasharray',
				'stroke-dashoffset',
				'stroke-linecap',
				'stroke-linejoin',
				'stroke-miterlimit',
				'stroke-opacity',
				'stroke-width',
				'style',
				'systemLanguage',
				'text-anchor',
				'transform',
				'x',
				'xml:space',
				'y',
			),
			'textPath'       => array(
				'class',
				'id',
				'method',
				'requiredFeatures',
				'spacing',
				'startOffset',
				'style',
				'systemLanguage',
				'transform',
				'xlink:href',
			),
			'title'          => array(),
			'tspan'          => array(
				'class',
				'clip-path',
				'clip-rule',
				'dx',
				'dy',
				'fill',
				'fill-opacity',
				'fill-rule',
				'filter',
				'font-family',
				'font-size',
				'font-style',
				'font-weight',
				'id',
				'mask',
				'opacity',
				'requiredFeatures',
				'rotate',
				'stroke',
				'stroke-dasharray',
				'stroke-dashoffset',
				'stroke-linecap',
				'stroke-linejoin',
				'stroke-miterlimit',
				'stroke-opacity',
				'stroke-width',
				'style',
				'systemLanguage',
				'text-anchor',
				'textLength',
				'transform',
				'x',
				'xml:space',
				'y',
			),
			'use'            => array(
				'class',
				'clip-path',
				'clip-rule',
				'fill',
				'fill-opacity',
				'fill-rule',
				'filter',
				'height',
				'id',
				'mask',
				'stroke',
				'stroke-dasharray',
				'stroke-dashoffset',
				'stroke-linecap',
				'stroke-linejoin',
				'stroke-miterlimit',
				'stroke-opacity',
				'stroke-width',
				'style',
				'transform',
				'width',
				'x',
				'xlink:href',
				'y',
			),
		);

		foreach ( $whitelist as $tag => $attributes ) {
			$allowed[ $tag ] = array();

			foreach ( $attributes as $attribute ) {
				$allowed[ $tag ][ $attribute ] = true;
			}
		}

		echo wp_kses( $svg, $allowed );
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
			'container',
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

		HTML::instance()->close( 'container' );

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

		self::sanitize_svg( Template_Function::instance()->dimas_get_icon_svg( $group, $name, $width, $heigth ) );

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
	public static function html_loop_open( $args ) {

		foreach ( $args as $key => $val ) {

			if ( isset( $val['tag'] ) ) {
				$arr_out[ $key ]['tag'] = $val['tag'];
			}

			if ( isset( $val['attr'] ) ) {
				$arr_out[ $key ]['attr'] = $val['attr'];
			}

			if ( isset( $val['actions'] ) ) {
				$arr_out[ $key ]['actions'] = $val['actions'];
			}

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
	public static function html_loop_close( $args ) {

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
	public static function swiper_loop( $args, $swiper_slide_count ) {

		$swiper_tag = array(
			0 => 'swiper',
			1 => 'swiper-wrapper',
			2 => 'swiper-slide',
		);

		foreach ( $swiper_tag as $key => $value ) {

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

		foreach ( $swiper_tag as $key => $value ) {

			if ( 'swiper-slide' != $value ) {
				HTML::instance()->close( $swiper[ $value ]['name'] );
			}
		}
	}

}
