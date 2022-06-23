<?php
/**
 *
 *
 * Loads section home col left.
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
			'class' => 'col-lg-5',
		),
	)
);

HTML::instance()->open(
	'dimas_title',
	array(
		'attr' => array(
			'class' => 'dimas-title',
		),
	)
);

HTML::instance()->self_close_tag(
	'dimas_title_h2',
	array(
		'tag' => 'h2',
		'attr' => array(
			'class' => 'pb-4 mb-6 label-banner has-after position-relative has-color-white',
		),
	),
	'Contact me',
);

HTML::instance()->close( 'dimas_title' );

get_template_part( 'template-pages/home-part/columns-contact/content-contact-col-left', 'contact-info' );

HTML::instance()->open(
	'dimas_social',
	array(
		'attr' => array(
			'class' => 'dimas-navbar-socials pt-32 pb-8 pb-lg-0',
		),
	)
);

get_template_part( 'template-parts/social/social', 'link' );

HTML::instance()->close( 'dimas_social' );

HTML::instance()->close( 'dimas_contact_col_1' );
