<?php
/**
 *
 * Loads section testimonials col left.
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

use \Dimas\HTML;

HTML::instance()->open(
	'dimas_testimonials_col_1',
	array(
		'attr' => array(
			'class' => 'col-lg-6 col-xxl-5 pb-32 pb-lg-0',
		),
	)
);

HTML::instance()->open(
	'dimas_testimonials_col_1_title',
	array(
		'attr' => array(
			'class' => 'dimas-title',
		),
	)
);

HTML::instance()->self_close_tag(
	'dimas_testimonials_col_1_title_h2',
	array(
		'tag'  => 'h2',
		'attr' => array(
			'class' => 'pb-4 mb-5 mb-lg-6 label-banner has-after position-relative has-color-white',
		),
	),
	'Testimonials',
);

HTML::instance()->close( 'dimas_testimonials_col_1_title' );

HTML::instance()->self_close_tag(
	'dimas_testimonials_col_1_subtitle',
	array(
		'tag'  => 'p',
		'attr' => array(
			'class' => 'dimas-subtitle mb-0 has-color-subtitle pb-5 d-none d-md-block',
		),
	),
	"There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, which don't look even slightly believable.",
);

echo wp_get_attachment_image(
	188,
	'full',
	false,
	array(
		'class' => 'dimas-clients-number',
		'alt'   => 'Clients number',
	)
);

HTML::instance()->close( 'dimas_testimonials_col_1' );
