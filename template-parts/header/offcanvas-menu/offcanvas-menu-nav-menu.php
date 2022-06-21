<?php
/**
 * Displays the offcanvas nav menu.
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

use \Dimas\HTML;
use \Dimas\Framework\Template_Tag;

$args_nav_offcanvas_menu = array(
	'theme_location'  => 'primary-menu',
	'container_class' => 'dimas-offcanvas-menu__navigation',
);

HTML::instance()->open(
	'dimas-offcanvas-menu__navigation',
	array(
		'attr' => array(
			'class' => 'dimas-offcanvas-menu__navigation',
		),
	)
);

Template_Tag::instance()->dimas_menu( $args_nav_offcanvas_menu );

HTML::instance()->close( 'dimas-offcanvas-menu__navigation' );
