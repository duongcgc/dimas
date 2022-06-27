<?php
/**
 *
 * Loads content of single project swiper left item 2.
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

use \Dimas\HTML;

$att_id   = 165;
$att_size = 'full';
$attr_img = array(
	'class' => 'slider-img',
	'alt'   => 'Slider project image',
);

HTML::instance()->self_close_tag(
	'swiper_slide_2',
	array(
		'attr' => array(
			'class' => 'swiper-slide',
		),
	),
	wp_get_attachment_image( $att_id, $att_size, false, $attr_img ),
);