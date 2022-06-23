<?php
/**
 *
 *
 * Loads section home col right.
 *
 * @link https://www.gcosoftware.vn/
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

use \Dimas\HTML;

HTML::instance()->open(
	'dimas_contact_col_1',
	array(
		'attr' => array(
			'class'                 => 'col-xxl-6 col-lg-5 offset-lg-1 position-relative overflow-hidden',
		),
	)
);

echo do_shortcode( '[contact-form-7 id="147" title="Contact form"]' );

HTML::instance()->close( 'dimas_contact_col_1' );
