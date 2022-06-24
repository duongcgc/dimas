<?php
/**
 *
 * The site's entry point.
 *
 * Loads the relevant template part.
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

get_header();

$type_current = get_post_type();

if ( is_singular() ) {
	get_template_part( 'template-parts/' . $type_current . '/single-' . $type_current );
} elseif ( is_archive() ) {
	get_template_part( 'template-parts/' . $type_current . '/archive-' . $type_current );
} elseif ( is_search() ) {
	get_template_part( 'template-parts/search/search' );
} else {
	get_template_part( '404' );
}

get_footer();
