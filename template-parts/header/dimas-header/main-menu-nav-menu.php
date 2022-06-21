<?php
/**
 * Displays the main menu nav menu.
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
