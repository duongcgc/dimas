<?php
/**
 * Loads the social link.
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

use \Dimas\HTML;
use \Dimas\SVG_Icons;
use \Dimas\Framework\Template_Function;

for ( $i = 1; $i <= get_theme_mod( 'social_link_count' );$i++ ) {
	$array_social_item[ $i ] = array(
		'icon_text' => get_theme_mod( 'social_link_item_' . $i . '_text' ),
		'icon_link' => ( '' != get_theme_mod( 'social_link_item_' . $i . '_link' ) ) ? get_theme_mod( 'social_link_item_' . $i . '_link' ) : '##',
	);
	if ( 'custom' == get_theme_mod( 'social_link_item_' . $i . '_icon_type' ) ) {
		$icon_name = get_theme_mod( 'social_link_item_' . $i . '_icon_custom' );
		if ( '' != Template_Function::instance()->dimas_get_icon_svg( 'ui', $icon_name ) ) {
			$array_social_item[ $i ]['icon_out'] = Template_Function::instance()->dimas_get_icon_svg( 'ui', $icon_name );
		} elseif ( '' != Template_Function::instance()->dimas_get_icon_svg( 'social', $icon_name ) ) {
			$array_social_item[ $i ]['icon_out'] = Template_Function::instance()->dimas_get_icon_svg( 'social', $icon_name );
		} else {
			$array_social_item[ $i ]['icon_out'] = null;
		}
	} else {
		$array_social_item[ $i ]['icon_out'] = get_theme_mod( 'social_link_item_' . $i . '_icon_input' );
	}
}

foreach ( $array_social_item as $key => $value ) {

	HTML::instance()->open(
		'social_item' . $key,
		array(
			'tag'  => 'a',
			'attr' => array(
				'class' => 'dimas-social-icon',
				'href'  => $value['icon_link'],
			),
		),
	);

	if ( '' != $value['icon_out'] ) {
		SVG_Icons::sanitize_svg( $value['icon_out'] );
	}

	if ( '' != $value['icon_text'] ) {
		echo esc_html( $value['icon_text'] );
	}

	HTML::instance()->close( 'social_item' . $key );
}

