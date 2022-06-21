<?php
/**
 *
 *
 * Loads content of single project.
 *
 * @link https://www.gcosoftware.vn/
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

use \Dimas\Framework\Template_Tag;

while ( have_posts() ) :

	the_post();

	$array_wrapper_tag = array(
		'dimas-main'                    => array(
			'tag'  => 'main',
			'attr' => array(
				'class' => 'dimas-main',
			),
		),
		'dimas-projects'                => array(
			'attr' => array(
				'class' => 'dimas-projects',
			),
		),
		'dimas-project'                 => array(
			'attr' => array(
				'class' => 'dimas-project',
			),
		),
		'dimas-project__vertical-align' => array(
			'attr' => array(
				'class' => 'dimas-project__vertical-align',
			),
		),
	);

	Template_Tag::html_loop_open( $array_wrapper_tag );

	get_template_part( 'template-parts/project/single-project-swiper-left' );

	get_template_part( 'template-parts/project/single-project-swiper-right' );

	Template_Tag::html_loop_close( $array_wrapper_tag );

endwhile;
