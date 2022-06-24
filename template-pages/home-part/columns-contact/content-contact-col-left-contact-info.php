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

use \Dimas\Framework\Template_Tag;
use \Dimas\HTML;

$array_info_contact = array(
	array(
		'icon_name'    => 'dimas_phone',
		'contact_link' => 'tel:(+34) 765 87 34 54',
		'contact_text' => '(+34) 765 87 34 54',
	),
	array(
		'icon_name'    => 'dimas_envelope',
		'contact_link' => 'mailto:dimas@domain.com',
		'contact_text' => 'dimas@domain.com',
	),
);

HTML::instance()->open(
	'dimas_contact_info',
	array(
		'tag'  => 'ul',
		'attr' => array(
			'class' => 'dimas-contact-info',
		),
	)
);

foreach ( $array_info_contact as $key => $item ) {

	HTML::instance()->open(
		'dimas_contact_info_item',
		array(
			'tag'  => 'li',
			'attr' => array(
				'class' => 'dimas-contact-info__item',
			),
		)
	);

	Template_Tag::dimas_icon(
		null,
		'ui',
		$item['icon_name'],
	);

	HTML::instance()->open(
		'dimas_contact_info_item_link',
		array(
			'tag'  => 'a',
			'attr' => array(
				'class' => 'dimas-contact-info__link d-inline-block',
				'href'  => $item['contact_link'],
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
		$item['contact_text'],
	);

	HTML::instance()->close( 'dimas_contact_info_item_link' );

	HTML::instance()->close( 'dimas_contact_info_item' );
}

HTML::instance()->close( 'dimas_contact_info' );
