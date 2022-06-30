<?php
/**
 *
 * Loads content single post.
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

use \Dimas\Framework\Template_Tag;
use \Dimas\HTML;

$array_wrapper_tag = array(
	'dimas_post__vertical_align_container' => array(
		'attr' => array(
			'class' => 'container py-8 pt-md-96 pt-md-96 pb-md-9',
		),
	),
	'dimas_post_content_wrap'              => array(
		'attr' => array(
			'class' => 'dimas-post-content row',
		),
	),
);

Template_Tag::dimas_html_loop_open( $array_wrapper_tag );

if ( get_theme_mod( 'post_single_social_share_show' ) ) {

	get_template_part( 'template-parts/social/social', 'share' );

}

HTML::instance()->open(
	'dimas_post_info',
	array(
		'attr' => array(
			'class' => 'dimas-post-info col-md-8 mx-auto',
		),
	)
);

if ( get_theme_mod( 'post_single_date_show' ) ) {

	Template_Tag::dimas_posted_on();

}

if ( get_theme_mod( 'post_single_title_show' ) ) {

	get_template_part( 'template-parts/title' );

}

HTML::instance()->close( 'dimas_post_info' );

HTML::instance()->open(
	'dimas_post_content__wrap',
	array(
		'attr' => array(
			'class' => 'dimas-post-content__wrap',
		),
	)
);

the_content();

HTML::instance()->close( 'dimas_post_content__wrap' );

Template_Tag::dimas_post_tags();

Template_Tag::dimas_html_loop_close( $array_wrapper_tag );
