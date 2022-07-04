<?php
/**
 *
 * Loads section about col left.
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

use \Dimas\HTML;

if ( null != $args ) {
	$data     = $args;
	$title_section    = $data['col_left']['title'];
	$icon_url     = ( $data['col_left']['icon_title'] ) ? $data['col_left']['icon_title']['url'] : DIMAS_ASSETS_URI . '/images/about/icon-gamepad.png';
	$subtitle = $data['col_left']['sub_title'];
} else {
	$title_section    = 'Work hard,<br>play hard';
	$subtitle = "There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, which don't look even slightly believable.";
}

HTML::instance()->open(
	'section_about_col_1',
	array(
		'attr' => array(
			'class' => 'col-lg-5 pb-8 pb-lg-0',
		),
	)
);

HTML::instance()->open(
	'section_about_col_1_title',
	array(
		'attr' => array(
			'class' => 'dimas-title',
		),
	)
);

HTML::instance()->open(
	'section_about_col_1_title_h2',
	array(
		'tag'  => 'h2',
		'attr' => array(
			'class' => 'pb-9 pb-md-4 mb-6 label-banner has-after position-relative',
		),
	),
);

echo wp_kses_post( $title_section );

HTML::instance()->open(
	'section_about_col_1_title_h2_icon',
	array(
		'tag'  => 'img',
		'attr' => array(
			'class' => 'dimas-gamepad',
			'alt'   => 'Gamepad',
			'src'   => $icon_url,
		),
	),
);

HTML::instance()->close( 'section_about_col_1_title_h2' );

HTML::instance()->close( 'section_about_col_1_title' );

HTML::instance()->self_close_tag(
	'section_about_col_1_subtitle',
	array(
		'tag'  => 'p',
		'attr' => array(
			'class' => 'dimas-subtitle mb-0 has-color-subtitle',
		),
	),
	$subtitle,
);

HTML::instance()->close( 'section_about_col_1_subtitle' );

HTML::instance()->close( 'section_about_col_1' );
