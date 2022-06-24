<?php
/**
 * Loads main menu - offcanvas open.
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

use \Dimas\Framework\Template_Tag;

$arr_wrapper_tag = array(
	'dimas_navbar_inner_right'        => array(
		'attr' => array(
			'class' => 'dimas-navbar-inner-right d-xxxl-none',
		),
	),
	'dimas_navbar_inner_right__child' => array(
		'attr' => array(
			'class' => 'd-flex align-items-center',
		),
	),
);

Template_Tag::dimas_html_loop_open( $arr_wrapper_tag );

Template_Tag::dimas_icon(
	array(
		'class' => 'dimas-menu-burger js-offcanvas-menu-open has-color-white',
	),
	'ui',
	'dimas_burger_open',
);

Template_Tag::dimas_html_loop_close( $arr_wrapper_tag );
