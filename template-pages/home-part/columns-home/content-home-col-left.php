<?php
/**
 *
 * Loads section home col left.
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

use \Dimas\HTML;
use \Dimas\Framework\Template_Tag;

$array_wapper_tag = array(
	'section_home_col_1'       => array(
		'attr' => array(
			'class' => 'col-sm-6 col-md-9 col-lg-8',
		),
	),
	'section_home_col_1_title' => array(
		'attr' => array(
			'class' => 'dimas-title',
		),
	),
);

if ( null != $args ) {
	$data         = $args;
	$subtitle     = $data['col_left']['sub_title'];
	$title_line_1 = '<span class="has-color-white">' . $data['col_left']['title_line_1'] . '</span><br>';
	$title_line_2 = '<span class="has-color-main">' . $data['col_left']['title_line_2'] . '</span>';
} else {
	$subtitle     = 'Hello!';
	$title_line_1 = '<span class="has-color-white">I’m Dimas.</span><br>';
	$title_line_2 = '<span class="has-color-main">UX/UI design</span>';
}

Template_Tag::dimas_html_loop_open( $array_wapper_tag );

HTML::instance()->self_close_tag(
	'section_home_col_1_title_span',
	array(
		'tag'  => 'span',
		'attr' => array(
			'class' => 'has-color-white label-header',
		),
	),
	$subtitle,
);

HTML::instance()->self_close_tag(
	'section_home_col_1_title_h1',
	array(
		'tag'  => 'h1',
		'attr' => array(
			'class' => 'pt-6 mb-0 label-banner',
		),
	),
	$title_line_1 . $title_line_2,
);

Template_Tag::dimas_html_loop_close( $array_wapper_tag );
