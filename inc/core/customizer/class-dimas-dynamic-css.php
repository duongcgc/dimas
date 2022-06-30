<?php
/**
 * Style functions and definitions.
 *
 * @package Dimas
 */

namespace Dimas\Core\Customizer;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Style initial
 *
 * @since 1.0.0
 */
class Dynamic_CSS {
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

		add_action( 'dimas_after_enqueue_style', array( $this, 'add_static_css' ) );

	}

	/**
	 * Get get style data
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function add_static_css() {
		$parse_css  = $this->colors_css();
		$parse_css .= $this->typography_css();
		$parse_css .= $this->animations_css();
		$parse_css .= $this->header_css();
		$parse_css .= $this->footer_css();
		wp_add_inline_style( 'footer', apply_filters( 'dimas_inline_style', $parse_css ) );
	}


	/**
	 * Generate CSS.
	 *
	 * @since Dimas 1.0
	 *
	 * @param string $selector The CSS selector.
	 * @param string $style    The CSS style.
	 * @param string $value    The CSS value.
	 * @param string $prefix   The CSS prefix.
	 * @param string $suffix   The CSS suffix.
	 * @param bool   $display  Print the styles.
	 * @return string
	 */
	public static function dimas_generate_css( $selector, $style, $value, $prefix = '', $suffix = '', $display = true ) {

		// Bail early if there is no $selector elements or properties and $value.
		if ( ! $value || ! $selector ) {
			return '';
		}

		$css = sprintf( '%s { %s: %s; }', $selector, $style, $prefix . $value . $suffix );

		if ( $display ) {
			/*
			 * Note to reviewers: $css contains auto-generated CSS.
			 * It is included inside <style> tags and can only be interpreted as CSS on the browser.
			 * Using wp_strip_all_tags() here is sufficient escaping to avoid
			 * malicious attempts to close </style> and open a <script>.
			 */
			echo wp_strip_all_tags( $css ); // phpcs:ignore WordPress.Security.EscapeOutput
		}
		return $css;
	}


	/**
	 * Get colors data
	 *
	 * @since  1.0.0
	 *
	 * @return string
	 */
	protected function colors_css() {
		if ( false == get_theme_mod( 'color_main_custom' ) ) {
			$color_main = get_theme_mod( 'color_main_default' );
		} else {
			$color_main = get_theme_mod( 'color_main' );
		}
		$static_css  = '';
		$static_css .= ':root{--dimas-color-main:' . $color_main . ';}';

		return $static_css;
	}

	/**
	 * Get typography data
	 *
	 * @since  1.0.0
	 *
	 * @return string
	 */
	protected function typography_css() {

		$array_typography = array(
			'body'            => get_theme_mod( 'typo_main' ),
			'h1.label-banner' => get_theme_mod( 'typo_h1' ),
			'h2.label-banner' => get_theme_mod( 'typo_h2' ),
			'h3'              => get_theme_mod( 'typo_h3' ),
			'h4'              => get_theme_mod( 'typo_h4' ),
			'h5'              => get_theme_mod( 'typo_h5' ),
			'h6'              => get_theme_mod( 'typo_h6' ),
		);

		$static_css = '';

		foreach ( $array_typography as $key => $value ) {
			if ( str_contains( $value['variant'], 'regular' ) ) {
				$weigth = 400;
			} else {
				$weigth = $value['variant'];
			}
			if ( str_contains( $value['variant'], 'italic' ) ) {
				$weigth = '400;font-style:italic';
			}

			$static_css .= $key . '{font-family:' . $value['font-family'] . ';';
			$static_css .= 'font-weight:' . $weigth . ';';
			$static_css .= 'font-size:' . $value['font-size'] . ';';
			$static_css .= 'line-height:' . $value['line-height'] . ';';
			$static_css .= 'color:' . $value['color'] . ';';
			$static_css .= 'text-transform:' . $value['text-transform'] . ';}';

		}

		return $static_css;
	}

	/**
	 * Get animations data
	 *
	 * @since  1.0.0
	 *
	 * @return string
	 */
	protected function animations_css() {

		$static_css = '';

		$static_css .= ':root{--dimas-transition-duration:' . get_theme_mod( 'transition_duration_numer' ) . 'ms;}';

		return $static_css;
	}

	/**
	 * Get header data
	 *
	 * @since  1.0.0
	 *
	 * @return string
	 */
	protected function header_css() {

		if ( false == get_theme_mod( 'header_bg_custom' ) ) {
			$header_bg = get_theme_mod( 'header_bg_color_default' );
		} else {
			$header_bg = get_theme_mod( 'header_bg_color' );
		}

		$static_css = '';

		$static_css .= '.dimas-navbar-background{background-color:' . $header_bg . ';}';
		$static_css .= '.dimas-navbar--fixed{background-color:' . $header_bg . '66;}';

		if ( 'image' == get_theme_mod( 'logo_type' ) ) {
			$width  = get_theme_mod( 'logo_dimension' )['max-width'];
			$height = get_theme_mod( 'logo_dimension' )['max-height'];
			if ( '' != $width ) {
				$static_css .= '.dimas-navbar-logo img{max-width:' . $width . ';}';
			}
			if ( '' != $height ) {
				$static_css .= '.dimas-navbar-logo img{max-height:' . $height . ';}';
			}
		}

		return $static_css;
	}

	/**
	 * Get footer data
	 *
	 * @since  1.0.0
	 *
	 * @return string
	 */
	protected function footer_css() {

		if ( false == get_theme_mod( 'footer_bg_custom' ) ) {
			$footer_bg = get_theme_mod( 'footer_bg_color_default' );
		} else {
			$footer_bg = get_theme_mod( 'footer_bg_color' );
		}

		$static_css = '';

		$static_css .= '.dimas-footer--fixed{background-color:' . $footer_bg . ';}';

		return $static_css;
	}

}
