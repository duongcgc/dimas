<?php
/**
 * Loads offcanvas menu.
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

use \Dimas\HTML;

HTML::instance()->open(
	'dimas_offcanvas_menu',
	array(
		'attr' => array(
			'class' => 'dimas-offcanvas-menu',
		),
	)
);

get_template_part( 'template-parts/header/offcanvas-menu/offcanvas-menu', 'button-close' );

get_template_part( 'template-parts/header/offcanvas-menu/offcanvas-menu', 'nav-menu' );

get_template_part( 'template-parts/header/offcanvas-menu/offcanvas-menu', 'social-link' );

HTML::instance()->close( 'dimas_offcanvas_menu' );
