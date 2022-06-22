<?php
/**
 *
 *
 * Loads content of single project swiper left item 3.
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

$att_id   = 166;
$att_size = 'full';
$attr_img = array(
	'class' => 'slider-img',
	'alt'   => 'Slider project image',
);

$arr_pointer = array(
	array(
		'data-left'  => '56%',
		'data-top'   => '38%',
		'data-title' => 'The symbol of Museum',
		'data-text'  => 'Cras vel hendrerit nisl. In magna quam, sodales eget vestibulum accumsan, gravida ac velit. Quisque accumsan pretium orci, quis facilisis ex elementum sed. Curabitur porta scelerisque tincidunt. Nunc velit magna, condimentum in metus sed, rutrum ultricies
        nunc.',
	),
	array(
		'data-left'  => '57%',
		'data-top'   => '63%',
		'data-title' => 'The symbol of Museum',
		'data-text'  => 'Cras vel hendrerit nisl. In magna quam, sodales eget vestibulum accumsan, gravida ac velit. Quisque accumsan pretium orci, quis facilisis ex elementum sed. Curabitur porta scelerisque tincidunt. Nunc velit magna, condimentum in metus sed, rutrum ultricies
        nunc.',
	),
	array(
		'data-left'  => '44%',
		'data-top'   => '48%',
		'data-title' => 'The symbol of Museum',
		'data-text'  => 'Cras vel hendrerit nisl. In magna quam, sodales eget vestibulum accumsan, gravida ac velit. Quisque accumsan pretium orci, quis facilisis ex elementum sed. Curabitur porta scelerisque tincidunt. Nunc velit magna, condimentum in metus sed, rutrum ultricies
        nunc.',
	),
	array(
		'data-left'  => '33%',
		'data-top'   => '72%',
		'data-title' => 'The symbol of Museum',
		'data-text'  => 'Cras vel hendrerit nisl. In magna quam, sodales eget vestibulum accumsan, gravida ac velit. Quisque accumsan pretium orci, quis facilisis ex elementum sed. Curabitur porta scelerisque tincidunt. Nunc velit magna, condimentum in metus sed, rutrum ultricies
        nunc.',
	),
	array(
		'data-left'  => '23%',
		'data-top'   => '32%',
		'data-title' => 'The symbol of Museum',
		'data-text'  => 'Cras vel hendrerit nisl. In magna quam, sodales eget vestibulum accumsan, gravida ac velit. Quisque accumsan pretium orci, quis facilisis ex elementum sed. Curabitur porta scelerisque tincidunt. Nunc velit magna, condimentum in metus sed, rutrum ultricies
        nunc.',
	),
);

HTML::instance()->open(
	'swiper_slide_3',
	array(
		'attr' => array(
			'class' => 'swiper-slide',
		),
	)
);

echo wp_get_attachment_image( $att_id, $att_size, $attr_img );

foreach ( $arr_pointer as $key => $val ) {

	HTML::instance()->open(
		'dimas_project_pointer',
		array(
			'attr' => array(
				'class'      => ( array_key_first( $arr_pointer ) === $key ) ? 'dimas-project-pointer active' : 'dimas-project-pointer',
				'data-left'  => $val['data-left'],
				'data-top'   => $val['data-top'],
				'data-title' => $val['data-title'],
				'data-text'  => $val['data-text'],
			),
		)
	);

	HTML::instance()->open(
		'dimas_project_pointer__description',
		array(
			'attr' => array(
				'class' => 'dimas-project-pointer__description',
			),
		)
	);

	HTML::instance()->open(
		'dimas_project_pointer__description--title',
		array(
			'tag'  => 'h3',
			'attr' => array(
				'class' => 'dimas-project-pointer__description--title has-color-white',
			),
		)
	);

	HTML::instance()->close( 'dimas_project_pointer__description--title' );

	HTML::instance()->open(
		'dimas_project_pointer__description--text',
		array(
			'tag'  => 'p',
			'attr' => array(
				'class' => 'dimas-project-pointer__description--text has-color-subtitle mb-0',
			),
		)
	);

	HTML::instance()->close( 'dimas_project_pointer__description--text' );

	HTML::instance()->close( 'dimas_project_pointer__description' );

	HTML::instance()->close( 'dimas_project_pointer' );

}

HTML::instance()->close( 'swiper_slide_3' );
