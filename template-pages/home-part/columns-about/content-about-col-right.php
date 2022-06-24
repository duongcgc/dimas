<?php
/**
 *
 * Loads section about col right.
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

use \Dimas\HTML;

$arr_about_item = array(
	array(
		'img'     => array(
			'id_img' => 181,
			'attr'   => array(
				'class' => 'dimas-about__image-counter',
				'alt' => 'Icon Photoshop',
			),
		),
		'counter' => array(
			'final-value'     => 95,
			'animation-speed' => 1000,
			'title'           => 'Photoshop',
			'counter-text'    => '95',
		),
	),
	array(
		'img'     => array(
			'id_img' => 179,
			'attr'   => array(
				'class' => 'dimas-about__image-counter',
				'alt' => 'Icon Figma',
			),
		),
		'counter' => array(
			'final-value'     => 80,
			'animation-speed' => 1000,
			'title'           => 'Figma',
			'counter-text'    => '80',
		),
	),
	array(
		'img'     => array(
			'id_img' => 182,
			'attr'   => array(
				'class' => 'dimas-about__image-counter',
				'alt' => 'Icon Sketch',
			),
		),
		'counter' => array(
			'final-value'     => 90,
			'animation-speed' => 1000,
			'title'           => 'Sketch',
			'counter-text'    => '90',
		),
	),
);

HTML::instance()->open(
	'section_home_col_2',
	array(
		'attr' => array(
			'class' => 'dimas-about col-xxl-6 col-lg-5 offset-lg-1',
		),
	)
);


foreach ( $arr_about_item as $key => $item ) {

	HTML::instance()->open(
		'about__item',
		array(
			'attr' => array(
				'class' => ( array_key_first( $arr_about_item ) == $key ) ? 'dimas-about__item pt-1' : 'dimas-about__item',
			),
		)
	);

	echo wp_get_attachment_image( $item['img']['id_img'], 'full', false, $item['img']['attr'] );

	HTML::instance()->open(
		'dimas_progress_bar',
		array(
			'attr' => array(
				'class' => 'dimas-progress-bar',
				'data-final-value' => $item['counter']['final-value'],
				'data-animation-speed' => $item['counter']['animation-speed'],
			),
		)
	);

	HTML::instance()->open(
		'dimas_progress_bar_title',
		array(
			'tag'  => 'h6',
			'attr' => array(
				'class' => 'dimas-progress-bar__title has-color-white label-content',
			),
		)
	);

	echo esc_html( $item['counter']['title'] );

	HTML::instance()->open(
		'dimas_progress_bar_counter',
		array(
			'tag'  => 'span',
			'attr' => array(
				'class' => 'counter',
			),
		)
	);

	echo esc_html( $item['counter']['counter-text'] );

	HTML::instance()->close( 'dimas_progress_bar_counter' );

	HTML::instance()->close( 'dimas_progress_bar_title' );

	HTML::instance()->open(
		'dimas_progress_bar__bar',
		array(
			'attr' => array(
				'class' => 'dimas-progress-bar__bar',
			),
		)
	);

	HTML::empty_tag( 'span' );

	HTML::instance()->close( 'dimas_progress_bar__bar' );

	HTML::instance()->close( 'dimas_progress_bar' );

	HTML::instance()->close( 'about__item' );
}


HTML::instance()->open( 'section_home_col_2' );
