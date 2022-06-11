<?php
/**
 * Dimas helper functions and definitions.
 *
 * @package Dimas
 */

use Dimas\Theme;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Helper initial
 */
class Helper {
	/**
	 * Post ID
	 *
	 * @var $post_id
	 */
	protected static $post_id = null;

	/**
	 * Header Layout
	 *
	 * @var $header_layout
	 */
	protected static $header_layout = null;

	/**
	 * Get font url
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function get_fonts_url() {
		$fonts_url = '';

		/*
		 Translators: If there are characters in your language that are not
		* supported by Montserrat, translate this to 'off'. Do not translate
		* into your own language.
		*/
		if ( 'off' !== _x( 'on', 'Jost font: on or off', 'dimas' ) ) {
			$font_families[] = 'Jost:200,300,400,500,600,700,800';
		}

		if ( ! empty( $font_families ) ) {
			$query_args = array(
				'family' => urlencode( implode( '|', $font_families ) ),
				'subset' => urlencode( 'latin,latin-ext' ),
			);

			$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
		}

		return esc_url_raw( $fonts_url );
	}

	/**
	 * Get theme option
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function get_option( $name ) {
		return Theme::instance()->get( 'options' )->get_option( $name );
	}

	/**
	 * Get post found
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function posts_found() {
		global $wp_query;

		if ( $wp_query && isset( $wp_query->found_posts ) ) {

			$post_text = $wp_query->found_posts > 1 ? esc_html__( 'posts', 'dimas' ) : esc_html__( 'post', 'dimas' );

			if ( self::is_catalog() ) {
				$post_text = $wp_query->found_posts > 1 ? esc_html__( 'products', 'dimas' ) : esc_html__( 'product', 'dimas' );
			}

			echo sprintf(
				'<div class="dimas-posts__found"><div class="dimas-posts__found-inner">%s<span class="current-post"> %s </span> %s <span class="found-post"> %s </span> %s <span class="count-bar"></span></div> </div>',
				esc_html__( 'Showing', 'dimas' ),
				$wp_query->post_count,
				esc_html__( 'of', 'dimas' ),
				$wp_query->found_posts,
				$post_text
			);

		}
	}

	/**
	 * Post pagination
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function load_pagination() {
		global $wp_query;

		if ( $wp_query->max_num_pages < 2 ) {
			return;
		}

		$nav_html = sprintf( '<span class="button-text">%s</span>', self::get_option( 'blog_view_more_text' ) );

		?>
		<nav class="next-posts-navigation navigation load-navigation">
			<div class="nav-links">
				<?php if ( get_next_posts_link() ) : ?>
					<div id="dimas-blog-previous-ajax" class="nav-previous-ajax">
						<?php next_posts_link( $nav_html ); ?>
						<div class="dimas-gooey-loading">
							<div class="dimas-gooey">
								<div class="dots">
									<span></span>
									<span></span>
									<span></span>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</nav>
		<?php
	}

	/**
	 * Content limit
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function get_content_limit( $num_words, $more = '&hellip;', $content = '' ) {
		if ( class_exists( '\Dimas\Addons\Helper' ) && method_exists( '\Dimas\Addons\Helper', 'get_content_limit' ) ) {
			return \Dimas\Addons\Helper::get_content_limit( $num_words, $more, $content );
		}
		$content = empty( $content ) ? get_the_excerpt() : $content;

		return $content;
	}

	/**
	 * Check is catalog
	 *
	 * @since 1.0.0
	 *
	 * @return boolean
	 */
	public static function is_catalog() {
		if ( function_exists( 'is_shop' ) && ( is_shop() || is_product_category() || is_product_tag() || is_tax( 'product_brand' ) || is_tax( 'product_collection' ) || is_tax( 'product_condition' ) ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Check is blog
	 *
	 * @since 1.0.0
	 *
	 * @return boolean
	 */
	public static function is_blog() {
		if ( ( is_archive() || is_author() || is_category() || is_home() || is_tag() ) && 'post' == get_post_type() ) {
			return true;
		}

		return false;
	}

	/**
	 * Check mobile version
	 *
	 * @since 1.0.0
	 *
	 * @return boolean
	 */
	public static function is_mobile() {
		if ( ! class_exists( 'Mobile_Detect' ) ) {
			return false;
		}

		if ( self::get_option( 'mobile_version' ) != 'yes' ) {
			return false;
		}

		$detect = new \Mobile_Detect();
		if ( $detect->isMobile() && ! $detect->isTablet() ) {
			return true;
		}

		return false;

	}

	/**
	 * Print HTML of currency switcher
	 * It requires plugin Initial Currency Switcher installed
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function currency_switcher( $args = array() ) {
		global $WOOCS;

		$currencies       = class_exists( 'WOOCS' ) ? $WOOCS->get_currencies() : array();
		$currencies       = apply_filters( 'woocs_active_currencies', $currencies );
		$current_currency = class_exists( 'WOOCS' ) ? $WOOCS->current_currency : '';
		$current_currency = apply_filters( 'woocs_current_currencies', $current_currency );

		$args          = wp_parse_args(
			$args,
			array(
				'label'     => '',
				'direction' => 'down',
			)
		);
		$currency_list = array();

		if ( empty( $currencies ) ) {
			return;
		}

		foreach ( $currencies as $key => $currency ) {
			if ( $current_currency == $key ) {
				array_unshift(
					$currency_list,
					sprintf(
						'<li><a href="#" class="woocs_flag_view_item woocs_flag_view_item_current" data-currency="%s">%s</a></li>',
						esc_attr( $currency['name'] ),
						esc_html( $currency['name'] )
					)
				);
			} else {
				$currency_list[] = sprintf(
					'<li><a href="#" class="woocs_flag_view_item" data-currency="%s">%s</a></li>',
					esc_attr( $currency['name'] ),
					esc_html( $currency['name'] )
				);
			}
		}
		?>
		<div class="dimas-currency list-dropdown <?php echo esc_attr( $args['direction'] ); ?>">
			<?php if ( ! empty( $args['label'] ) ) : ?>
				<span class="label"><?php echo esc_html( $args['label'] ); ?></span>
			<?php endif; ?>
			<div class="dropdown">
				<span class="current">
					<span class="selected"><?php echo esc_html( $currencies[ $current_currency ]['name'] ); ?></span>
					<?php echo \Dimas\Icon::get_svg( 'chevron-bottom' ); ?>
				</span>
				<div class="currency-dropdown content-droplist">
					<ul>
						<?php echo implode( "\n\t", $currency_list ); ?>
					</ul>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Print HTML of language switcher
	 * It requires plugin WPML installed
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function language_switcher( $args = array() ) {
		$languages = function_exists( 'icl_get_languages' ) ? icl_get_languages() : array();
		$languages = apply_filters( 'wpml_active_languages', $languages );

		if ( empty( $languages ) ) {
			return;
		}

		$args      = wp_parse_args(
			$args,
			array(
				'label'     => '',
				'direction' => 'down',
			)
		);
		$lang_list = array();
		$current   = '';

		foreach ( (array) $languages as $code => $language ) {
			if ( ! $language['active'] ) {
				$lang_list[] = sprintf(
					'<li class="%s"><a href="%s">%s</a></li>',
					esc_attr( $code ),
					esc_url( $language['url'] ),
					esc_html( $language['native_name'] )
				);
			} else {
				$current = $language;
				array_unshift(
					$lang_list,
					sprintf(
						'<li class="%s"><a href="%s">%s</a></li>',
						esc_attr( $code ),
						esc_url( $language['url'] ),
						esc_html( $language['native_name'] )
					)
				);
			}
		}
		?>

		<div class="dimas-language list-dropdown <?php echo esc_attr( $args['direction'] ); ?>">
			<?php if ( ! empty( $args['label'] ) ) : ?>
				<span class="label"><?php echo esc_html( $args['label'] ); ?></span>
			<?php endif; ?>
			<div class="dropdown">
				<span class="current">
					<span class="selected"><?php echo esc_html( $current['native_name'] ); ?></span>
					<?php echo \Dimas\Icon::get_svg( 'chevron-bottom' ); ?>
				</span>
				<div class="language-dropdown content-droplist">
					<ul>
						<?php echo implode( "\n\t", $lang_list ); ?>
					</ul>
				</div>
			</div>
		</div>

		<?php
	}

	/**
	 * Get Socials menu
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function socials_menu() {
		if ( has_nav_menu( 'socials' ) ) {
			if ( class_exists( '\Dimas\Addons\Modules\Mega_Menu\Socials_Walker' ) ) {
				wp_nav_menu(
					apply_filters(
						'dimas_navigation_social_content',
						array(
							'theme_location'  => 'socials',
							'container_class' => 'socials-menu ',
							'menu_id'         => 'socials-menu',
							'depth'           => 1,
							'link_before'     => '<span>',
							'link_after'      => '</span>',
							'walker'          => new \Dimas\Addons\Modules\Mega_Menu\Socials_Walker(),
						)
					)
				);
			} else {
				wp_nav_menu(
					apply_filters(
						'dimas_navigation_social_content',
						array(
							'theme_location'  => 'socials',
							'container_class' => 'socials-menu ',
							'menu_id'         => 'socials-menu',
							'depth'           => 1,
							'link_before'     => '<span>',
							'link_after'      => '</span>',
						)
					)
				);
			}
		}
	}

	/**
	 * Get Header Layout
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function get_header_layout() {
		if ( isset( self::$header_layout ) ) {
			return self::$header_layout;
		}

		$custom_header_layout = get_post_meta( self::get_post_ID(), 'rz_header_layout', true );
		if ( ! empty( $custom_header_layout ) && 'default' != $custom_header_layout ) {
			self::$header_layout = $custom_header_layout;
		} elseif ( self::get_option( 'header_type' ) == 'default' ) {
			self::$header_layout = self::get_option( 'header_layout' );
		}

		return self::$header_layout;
	}

	/**
	 * Get Post ID
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function get_post_ID() {
		if ( isset( self::$post_id ) ) {
			return self::$post_id;
		}

		if ( self::is_catalog() ) {
			self::$post_id = intval( get_option( 'woocommerce_shop_page_id' ) );
		} elseif ( self::is_blog() ) {
			self::$post_id = intval( get_option( 'page_for_posts' ) );
		} else {
			self::$post_id = get_the_ID();
		}

		return self::$post_id;
	}

	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function post_thumbnail( $size = 'full' ) {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		$post_thumbnail_id = get_post_thumbnail_id( get_the_ID() );

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php echo wp_get_attachment_image( $post_thumbnail_id, $size ); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php echo wp_get_attachment_image( $post_thumbnail_id, $size ); ?>
			</a>

			<?php
		endif; // End is_singular().
	}

	/**
	 * Get Post date
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function post_date() {
		$day   = '<span class="field-day">' . esc_html( get_the_date( 'd' ) ) . '</span>';
		$month = '<span class="field-month">' . esc_html( get_the_date( 'M' ) ) . '</span>';

		echo sprintf( '<div class="blog-date">%s %s</div>', $month, $day );
	}

	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function post_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'dimas' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'dimas' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'dimas' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'dimas' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
					/* translators: %s: post title */
						__( 'Leave a Comments<span class="screen-reader-text"> on %s</span>', 'dimas' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

	}

	/**
	 * Check elementor actived.
	 *
	 * @return boolean
	 */
	public static function dimas_is_elementor_activated() {
		return function_exists( 'elementor_load_plugin_textdomain' );
	}

	/**
	 * Check contactform7 actived.
	 *
	 * @return boolean
	 */
	public static function dimas_is_contactform7_activated() {
		return class_exists( 'WPCF7' );
	}

	/**
	 * Check OCDI actived.
	 *
	 * @return boolean
	 */
	public static function dimas_is_one_click_import_activated() {
		return class_exists( 'OCDI_Plugin' ) ? true : false;
	}

	/**
	 * Check WooCommerce actived.
	 *
	 * @return boolean
	 */
	public static function dimas_is_woocommerce_activated() {
		return class_exists( 'WooCommerce' ) ? true : false;
	}

	/**
	 * Check WooCommerce Version.
	 *
	 * @return mixed
	 */
	public static function dimas_woocommerce_version_check( $version = '3.3' ) {
		if ( self::dimas_is_woocommerce_activated() ) {
			global $woocommerce;
			if ( version_compare( $woocommerce->version, $version, '>=' ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Checks if the current page is a product archive
	 *
	 * @return mixed
	 */
	public static function dimas_is_product_archive() {
		if ( dimas_is_woocommerce_activated() ) {
			if ( is_shop() || is_product_taxonomy() || is_product_category() || is_product_tag() ) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	/**
	 * Check WC_Bookings actived.
	 *
	 * @return boolean
	 */
	public static function dimas_is_woocommerce_extension_activated( $extension = 'WC_Bookings' ) {
		return class_exists( $extension ) ? true : false;
	}

	/**
	 * Check YITH actived.
	 *
	 * @return boolean
	 */
	public static function dimas_is_woocommerce_yith_activated( $extension = 'WC_Bookings' ) {
		if ( $extension == 'YITH_WCQV' ) {
			return class_exists( $extension ) && class_exists( 'YITH_WCQV_Frontend' ) ? true : false;
		}

		return class_exists( $extension ) ? true : false;
	}

	/**
	 * Check Mailchimp actived.
	 *
	 * @return boolean
	 */
	public static function dimas_is_mailchimp_activated() {
		return function_exists( '_mc4wp_load_plugin' );
	}

	/**
	 * Check Ajaxloadmore actived.
	 *
	 * @return boolean
	 */
	public static function dimas_is_ajax_load_more_activated() {
		return class_exists( 'AjaxLoadMore' );
	}

	/**
	 * Check Revslider actived.
	 *
	 * @return boolean
	 */
	public static function dimas_is_revslider_activated() {
		return class_exists( 'RevSliderBase' );
	}

	/**
	 * Check Blog archive.
	 *
	 * @return boolean
	 */
	public static function dimas_is_blog_archive() {
		return ( is_home() && is_front_page() ) || is_archive() || is_category() || is_tag() || is_home();
	}

	/**
	 * Get placeholder image.
	 *
	 * @return string
	 */
	public static function dimas_get_placeholder_image() {
		return get_parent_theme_file_uri( '/assets/images/placeholder.png' );
	}

	/**
	 * Check Breadcrumb.
	 *
	 * @return bool
	 */
	public static function dimas_page_enable_breadcrumb() {
		$check = get_post_meta( get_the_ID(), 'dimas_enable_breadcrumb', true ) === '0' ? false : true;

		return ( $check );
	}

	/**
	 * Enable Page Title.
	 *
	 * @return bool
	 */
	public static function dimas_page_enable_page_title() {
		$check = get_post_meta( get_the_ID(), 'dimas_enable_page_title', true ) === '0' ? false : true;

		return ( is_page() && $check );
	}

	/**
	 * Check is fontpage.
	 *
	 * @return void
	 */
	public static function dimas_is_frontpage() {
		return ( is_front_page() && ! is_home() );
	}



	/**
	 * Get Query Posts.
	 *
	 * @param mixed $args

	 * @return WP_Query
	 */
	public static function dimas_get_query( $args ) {
		global $wp_query;
		$default  = array(
			'post_type' => 'post',
		);
		$args     = wp_parse_args( $args, $default );
		$wp_query = new WP_Query( $args );

		return $wp_query;
	}


	/**
	 * Get file content.
	 *
	 * @param string $path
	 * @return void
	 */
	public static function dimas_get_file_contents( $path ) {
		if ( is_file( $path ) ) {
			return file_get_contents( $path );
		}

		return false;
	}

	/**
	 * Elapsed ...
	 *
	 * @param [type]  $datetime
	 * @param boolean $full
	 * @return void
	 */
	public static function time_elapsed_string( $datetime, $full = false ) {
		$now  = new DateTime();
		$ago  = new DateTime( $datetime );
		$diff = $now->diff( $ago );

		$diff->w  = floor( $diff->d / 7 );
		$diff->d -= $diff->w * 7;

		$string = array(
			'y' => __( 'year', 'dm' ),
			'm' => __( 'month', 'dm' ),
			'w' => __( 'week', 'dm' ),
			'd' => __( 'day', 'dm' ),
		// 'h' => __('hour', 'dm'),
		// 'i' => __('minute', 'dm'),
		// 's' => __('second', 'dm'),
		);
		foreach ( $string as $k => &$v ) {
			if ( $diff->$k ) {
				$v = $diff->$k . ' ' . $v . ( $diff->$k > 1 ? 's' : '' );
			} else {
				unset( $string[ $k ] );
			}
		}

		if ( ! $full ) {
			$string = array_slice( $string, 0, 1 );
		}

		return $string ? implode( ', ', $string ) . __( ' left', 'dm' ) : __( 'just now', 'dm' );
	}

	/**
	 * Sanitize Editor.
	 *
	 * @param $value
	 *
	 * @return string
	 */

	public function dimas_sanitize_editor( $value ) {
		return force_balance_tags( apply_filters( 'the_content', $value ) );
	}



	 /**
	  * Sanitize Button.
	  *
	  * @param $value
	  *
	  * @return bold
	  */
	function dimas_sanitize_button_switch( $value ) {
		if ( $value ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Query WooCommerce activation
	 */
	public static function dimas_is_woocommerce_activated() {
		return class_exists( 'WooCommerce' ) ? true : false;
	}

	/**
	 * Scrape Instagram.
	 *
	 * @param string $username
	 * @param int    $slice
	 *
	 * @return array|mixed|WP_Error
	 */
	public static function dimas_scrape_instagram( $username, $slice = 9 ) {
		$username   = strtolower( $username );
		$by_hashtag = ( substr( $username, 0, 1 ) == '#' );
		if ( false === ( $instagram = get_transient( 'otf-instagram-media-new-' . sanitize_title_with_dashes( $username ) ) ) ) {
			$request_param = ( $by_hashtag ) ? 'explore/tags/' . substr( $username, 1 ) : trim( $username );
			$remote        = wp_remote_get( 'https://instagram.com/' . $request_param );

			if ( is_wp_error( $remote ) ) {
				return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Instagram.', 'dm' ) );
			}

			if ( 200 != wp_remote_retrieve_response_code( $remote ) ) {
				return new WP_Error( 'invalid_response', esc_html__( 'Instagram did not return a 200.', 'dm' ) );
			}

			$shards      = explode( 'window._sharedData = ', $remote['body'] );
			$insta_json  = explode( ';</script>', $shards[1] );
			$insta_array = json_decode( $insta_json[0], true );

			if ( ! $insta_array ) {
				return new WP_Error( 'bad_json', esc_html__( 'Instagram has returned invalid data.', 'dm' ) );
			}

			// old style
			if ( isset( $insta_array['entry_data']['UserProfile'][0]['userMedia'] ) ) {
				$images = $insta_array['entry_data']['UserProfile'][0]['userMedia'];
				$type   = 'old';
				// old_2 style
			} elseif ( $by_hashtag && isset( $insta_array['entry_data']['TagPage'][0]['tag']['media']['nodes'] ) ) {
				$images = $insta_array['entry_data']['TagPage'][0]['tag']['media']['nodes'];
				$type   = 'old_2';
			} elseif ( isset( $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'] ) ) {
				$images = $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'];
				$type   = 'old_2';
				// new style
			} elseif ( isset( $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'] ) ) {
				$images = $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'];
				$type   = 'new';
				// new style
			} elseif ( $by_hashtag && isset( $insta_array['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'] ) ) {
				$images = $insta_array['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'];
				$type   = 'new';
			} else {
				return new WP_Error( 'bad_json_2', esc_html__( 'Instagram has returned invalid data.', 'dm' ) );
			}

			if ( ! is_array( $images ) ) {
				return new WP_Error( 'bad_array', esc_html__( 'Instagram has returned invalid data.', 'dm' ) );
			}

			$instagram = array();

			switch ( $type ) {
				case 'old':
					foreach ( $images as $image ) {
						if ( $image['user']['username'] == $username ) {
							$image['images']['thumbnail']           = preg_replace( '/^http:/i', '', $image['images']['thumbnail'] );
							$image['images']['standard_resolution'] = preg_replace( '/^http:/i', '', $image['images']['standard_resolution'] );
							$image['images']['low_resolution']      = preg_replace( '/^http:/i', '', $image['images']['low_resolution'] );
							$instagram[]                            = array(
								'description' => $image['caption']['text'],
								'link'        => $image['link'],
								'time'        => $image['created_time'],
								'comments'    => $image['comments']['count'],
								'likes'       => $image['likes']['count'],
								'thumbnail'   => $image['images']['thumbnail'],
								'large'       => $image['images']['standard_resolution'],
								'small'       => $image['images']['low_resolution'],
								'type'        => $image['type'],
							);
						}
					}
					break;
				case 'old_2':
					foreach ( $images as $image ) {
						$image['thumbnail_src'] = preg_replace( '/^https:/i', '', $image['thumbnail_src'] );
						$image['thumbnail']     = preg_replace( '/^https:/i', '', $image['thumbnail_resources'][0]['src'] );
						$image['medium']        = preg_replace( '/^https:/i', '', $image['thumbnail_resources'][2]['src'] );
						$image['large']         = $image['thumbnail_src'];
						$image['display_src']   = preg_replace( '/^https:/i', '', $image['display_src'] );
						if ( $image['is_video'] == true ) {
							$type = 'video';
						} else {
							$type = 'image';
						}
						$caption = esc_html__( 'Instagram Image', 'dm' );
						if ( ! empty( $image['caption'] ) ) {
							$caption = $image['caption'];
						}
						$instagram[] = array(
							'description' => $caption,
							'link'        => '//instagram.com/p/' . $image['code'],
							'time'        => $image['date'],
							'comments'    => $image['comments']['count'],
							'likes'       => $image['likes']['count'],
							'thumbnail'   => $image['thumbnail'],
							'medium'      => $image['medium'],
							'large'       => $image['large'],
							'original'    => $image['display_src'],
							'type'        => $type,
						);
					}
					break;
				default:
					foreach ( $images as $image ) {
						$image   = $image['node'];
						$caption = esc_html__( 'Instagram Image', 'dm' );
						if ( ! empty( $image['edge_media_to_caption']['edges'][0]['node']['text'] ) ) {
							$caption = $image['edge_media_to_caption']['edges'][0]['node']['text'];
						}

						$image['thumbnail_src'] = preg_replace( '/^https:/i', '', $image['thumbnail_src'] );
						$image['thumbnail']     = preg_replace( '/^https:/i', '', $image['thumbnail_resources'][0]['src'] );
						$image['medium']        = preg_replace( '/^https:/i', '', $image['thumbnail_resources'][2]['src'] );
						$image['large']         = $image['thumbnail_src'];

						$type = ( $image['is_video'] ) ? 'video' : 'image';

						$instagram[] = array(
							'description' => $caption,
							'link'        => '//instagram.com/p/' . $image['shortcode'],
							'comments'    => $image['edge_media_to_comment']['count'],
							'likes'       => $image['edge_liked_by']['count'],
							'thumbnail'   => $image['thumbnail'],
							'medium'      => $image['medium'],
							'large'       => $image['large'],
							'type'        => $type,
						);
					}
					break;
			}
			// do not set an empty transient - should help catch private or empty accounts
			if ( ! empty( $instagram ) ) {
				$instagram = base64_encode( maybe_serialize( $instagram ) );
				set_transient( 'otf-instagram-media-new-' . sanitize_title_with_dashes( $username ), $instagram, apply_filters( 'null_instagram_cache_time', HOUR_IN_SECONDS * 2 ) );
			}
		}
		if ( ! empty( $instagram ) ) {
			$instagram = maybe_unserialize( base64_decode( $instagram ) );

			return array_slice( $instagram, 0, $slice );
		} else {
			return new WP_Error( 'no_images', esc_html__( 'Instagram did not return any images.', 'dm' ) );
		}
	}


	/**
	 * Get metabox.
	 *
	 * @param int    $id
	 * @param string $key
	 * @param bool   $default
	 *
	 * @return bool|mixed
	 */
	public static function dimas_get_metabox( $id, $key, $default = false ) {
		$value = get_post_meta( $id, $key, true );
		if ( false === $value ) {
			return $default;
		} else {
			return $value;
		}
	}

	/**
	 * Do custom shortcode.
	 *
	 * @param string $tag      Shortcode tag name.
	 * @param array  $atts      List of params.
	 * @param mixed  $content  The content of shortcode.
	 * @return void
	 */
	public static function dimas_do_shortcode( $tag, array $atts = array(), $content = null ) {
		global $shortcode_tags;

		if ( ! isset( $shortcode_tags[ $tag ] ) ) {
			return false;
		}

		return call_user_func( $shortcode_tags[ $tag ], $atts, $content, $tag );
	}

	/**
	 * Get Theme Supports.
	 *
	 * @return bool|array
	 * @see custom theme support: https://developer.wordpress.org/reference/functions/add_theme_support/
	 */
	public static function dimas_get_theme_supports() {
		$theme_supports = get_theme_support( 'dimas-service-framework' );
		if ( $theme_supports ) {
			return wp_parse_args(
				$theme_supports,
				array(
					'typography_callback' => '',
					'colors_callback'     => '',
					'post_types'          => array(),
				)
			);
		} else {
			return false;
		}
	}



}
