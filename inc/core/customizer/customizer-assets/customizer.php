<?php
/**
 *
 * Customize function
 *
 * @package Dimas
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * ADD CUSTOM JS & CSS TO CUSTOMIZER function
 *
 * @return void
 */
function picostrap_customize_enqueue() {
	wp_enqueue_script( 'custom-customize', get_template_directory_uri() . '/inc/customizer-assets/customizer.js', array( 'jquery', 'customize-controls' ), '2.63', true );
	wp_enqueue_script( 'custom-customize-lib', get_template_directory_uri() . '/inc/customizer-assets/customizer-vars.js', array( 'jquery', 'customize-controls' ), '2.61', true );
	wp_enqueue_style( 'custom-customize', get_template_directory_uri() . '/inc/customizer-assets/customizer.css', array(), '2.61' );

	// fontpicker.
	wp_enqueue_script( 'fontpicker', get_template_directory_uri() . '/inc/customizer-assets/fontpicker/jquery.fontpicker.min.js', array( 'jquery', 'customize-controls' ), '2.61', true );
	wp_enqueue_style( 'fontpicker', get_template_directory_uri() . '/inc/customizer-assets/fontpicker/jquery.fontpicker.min.css', array(), '2.61' );
}
add_action( 'customize_controls_enqueue_scripts', 'picostrap_customize_enqueue' );

add_filter( 'body_class', 'picostrap_config_body_classes' );
/**
 * ADD BODY CLASSES function
 *
 * @param array $classes Class array to add body.
 * @return array
 */
function picostrap_config_body_classes( $classes ) {
	$classes[] = 'picostrap_header_navbar_position_' . get_theme_mod( 'picostrap_header_navbar_position' );
	return $classes;
}

add_action( 'get_header', 'picostrap_filter_head' );
/**
 * REMOVE BODY MARGIN-TOP GIVEN BY WordPress ADMIN BAR function
 *
 * @return void
 */
function picostrap_filter_head() {
	if ( get_theme_mod( 'picostrap_header_navbar_position' ) == 'fixed-top' ) {
		remove_action( 'wp_head', '_admin_bar_bump_cb' );
	}
}

if ( ! function_exists( 'picostrap_get_scss_variables_array' ) ) :

	/**
	 * MAIN SETTING: DECLARE ALL SCSS VARIABLES TO HANDLE IN THE CUSTOMIZER function
	 *
	 * @return array
	 */
	function picostrap_get_scss_variables_array() {
		return array();
	}

endif;


// ENABLE SELECTIVE REFRESH.
add_theme_support( 'customize-selective-refresh-widgets' );


// add_action( 'customize_register', 'picostrap_register_main_partials' );.
/**
 * ADD HELPER ICONS function
 *
 * @param object WP_Customize_Manager $wp_customize The wp_customize.
 * @return void
 */
function picostrap_register_main_partials( WP_Customize_Manager $wp_customize ) {

	// Abort if selective refresh is not available.
	if ( ! isset( $wp_customize->selective_refresh ) ) {
		return;}

	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	// blogname.
	$wp_customize->selective_refresh->add_partial(
		'header_site_title',
		array(
			'selector'        => 'a.navbar-brand',
			'settings'        => array( 'blogname' ),
			'render_callback' => function() {
				return get_bloginfo( 'name', 'display' );  },
		)
	);

	// blog description.
	$wp_customize->selective_refresh->add_partial(
		'header_site_desc',
		array(
			'selector'        => '#top-description',
			'settings'        => array( 'blogdescription' ),
			'render_callback' => function() {
				return get_bloginfo( 'description', 'display' ); },
		)
	);

	// hide tagline.
	$wp_customize->selective_refresh->add_partial(
		'header_disable_tagline',
		array(
			'selector'        => '#top-description',
			'settings'        => array( 'header_disable_tagline' ),
			'render_callback' => function() {
				if ( ! get_theme_mod( 'header_disable_tagline' ) ) {
					return get_bloginfo( 'description', 'display' );
				} else {
					return '';
				}},
		)
	);

	// MENUS.
	$wp_customize->selective_refresh->add_partial(
		'header_menu_left',
		array(
			'selector' => '#navbar .menuwrap-left',
			'settings' => array( 'nav_menu_locations[navbar-left]' ),

		)
	);

	// topbar content.
	$wp_customize->selective_refresh->add_partial(
		'topbar_html_content',
		array(
			'selector'        => '#topbar-content',
			'settings'        => array( 'topbar_content' ),
			'render_callback' => function() {
				 return get_theme_mod( 'topbar_content' );
			},
		)
	);
	// footer text.
	$wp_customize->selective_refresh->add_partial(
		'footer_ending_text',
		array(
			'selector'        => 'footer.site-footer',
			'settings'        => array( 'picostrap_footer_text' ),
			'render_callback' => function() {
				 return picostrap_site_info();
			},
		)
	);

	// SINGLE: categories.
	$wp_customize->selective_refresh->add_partial(
		'singlepost_entry_footer',
		array(
			'selector'        => '.entry-categories',
			'settings'        => array( 'singlepost_disable_entry_cats' ),
			'render_callback' => '__return_false',
		)
	);

	// SINGLE: meta: date and author.
	$wp_customize->selective_refresh->add_partial(
		'singlepost_entry_meta',
		array(
			'selector'        => '#single-post-meta',
			'settings'        => array( 'singlepost_disable_entry_meta' ),
			'render_callback' => '__return_false',
		)
	);

	// SINGLE: sharing buttons.
	$wp_customize->selective_refresh->add_partial(
		'enable_sharing_buttons',
		array(
			'selector'        => '.picostrap-sharing-buttons',
			'settings'        => array( 'enable_sharing_buttons' ),
			'render_callback' => '__return_false',
		)
	);

}

// add_action( 'customize_register', 'picostrap_theme_customize_register_extras' );.

/**
 * DECLARE ALL THE WIDGETS WE NEED FOR THE SCSS OPTIONS function
 *
 * @param object $wp_customize The wp_customize.
 * @return void
 */
function picostrap_theme_customize_register_extras( $wp_customize ) {

	// ADDITIONAL SECTIONS:
	// COLORS is already default.

	$wp_customize->add_section(
		'typography',
		array(
			'title'    => __( 'Typography', 'picostrap' ),
			'priority' => 50,
		)
	);

	$wp_customize->add_section(
		'components',
		array(
			'title'    => __( 'Global Options', 'picostrap' ),
			'priority' => 50,
		)
	);

	$wp_customize->add_section(
		'buttons-forms',
		array(
			'title'    => __( 'Forms', 'picostrap' ),
			'priority' => 50,
		)
	);

	$wp_customize->add_section(
		'buttons',
		array(
			'title'    => __( 'Buttons', 'picostrap' ),
			'priority' => 50,
		)
	);

	// istantiate  all controls needed for controlling the SCSS variables.
	foreach ( picostrap_get_scss_variables_array() as $section_slug => $section_data ) :

		foreach ( $section_data as $variable_name => $variable_props ) :

			$variable_slug               = str_replace( '$', 'SCSSvar_', $variable_name );
			$variable_pretty_format_name = ucwords( str_replace( '-', ' ', str_replace( '$', '', $variable_name ) ) );
			$variable_type               = $variable_props['type'];
			if ( array_key_exists( 'default', $variable_props ) ) {
				$default = $variable_props['default'];
			} else {
				$default = '';
			}

			if ( 'color' == $variable_type ) :

				$wp_customize->add_setting(
					$variable_slug,
					array(
						'default'           => $default,
						'sanitize_callback' => 'sanitize_hex_color',
						'transport'         => 'postMessage',
					)
				);
				$wp_customize->add_control(
					new WP_Customize_Color_Control(
						$wp_customize,
						$variable_slug, // give it an ID.
						array(
							'label'       => $variable_pretty_format_name, // set the label to appear in the Customizer.
							'description' => '(' . $variable_name . ')',
							'section'     => $section_slug, // select the section for it to appear under.
						)
					)
				);
			endif;

			if ( 'boolean' == $variable_type ) :

				$wp_customize->add_setting(
					$variable_slug,
					array(
						'default'   => $default,
						'transport' => 'postMessage',
					)
				);
				$wp_customize->add_control(
					new WP_Customize_Control(
						$wp_customize,
						$variable_slug,
						array(
							'label'       => $variable_pretty_format_name, // set the label to appear in the Customizer.
							'description' => '(' . $variable_name . ')',
							'section'     => $section_slug, // select the section for it to appear under.
							'type'        => 'checkbox',
						)
					)
				);
			endif;

			if ( 'text' == $variable_type ) :

				if ( array_key_exists( 'placeholder', $variable_props ) ) {
					$placeholder_html = '<b>Default:</b> ' . $variable_props['placeholder'];
				} else {
					$placeholder_html = '';
				}
				if ( array_key_exists( 'newgroup', $variable_props ) ) {
					$optional_grouptitle = " <span hidden class='cs-option-group-title'>" . $variable_props['newgroup'] . '</span>';
				} else {
					$optional_grouptitle = '';
				}

				$wp_customize->add_setting(
					$variable_slug,
					array(
						'default'   => $default,
						'transport' => 'postMessage',
					// "default" => "1rem",
					// 'sanitize_callback' => 'picostrap_sanitize_rem'
					)
				);
				$wp_customize->add_control(
					new WP_Customize_Control(
						$wp_customize,
						$variable_slug,
						array(
							'label'       => $variable_pretty_format_name, // set the label to appear in the Customizer.
							'description' => $optional_grouptitle . ' <!-- (' . $variable_name . ') -->' . $placeholder_html, // ADD COMMENT HERE IF NECESSARY.
							'section'     => $section_slug, // select the section for it to appear under.
							'type'        => 'text',
						)
					)
				);
			endif;

		endforeach;
	endforeach;

}
