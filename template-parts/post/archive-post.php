<?php
/**
 *
 *
 * Loads page archive post.
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

$array_wrapper_tag = array(
	'dimas_main'                         => array(
		'tag'  => 'main',
		'attr' => array(
			'class' => 'dimas-main',
		),
	),
	'dimas_archive'                      => array(
		'attr' => array(
			'class' => 'dimas-archive',
		),
	),
	'dimas_blog_archive'                 => array(
		'attr' => array(
			'class' => 'dimas-blog-archive',
		),
	),
	'dimas_blog_archive__vertical_align' => array(
		'attr' => array(
			'class' => 'dimas-blog-archive__vertical-align container',
		),
	),
);

Template_Tag::dimas_html_loop_open( $array_wrapper_tag );

get_template_part( 'template-parts/content/content', 'archive-post' );

Template_Tag::dimas_html_loop_close( $array_wrapper_tag );
