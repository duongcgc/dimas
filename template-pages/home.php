<?php
/**
 *
 * Display home page.
 *
 * @link https://www.gcosoftware.vn/
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
use \Dimas\HTML;

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
		'url_background' => get_template_directory_uri() . '/assets/images/home/bg-home.png',
		'section_name'   => 'home',
	),
	array(
		'data_anchor'    => 'About',
		'url_background' => '',
		'section_name'   => 'about',
	),
	array(
		'data_anchor'    => 'Projects',
		'url_background' => get_template_directory_uri() . '/assets/images/projects/bg-projects.png',
		'section_name'   => 'projects',
	),
	array(
		'data_anchor'    => 'Services',
		'url_background' => '',
		'section_name'   => 'services',
	),
	array(
		'data_anchor'    => 'Testimonials',
		'url_background' => get_template_directory_uri() . '/assets/images/testimonials/bg-testimonials.png',
		'section_name'   => 'testimonials',
	),
	array(
		'data_anchor'    => 'Blog',
		'url_background' => '',
		'section_name'   => 'blog',
	),
	array(
		'data_anchor'    => 'Contact',
		'url_background' => get_template_directory_uri() . '/assets/images/contact/bg-contact.png',
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
