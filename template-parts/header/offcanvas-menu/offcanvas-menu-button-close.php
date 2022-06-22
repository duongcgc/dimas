<?php
/**
 * Loads offcanvas menu button close.
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

use \Dimas\HTML;
use \Dimas\Framework\Template_Tag;

HTML::instance()->open(
	'dimas_offcanvas_menu__header',
	array(
		'attr' => array(
			'class' => 'dimas-offcanvas-menu__header',
		),
	)
);

Template_Tag::dimas_icon(
	array(
		'class' => 'dimas-menu-burger dimas-menu-burger--opened js-offcanvas-menu-close float-right',
	),
	'ui',
	'dimas_burger_close',
);

HTML::instance()->close( 'dimas_offcanvas_menu__header' );
