<?php
/**
 *
 * Loads section contact col left - contact info.
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

for ( $i = 1; $i <= get_theme_mod( 'info_count' );$i++ ) {
	$array_contact_item[ $i ] = array(
		'item_text' => get_theme_mod( 'info_item_' . $i . '_text' ),
		'item_link' => ( '' != get_theme_mod( 'info_item_' . $i . '_link' ) ) ? get_theme_mod( 'info_item_' . $i . '_link' ) : '##',
	);
	if ( 'custom' == get_theme_mod( 'info_item_' . $i . '_icon_type' ) ) {
		$icon_name = get_theme_mod( 'info_item_' . $i . '_icon_custom' );
		if ( '' != Template_Function::instance()->dimas_get_icon_svg( 'ui', $icon_name ) ) {
			$array_contact_item[ $i ]['icon_out'] = Template_Function::instance()->dimas_get_icon_svg( 'ui', $icon_name );
		} elseif ( '' != Template_Function::instance()->dimas_get_icon_svg( 'social', $icon_name ) ) {
			$array_contact_item[ $i ]['icon_out'] = Template_Function::instance()->dimas_get_icon_svg( 'social', $icon_name );
		} else {
			$array_contact_item[ $i ]['icon_out'] = null;
		}
	} else {
		$array_contact_item[ $i ]['icon_out'] = get_theme_mod( 'info_item_' . $i . '_icon_input' );
	}
}

HTML::instance()->open(
	'dimas_contact_info',
	array(
		'tag'  => 'ul',
		'attr' => array(
			'class' => 'dimas-contact-info',
		),
	)
);

foreach ( $array_contact_item as $key => $item ) {

	HTML::instance()->open(
		'dimas_contact_info_item',
		array(
			'tag'  => 'li',
			'attr' => array(
				'class' => 'dimas-contact-info__item',
			),
		)
	);

	if ( '' != $item['icon_out'] ) {
		SVG_Icons::sanitize_svg( $item['icon_out'] );
	}

	HTML::instance()->open(
		'dimas_contact_info_item_link',
		array(
			'tag'  => 'a',
			'attr' => array(
				'class' => 'dimas-contact-info__link d-inline-block',
				'href'  => $item['item_link'],
			),
		)
	);

	HTML::instance()->self_close_tag(
		'dimas_contact_info_item_text',
		array(
			'tag'  => 'h3',
			'attr' => array(
				'class' => 'dimas-contact-info__text has-color-white mb-0',
			),
		),
		$item['item_text'],
	);

	HTML::instance()->close( 'dimas_contact_info_item_link' );

	HTML::instance()->close( 'dimas_contact_info_item' );
}

HTML::instance()->close( 'dimas_contact_info' );
