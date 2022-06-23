<?php
/**
 * Loads dimas header.
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

use \Dimas\HTML;

HTML::instance()->open(
	'dimas_header',
	array(
		'tag'  => 'header',
		'attr' => array(
			'class' => 'dimas-header',
			'id'    => 'masthead',
		),
	)
);

HTML::instance()->open(
	'dimas_navbar',
	array(
		'attr' => array(
			'class' => 'dimas-navbar dimas-navbar--main dimas-navbar--fixed',
		),
	)
);

HTML::instance()->self_close_tag(
	'dimas_navbar_background',
	array(
		'attr' => array(
			'class' => 'dimas-navbar-background',
		),
	),
	'',
);

get_template_part( 'template-parts/header/dimas-header/dimas-header', 'main-menu', $args );

HTML::instance()->close( 'dimas_navbar' );

HTML::instance()->close( 'dimas_header' );
