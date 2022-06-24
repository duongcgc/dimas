<?php
/**
 *
 * Loads content of single project swiper left.
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

use \Dimas\Framework\Template_Tag;
use \Dimas\HTML;

$array_wrapper_tag = array(
	'left_slider' =>
	array(
		'attr' => array(
			'id'    => 'left-slider',
			'class' => 'col-xl-8 overflow-hidden position-relative dimas-section',
		),
	),
	'swiper' =>
	array(
		'attr' => array(
			'class' => 'swiper',
		),
	),
	'swiper_wrapper' =>
	array(
		'attr' => array(
			'class' => 'swiper-wrapper',
		),
	),
);
$item_swiper_right = array( 'item-1', 'item-2', 'item-3', 'item-4' );

Template_Tag::dimas_html_loop_open( $array_wrapper_tag );

foreach ( $item_swiper_right as $key => $item_name ) {

	get_template_part( 'template-parts/project/single-project-swiper-left/swiper-left', $item_name );

}

HTML::instance()->close( 'swiper_wrapper' );

get_template_part( 'template-parts/pagination/project', 'pagination' );

HTML::instance()->close( 'swiper' );

HTML::instance()->close( 'left_slider' );
