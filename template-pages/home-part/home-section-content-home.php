<?php
/**
 *
 * Loads content section home of home page.
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

get_template_part( 'template-pages/home-part/columns-home/content-home', 'col-left', $data );

get_template_part( 'template-pages/home-part/columns-home/content-home', 'col-right', $data );
