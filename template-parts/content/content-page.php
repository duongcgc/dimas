<?php
/**
 *
 *
 * Loads Content single page.
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

$array_wrapper_tag = array(
	'dimas_section'                 => array(
		'tag'  => 'section',
		'attr' => array(
			'class' => 'dimas-section',
		),
	),
	'dimas_section__vertical_align' => array(
		'attr' => array(
			'class' => 'dimas-section__vertical-align',
		),
	),
	'section__content '             => array(
		'attr' => array(
			'class' => 'dimas-section__content',
		),
	),
	'section__content_container'    => array(
		'attr' => array(
			'class' => 'container',
		),
	),
	'section__content_row'          => array(
		'attr' => array(
			'class' => 'row',
		),
	),
);

Template_Tag::dimas_html_loop_open( $array_wrapper_tag );

get_template_part( 'template-parts/title' );

HTML::instance()->open(
	'page_content',
	array(
		'attr' => array(
			'class' => 'page-content',
		),
	)
);

the_content();

Template_Tag::dimas_post_tags();

HTML::instance()->close( 'page_content' );

Template_Tag::dimas_html_loop_close( $array_wrapper_tag );
