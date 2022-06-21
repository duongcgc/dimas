<?php
/**
 *
 *
 * Loads content of single project swiper left.
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
	'left-slider',
	array(
		'attr' => array(
			'id'    => 'left-slider',
			'class' => 'col-xl-8 overflow-hidden position-relative',
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
	'swiper-wrapper',
	array(
		'attr' => array(
			'class' => 'swiper-wrapper',
		),
	)
);

get_template_part( 'template-parts/project/single-project-swiper-left/swiper-left-item-1' );

get_template_part( 'template-parts/project/single-project-swiper-left/swiper-left-item-2' );

get_template_part( 'template-parts/project/single-project-swiper-left/swiper-left-item-3' );

get_template_part( 'template-parts/project/single-project-swiper-left/swiper-left-item-4' );

HTML::instance()->close( 'swiper-wrapper' );

get_template_part( 'template-parts/swiper-slider/pagination/project-pagination' );

HTML::instance()->close( 'swiper' );

HTML::instance()->close( 'left-slider' );
