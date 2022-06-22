<?php
/**
 *
 *
 * Loads content of single project swiper left item 4.
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

$section_title       = 'Final result';
$section_description = 'Cras vel hendrerit nisl. In magna quam, sodales eget vestibulum accumsan, gravida ac velit. Quisque accumsan pretium orci, quis facilisis ex elementum sed. Curabitur porta scelerisque tincidunt. Nunc velit magna, condimentum in metus sed, rutrum ultricies
nunc. Nulla pretium imperdiet dolor sit amet imperdiet. Maecenas accumsan fringilla lectus id tempor. Phasellus a convallis sapien. Suspendisse scelerisque, urna vitae aliquam tristique, mauris tortor blandit
ex, eu efficitur ex sapien a sem. Praesent ut vehicula mauris. Proin fringilla ornare sagittis.';
$img_heart           = array(
	'id'   => 173,
	'size' => 'full',
	'attr' => array(
		'class' => 'thanks__icon heart-img me-3',
		'alt'   => 'Icon heart',
	),
);

HTML::instance()->open(
	'swiper_slide_4',
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

HTML::instance()->open(
	'dimas_section__text',
	array(
		'tag'  => 'p',
		'attr' => array(
			'class' => 'dimas-section__text has-color-subtitle mb-32',
		),
	)
);

echo esc_html( $section_description );

HTML::instance()->close( 'dimas_section__text' );

HTML::instance()->open(
	'thanks_wrap',
	array(
		'attr' => array(
			'class' => 'thanks thanks-wrap mb-6 mb-xxl-96 d-flex align-items-center',
		),
	)
);

echo wp_get_attachment_image( $img_heart['id'], $img_heart['size'], false, $img_heart['attr'] );

HTML::instance()->open(
	'thanks__text',
	array(
		'tag'  => 'p',
		'attr' => array(
			'class' => 'thanks__text',
		),
	)
);

echo 'Thank for watching !';

HTML::instance()->close( 'thanks__text' );

HTML::instance()->close( 'thanks_wrap' );

get_template_part( 'template-parts/pagination/project', 'navigation' );

HTML::instance()->close( 'swiper_slide_4' );
