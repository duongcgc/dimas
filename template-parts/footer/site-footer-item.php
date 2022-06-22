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

$footer_array = array(
	'coppyright' =>
	array(
		'class' => 'coppyright',
		'href'  => 'mailto:dimas@domain.com',
		'text'  => 'dimas@domain.com',
	),
	'hotline'    =>
	array(
		'class' => 'hotline',
		'href'  => 'tel:(+34)765873454',
		'text'  => 'Tell: (+34) 765 87 34 54',
	),
);

foreach ( $footer_array as $key => $value ) {

	HTML::instance()->open(
		'dimas_footer',
		array(
			'attr' => array(
				'class' => 'dimas-footer' . $value['class'],
			),
		)
	);

	HTML::instance()->open(
		'dimas_footer__a',
		array(
			'tag'  => 'a',
			'attr' => array(
				'class' => 'd-block',
				'href'  => $value['href'],
			),
		)
	);

	echo esc_html( $value['text'] );

	HTML::instance()->close( 'dimas_footer__a' );

	HTML::instance()->close( 'dimas_footer' );

}
