<?php
/**
 *
 * Loads content of single project swiper left item 1.
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

use \Dimas\HTML;

$att_id   = 149;
$att_size = 'full';
$attr_img = array(
	'class' => 'slider-img',
	'alt'   => 'Slider project image',
);

HTML::instance()->self_close_tag(
	'swiper_slide_1',
	array(
		'attr' => array(
			'class' => 'swiper-slide',
		),
	),
	wp_get_attachment_image( $att_id, $att_size, false, $attr_img ),
);
