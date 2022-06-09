<?php
/**
 * Media functions and definitions.
 * => Processing media files image, video, audio...
 *
 * @package Dimas
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Media initial
 */
class Dimas_Media {
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
	 * Get Image Size.
	 *
	 * @param string $thumb_size
	 * @return void
	 */
	public static function dimas_get_image_size( $thumb_size ) {
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


	/**
	 * Get all image size.
	 *
	 * @return void
	 */
	public static function dimas_get_all_image_sizes() {
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
}
