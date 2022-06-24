<?php
/**
 *
 * Loads section home col right.
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

use \Dimas\Framework\Template_Tag;
use \Dimas\HTML;

$array_wapper_tag = array(
	'section_home_col_2'      =>
	array(
		'attr' => array(
			'class' => 'd-none col-sm-6 col-md-3 col-lg-4 d-sm-flex position-relative',
		),
	),
	'section_home_col_2_wrap' =>
	array(
		'attr' => array(
			'class' => 'dimas-experience d-flex justify-content-center align-items-center',
		),
	),
);

$array_circle_text = array(
	'data-text-circular' => 'Y E A R S  ★ ★ ★  E X P E R I E N C E  ★ ★ ★  ',
	'data-radius-circle' => '100px',
	'data-starting-deg'  => '0',
);

Template_Tag::dimas_html_loop_open( $array_wapper_tag );

HTML::instance()->self_close_tag(
	'circTxt',
	array(
		'attr' => array(
			'class'              => 'circTxt',
			'data-text-circular' => $array_circle_text['data-text-circular'],
			'data-radius-circle' => $array_circle_text['data-radius-circle'],
			'data-starting-deg'  => $array_circle_text['data-starting-deg'],
		),
	),
	'',
);

HTML::instance()->self_close_tag(
	'dimas_experience__main_text',
	array(
		'tags' => 'h2',
		'attr' => array(
			'class' => 'dimas-experience__main-text',
		),
	),
	'12',
);

Template_Tag::dimas_html_loop_close( $array_wapper_tag );
