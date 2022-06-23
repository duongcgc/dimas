<?php
/**
 *
 *
 * Loads content section projects of home page.
 *
 * @link https://www.gcosoftware.vn/
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

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

	HTML::instance()->open(
		'dimas_projects',
		array(
			'attr' => array(
				'class' => 'dimas-projects',
			),
		)
	);

	HTML::instance()->open(
		'dimas_projects_link',
		array(
			'tag'  => 'a',
			'attr' => array(
				'class' => 'dimas-projects__url',
				'href'  => $project_link,
			),
		)
	);

	HTML::instance()->open(
		'dimas_projects_category',
		array(
			'attr' => array(
				'class' => 'dimas-projects__category has-color-white',
			),
		)
	);

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
