<?php
/**
 * Loads dimas header - main menu.
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

use \Dimas\HTML;

HTML::instance()->open(
	'dimas_navbar_inner',
	array(
		'attr' => array(
			'class' => 'dimas-navbar-inner h-100',
		),
	)
);

get_template_part( 'template-parts/header/dimas-header/main-menu', 'dimas-logo' );

get_template_part( 'template-parts/header/dimas-header/main-menu', 'nav-menu' );

get_template_part( 'template-parts/header/dimas-header/main-menu', 'button-offcanvas-open' );

get_template_part( 'template-parts/header/dimas-header/main-menu', 'social-link' );

HTML::instance()->close( 'dimas_navbar_inner' );
