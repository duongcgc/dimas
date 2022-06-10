<?php
/**
 * Template part for display primary menu
 *
 * @package Razzi
 */

 $classes = 'main-navigation primary-navigation';
if( Dimas_Helper::get_option('header_active_primary_menu_color') == 'current' ) {
	$classes .= ' main-menu-current-color';
}
?>
<nav id="primary-menu" class="<?php echo esc_attr( $classes ); ?>">
	<?php Dimas_Theme::instance()->get('header')->primary_menu(); ?>
</nav>
