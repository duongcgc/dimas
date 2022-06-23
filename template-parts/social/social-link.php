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

$icon_name = array(
	'dimas_fb' => array(
		'icon_name' => 'dimas_fb',
		'icon_link' => '##',
	),
	'dimas_tw' => array(
		'icon_name' => 'dimas_tw',
		'icon_link' => '##',
	),
	'dimas_dr' => array(
		'icon_name' => 'dimas_dr',
		'icon_link' => '##',
	),
);

foreach ( $icon_name as $key => $value ) {

	\Dimas\Framework\Template_Tag::dimas_icon(
		array(
			'class' => 'dimas-social-icon',
			'href' => $value['icon_link'],
		),
		'social',
		$value['icon_name'],
	);

}
