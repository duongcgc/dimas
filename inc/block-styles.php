<?php
/**
 * Block Dimas_Styles
 *
 * @link https://developer.wordpress.org/reference/functions/register_block_style/
 *
 * @package WordPress
 * @subpackage Dimas
 * @since Dimas 1.0
 */

if ( function_exists( 'register_block_style' ) ) {
	/**
	 * Register block styles.
	 *
	 * @since Dimas 1.0
	 *
	 * @return void
	 */
	function dimas_register_block_styles() {
		// Columns: Overlap.
		register_block_style(
			'core/columns',
			array(
				'name'  => 'dimas-columns-overlap',
				'label' => esc_html__( 'Overlap', 'dimas' ),
			)
		);

		// Cover: Borders.
		register_block_style(
			'core/cover',
			array(
				'name'  => 'dimas-border',
				'label' => esc_html__( 'Borders', 'dimas' ),
			)
		);

		// Group: Borders.
		register_block_style(
			'core/group',
			array(
				'name'  => 'dimas-border',
				'label' => esc_html__( 'Borders', 'dimas' ),
			)
		);

		// Image: Borders.
		register_block_style(
			'core/image',
			array(
				'name'  => 'dimas-border',
				'label' => esc_html__( 'Borders', 'dimas' ),
			)
		);

		// Image: Frame.
		register_block_style(
			'core/image',
			array(
				'name'  => 'dimas-image-frame',
				'label' => esc_html__( 'Frame', 'dimas' ),
			)
		);

		// Latest Posts: Dividers.
		register_block_style(
			'core/latest-posts',
			array(
				'name'  => 'dimas-latest-posts-dividers',
				'label' => esc_html__( 'Dividers', 'dimas' ),
			)
		);

		// Latest Posts: Borders.
		register_block_style(
			'core/latest-posts',
			array(
				'name'  => 'dimas-latest-posts-borders',
				'label' => esc_html__( 'Borders', 'dimas' ),
			)
		);

		// Dimas_Media & Text: Borders.
		register_block_style(
			'core/media-text',
			array(
				'name'  => 'dimas-border',
				'label' => esc_html__( 'Borders', 'dimas' ),
			)
		);

		// Separator: Thick.
		register_block_style(
			'core/separator',
			array(
				'name'  => 'dimas-separator-thick',
				'label' => esc_html__( 'Thick', 'dimas' ),
			)
		);

		// Social icons: Dark gray color.
		register_block_style(
			'core/social-links',
			array(
				'name'  => 'dimas-social-icons-color',
				'label' => esc_html__( 'Dark gray', 'dimas' ),
			)
		);
	}
	add_action( 'init', 'dimas_register_block_styles' );
}
