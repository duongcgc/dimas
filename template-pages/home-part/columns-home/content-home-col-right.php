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
	'section_home_col_2',
	array(
		'attr' => array(
			'class' => 'd-none col-sm-6 col-md-3 col-lg-4 d-sm-flex position-relative',
		),
	)
);

HTML::instance()->open(
	'section_home_col_2_wrap',
	array(
		'attr' => array(
			'class' => 'dimas-experience d-flex justify-content-center align-items-center',
		),
	)
);

echo wp_get_attachment_image(
	177,
	'medium',
	false,
	array(
		'class' => 'dimas-experience__img dimas-experience__img--circle position-absolute',
		'alt'   => 'Circle',
	)
);

echo wp_get_attachment_image(
	176,
	'medium',
	false,
	array(
		'class' => 'dimas-experience__img dimas-experience__img--text position-absolute',
		'alt'   => 'Experience text',
	)
);

HTML::instance()->close( 'section_home_col_2_wrap' );

HTML::instance()->close( 'section_home_col_2' );
