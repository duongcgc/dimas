<?php
/**
 *
 *
 * Loads section home page.
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
use \Dimas\HTML;

$array_wrapper_tag = array(
	'dimas_section'                 => array(
		'tag'  => 'section',
		'attr' => array(
			'data-anchor' => $data_anchor,
			'style'       => 'background-image: url(' . $url_bg . ')',
			'class'       => 'dimas-section pp-scrollable',
		),
	),
	'dimas_section__vertical_align' => array(
		'attr' => array(
			'class' => 'dimas-section__vertical-align',
		),
	),
	'section__content '             => array(
		'attr' => array(
			'class' => 'dimas-section__content dimas-section__content--' . $section_name,
		),
	),
	'section__content_container'    => array(
		'attr' => array(
			'class' => 'container',
		),
	),
	'section__content_row'          => array(
		'attr' => array(
			'class' => 'row',
		),
	),
);

Template_Tag::dimas_html_loop_open( $array_wrapper_tag );
