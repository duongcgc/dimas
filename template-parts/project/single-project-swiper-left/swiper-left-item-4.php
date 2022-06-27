<?php
/**
 *
 * Loads content of single project swiper left item 4.
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

use \Dimas\HTML;
use \Dimas\Framework\Template_Tag;

$id_poster_image  = 167;
$poster_size      = 'full';
$url_poster_image = wp_get_attachment_image_url( $id_poster_image, $poster_size );
$id_video         = 168;
$url_video        = wp_get_attachment_url( $id_video );

HTML::instance()->open(
	'swiper_slide_4',
	array(
		'attr' => array(
			'class' => 'swiper-slide',
		),
	)
);

HTML::instance()->self_close_tag(
	'slider_video',
	array(
		'tag'  => 'video',
		'attr' => array(
			'class'  => 'slider-video',
			'poster' => $url_poster_image,
			'loop'   => true,
			'src'    => $url_video,
		),
	),
	'',
);

HTML::instance()->open(
	'dimas_btn_play_video',
	array(
		'attr' => array(
			'class' => 'dimas-btn play-video',
		),
	)
);

Template_Tag::dimas_icon(
	null,
	'ui',
	'dimas_play',
);

HTML::instance()->close( 'dimas_btn_play_video' );

HTML::instance()->close( 'swiper_slide_4' );