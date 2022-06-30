<?php
/**
 * Loads footer item.
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

use \Dimas\HTML;

$footer_item = array( 'left', 'right' );

foreach ( $footer_item as $key => $value ) {
	if ( get_theme_mod( 'footer_item_' . $value . '_show' ) ) {
		$footer_array[ $value ] = array(
			'class' => esc_html( $value ),
			'href'  => get_theme_mod( 'footer_item_' . $value . '_link' ),
			'text'  => get_theme_mod( 'footer_item_' . $value . '_text' ),
		);
	}
}

foreach ( $footer_array as $key => $value ) {

	HTML::instance()->open(
		'dimas_footer',
		array(
			'attr' => array(
				'class' => 'dimas-footer-' . $value['class'],
			),
		)
	);

	HTML::instance()->self_close_tag(
		'dimas_footer__a',
		array(
			'tag'  => 'a',
			'attr' => array(
				'class' => 'd-block',
				'href'  => $value['href'],
			),
		),
		$value['text'],
	);

	HTML::instance()->close( 'dimas_footer' );

}
