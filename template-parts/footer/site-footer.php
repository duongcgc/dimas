<?php
/**
 * The template for displaying footer.
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

use \Dimas\HTML;

HTML::instance()->open(
	'dimas-footer',
	array(
		'tag'  => 'footer',
		'attr' => array(
			'class' => 'dimas-footer dimas-footer--fixed',
		),
	)
);

get_template_part( 'template-parts/footer/site-footer-item' );

HTML::instance()->close( 'dimas-footer' );
