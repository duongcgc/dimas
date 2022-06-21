<?php
/**
 *
 *
 * Loads content of single page.
 *
 * @link https://www.gcosoftware.vn/
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
		'content-main',
		array(
			'tag'  => 'main',
			'attr' => array(
				'id'   => 'content',
				'role' => 'main',
			),
		)
	);

	HTML::instance()->open(
		'page-header',
		array(
			'tag'  => 'header',
			'attr' => array(
				'class' => 'page-header',
			),
		)
	);

	the_title( '<h1 class="entry-title">', '</h1>' );

	HTML::instance()->close( 'page-header' );

	HTML::instance()->open(
		'page-content',
		array(
			'attr' => array(
				'class' => 'page-content',
			),
		)
	);

	the_content();

	HTML::instance()->open(
		'post-tags',
		array(
			'attr' => array(
				'class' => 'post-tags',
			),
		)
	);

	the_tags( '<span class="tag-links">' . __( 'Tagged ', 'dimas' ), null, '</span>' );

	HTML::instance()->close( 'post-tags' );

	HTML::instance()->close( 'page-content' );

	comments_template();

	HTML::instance()->close( 'content-main' );

endwhile;
