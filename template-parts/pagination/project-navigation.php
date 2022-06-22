<?php
/**
 *
 *
 * Loads single projects navigation.
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
use \Dimas\Framework\Template_Tag;

$project_prev_url = get_previous_post_link( '%link', '%title', false, '', 'branch-project' );
$project_next_url = get_next_post_link( '%link', '%title', false, '', 'branch-project' );

HTML::instance()->open(
	'projects_nav',
	array(
		'attr' => array(
			'class' => 'projects-pagination pb-32',
		),
	)
);

HTML::instance()->open(
	'projects_nav__prev',
	array(
		'attr' => array(
			'class' => ( '' === $project_prev_url ) ? 'projects-pagination__prev invisible' : 'projects-pagination__prev',
		),
	)
);

if ( '' != $project_prev_url ) {

	previous_post_link( '%link', '%title', false, '', 'branch-project' );
}

HTML::instance()->close( 'projects_nav__prev' );

HTML::instance()->open(
	'projects_nav__next',
	array(
		'attr' => array(
			'class' => ( '' === $project_next_url ) ? 'projects-pagination__next invisible' : 'projects-pagination__next',
		),
	)
);

if ( '' != $project_next_url ) {

	next_post_link( '%link', '%title', false, '', 'branch-project' );
}

HTML::instance()->close( 'projects_nav__next' );

HTML::instance()->close( 'projects_nav' );
