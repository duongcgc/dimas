<?php
/**
 * Loads main menu - dimas logo.
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

use \Dimas\HTML;
use \Dimas\Framework\Template_Tag;

HTML::instance()->open(
	'dimas_navbar_inner_left',
	array(
		'attr' => array(
			'class' => 'dimas-navbar-inner-left',
		),
	)
);

Template_Tag::dimas_logo( array( 'class' => 'dimas-navbar-logo' ), 'full' );

HTML::instance()->close( 'dimas_navbar_inner_left' );
