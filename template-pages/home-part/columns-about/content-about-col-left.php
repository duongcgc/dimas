<?php
/**
 *
 *
 * Loads section about col left.
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
	)
);

echo '<span class="has-color-white">Work hard,</span><br><span class="has-color-white">play hard</span>';

echo wp_get_attachment_image(
	180,
	'medium',
	false,
	array(
		'class' => 'dimas-gamepad',
		'alt'   => 'Gamepad',
	)
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
	"There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, which don't look even slightly believable."
);

HTML::instance()->close( 'section_about_col_1_subtitle' );

HTML::instance()->close( 'section_about_col_1' );
