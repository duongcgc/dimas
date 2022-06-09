<?php
/**
 * Customizer settings for this theme.
 *
 * @package WordPress
 * @subpackage Dimas
 * @since Dimas 1.0
 */


	/**
	 * Customizer Settings.
	 *
	 * @since Dimas 1.0
	 */
class Dimas_Customize {

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
		$wp_customize->register_control_type( 'Dimas\Customize_Color_Control' );

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

	// ======================================================================================
	// Customizer Callback
	// ======================================================================================

	public static function dimas_customize_partial_header_content() {
		get_template_part( 'template-parts/header' );
	}

	public static function dimas_customize_partial_css() {
		echo '<style type="text/css">';
		echo apply_filters( 'dimas_theme_custom_inline_css', '' ) . dimas_theme_custom_css();
		echo '</style>';
	}

	public static function dimas_customize_partial_google_font() {
		?>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php
		wp_head();
	}

	public static function dimas_customize_partial_sidebar() {
		echo dynamic_sidebar( apply_filters( 'opal_theme_sidebar', '' ) );
	}

	public static function dimas_customize_partial_page_title() {
		get_template_part( 'template-parts/common/page-title' );
	}

	public static function dimas_customize_partial_footer() {
		if ( ! get_theme_mod( 'dimas_footer_layout', 0 ) ) {
			get_template_part( 'template-parts/footer/default' );
		} else {
			get_template_part( 'template-parts/footer/builder' );
		}
	}

	public static function dimas_customize_partial_copyright() {
		echo force_balance_tags( apply_filters( 'the_content', get_theme_mod( 'dimas_footer_copyright' ) ) );
	}

	public static function dimas_get_option( $option_key, $key = '', $default = false ) {
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
}
