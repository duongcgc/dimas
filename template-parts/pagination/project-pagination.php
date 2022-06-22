<?php
/**
 *
 *
 * Loads single project swiper left pagination.
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
	'swiper_pagination',
	array(
		'attr' => array(
			'class' => 'swiper-pagination',
		),
	)
);

HTML::instance()->close( 'swiper_pagination' );

HTML::instance()->open(
	'swiper_button_prev',
	array(
		'attr' => array(
			'class' => 'swiper-button-prev',
		),
	)
);

Template_Tag::dimas_icon(
	null,
	'ui',
	'dimas_chevron_left',
);

HTML::instance()->close( 'swiper_button_prev' );

HTML::instance()->open(
	'swiper_button_next',
	array(
		'attr' => array(
			'class' => 'swiper-button-next',
		),
	)
);

Template_Tag::dimas_icon(
	null,
	'ui',
	'dimas_chevron_right',
);

HTML::instance()->close( 'swiper_button_next' );
