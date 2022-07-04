<?php
/**
 *
 * Loads content section blog of home page.
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

if ( isset( $args ) ) {
	$data = $args;
} else {
	$data = null;
}

get_template_part( 'template-pages/home-part/columns-about/content-about', 'col-left', $data );

get_template_part( 'template-pages/home-part/columns-about/content-about', 'col-right', $data );
