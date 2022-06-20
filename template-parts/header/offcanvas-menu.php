<?php
/**
 * Displays the offcanvas menu.
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
	'dimas-offcanvas-menu',
	array(
		'attr' => array(
			'class' => 'dimas-offcanvas-menu',
		),
	)
);

HTML::instance()->open(
	'dimas-offcanvas-menu__header',
	array(
		'attr' => array(
			'class' => 'dimas-offcanvas-menu__header',
		),
	)
);

Template_Tag::instance()->dimas_icon(
	array(
		'class' => 'dimas-menu-burger dimas-menu-burger--opened js-offcanvas-menu-close float-right',
	),
	'ui',
	'dimas_burger_close',
);

HTML::instance()->close( 'dimas-offcanvas-menu__header' );

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

HTML::instance()->open(
	'dimas-offcanvas-menu__footer',
	array(
		'attr' => array(
			'class' => 'dimas-offcanvas-menu__footer d-flex justify-content-center',
		),
	)
);

get_template_part( 'template-parts/header/social-link' );

HTML::instance()->close( 'dimas-offcanvas-menu__footer' );

HTML::instance()->close( 'dimas-offcanvas-menu' );
