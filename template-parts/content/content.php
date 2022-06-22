<?php
/**
 *
 *
 * Loads content loop post.
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
use \Dimas\Framework\Template_Tag;

HTML::instance()->open(
	'item__blog',
	array(
		'tag'  => 'article',
		'attr' => array(
			'class' => 'dimas-section__item dimas-section__item--blog dimas-post grid-item grid-sizer',
		),
	)
);

HTML::instance()->open(
	'post__thumbnail',
	array(
		'attr' => array(
			'class' => 'dimas-post__thumbnail dimas-post__thumbnail--wrap',
		),
	)
);

Template_Tag::dimas_post_link_open();

the_post_thumbnail( 'post-thumbnail', array( 'class' => 'dimas-post__thumbnail dimas-post__thumbnail--img' ) );

HTML::instance()->open(
	'arrow_wrap',
	array(
		'attr' => array(
			'class' => 'dimas-post__thumbnail dimas-post__thumbnail--arrow-wrap',
		),
	)
);

Template_Tag::dimas_icon(
	null,
	'ui',
	'dimas_arrow',
);

HTML::instance()->close( 'arrow_wrap' );

Template_Tag::dimas_post_link_close();

HTML::instance()->close( 'post__thumbnail' );

HTML::instance()->open(
	'post__content',
	array(
		'attr' => array(
			'class' => 'dimas-post__content dimas-post__content--wrap',
		),
	)
);

Template_Tag::dimas_post_date();

Template_Tag::dimas_post_title();

Template_Tag::dimas_post_excerpt();

HTML::instance()->close( 'post__content' );

HTML::instance()->close( 'item__blog' );
