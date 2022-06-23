<?php
/**
 *
 *
 * Loads section home col left.
 *
 * @link https://www.gcosoftware.vn/
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

use \Dimas\Framework\Template_Tag;
use \Dimas\HTML;

$array_wrapper_tag = array(
	'dimas_services_col_1'     => array(
		'attr' => array(
			'class' => 'col-lg-6 col-xxl-7 pt-lg-3 dimas-tab',
		),
	),
	'dimas_services_col_1_nav' => array(
		'attr' => array(
			'tag'   => 'ul',
			'class' => 'nav flex-column',
		),
	),
);

$array_wrapper_tag_child = array(
	'dimas_services_col_1_nav_item'              => array(
		'attr' => array(
			'tag'   => 'li',
			'class' => 'nav-item',
		),
	),
	'dimas_services_col_1_nav_item_wrap_content' => array(
		'attr' => array(
			'class' => 'cursor-pointer dimas-tab__header position-relative mb-32 mb-md-9',
		),
	),
);

$array_items = array(
	'branding' => array(
		'icon'     => array(
			null,
			'ui',
			'dimas_diamond',
		),
		'title'    => 'Branding',
		'subtitle' => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour',
	),
	'design'   => array(
		'icon'     => array(
			null,
			'ui',
			'dimas_feather',
		),
		'title'    => 'Design',
		'subtitle' => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour',
	),
	'artwork'  => array(
		'icon'     => array(
			null,
			'ui',
			'dimas_third_circle',
		),
		'title'    => 'Artwork',
		'subtitle' => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour',
	),
);


Template_Tag::dimas_html_loop_open( $array_wrapper_tag );

foreach ( $array_items as $key => $value ) {

	if ( array_key_last( $array_items ) == $key ) {

		$array_wrapper_tag_child['dimas_services_col_1_nav_item_wrap_content'] = array(
			'attr' => array(
				'class' => 'cursor-pointer dimas-tab__header position-relative nav-link mb-32 mb-md-0',
			),
		);

		Template_Tag::dimas_html_loop_open( $array_wrapper_tag_child );
	} else {
		Template_Tag::dimas_html_loop_open( $array_wrapper_tag_child );
	}

	HTML::instance()->open(
		'dimas_tab__icon_wrap',
		array(
			'attr' => array(
				'class' => 'dimas-tab__icon-wrap mb-3 mb-md-0',
			),
		)
	);

	Template_Tag::dimas_icon( $value['icon'][0], $value['icon'][1], $value['icon'][2], );

	HTML::instance()->close( 'dimas_tab__icon_wrap' );

	HTML::instance()->open(
		'dimas_title',
		array(
			'attr' => array(
				'class' => 'dimas-title dimas-services',
			),
		)
	);

	HTML::instance()->self_close_tag(
		'dimas_title_h2',
		array(
			'tag'  => 'h2',
			'attr' => array(
				'class' => 'dimas-services__name label-banner hg60 has-color-white',
			),
		),
		$value['title'],
	);

	HTML::instance()->self_close_tag(
		'dimas_title_p',
		array(
			'tag'  => 'p',
			'attr' => array(
				'class' => 'dimas-subtitle mb-0 has-color-subtitle',
			),
		),
		$value['subtitle'],
	);

	HTML::instance()->close( 'dimas_title' );

	Template_Tag::dimas_html_loop_close( $array_wrapper_tag_child );

}

Template_Tag::dimas_html_loop_close( $array_wrapper_tag );
