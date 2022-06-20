<?php
/**
 * Displays the social link.
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

$icon_name = array( 'dimas_fb', 'dimas_tw', 'dimas_dr' );

foreach ( $icon_name as $key => $value ) {
	\Dimas\Framework\Template_Tag::instance()->dimas_icon(
		array(
			'class' => 'dimas-social-icon',
		),
		'social',
		$value,
	);
}
