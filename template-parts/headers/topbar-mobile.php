<?php
/**
 * Template part for displaying the topbar
 *
 * @package dimas
 */

use Dimas\Helper;

$mobile_items = array_filter( (array) Helper::get_option( 'mobile_topbar_items' ) );
?>

<div id="topbar-mobile" class="topbar topbar-mobile hidden-md hidden-lg">
	<div class="dimas-container-fluid dimas-container">

		<?php if ( ! empty( $mobile_items ) ) : ?>
			<div class="topbar-items mobile-topbar-items">
				<?php Theme::instance()->get('topbar')->topbar_mobile_items( $mobile_items ); ?>
			</div>
		<?php endif; ?>
	</div>
</div>