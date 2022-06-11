<?php
/**
 * Fonts functions and definitions.
 * => Loading fonts into this theme.
 *
 * @package Dimas
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Fonts initial
 */
class GO_Fonts {
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

	}

	/**
	 * Sanitize font family for input.
	 *
	 * @param string $font    The font name.
	 * @return array
	 */
	public static function dimas_sanitize_font_family( $font ) {
		if ( $font && is_array( $font ) ) {
			return $font;
		}

		return array(
			'family'     => '',
			'subsets'    => 'latin',
			'fontWeight' => '400',
		);
	}


	/**
	 * Santitize font style for input.
	 *
	 * @param mixed $font      The name fonts.
	 * @return array
	 */
	public static function dimas_sanitize_font_style( $font ) {
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
	 * Get list font google.
	 *
	 * @return array
	 */
	public static function dimas_get_google_fonts() {
		$content = file_get_contents( DIMAS_CORE_PLUGIN_DIR . 'webfonts.json' );

		return json_decode( $content )->items;
	}

	/**
	 * Get font url.
	 *
	 * @return void
	 */
	public static function dimas_get_fonts_url() {
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
	 * Sanitize Font weight.
	 *
	 * @param [type] $arr
	 * @return void
	 */
	public static function sanitize_font_weight( $arr ) {
		if ( is_array( $arr ) && ! empty( $arr['fontWeight'] ) ) {
			$arr['fontWeight'] = preg_replace( '/\D+/m', '', $arr['fontWeight'] );
		}

		return $arr;
	}
}
