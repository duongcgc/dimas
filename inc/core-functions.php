<?php
/**
 * @return array
 */
function dimas_get_google_fonts() {
	$content = file_get_contents( DIMAS_CORE_PLUGIN_DIR . 'webfonts.json' );

	return json_decode( $content )->items;
}

/**
 * @return bool|array
 * @see
 */
function dimas_get_theme_supports() {
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


if ( ! function_exists( 'dimas_do_shortcode' ) ) {

	function dimas_do_shortcode( $tag, array $atts = array(), $content = null ) {
		global $shortcode_tags;

		if ( ! isset( $shortcode_tags[ $tag ] ) ) {
			return false;
		}

		return call_user_func( $shortcode_tags[ $tag ], $atts, $content, $tag );
	}
}

function dimas_get_fonts_url() {
	$subsets       = array();
	$font_families = array();

	// Body Font.
	$body_font = get_theme_mod( 'dimas_typography_general_body_font' );
	if ( is_array( $body_font ) && $body_font['family'] ) {
		$font_families[] = "{$body_font['family']}:{$body_font['fontWeight']}";
		// $font_families[] = "{$body_font['family']}";
		$subsets[] = $body_font['subsets'];
	}

	// Heading Font.
	$heading_font = get_theme_mod( 'dimas_typography_general_heading_font' );
	if ( is_array( $heading_font ) && $heading_font['family'] ) {

		// $font_families[] = "{$heading_font['family']}";
		$font_families[] = "{$heading_font['family']}:{$heading_font['fontWeight']}";
		$subsets[]       = $heading_font['subsets'];
	}

	// Tertiary Font.
	$tertiary_font = get_theme_mod( 'dimas_typography_general_tertiary_font' );
	if ( is_array( $tertiary_font ) && $tertiary_font['family'] ) {
		// $font_families[] = "{$heading_font['family']}";
		$font_families[] = "{$tertiary_font['family']}:{$tertiary_font['fontWeight']}";
		$subsets[]       = $tertiary_font['subsets'];
	}

	// Quaternary Font.
	$quaternary_font = get_theme_mod( 'dimas_typography_general_quaternary_font' );
	if ( is_array( $quaternary_font ) && $quaternary_font['family'] ) {
		// $font_families[] = "{$heading_font['family']}";
		$font_families[] = "{$quaternary_font['family']}:{$quaternary_font['fontWeight']}";
		$subsets[]       = $quaternary_font['subsets'];
	}

	if ( count( $font_families ) <= 0 ) {
		return false;
	}

	$query_args = array(
		'family' => urlencode( implode( '|', $font_families ) ),
		'subset' => urlencode( implode( ',', $subsets ) ),
	);
	$fonts_url  = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );

	return esc_url( $fonts_url );
}

/**
 * @param $font
 *
 * @return array
 */
function dimas_sanitize_font_style( $font ) {
	if ( $font && is_array( $font ) ) {
		return $font;
	}

	return array(
		'italic'     => '',
		'underline'  => '',
		'uppercase'  => '',
		'fontWeight' => '',
	);
}

/**
 * @param $value
 *
 * @return string
 */
function dimas_sanitize_editor( $value ) {
	return force_balance_tags( apply_filters( 'the_content', $value ) );
}

/**
 * @return bool
 */
function dimas_sanitize_button_switch( $value ) {
	if ( $value ) {
		return true;
	} else {
		return false;
	}
}


/**
 * @param $font
 *
 * @return array
 */
function dimas_sanitize_font_family( $font ) {
	if ( $font && is_array( $font ) ) {
		return $font;
	}

	return array(
		'family'     => '',
		'subsets'    => 'latin',
		'fontWeight' => '400',
	);
}


if ( ! function_exists( 'dimas_is_frontpage' ) ) {

	function dimas_is_frontpage() {
		return ( is_front_page() && ! is_home() );
	}
}

if ( ! function_exists( 'dimas_page_enable_breadcrumb' ) ) {
	/**
	 * @return bool
	 */
	function dimas_page_enable_breadcrumb() {
		$check = get_post_meta( get_the_ID(), 'dimas_enable_breadcrumb', true ) === '0' ? false : true;

		return ( $check );
	}
}

if ( ! function_exists( 'dimas_page_enable_page_title' ) ) {
	/**
	 * @return bool
	 */
	function dimas_page_enable_page_title() {
		$check = get_post_meta( get_the_ID(), 'dimas_enable_page_title', true ) === '0' ? false : true;

		return ( is_page() && $check );
	}
}

if ( ! function_exists( 'dimas_get_query' ) ) {

	/**
	 * @param $args
	 *
	 * @return WP_Query
	 */
	function dimas_get_query( $args ) {
		global $wp_query;
		$default  = array(
			'post_type' => 'post',
		);
		$args     = wp_parse_args( $args, $default );
		$wp_query = new WP_Query( $args );

		return $wp_query;
	}
}

if ( ! function_exists( 'dimas_get_metabox' ) ) {

	/**
	 * @param int    $id
	 * @param string $key
	 * @param bool   $default
	 *
	 * @return bool|mixed
	 */
	function dimas_get_metabox( $id, $key, $default = false ) {
		$value = get_post_meta( $id, $key, true );
		if ( false === $value ) {
			return $default;
		} else {
			return $value;
		}
	}
}



if ( ! function_exists( 'dimas_scrape_instagram' ) ) {
	/**
	 * @param string $username
	 * @param int    $slice
	 *
	 * @return array|mixed|WP_Error
	 */
	function dimas_scrape_instagram( $username, $slice = 9 ) {
		$username   = strtolower( $username );
		$by_hashtag = ( substr( $username, 0, 1 ) == '#' );
		if ( false === ( $instagram = get_transient( 'otf-instagram-media-new-' . sanitize_title_with_dashes( $username ) ) ) ) {
			$request_param = ( $by_hashtag ) ? 'explore/tags/' . substr( $username, 1 ) : trim( $username );
			$remote        = wp_remote_get( 'https://instagram.com/' . $request_param );

			if ( is_wp_error( $remote ) ) {
				return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Instagram.', 'beautifo-core' ) );
			}

			if ( 200 != wp_remote_retrieve_response_code( $remote ) ) {
				return new WP_Error( 'invalid_response', esc_html__( 'Instagram did not return a 200.', 'beautifo-core' ) );
			}

			$shards      = explode( 'window._sharedData = ', $remote['body'] );
			$insta_json  = explode( ';</script>', $shards[1] );
			$insta_array = json_decode( $insta_json[0], true );

			if ( ! $insta_array ) {
				return new WP_Error( 'bad_json', esc_html__( 'Instagram has returned invalid data.', 'beautifo-core' ) );
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
				return new WP_Error( 'bad_json_2', esc_html__( 'Instagram has returned invalid data.', 'beautifo-core' ) );
			}

			if ( ! is_array( $images ) ) {
				return new WP_Error( 'bad_array', esc_html__( 'Instagram has returned invalid data.', 'beautifo-core' ) );
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
						$caption = esc_html__( 'Instagram Image', 'beautifo-core' );
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
						$caption = esc_html__( 'Instagram Image', 'beautifo-core' );
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
			return new WP_Error( 'no_images', esc_html__( 'Instagram did not return any images.', 'beautifo-core' ) );
		}
	}
}

if ( ! function_exists( 'dimas_pretty_number' ) ) {
	function dimas_pretty_number( $x = 0 ) {
		$x = (int) $x;

		if ( $x > 1000000 ) {
			return floor( $x / 1000000 ) . 'M';
		}

		if ( $x > 10000 ) {
			return floor( $x / 1000 ) . 'k';
		}

		return $x;
	}
}

function dimas_get_icon_svg( $path, $color = '', $width = '' ) {
	$content = dimas_get_file_contents( $path );
	if ( $content ) {
		$re = '/<svg(([^\n]*\n)+)<\/svg>/';
		preg_match_all( $re, $content, $matches, PREG_SET_ORDER, 0 );
		if ( count( $matches ) > 0 ) {
			$content = $matches[0][0];
			$css     = '';
			if ( $color ) {
				$content = preg_replace( '/stroke="[^"]*"/', 'stroke="' . $color . '"', $content );
				$css    .= 'fill:' . $color . ';';
			}
			if ( $width ) {
				$css .= 'width:' . $width . '; height: auto;';
			}
			$content = preg_replace( "/(<svg[^>]*)(style=(\"|')([^(\"|')]*)('|\"))/m", '$1 style="' . $css . '$4"', $content );
		}
	}

	return $content;
}

function dimas_get_file_contents( $path ) {
	if ( is_file( $path ) ) {
		return file_get_contents( $path );
	}

	return false;
}

function dimas_get_image_size( $thumb_size ) {
	if ( is_string( $thumb_size )
		&& in_array(
			$thumb_size,
			array(
				'thumbnail',
				'thumb',
				'medium',
				'large',
				'full',
			)
		) ) {
		$images_sizes = dimas_get_all_image_sizes();
		$image_size   = $images_sizes[ $thumb_size ];
		if ( $thumb_size == 'full' ) {
			$image_size['width']  = 999999;
			$image_size['height'] = 999999;
		}

		return array( $image_size['width'], $image_size['height'] );
	} elseif ( is_string( $thumb_size ) ) {
		preg_match_all( '/\d+/', $thumb_size, $thumb_matches );
		if ( isset( $thumb_matches[0] ) ) {
			$thumb_size = array();
			if ( count( $thumb_matches[0] ) > 1 ) {
				$thumb_size[] = $thumb_matches[0][0]; // width
				$thumb_size[] = $thumb_matches[0][1]; // height
			} elseif ( count( $thumb_matches[0] ) > 0 && count( $thumb_matches[0] ) < 2 ) {
				$thumb_size[] = $thumb_matches[0][0]; // width
				$thumb_size[] = $thumb_matches[0][0]; // height
			} else {
				$thumb_size = false;
			}
		}

		return $thumb_size;
	}
}

function dimas_get_all_image_sizes() {
	global $_wp_additional_image_sizes;

	$default_image_sizes = array( 'thumbnail', 'medium', 'large', 'full' );

	foreach ( $default_image_sizes as $size ) {
		$image_sizes[ $size ]['width']  = intval( get_option( "{$size}_size_w" ) );
		$image_sizes[ $size ]['height'] = intval( get_option( "{$size}_size_h" ) );
		$image_sizes[ $size ]['crop']   = get_option( "{$size}_crop" ) ? get_option( "{$size}_crop" ) : false;
	}

	if ( isset( $_wp_additional_image_sizes ) && count( $_wp_additional_image_sizes ) ) {
		$image_sizes = array_merge( $image_sizes, $_wp_additional_image_sizes );
	}

	return $image_sizes;
}

// ======================================================================================
// Customizer Callback
// ======================================================================================
function dimas_customize_partial_header_content() {
	get_template_part( 'template-parts/header' );
}

function dimas_customize_partial_css() {
	echo '<style type="text/css">';
	echo apply_filters( 'dimas_theme_custom_inline_css', '' ) . dimas_theme_custom_css();
	echo '</style>';
}

function dimas_customize_partial_google_font() {
	?>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php
	wp_head();
}

function dimas_customize_partial_sidebar() {
	echo dynamic_sidebar( apply_filters( 'opal_theme_sidebar', '' ) );
}

function dimas_customize_partial_page_title() {
	get_template_part( 'template-parts/common/page-title' );
}

function dimas_customize_partial_footer() {
	if ( ! get_theme_mod( 'dimas_footer_layout', 0 ) ) {
		get_template_part( 'template-parts/footer/default' );
	} else {
		get_template_part( 'template-parts/footer/builder' );
	}
}

function dimas_customize_partial_copyright() {
	echo force_balance_tags( apply_filters( 'the_content', get_theme_mod( 'dimas_footer_copyright' ) ) );
}

function dimas_get_option( $option_key, $key = '', $default = false ) {
	if ( function_exists( 'cmb2_get_option' ) ) {
		// Use cmb2_get_option as it passes through some key filters.
		return cmb2_get_option( $option_key, $key, $default );
	}
	// Fallback to get_option if CMB2 is not loaded yet.
	$opts = get_option( $option_key, $default );
	$val  = $default;
	if ( 'all' == $key ) {
		$val = $opts;
	} elseif ( is_array( $opts ) && array_key_exists( $key, $opts ) && false !== $opts[ $key ] ) {
		$val = $opts[ $key ];
	}

	return $val;
}

if ( ! function_exists( 'dimas_fnc_excerpt' ) ) {
	// Custom Excerpt Function
	function dimas_fnc_excerpt( $limit, $afterlimit = '[...]' ) {
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
}

function dimas_do_shortcode( $tag, array $atts = array(), $content = null ) {
	global $shortcode_tags;

	if ( ! isset( $shortcode_tags[ $tag ] ) ) {
		return false;
	}

	return call_user_func( $shortcode_tags[ $tag ], $atts, $content, $tag );
}


if ( ! function_exists( 'dimas_is_woocommerce_activated' ) ) {
	/**
	 * Query WooCommerce activation
	 */
	function dimas_is_woocommerce_activated() {
		return class_exists( 'WooCommerce' ) ? true : false;
	}
}

function time_elapsed_string( $datetime, $full = false ) {
	$now  = new DateTime();
	$ago  = new DateTime( $datetime );
	$diff = $now->diff( $ago );

	$diff->w  = floor( $diff->d / 7 );
	$diff->d -= $diff->w * 7;

	$string = array(
		'y' => __( 'year', 'beautifo-core' ),
		'm' => __( 'month', 'beautifo-core' ),
		'w' => __( 'week', 'beautifo-core' ),
		'd' => __( 'day', 'beautifo-core' ),
		// 'h' => __('hour', 'beautifo-core'),
		// 'i' => __('minute', 'beautifo-core'),
		// 's' => __('second', 'beautifo-core'),
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

	return $string ? implode( ', ', $string ) . __( ' left', 'beautifo-core' ) : __( 'just now', 'beautifo-core' );
}

function sanitize_font_weight( $arr ) {
	if ( is_array( $arr ) && ! empty( $arr['fontWeight'] ) ) {
		$arr['fontWeight'] = preg_replace( '/\D+/m', '', $arr['fontWeight'] );
	}

	return $arr;
}

if ( ! function_exists( 'dimas_vertical_navigation' ) ) {
	/**
	 * Display Vertical Navigation
	 *
	 * @return void
	 * @since  1.0.0
	 */
	function dimas_vertical_navigation() {

		if ( isset( get_nav_menu_locations()['vertical'] ) ) {

			$menu_location  = 'vertical';
			$menu_locations = get_nav_menu_locations();
			$menu_object    = ( isset( $menu_locations[ $menu_location ] ) ? wp_get_nav_menu_object( $menu_locations[ $menu_location ] ) : null );
			$menu_name      = ( isset( $menu_object->name ) ? $menu_object->name : esc_html__( 'Vertical Menu', 'beautifo-core' ) );

			?>
			<nav class="vertical-navigation" aria-label="<?php esc_html_e( 'Vertical Navigation', 'beautifo-core' ); ?>">
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
}
