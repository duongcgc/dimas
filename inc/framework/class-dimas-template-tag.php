<?php
/**
 * Custom template tags for this theme
 * => all functions that echo content to theme.
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
	public function dimas_posted_on() {
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
	public function dimas_post_thumbnail() {
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
	public function dimas_the_posts_navigation() {
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
	 * Display Vertical Navigation
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function dimas_vertical_navigation() {

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
	 * Display image
	 *
	 * @param int   $id The image id.
	 * @param array $attrs The attributes of image.
	 * @since  1.0.0
	 * @return void
	 */
	public function dimas_image( $id, $attrs ) {
		echo wp_get_attachment_image( $id, $attrs );
	}

	/**
	 * Display menu
	 *
	 * @param array $args The args of menu.
	 * @return void
	 * @since  1.0.0
	 */
	public function dimas_menu( $args ) {

		$args = Template_Function::instance()->dimas_menu_args( $args );

		echo wp_kses_post( wp_nav_menu( $args ) );

	}

}
