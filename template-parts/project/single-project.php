<?php
/**
 *
 * Loads page single project.
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
		'dimas_main'                    => array(
			'tag'  => 'main',
			'attr' => array(
				'class' => 'dimas-main',
			),
		),
		'dimas_projects'                => array(
			'attr' => array(
				'class' => 'dimas-projects',
			),
		),
		'dimas_project'                 => array(
			'attr' => array(
				'class' => 'dimas-project',
			),
		),
		'dimas+project__vertical_align' => array(
			'attr' => array(
				'class' => 'dimas-project__vertical-align',
			),
		),
	);

	Template_Tag::dimas_html_loop_open( $array_wrapper_tag );

	get_template_part( 'template-parts/content/content', 'single-project' );

	Template_Tag::dimas_html_loop_close( $array_wrapper_tag );

endwhile;
