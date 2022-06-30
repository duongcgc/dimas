<?php
/**
 *
 * Loads Single page.
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

use \Dimas\HTML;

while ( have_posts() ) :

	the_post();

	HTML::instance()->open(
		'content_main',
		array(
			'tag'  => 'main',
			'attr' => array(
				'id'   => 'content',
				'role' => 'main',
			),
		)
	);

	get_template_part( 'template-parts/content/content', 'page' );

	if ( get_theme_mod( 'page_comments_show' ) ) {

		comments_template();
	}

	HTML::instance()->close( 'content_main' );

endwhile;
