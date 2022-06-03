<?php
/**
 * Show the appropriate content for the Image post format.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Dimas
 * @since Dimas 1.0
 */

// If there is no featured-image, print the first image block found.
if (
	! dimas_can_show_post_thumbnail() &&
	has_block( 'core/image', get_the_content() )
) {

	dimas_print_first_instance_of_block( 'core/image', get_the_content() );
}

the_excerpt();
