<?php
/**
 *
 * Display home page.
 *
 * Template Name: Home Page
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

use \Dimas\Framework\Template_Tag;

get_header();

$array_wrapper_tag = array(
	'dimas_main_page'       => array(
		'tag'  => 'main',
		'attr' => array(
			'class' => 'dimas-main',
		),
	),
	'dimas_fullpage_slider' => array(
		'attr' => array(
			'class' => 'dimas-fullpage-slider',
		),
	),
);

$arr_args = array(
	array(
		'data_anchor'    => 'Home',
		'url_background' => wp_get_attachment_image_url( 175, 'full' ),
		'section_name'   => 'home',
	),
	array(
		'data_anchor'    => 'About',
		'url_background' => '',
		'section_name'   => 'about',
	),
	array(
		'data_anchor'    => 'Projects',
		'url_background' => wp_get_attachment_image_url( 189, 'full' ),
		'section_name'   => 'projects',
	),
	array(
		'data_anchor'    => 'Services',
		'url_background' => '',
		'section_name'   => 'services',
	),
	array(
		'data_anchor'    => 'Testimonials',
		'url_background' => wp_get_attachment_image_url( 187, 'full' ),
		'section_name'   => 'testimonials',
	),
	array(
		'data_anchor'    => 'Blog',
		'url_background' => '',
		'section_name'   => 'blog',
	),
	array(
		'data_anchor'    => 'Contact',
		'url_background' => wp_get_attachment_image_url( 178, 'full' ),
		'section_name'   => 'contact',
	),
);


Template_Tag::dimas_html_loop_open( $array_wrapper_tag );


foreach ( $arr_args as $key => $args ) {

	get_template_part( 'template-pages/home-part/home', 'section', $args );

}

get_template_part( 'template-pages/home-part/home', 'navigation' );

Template_Tag::dimas_html_loop_close( $array_wrapper_tag );

get_footer();
