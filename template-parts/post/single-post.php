<?php
/**
 *
 *
 * Loads page single post.
 *
 * @link https://www.gcosoftware.vn/
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

use \Dimas\Framework\Template_Tag;

while ( have_posts() ) :

	the_post();

	$array_wrapper_tag = array(
		'dimas_main'                 => array(
			'tag'  => 'main',
			'attr' => array(
				'class' => 'dimas-main',
			),
		),
		'dimas_blog'                 => array(
			'attr' => array(
				'class' => 'dimas-blog',
			),
		),
		'dimas_blog_post'            => array(
			'attr' => array(
				'class' => 'dimas-post',
			),
		),
		'dimas_post__vertical_align' => array(
			'attr' => array(
				'class' => 'dimas-post__vertical-align',
			),
		),
	);

	Template_Tag::dimas_html_loop_open( $array_wrapper_tag );

	the_post_thumbnail(
		'full',
		array(
			'class' => 'dimas-post__thumbnail',
			'attr'  => 'Post thumbnail',
		)
	);

	get_template_part( 'template-parts/content/content', 'single-post' );

	get_template_part( 'template-parts/content/content', 'related-post' );

	comments_template();

	Template_Tag::dimas_html_loop_close( $array_wrapper_tag );

endwhile;
