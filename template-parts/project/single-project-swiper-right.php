<?php
/**
 *
 *
 * Loads content of single project swiper right.
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
	'right_slider',
	array(
		'attr' => array(
			'id'    => 'right-slider',
			'class' => 'col-xl-4 position-relative',
		),
	)
);

HTML::instance()->open(
	'scroll_wrap',
	array(
		'attr' => array(
			'class' => 'scroll-wrap',
		),
	)
);

HTML::instance()->open(
	'swiper',
	array(
		'attr' => array(
			'class' => 'swiper',
		),
	)
);

HTML::instance()->open(
	'swiper_wrapper',
	array(
		'attr' => array(
			'class' => 'swiper-wrapper',
		),
	)
);

get_template_part( 'template-parts/project/single-project-swiper-right/swiper-right', 'item-1' );

get_template_part( 'template-parts/project/single-project-swiper-right/swiper-right', 'item-2' );

get_template_part( 'template-parts/project/single-project-swiper-right/swiper-right', 'item-3' );

get_template_part( 'template-parts/project/single-project-swiper-right/swiper-right', 'item-4' );

HTML::instance()->close( 'swiper_wrapper' );

HTML::instance()->close( 'swiper' );

HTML::instance()->close( 'scroll_wrap' );

HTML::instance()->close( 'right_slider' );
