<?php
/**
 * Displays the main menu social link.
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

use \Dimas\HTML;

HTML::instance()->open(
	'dimas-navbar-socials',
	array(
		'attr' => array(
			'class' => 'dimas-navbar-socials d-none d-xxxl-flex justify-content-end',
		),
	)
);

get_template_part( 'template-parts/social-link/social-link' );

HTML::instance()->close( 'dimas-navbar-socials' );
