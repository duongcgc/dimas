<?php
/**
 *
 * Loads title page.
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

use \Dimas\HTML;

if ( is_singular( 'project' ) ) {

	HTML::instance()->self_close_tag(
		'page_title',
		array(
			'tag'  => 'h2',
			'attr' => array(
				'class' => 'dimas-section__name label-banner mb-5 has-color-white',
			),
		),
		get_the_title(),
	);

} elseif ( is_singular( 'post' ) || is_singular( 'page' ) ) {

	HTML::instance()->self_close_tag(
		'page_title',
		array(
			'tag'  => 'h1',
			'attr' => array(
				'class' => 'post-title pb-5 has-color-white mb-0',
			),
		),
		get_the_title(),
	);

} elseif ( is_archive() ) {

	$archive_title = 'Latest Posts';

	HTML::instance()->self_close_tag(
		'archive_title',
		array(
			'tag'  => 'h1',
			'attr' => array(
				'class' => 'archive-title has-color-white mb-0 pb-5 pb-lg-96 text-center',
			),
		),
		$archive_title,
	);

}
