<?php
/**
 * Displays the site header.
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

use \Dimas\HTML;

HTML::instance()->open(
	'dimas-header',
	array(
		'tag'  => 'header',
		'attr' => array(
			'class' => 'dimas-header',
			'id'    => 'masthead',
		),
	)
);

HTML::instance()->open(
	'dimas-navbar',
	array(
		'attr' => array(
			'class' => 'dimas-navbar dimas-navbar--main dimas-navbar--fixed',
		),
	)
);

HTML::instance()->open(
	'dimas-navbar-background',
	array(
		'attr' => array(
			'class' => 'dimas-navbar-background',
		),
	)
);

HTML::instance()->close( 'dimas-navbar-background' );

get_template_part( 'template-parts/header/main-menu' );

HTML::instance()->close( 'dimas-navbar' );

HTML::instance()->close( 'dimas-header' );

get_template_part( 'template-parts/header/offcanvas-menu' );

HTML::instance()->open(
	'dimas-site-overlay',
	array(
		'attr' => array(
			'class' => 'dimas-site-overlay',
		),
	)
);

HTML::instance()->close( 'dimas-site-overlay' );
