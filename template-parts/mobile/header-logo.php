<?php
/**
 * Template file for displaying mobile menu
 *
 * @package Razzi
 */

use Razzi\Helper;
$dimension = Helper::get_option( 'mobile_logo_dimension' );
$style     = ! empty( $dimension['width'] ) ? ' width="' . esc_attr( $dimension['width'] ) . '"' : '';
$style     .= ! empty( $dimension['width'] ) ? ' height="' . esc_attr( $dimension['height'] ) . '"' : '';

$header_background = get_post_meta( DM_Helper::get_post_ID(), 'rz_header_background', true );
$header_background_text = get_post_meta( DM_Helper::get_post_ID(), 'rz_header_text_color', true );
?>

<div class="mobile-logo site-branding">
	<a href="<?php echo esc_url( home_url() ) ?>" class="logo logo-text">
		<?php if ( Helper::get_option( 'mobile_logo' ) ) :?>
			<img class="logo-dark" src="<?php echo esc_url( Helper::get_option( 'mobile_logo' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" <?php echo wp_kses_post( $style ) ?>>
			<?php if ( $header_background == 'transparent' && $header_background_text == 'light' ) : ?>
				<img class="logo-light" src="<?php echo esc_url( Helper::get_option( 'mobile_logo_light' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" <?php echo wp_kses_post( $style ) ?>>
			<?php endif;?>
		<?php else: ?>
			<span class="logo-dark"><?php echo esc_html( Helper::get_option( 'logo_text' ) ); ?></span>
		<?php endif;?>
	</a>
</div>