<?php
/**
 *
 *
 * Loads content of single project swiper left item 3.
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

$section_title       = 'Solution';
$section_description = 'Donec a iaculis odio. Mauris tincidunt, ligula ut congue tempor, augue nibh condimentum ipsum, ullamcorper congue felis nibh egestas risus. Aliquam sed pretium dui, in malesuada velit. Pellentesque at enim placerat risus.';
$img_quote           = array(
	'id'   => 172,
	'size' => 'full',
	'attr' => array(
		'class' => 'quote__img me-8 me-xl-5 me-xxl-8',
		'alt'   => 'Icon quote',
	),
);
$text_quote          = 'In ullamcorper ac erat ac egestas. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.';

HTML::instance()->open(
	'swiper-slide-3',
	array(
		'attr' => array(
			'class' => 'swiper-slide',
		),
	)
);

HTML::instance()->open(
	'dimas-section__name',
	array(
		'tag'  => 'h2',
		'attr' => array(
			'class' => 'dimas-section__name label-banner mb-5 has-color-white',
		),
	)
);

echo esc_html( $section_title );

HTML::instance()->close( 'dimas-section__name' );

HTML::instance()->open(
	'dimas-section__text',
	array(
		'tag'  => 'p',
		'attr' => array(
			'class' => 'dimas-section__text has-color-subtitle mb-5 mb-md-8',
		),
	)
);

echo esc_html( $section_description );

HTML::instance()->close( 'dimas-section__text' );

HTML::instance()->open(
	'quote',
	array(
		'attr' => array(
			'class' => 'quote quote-wrap d-flex align-items-start',
		),
	)
);

echo wp_get_attachment_image( $img_quote['id'], $img_quote['size'], false, $img_quote['attr'] );

HTML::instance()->open(
	'quote__content',
	array(
		'attr' => array(
			'class' => 'quote__content',
		),
	)
);

HTML::instance()->open(
	'quote__text',
	array(
		'tag'  => 'p',
		'attr' => array(
			'class' => 'quote__text has-color-white mb-0',
		),
	)
);

echo esc_html( $text_quote );

HTML::instance()->close( 'quote__text' );

HTML::instance()->close( 'quote__content' );

HTML::instance()->close( 'quote' );

HTML::instance()->close( 'swiper-slide-3' );
