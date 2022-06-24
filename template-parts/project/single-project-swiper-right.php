<?php
/**
 *
 * Loads content of single project swiper right.
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

use \Dimas\Framework\Template_Tag;


$array_wrapper_tag = array(
	'right_slider'   =>
	array(
		'attr' => array(
			'id'    => 'right-slider',
			'class' => 'col-xl-4 position-relative dimas-section',
		),
	),
	'scroll_wrap'    =>
	array(
		'attr' => array(
			'class' => 'scroll-wrap',
		),
	),
	'swiper'         =>
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

	get_template_part( 'template-parts/project/single-project-swiper-right/swiper-right', $item_name );

}

Template_Tag::dimas_html_loop_close( $array_wrapper_tag );
