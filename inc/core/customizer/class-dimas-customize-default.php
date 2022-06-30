<?php
/**
 * Get the default option for Customizer.
 *
 * @package Dimas
 */

if ( ! function_exists( 'theme_mod_defaults_args' ) ) {
	/**
	 * Dimas set theme mode defaults option function
	 *
	 * @return array
	 */
	function theme_mod_defaults_args() {
		static $defaults;

		if ( ! $defaults ) {
			$defaults = apply_filters(
				'dimas_defaults',
				array(

					// General.
					'preloader_show'                 => true,
					'preloader_background_color'     => 'rgb(1, 26, 44, 1)',
					'preloader'                      => 'default',

					// Animations.
					'transition_duration_numer'      => 300,

					// Colors.
					'color_main_default'             => '#ff6F61',
					'color_main_custom'              => true,
					'color_main'                     => 'rgb(242, 25, 103, 1)',

					// Typography body.
					'typo_main'                      => array(
						'font-family'    => 'Poppins',
						'variant'        => 'regular',
						'font-size'      => '0.875rem',
						'line-height'    => '1.8571428571',
						'color'          => '#B3BBC0',
						'text-transform' => 'none',
						'subsets'        => array( 'latin-ext' ),
					),
					'typo_h1'                        => array(
						'font-family'    => 'Heist',
						'variant'        => 'regular',
						'font-size'      => '5rem',
						'line-height'    => '1.25',
						'color'          => '#fff',
						'text-transform' => 'none',
						'subsets'        => array( 'latin-ext' ),
					),
					'typo_h2'                        => array(
						'font-family'    => 'Heist',
						'variant'        => 'regular',
						'font-size'      => '3.5rem',
						'line-height'    => '1.25',
						'color'          => '#fff',
						'text-transform' => 'none',
						'subsets'        => array( 'latin-ext' ),
					),
					'typo_h3'                        => array(
						'font-family'    => 'Heist',
						'variant'        => 'regular',
						'font-size'      => '1.25rem',
						'line-height'    => '1.3',
						'color'          => '#fff',
						'text-transform' => 'none',
						'subsets'        => array( 'latin-ext' ),
					),
					'typo_h4'                        => array(
						'font-family'    => 'Outfit',
						'variant'        => '700',
						'font-size'      => '1.25rem',
						'line-height'    => '1.1875',
						'color'          => '#fff',
						'text-transform' => 'none',
						'subsets'        => array( 'latin-ext' ),
					),
					'typo_h5'                        => array(
						'font-family'    => 'Poppins',
						'variant'        => 'regular',
						'font-size'      => '1rem',
						'line-height'    => '1.25',
						'color'          => '#F21967',
						'text-transform' => 'none',
						'subsets'        => array( 'latin-ext' ),
					),
					'typo_h6'                        => array(
						'font-family'    => 'Poppins',
						'variant'        => 'regular',
						'font-size'      => '0.875rem',
						'line-height'    => '1.8571428571',
						'color'          => '#B3BBC0',
						'text-transform' => 'none',
						'subsets'        => array( 'latin-ext' ),
					),

					// Header.
					'header_bg_color_default'        => '#ff6F61',
					'header_bg_custom'               => true,
					'header_bg_color'                => '#011A2C66',
					'logo_type'                      => 'image',
					'logo'                           => '',
					'logo_light'                     => '',
					'logo_text'                      => 'Dimas.',
					'logo_dimension'                 => array(
						'width'  => '',
						'height' => '',
					),
					'header_menus_item'              => '',
					'header_social_show'             => true,

					// Footer.
					'footer_bg_color_default'        => '#ff6F61',
					'footer_bg_custom'               => true,
					'footer_bg_color'                => '#011A2C66',
					'footer_item_left_show'          => 1,
					'footer_item_left_text'          => esc_html__( 'DIMAS@DOMAIN.COM', 'dimas' ),
					'footer_item_left_link '         => esc_html__( 'mailto:dimas@domain.com', 'dimas' ),
					'footer_item_right_show'         => 1,
					'footer_item_right_text'         => esc_html__( 'TELL: (+34) 765 87 34 54', 'dimas' ),
					'footer_item_right_link '        => esc_html__( 'tel:(+34)765873454', 'dimas' ),

					// pages.
					'page_title_show'                => true,
					'page_comments_show'             => true,

					// post.
					'post_archive_title_show'        => true,
					'post_archive_title_type'        => 'enter_input',
					'post_archive_title_input'       => esc_html__( 'Latest Posts', 'dimas' ),
					'post_archive_style_chose'       => 'masonry',

					'post_single_fetured_img_show'   => true,
					'post_single_date_show'          => true,
					'post_single_title_show'         => true,
					'post_single_social_share_show'  => true,
					'post_single_related_show'       => true,
					'post_single_comments_show'      => true,

					// social & contact.

					'social_link_count'              => 3,
					'social_link_item_1_icon_type'   => 'custom',
					'social_link_item_2_icon_type'   => 'custom',
					'social_link_item_3_icon_type'   => 'custom',
					'social_link_item_4_icon_type'   => 'custom',
					'social_link_item_5_icon_type'   => 'custom',
					'social_link_item_6_icon_type'   => 'custom',

					'social_link_item_1_icon_custom' => 'dimas_fb',
					'social_link_item_2_icon_custom' => 'dimas_fb',
					'social_link_item_3_icon_custom' => 'dimas_fb',
					'social_link_item_4_icon_custom' => 'dimas_fb',
					'social_link_item_5_icon_custom' => 'dimas_fb',
					'social_link_item_6_icon_custom' => 'dimas_fb',

					'social_link_item_1_icon_input'  => '',
					'social_link_item_2_icon_input'  => '',
					'social_link_item_3_icon_input'  => '',
					'social_link_item_4_icon_input'  => '',
					'social_link_item_5_icon_input'  => '',
					'social_link_item_6_icon_input'  => '',

					'social_link_item_1_text'        => '',
					'social_link_item_2_text'        => '',
					'social_link_item_3_text'        => '',
					'social_link_item_4_text'        => '',
					'social_link_item_5_text'        => '',
					'social_link_item_6_text'        => '',

					'social_link_item_1_link'        => '',
					'social_link_item_2_link'        => '',
					'social_link_item_3_link'        => '',
					'social_link_item_4_link'        => '',
					'social_link_item_5_link'        => '',
					'social_link_item_6_link'        => '',

					'info_count'                     => 3,
					'info_item_1_icon_type'          => 'custom',
					'info_item_2_icon_type'          => 'custom',
					'info_item_3_icon_type'          => 'custom',
					'info_item_4_icon_type'          => 'custom',
					'info_item_5_icon_type'          => 'custom',
					'info_item_6_icon_type'          => 'custom',

					'info_item_1_icon_custom'        => 'dimas_fb',
					'info_item_2_icon_custom'        => 'dimas_fb',
					'info_item_3_icon_custom'        => 'dimas_fb',
					'info_item_4_icon_custom'        => 'dimas_fb',
					'info_item_5_icon_custom'        => 'dimas_fb',
					'info_item_6_icon_custom'        => 'dimas_fb',

					'info_item_1_icon_input'         => '',
					'info_item_2_icon_input'         => '',
					'info_item_3_icon_input'         => '',
					'info_item_4_icon_input'         => '',
					'info_item_5_icon_input'         => '',
					'info_item_6_icon_input'         => '',

					'info_item_1_text'               => '',
					'info_item_2_text'               => '',
					'info_item_3_text'               => '',
					'info_item_4_text'               => '',
					'info_item_5_text'               => '',
					'info_item_6_text'               => '',

					'info_item_1_link'               => '',
					'info_item_2_link'               => '',
					'info_item_3_link'               => '',
					'info_item_4_link'               => '',
					'info_item_5_link'               => '',
					'info_item_6_link'               => '',

				)
			);
		}

		return $defaults;
	}
}

if ( ! function_exists( 'set_theme_mod_defaults' ) ) {
	/**
	 * Dimas set theme mode defaults option function
	 *
	 * @return void
	 */
	function set_theme_mod_defaults() {

		$defaults = theme_mod_defaults_args();

		foreach ( $defaults as $key => $val ) {
			set_theme_mod( $key, $val );
		}

	}
	add_action( 'admin_head', 'set_theme_mod_defaults' );
}

if ( ! function_exists( 'dimas_defaults' ) ) {
	/**
	 * Dimas get defaults option function
	 *
	 * @param string $name the name of option.
	 * @return string
	 */
	function dimas_defaults( $name ) {

		$defaults = theme_mod_defaults_args();

		return isset( $defaults[ $name ] ) ? $defaults[ $name ] : null;
	}
}
