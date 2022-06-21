<?php
/**
 * Displays the offcanvas button close.
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
	'dimas-offcanvas-menu__header',
	array(
		'attr' => array(
			'class' => 'dimas-offcanvas-menu__header',
		),
	)
);

Template_Tag::instance()->dimas_icon(
	array(
		'class' => 'dimas-menu-burger dimas-menu-burger--opened js-offcanvas-menu-close float-right',
	),
	'ui',
	'dimas_burger_close',
);

HTML::instance()->close( 'dimas-offcanvas-menu__header' );
