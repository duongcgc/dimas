<?php
/**
 *
 *
 * Loads content archive post.
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

get_template_part( 'template-parts/title' );

HTML::instance()->open(
	'dimas_grid_wrap',
	array(
		'attr' => array(
			'class' => 'dimas-posts dimas-grid-wrap grid',
		),
	)
);

if ( have_posts() ) {

	while ( have_posts() ) :

		the_post();

		get_template_part( 'template-parts/content/content' );

	endwhile;

} else {

	HTML::instance()->open(
		'empty_post',
		array(
			'tag'  => 'h3',
			'attr' => array(
				'class' => 'empty_post',
			),
		)
	);

	echo 'Chuyên mục chưa có bài viết, vui lòng quay lại sau.';

	HTML::instance()->close( 'empty_post' );
}

HTML::instance()->close( 'dimas_grid_wrap' );

get_template_part( 'template-parts/pagination/post', 'pagination' );
