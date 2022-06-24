<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

use \Dimas\Framework\Template_Tag;
use \Dimas\HTML;

$array_wapper_tag = array(
	'error_404'    => array(
		'attr' => array(
			'class' => 'error-404 not-found',
		),
	),
	'page_content' => array(
		'attr' => array(
			'class' => 'page-content',
		),
	),
);

Template_Tag::dimas_html_loop_open( $array_wapper_tag );

HTML::instance()->self_close_tag(
	'error_404_text',
	array(
		'tag'  => 'p',
		'attr' => array(
			'class' => 'error-404__text',
		),
	),
	esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'dimas' ),
);

Template_Tag::dimas_html_loop_close( $array_wapper_tag );
