<?php
/**
 *
 *
 * Loads section home col left.
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
use \Dimas\Framework\Template_Tag;

$array_wapper_tag = array(
	'section_home_col_1' => array(
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

Template_Tag::dimas_html_loop_open( $array_wapper_tag );

HTML::instance()->self_close_tag(
	'section_home_col_1_title_span',
	array(
		'tag'  => 'span',
		'attr' => array(
			'class' => 'has-color-white label-header',
		),
	),
	'Hello!'
);

HTML::instance()->self_close_tag(
	'section_home_col_1_title_h1',
	array(
		'tag'  => 'h1',
		'attr' => array(
			'class' => 'pt-6 mb-0 label-banner',
		),
	),
	'<span class="has-color-white">I’m Dimas.</span><br><span class="has-color-main">UX/UI design</span>'
);

Template_Tag::dimas_html_loop_close( $array_wapper_tag );
