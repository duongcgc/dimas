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

use \Dimas\HTML;
use \Dimas\Framework\Template_Tag;

HTML::instance()->open(
	'dimas_navbar_inner_right',
	array(
		'attr' => array(
			'class' => 'dimas-navbar-inner-right d-xxxl-none',
		),
	)
);

HTML::instance()->open(
	'dimas_navbar_inner_right__child',
	array(
		'attr' => array(
			'class' => 'd-flex align-items-center',
		),
	)
);

Template_Tag::dimas_icon(
	array(
		'class' => 'dimas-menu-burger js-offcanvas-menu-open has-color-white',
	),
	'ui',
	'dimas_burger_open',
);

HTML::instance()->close( 'dimas_navbar_inner_right__child' );

HTML::instance()->close( 'dimas_navbar_inner_right' );
