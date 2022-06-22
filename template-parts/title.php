<?php
/**
 *
 *
 * Loads title page.
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

if ( is_singular( 'project' ) ) {

	HTML::instance()->open(
		'page_title',
		array(
			'tag'  => 'h2',
			'attr' => array(
				'class' => 'dimas-section__name label-banner mb-5 has-color-white',
			),
		)
	);

	the_title();

	HTML::instance()->close( 'page_title' );

} elseif ( is_singular( 'post' ) || is_singular( 'page' ) ) {

	HTML::instance()->open(
		'page_title',
		array(
			'tag'  => 'h1',
			'attr' => array(
				'class' => 'dimas-post-info__post-title pb-5 post-title has-color-white mb-0',
			),
		)
	);

	the_title();

	HTML::instance()->close( 'page_title' );

} elseif ( is_archive() ) {

	$archive_title = 'Latest Posts';

	HTML::instance()->open(
		'archive_title',
		array(
			'tag'  => 'h1',
			'attr' => array(
				'class' => 'dimas-post-info__post-title post-title has-color-white mb-0 pb-5 pb-lg-96 text-center',
			),
		)
	);

	echo esc_html( $archive_title );

	HTML::instance()->close( 'archive_title' );

}
