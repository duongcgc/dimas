<?php
/**
 *
 *
 * Loads content of single project swiper left item 2.
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

$section_title = 'Solution';
$arr_solution  = array(
	array(
		'text' => 'Donec a iaculis odio. Mauris tincidunt, ligula ut congue tempor, augue nibh condimentum ipsum, ullamcorper congue felis nibh egestas risus. Aliquam sed pretium dui, in malesuada velit. Pellentesque at enim placerat risus.',
	),
	array(
		'img'  => array(
			'id'   => 171,
			'size' => 'full',
			'attr' => array(
				'class' => 'dimas-section__img col-3 mt-2 pe-3 pe-md-4',
				'alt'   => 'Project arrow,',
			),
		),
		'text' => 'Cras vel hendrerit nisl. In magna quam, sodales eget vestibulum accumsan, gravida ac velit. Quisque accumsan pretium orci, quis facilisis ex elementum sed. Curabitur porta scelerisque tincidunt. Nunc velit magna, condimentum in metus sed, rutrum ultricies
		nunc. Nulla pretium imperdiet dolor sit amet imperdiet. Maecenas accumsan fringilla lectus id tempor. Phasellus a convallis sapien. Suspendisse scelerisque, urna vitae aliquam tristique, mauris tortor
		blandit ex, eu efficitur ex sapien a sem. Praesent ut vehicula mauris. Proin fringilla ornare sagittis.',
	),
);


HTML::instance()->open(
	'swiper_slide_2',
	array(
		'attr' => array(
			'class' => 'swiper-slide',
		),
	)
);

HTML::instance()->open(
	'dimas_section__name',
	array(
		'tag'  => 'h2',
		'attr' => array(
			'class' => 'dimas-section__name label-banner mb-5 has-color-white',
		),
	)
);

echo esc_html( $section_title );

HTML::instance()->close( 'dimas_section__name' );

foreach ( $arr_solution as $key => $value ) {

	if ( ! isset( $value['img'] ) ) {
		HTML::instance()->open(
			'dimas_section__text',
			array(
				'tag'  => 'p',
				'attr' => array(
					'class' => 'dimas-section__text has-color-subtitle mb-0 mb-md-2 col-9',
				),
			)
		);

		echo esc_html( $value['text'] );

		HTML::instance()->close( 'dimas_section__text' );
	} else {

		HTML::instance()->open(
			'section__wrap',
			array(
				'attr' => array(
					'class' => 'dimas-section__wrap d-flex flex-wrap align-items-start',
				),
			)
		);

		echo wp_get_attachment_image( $value['img']['id'], $value['img']['size'], false, $value['img']['attr'] );

		HTML::instance()->open(
			'dimas_section__text',
			array(
				'tag'  => 'p',
				'attr' => array(
					'class' => 'dimas-section__text has-color-subtitle mt-5 mt-md-7 mb-0 col-9',
				),
			)
		);

		echo esc_html( $value['text'] );

		HTML::instance()->close( 'dimas_section__text' );

		HTML::instance()->close( 'section__wrap' );
	}
}

HTML::instance()->close( 'swiper_slide_2' );
