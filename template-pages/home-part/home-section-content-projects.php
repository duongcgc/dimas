<?php
/**
 *
 * Loads content section projects of home page.
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

use \Dimas\Framework\Template_Tag;
use \Dimas\HTML;

// Args for project.
$args_project = array(
	'post_type'           => 'project',
	'post_status'         => 'publish',
	'posts_per_page'      => 6,
	'ignore_sticky_posts' => 1,
);
// Project Featured.
$project_featured = get_posts( $args_project );

$array_wrapper_tag = array(
	'dimas_projects'          =>
	array(
		'attr' => array(
			'class' => 'dimas-projects',
		),
	),
	'dimas_projects_link'     =>
	array(
		'tag'  => 'a',
		'attr' => array(
			'class' => 'dimas-projects__url',
			'href'  => '',
		),
	),
	'dimas_projects_category' =>
	array(
		'attr' => array(
			'class' => 'dimas-projects__category has-color-white',
		),
	),
);

HTML::instance()->open(
	'section_project_col_wrap',
	array(
		'attr' => array(
			'class' => 'col-lg-6',
		),
	)
);

$i = 1;

foreach ( $project_featured as $project ) {

	$featured_id    = $project->ID;
	$project_link   = get_post_permalink( $featured_id );
	$project_title  = get_the_title( $featured_id );
	$project_branch = wp_get_post_terms( $featured_id, 'branch-project', array( 'fields' => 'names' ) )[0];

	$array_wrapper_tag['dimas_projects_link']['attr']['href'] = $project_link;

	if ( 4 == $i ) {
		HTML::instance()->close( 'section_project_col_wrap' );
		HTML::instance()->open(
			'section_project_col_wrap',
			array(
				'attr' => array(
					'class' => 'col-lg-6',
				),
			)
		);
	}

	Template_Tag::dimas_html_loop_open( $array_wrapper_tag );

	HTML::instance()->self_close_tag(
		'dimas_projects_category_number',
		array(
			'tag'  => 'span',
			'attr' => array(
				'class' => 'dimas-projects__number',
			),
		),
		'0' . $i,
	);

	HTML::instance()->self_close_tag(
		'dimas_projects_category_name',
		array(
			'tag'  => 'h2',
			'attr' => array(
				'class' => 'dimas-projects__category-name label-header',
			),
		),
		$project_branch,
	);

	HTML::instance()->close( 'dimas_projects_category' );

	HTML::instance()->self_close_tag(
		'dimas_projects_name',
		array(
			'tag'  => 'h2',
			'attr' => array(
				'class' => 'dimas-projects__projects-name label-banner hg60 has-color-white ms-lg-8',
			),
		),
		$project_title,
	);

	HTML::instance()->close( 'dimas_projects_link' );

	HTML::instance()->close( 'dimas_projects' );

	$i++;

}

wp_reset_postdata();

HTML::instance()->close( 'section_project_col_wrap' );
