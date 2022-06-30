<?php
/**
 * Loads offcanvas menu - nav menu.
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

use \Dimas\Framework\Template_Tag;

$show_menu = get_theme_mod( 'header_menus_item' );
if ( '0' != $show_menu ) {
	$args_nav_offcanvas_menu = array(
		'menu'            => $show_menu,
		'container_class' => 'dimas-offcanvas-menu__navigation',
	);

	Template_Tag::instance()->dimas_menu( $args_nav_offcanvas_menu );
}
