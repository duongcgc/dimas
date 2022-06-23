<?php
/**
 *
 *
 * Loads related post.
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
use \Dimas\HTML;

$args_related      = array(
	'posts_per_page'      => 3,
	'ignore_sticky_posts' => true,
	'category__in'        => wp_get_post_categories(),
	'exclude'             => array( get_the_id() ),
);
$related_post      = new WP_Query( $args_related );
$array_wrapper_tag = array(
	'dimas_post__related_posts' => array(
		'attr' => array(
			'class' => 'dimas-post__related-posts has-bg-black py-8 py-md-96',
		),
	),
	'dimas_container'           => array(
		'attr' => array(
			'class' => 'container',
		),
	),
	'dimas_post_related_wrap'   => array(
		'attr' => array(
			'class' => 'dimas-post-related-wrap d-flex flex-wrap justify-content-center',
		),
	),
);
$array_title_tag   = array(
	'section_title' => array(
		'attr' => array(
			'class' => 'section-title col-md-8 mx-auto mb-5 mb-md-8',
		),
	),
	'label_banner'  => array(
		'tag'  => 'h2',
		'attr' => array(
			'class' => 'label-banner mb-0 has-color-white',
		),
	),
);

if ( $related_post->have_posts() ) {

	Template_Tag::dimas_html_loop_open( $array_wrapper_tag );

	Template_Tag::dimas_html_loop_open( $array_title_tag );

	echo 'Related posts';

	Template_Tag::dimas_html_loop_close( $array_title_tag );

	HTML::instance()->open(
		'dimas_grid_wrap',
		array(
			'attr' => array(
				'class' => 'dimas-grid-wrap d-grid',
			),
		)
	);

	while ( $related_post->have_posts() ) {

		$related_post->the_post();

		get_template_part( 'template-parts/content/content' );

	}

	HTML::instance()->close( 'dimas_grid_wrap' );

	Template_Tag::dimas_html_loop_close( $array_wrapper_tag );

}

wp_reset_postdata();
wp_reset_query();
