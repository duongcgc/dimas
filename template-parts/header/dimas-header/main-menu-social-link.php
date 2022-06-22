<?php
/**
 * Loads main menu - social link.
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

use \Dimas\HTML;

HTML::instance()->open(
	'dimas_navbar_socials',
	array(
		'attr' => array(
			'class' => 'dimas-navbar-socials d-none d-xxxl-flex justify-content-end',
		),
	)
);

get_template_part( 'template-parts/social/social', 'link' );

HTML::instance()->close( 'dimas_navbar_socials' );
