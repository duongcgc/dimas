<?php
/**
 * Template file for displaying cart mobile
 *
 * @package Razzi
 */
?>

<a href="#" class="rz-navigation-bar_icon cart-icon" data-toggle="modal" data-target="cart-modal">
	<?php echo Dimas_SVG_Icon::get_svg( 'cart', '', 'shop' ); ?>
	<span class="counter cart-counter"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
</a>
