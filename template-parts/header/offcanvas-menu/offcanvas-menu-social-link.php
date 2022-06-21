<?php
/**
 * Displays the offcanvas social link.
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

use \Dimas\HTML;

HTML::instance()->open(
	'dimas-offcanvas-menu__footer',
	array(
		'attr' => array(
			'class' => 'dimas-offcanvas-menu__footer d-flex justify-content-center',
		),
	)
);

get_template_part( 'template-parts/social-link/social-link' );

HTML::instance()->close( 'dimas-offcanvas-menu__footer' );
