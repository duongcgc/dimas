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

if ( function_exists( 'get_fields' ) ) {
	$data = get_fields();
}

$arr_args = array(
	array(
		'data_anchor'    => 'Home',
		'url_background' => ( $data['section_home']['section_bg_img'] ) ? $data['section_home']['section_bg_img']['url'] : DIMAS_ASSETS_URI . '/images/home/bg-home.png',
		'section_name'   => 'home',
		'data'           => ( $data['section_home'] ) ? $data['section_home'] : array(),
	),
	array(
		'data_anchor'    => 'About',
		'url_background' => ( $data['section_about']['section_bg_img'] ) ? $data['section_about']['section_bg_img']['url'] : '',
		'section_name'   => 'about',
		'data'           => ( $data['section_about'] ) ? $data['section_about'] : array(),
	),
	array(
		'data_anchor'    => 'Projects',
		'url_background' => ( $data['section_projects']['section_bg_img'] ) ? $data['section_projects']['section_bg_img']['url'] : DIMAS_ASSETS_URI . '/images/projects/bg-projects.png',
		'section_name'   => 'projects',
		'data'           => ( $data['section_projects'] ) ? $data['section_projects'] : array(),
	),
	array(
		'data_anchor'    => 'Services',
		'url_background' => '',
		'section_name'   => 'services',
		'data'           => ( $data['section_services'] ) ? $data['section_services'] : array(),
	),
	array(
		'data_anchor'    => 'Testimonials',
		'url_background' => wp_get_attachment_image_url( 187, 'full' ),
		'section_name'   => 'testimonials',
		'data'           => ( $data['section_testimonials'] ) ? $data['section_testimonials'] : array(),
	),
	array(
		'data_anchor'    => 'Blog',
		'url_background' => '',
		'section_name'   => 'blog',
		'data'           => ( $data['section_blog'] ) ? $data['section_blog'] : array(),
	),
	array(
		'data_anchor'    => 'Contact',
		'url_background' => wp_get_attachment_image_url( 178, 'full' ),
		'section_name'   => 'contact',
		'data'           => ( $data['section_contact'] ) ? $data['section_contact'] : array(),
	),
);


Template_Tag::dimas_html_loop_open( $array_wrapper_tag );


foreach ( $arr_args as $key => $args ) {

	get_template_part( 'template-pages/home-part/home', 'section', $args );

}

get_template_part( 'template-pages/home-part/home', 'navigation' );

Template_Tag::dimas_html_loop_close( $array_wrapper_tag );

get_footer();
