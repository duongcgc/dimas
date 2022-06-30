<?php
/**
 * Loads offcanvas menu social link.
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

use \Dimas\HTML;

HTML::instance()->open(
	'dimas_offcanvas_menu__footer',
	array(
		'attr' => array(
			'class' => 'dimas-offcanvas-menu__footer d-flex justify-content-center',
		),
	)
);

if ( true == get_theme_mod( 'header_social_show' ) ) {
	get_template_part( 'template-parts/social/social', 'link' );
}

HTML::instance()->close( 'dimas_offcanvas_menu__footer' );
