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

$data = array();
if ( null != $args ) {
	$data = $args;
}

$skills = get_posts(
	array(
		'post_type' => 'skill',
		'nopaging'  => true,
	),
);

if ( count( $skills ) > 0 ) {
	foreach ( $skills as $key => $skill ) {
		$skill_id         = $skill->ID;
		$featured_img_id  = get_post_thumbnail_id( $skill_id );
		$featured_img_url = wp_get_attachment_url( $featured_img_id );
		$featured_img_alt = get_post_meta( $featured_img_id, '_wp_attachment_image_alt', true );
		$skill_progress   = get_post_meta( $skill_id, 'skill_progress', true );
		$arr_about_item[] = array(
			'img'     => array(
				'attr' => array(
					'class' => 'dimas-about__image-counter',
					'alt'   => $featured_img_alt,
					'src'   => $featured_img_url,
				),
			),
			'counter' => array(
				'final-value'     => $skill_progress,
				'animation-speed' => ( $data['col_right']['animation_speed'] ) ? $data['col_right']['animation_speed'] : 1000,
				'title'           => $skill->post_title,
				'counter-text'    => $skill_progress,
			),
		);
	}
} else {
	$arr_about_item = array(
		array(
			'img'     => array(
				'attr' => array(
					'class' => 'dimas-about__image-counter',
					'alt'   => 'Icon Photoshop',
					'src'   => DIMAS_ASSETS_URI . '/images/about/icon-photoshop.png',
				),
			),
			'counter' => array(
				'final-value'     => 95,
				'animation-speed' => ( $data['col_right']['animation_speed'] ) ? $data['col_right']['animation_speed'] : 1000,
				'title'           => 'Photoshop',
				'counter-text'    => '95',
			),
		),
		array(
			'img'     => array(
				'attr' => array(
					'class' => 'dimas-about__image-counter',
					'alt'   => 'Icon Figma',
					'src'   => DIMAS_ASSETS_URI . '/images/about/icon-figma.png',
				),
			),
			'counter' => array(
				'final-value'     => 80,
				'animation-speed' => ( $data['col_right']['animation_speed'] ) ? $data['col_right']['animation_speed'] : 1000,
				'title'           => 'Figma',
				'counter-text'    => '80',
			),
		),
		array(
			'img'     => array(
				'attr' => array(
					'class' => 'dimas-about__image-counter',
					'alt'   => 'Icon Sketch',
					'src'   => DIMAS_ASSETS_URI . '/images/about/icon-sketch.png',
				),
			),
			'counter' => array(
				'final-value'     => 90,
				'animation-speed' => ( $data['col_right']['animation_speed'] ) ? $data['col_right']['animation_speed'] : 1000,
				'title'           => 'Sketch',
				'counter-text'    => '90',
			),
		),
	);
}

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

	HTML::instance()->open(
		'skill_icon' . $key,
		array(
			'tag'  => 'img',
			'attr' => $item['img']['attr'],
		),
	);

	HTML::instance()->open(
		'dimas_progress_bar',
		array(
			'attr' => array(
				'class'                => 'dimas-progress-bar',
				'data-final-value'     => $item['counter']['final-value'],
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
