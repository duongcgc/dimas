<?php
/**
 * Template part for displaying the preloader.
 *
 * @package Dimas
 */
?>
<div id="preloader" class="preloader preloader-<?php echo esc_attr( Helper::get_option( 'preloader' ) ) ?>">
	<?php
	switch ( Helper::get_option( 'preloader' ) ) {
		case 'image':
			$image = Helper::get_option( 'preloader_image' );
			break;

		case 'external':
			$image = Helper::get_option( 'preloader_url' );
			break;

		default:
			$image = apply_filters( 'konte_preloader', false );
			break;
	}

	if ( ! $image ) {
		echo '<span class="preloader-icon spinner"></span>';
	} else {
		$image = '<img src="' . esc_url( $image ) . '" alt="' . esc_attr__( 'Preloader', 'dimas' ) . '">';
		echo '<span class="preloader-icon">' . $image . '</span>';
	}
	?>
</div>