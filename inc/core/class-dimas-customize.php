<?php
/**
 * Customizer settings for this theme.
 *
 * @package WordPress
 * @subpackage Dimas
 * @since Dimas 1.0
 */

namespace Dimas;

if ( ! class_exists( 'Theme_Customize' ) ) {
	/**
	 * Customizer Settings.
	 *
	 * @since Dimas 1.0
	 */
	class Theme_Customize {

		/**
		 * Constructor. Instantiate the object.
		 *
		 * @since Dimas 1.0
		 */
		public function __construct() {
			add_action( 'customize_register', array( $this, 'register' ) );
			add_action( 'customize_preview_init', array( $this, 'dimas_customize_preview_init' ) );
			add_action( 'customize_controls_enqueue_scripts', array( $this, 'dimas_customize_controls_enqueue_scripts' ) );

		}

		/**
		 * Register customizer options.
		 *
		 * @since Dimas 1.0
		 *
		 * @param WP_Customize_Manager $wp_customize Dimas_Theme Customizer object.
		 * @return void
		 */
		public function register( $wp_customize ) {

			// Change site-title & description to postMessage.
			$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage'; // @phpstan-ignore-line. Assume that this setting exists.
			$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage'; // @phpstan-ignore-line. Assume that this setting exists.

			// Add partial for blogname.
			$wp_customize->selective_refresh->add_partial(
				'blogname',
				array(
					'selector'        => '.site-title',
					'render_callback' => array( $this, 'partial_blogname' ),
				)
			);

			// Add partial for blogdescription.
			$wp_customize->selective_refresh->add_partial(
				'blogdescription',
				array(
					'selector'        => '.site-description',
					'render_callback' => array( $this, 'partial_blogdescription' ),
				)
			);

			// Add "display_title_and_tagline" setting for displaying the site-title & tagline.
			$wp_customize->add_setting(
				'display_title_and_tagline',
				array(
					'capability'        => 'edit_theme_options',
					'default'           => true,
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);

			// Add control for the "display_title_and_tagline" setting.
			$wp_customize->add_control(
				'display_title_and_tagline',
				array(
					'type'    => 'checkbox',
					'section' => 'title_tagline',
					'label'   => esc_html__( 'Display Site Title & Tagline', 'dimas' ),
				)
			);

			/**
			 * Add excerpt or full text selector to customizer
			 */
			$wp_customize->add_section(
				'excerpt_settings',
				array(
					'title'    => esc_html__( 'Excerpt Settings', 'dimas' ),
					'priority' => 120,
				)
			);

			$wp_customize->add_setting(
				'display_excerpt_or_full_post',
				array(
					'capability'        => 'edit_theme_options',
					'default'           => 'excerpt',
					'sanitize_callback' => static function( $value ) {
						return 'excerpt' === $value || 'full' === $value ? $value : 'excerpt';
					},
				)
			);

			$wp_customize->add_control(
				'display_excerpt_or_full_post',
				array(
					'type'    => 'radio',
					'section' => 'excerpt_settings',
					'label'   => esc_html__( 'On Archive Pages, posts show:', 'dimas' ),
					'choices' => array(
						'excerpt' => esc_html__( 'Summary', 'dimas' ),
						'full'    => esc_html__( 'Full text', 'dimas' ),
					),
				)
			);

			// Background color.
			// Include the custom control class.
			include_once get_theme_file_path( 'inc/core/customizer/class-dimas-customize-color-control.php' ); // phpcs:ignore WPDimas_ThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

			// Register the custom control.
			$wp_customize->register_control_type( 'Customize_Color_Control' );

			// Get the palette from theme-supports.
			$palette = get_theme_support( 'editor-color-palette' );

			// Build the colors array from theme-support.
			$colors = array();
			if ( isset( $palette[0] ) && is_array( $palette[0] ) ) {
				foreach ( $palette[0] as $palette_color ) {
					$colors[] = $palette_color['color'];
				}
			}

			// Add the control. Overrides the default background-color control.
			$wp_customize->add_control(
				new Customize_Color_Control(
					$wp_customize,
					'background_color',
					array(
						'label'   => esc_html_x( 'Background color', 'Customizer control', 'dimas' ),
						'section' => 'colors',
						'palette' => $colors,
					)
				)
			);
		}


		/**
		 * Enqueue scripts for the customizer preview.
		 *
		 * @since Dimas 1.0
		 *
		 * @return void
		 */
		public function dimas_customize_preview_init() {
			wp_enqueue_script(
				'dimas-customize-helpers',
				get_theme_file_uri( '/assets/js/customize-helpers.js' ),
				array(),
				wp_get_theme()->get( 'Version' ),
				true
			);

			wp_enqueue_script(
				'dimas-customize-preview',
				get_theme_file_uri( '/assets/js/customize-preview.js' ),
				array( 'customize-preview', 'customize-selective-refresh', 'jquery', 'dimas-customize-helpers' ),
				wp_get_theme()->get( 'Version' ),
				true
			);
		}

		/**
		 * Enqueue scripts for the customizer.
		 *
		 * @since Dimas 1.0
		 *
		 * @return void
		 */
		public function dimas_customize_controls_enqueue_scripts() {

			wp_enqueue_script(
				'dimas-customize-helpers',
				get_theme_file_uri( '/assets/js/customize-helpers.js' ),
				array(),
				wp_get_theme()->get( 'Version' ),
				true
			);
		}

		/**
		 * Sanitize boolean for checkbox.
		 *
		 * @since Dimas 1.0
		 *
		 * @param bool $checked Whether or not a box is checked.
		 * @return bool
		 */
		public static function sanitize_checkbox( $checked = null ) {
			return (bool) isset( $checked ) && true === $checked;
		}

		/**
		 * Render the site title for the selective refresh partial.
		 *
		 * @since Dimas 1.0
		 *
		 * @return void
		 */
		public function partial_blogname() {
			bloginfo( 'name' );
		}

		/**
		 * Render the site tagline for the selective refresh partial.
		 *
		 * @since Dimas 1.0
		 *
		 * @return void
		 */
		public function partial_blogdescription() {
			bloginfo( 'description' );
		}
	}
}
