<?php
/**
 * Displays the main menu.
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

use \Dimas\HTML;
use \Dimas\Framework\Template_Tag;

$args_nav_menu = array(
	'theme_location'  => 'primary-menu',
	'container_class' => 'dimas-default-menu__navigation',
);

HTML::instance()->open(
	'dimas-navbar-inner',
	array(
		'attr' => array(
			'class' => 'dimas-navbar-inner h-100',
		),
	)
);

HTML::instance()->open(
	'dimas-navbar-inner-left',
	array(
		'attr' => array(
			'class' => 'dimas-navbar-inner-left',
		),
	)
);

Template_Tag::instance()->dimas_logo( array( 'class' => 'dimas-navbar-logo' ), 'full' );

HTML::instance()->close( 'dimas-navbar-inner-left' );

Template_Tag::instance()->dimas_bootstrap_container_open();

HTML::instance()->open(
	'dimas-navbar-inner-center',
	array(
		'attr' => array(
			'class' => 'dimas-navbar-inner-center d-none d-xxxl-flex row',
		),
	)
);

Template_Tag::instance()->dimas_menu( $args_nav_menu );

HTML::instance()->close( 'dimas-navbar-inner-center' );

Template_Tag::instance()->dimas_bootstrap_container_close();

HTML::instance()->open(
	'dimas-navbar-inner-right',
	array(
		'attr' => array(
			'class' => 'dimas-navbar-inner-right d-xxxl-none',
		),
	)
);

HTML::instance()->open(
	'dimas-navbar-inner-right__child',
	array(
		'attr' => array(
			'class' => 'd-flex align-items-center',
		),
	)
);

Template_Tag::instance()->dimas_icon(
	array(
		'class' => 'dimas-menu-burger js-offcanvas-menu-open has-color-white',
	),
	'ui',
	'dimas_burger_open',
);

HTML::instance()->close( 'dimas-navbar-inner-right__child' );

HTML::instance()->close( 'dimas-navbar-inner-right' );

HTML::instance()->open(
	'dimas-navbar-socials',
	array(
		'attr' => array(
			'class' => 'dimas-navbar-socials d-none d-xxxl-flex justify-content-end',
		),
	)
);

get_template_part( 'template-parts/header/social-link' );

HTML::instance()->close( 'dimas-navbar-socials' );

HTML::instance()->close( 'dimas-navbar-inner' );
