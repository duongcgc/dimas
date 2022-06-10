<?php
/**
 * Template part for displaying the preloader.
 *
 * @package Razzi
 */
?>
<div id="preloader" class="preloader preloader-<?php echo esc_attr( Dimas_Helper::get_option( 'preloader' ) ) ?>">
	<?php
	switch ( Dimas_Helper::get_option( 'preloader' ) ) {
		case 'image':
			$image = Dimas_Helper::get_option( 'preloader_image' );
			break;

		case 'external':
			$image = Dimas_Helper::get_option( 'preloader_url' );
			break;

		default:
			$image = apply_filters( 'konte_preloader', false );
			break;
	}

	if ( ! $image ) {
		echo '<span class="preloader-icon spinner"></span>';
	} else {
		$image = '<img src="' . esc_url( $image ) . '" alt="' . esc_attr__( 'Preloader', 'razzi' ) . '">';
		echo '<span class="preloader-icon">' . $image . '</span>';
	}
	?>
</div>