<?php
/**
 *
 *
 * Loads section services col right.
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

HTML::instance()->self_close_tag(
	'dimas_services_col_2',
	array(
		'attr' => array(
			'class' => 'col-lg-5 col-xxl-4 offset-xl-1 d-none d-lg-flex d-xxl-block align-items-center dimas-tab__content',
		),
	),
	wp_get_attachment_image(
		183,
		'full',
		false,
		array(
			'class' => 'dimas-services-img',
			'alt'   => 'Services image',
		)
	),
);
