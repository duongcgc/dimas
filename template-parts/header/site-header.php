<?php
/**
 * Loads header.
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

use \Dimas\HTML;

get_template_part( 'template-parts/header/site-header', 'dimas-header' );

get_template_part( 'template-parts/header/site-header', 'offcanvas-menu' );

HTML::instance()->self_close_tag(
	'dimas_site_overlay',
	array(
		'attr' => array(
			'class' => 'dimas-site-overlay',
		),
	),
	'',
);
