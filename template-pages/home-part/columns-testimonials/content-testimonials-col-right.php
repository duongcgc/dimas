<?php
/**
 *
 *
 * Loads section home col right.
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

$array_testimonial = array(
	array(
		'data-customer-img-src' => wp_get_attachment_image_url( 184, 'full', false ),
		'testimonial-comment'   => "There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, which don't look even slightly believable.",
		'testimonial-name'      => 'John Doe - CEO Fantasy Company',
	),
	array(
		'data-customer-img-src' => wp_get_attachment_image_url( 185, 'full', false ),
		'testimonial-comment'   => "There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, which don't look even slightly believable.",
		'testimonial-name'      => 'John Doe - CEO Fantasy Company',
	),
	array(
		'data-customer-img-src' => wp_get_attachment_image_url( 186, 'full', false ),
		'testimonial-comment'   => "There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, which don't look even slightly believable.",
		'testimonial-name'      => 'John Doe - CEO Fantasy Company',
	),
);

$array_testimonial_wiper_wrap = array(
	'dimas_testimonials_col_2' => array(
		'attr' => array(
			'class' => 'col-lg-5 col-xxl-6 offset-xl-1 position-relative overflow-hidden',
		),
	),
	'dimas_testimonial_slider' => array(
		'attr' => array(
			'class' => 'dimas-testimonial-slider',
		),
	),
);

Template_Tag::dimas_html_loop_open( $array_testimonial_wiper_wrap );

HTML::instance()->open(
	'swiper_wrapper',
	array(
		'attr' => array(
			'class' => 'swiper-wrapper',
		),
	),
	'',
);

foreach ( $array_testimonial as $key => $testimonial ) {

	HTML::instance()->open(
		'swiper_slide',
		array(
			'attr' => array(
				'class'                 => 'swiper-slide testimonial',
				'data-customer-img-src' => $testimonial['data-customer-img-src'],
			),
		)
	);

	HTML::instance()->self_close_tag(
		'testimonial__comment',
		array(
			'tag'  => 'h3',
			'attr' => array(
				'class' => 'testimonial__comment quote has-color-white pb-26 pb-lg-6 mb-0',
			),
		),
		$testimonial['testimonial-comment'],
	);

	HTML::instance()->self_close_tag(
		'testimonial__name',
		array(
			'tag'  => 'p',
			'attr' => array(
				'class' => 'testimonial__name name-author has-color-subtitle pb-5 mb-0',
			),
		),
		$testimonial['testimonial-name'],
	);

	HTML::instance()->close( 'swiper_slide' );

}

HTML::instance()->close( 'swiper_wrapper' );

HTML::instance()->self_close_tag(
	'swiper_pagination',
	array(
		'attr' => array(
			'class' => 'swiper-pagination',
		),
	),
	'',
);

Template_Tag::dimas_html_loop_close( $array_testimonial_wiper_wrap );
