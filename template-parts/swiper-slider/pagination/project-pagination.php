<?php
/**
 *
 *
 * Loads content of single project swiper left pagination.
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

HTML::instance()->open(
	'swiper-pagination',
	array(
		'attr' => array(
			'class' => 'swiper-pagination',
		),
	)
);

HTML::instance()->close( 'swiper-pagination' );

HTML::instance()->open(
	'swiper-button-prev',
	array(
		'attr' => array(
			'class' => 'swiper-button-prev',
		),
	)
);

Template_Tag::instance()->dimas_icon(
	null,
	'ui',
	'dimas_chevron_left',
);

HTML::instance()->close( 'swiper-button-prev' );

HTML::instance()->open(
	'swiper-button-next',
	array(
		'attr' => array(
			'class' => 'swiper-button-next',
		),
	)
);

Template_Tag::instance()->dimas_icon(
	null,
	'ui',
	'dimas_chevron_right',
);

HTML::instance()->close( 'swiper-button-next' );
