<?php
/**
 *
 * Loads home page navigation.
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

use \Dimas\Framework\Template_Tag;
use \Dimas\HTML;

HTML::instance()->open(
	'dimas_fullpage_slider_nav',
	array(
		'tag'  => 'ul',
		'attr' => array(
			'class' => 'dimas-fullpage-slider-nav d-none d-lg-block',
		),
	)
);

Template_Tag::dimas_home_page_navigation( 'primary-menu' );

HTML::instance()->close( 'dimas_fullpage_slider_nav' );
