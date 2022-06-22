<?php
/**
 *
 *
 * Loads section home page.
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

if ( ! isset( $args ) ) {
	return;
} else {
	$data_anchor    = $args['data_anchor'];
	$url_background = $args['url_background'];
	$section_name   = $args['section_name'];
}

$array_wrapper_tag = array(
	'dimas_section__vertical_align' . $section_name => array(
		'attr' => array(
			'class' => 'dimas-section__vertical-align',
		),
	),
	'section__content' . $section_name              => array(
		'attr' => array(
			'class' => 'dimas-section__content dimas-section__content--' . $section_name,
		),
	),
	'section__content_container' . $section_name    => array(
		'attr' => array(
			'class' => 'container',
		),
	),
	'section__content_row' . $section_name          => array(
		'attr' => array(
			'class' => 'row',
		),
	),
);


HTML::instance()->open(
	'dimas_section' . $section_name,
	array(
		'tag'  => 'section',
		'attr' => array(
			'data-anchor' => $data_anchor,
			'style'       => 'background-image: url(' . $url_background . ')',
			'class'       => 'dimas-section pp-scrollable',
		),
	)
);

Template_Tag::dimas_html_loop_open( $array_wrapper_tag );

get_template_part( 'template-pages/home-part/home-section', 'content-' . $section_name );

Template_Tag::dimas_html_loop_close( $array_wrapper_tag );

HTML::instance()->close( 'dimas_section' . $section_name );
