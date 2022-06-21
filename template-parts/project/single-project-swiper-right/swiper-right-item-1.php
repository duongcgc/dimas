<?php
/**
 *
 *
 * Loads content of single project swiper left item 1.
 *
 * @link https://www.gcosoftware.vn/
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

use \Dimas\HTML;

$arr_info_project = array(
	array(
		'label' => 'Services',
		'text'  => 'Design, Branding, Artwork',
	),
	array(
		'label' => 'Manager',
		'text'  => 'John Doe',
	),
	array(
		'label' => 'Date',
		'text'  => 'January 23, 2022',
	),
	array(
		'label' => 'Client',
		'text'  => 'ABC Group',
	),
);

HTML::instance()->open(
	'swiper-slide-1',
	array(
		'attr' => array(
			'class' => 'swiper-slide',
		),
	)
);

HTML::instance()->open(
	'dimas-section__name',
	array(
		'tag'  => 'h2',
		'attr' => array(
			'class' => 'dimas-section__name label-banner mb-5 has-color-white',
		),
	)
);

the_title();

HTML::instance()->close( 'dimas-section__name' );

if ( get_the_excerpt() ) {

	HTML::instance()->open(
		'dimas-section__text',
		array(
			'tag'  => 'p',
			'attr' => array(
				'class' => 'dimas-section__text has-color-subtitle mb-5 mb-md-8',
			),
		)
	);

	the_excerpt();

	HTML::instance()->close( 'dimas-section__text' );

}

HTML::instance()->open(
	'section__list',
	array(
		'tag'  => 'ul',
		'attr' => array(
			'class' => 'dimas-section__list-item mb-0',
		),
	)
);

foreach ( $arr_info_project as $key => $value ) {

	HTML::instance()->open(
		'section__item',
		array(
			'tag'  => 'li',
			'attr' => array(
				'class' => 'dimas-section__item',
			),
		)
	);

	HTML::instance()->open(
		'section__item--label',
		array(
			'tag'  => 'h6',
			'attr' => array(
				'class' => 'dimas-section__item--label has-color-white label-content mb-2 text-uppercase',
			),
		)
	);

	echo esc_html( $value['label'] );

	HTML::instance()->close( 'section__item--label' );

	HTML::instance()->open(
		'section__item--text',
		array(
			'tag'  => 'p',
			'attr' => array(
				'class' => ( array_key_last( $arr_info_project ) === $key ) ? 'dimas-section__item--text has-color-subtitle mb-0' : 'dimas-section__item--text has-color-subtitle mb-4 pb-4',
			),
		)
	);

	echo esc_html( $value['text'] );

	HTML::instance()->close( 'section__item--text' );

	HTML::instance()->close( 'section__item' );

}

HTML::instance()->close( 'section__list' );

HTML::instance()->close( 'swiper-slide-1' );
