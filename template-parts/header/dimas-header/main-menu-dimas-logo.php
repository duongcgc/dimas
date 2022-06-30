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
use \Dimas\SVG_Icons;

HTML::instance()->open(
	'dimas_navbar_inner_left',
	array(
		'attr' => array(
			'class' => 'dimas-navbar-inner-left',
		),
	)
);

if ( 'text' == get_theme_mod( 'logo_type' ) ) {
	echo esc_html( get_theme_mod( 'logo_text' ) );
}
if ( 'svg' == get_theme_mod( 'logo_type' ) ) {
	SVG_Icons::sanitize_svg( get_theme_mod( 'logo_svg' ) );
} else {
	Template_Tag::dimas_logo( array( 'class' => 'dimas-navbar-logo' ), 'full' );
}

HTML::instance()->close( 'dimas_navbar_inner_left' );
