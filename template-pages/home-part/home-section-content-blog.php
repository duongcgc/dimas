<?php
/**
 *
 *
 * Loads content section blog of home page.
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

// Args for blog.
$args_blog = array(
	'post_type'           => 'post',
	'post_status'         => 'publish',
	'posts_per_page'      => 5,
	'ignore_sticky_posts' => 1,
);
// Blog Featured.
$blog_featured = new WP_Query( $args_blog );


HTML::instance()->open(
	'dimas_grid_wrap',
	array(
		'attr' => array(
			'class' => 'dimas-grid-wrap d-grid',
		),
	)
);

HTML::instance()->open(
	'article_all_blog',
	array(
		'tag'  => 'article',
		'attr' => array(
			'class' => 'dimas-section__item dimas-section__item--button pb-3 pb-md-0',
		),
	),
);

HTML::instance()->self_close_tag(
	'dimas_title',
	array(
		'tag'  => 'h2',
		'attr' => array(
			'class' => 'dimas-title label-banner hg60 has-color-white pb-6 mb-0',
		),
	),
	'Blog',
);

HTML::instance()->open(
	'button_all_blog',
	array(
		'tag'  => 'a',
		'attr' => array(
			'class' => 'dimas-btn label-content has-color-white has-bg-main',
			'href'  => get_category_link( get_option( 'default_category' ) ),
		),
	)
);

echo 'all post';

Template_Tag::dimas_icon(
	null,
	'ui',
	'dimas_arrow',
);

HTML::instance()->close( 'button_all_blog' );

HTML::instance()->close( 'article_all_blog' );

if ( $blog_featured->have_posts() ) {

	while ( $blog_featured->have_posts() ) :

		$blog_featured->the_post();

		get_template_part( 'template-parts/content/content' );

	endwhile;

} else {

	HTML::instance()->self_close_tag(
		'empty_post',
		array(
			'tag'  => 'h3',
			'attr' => array(
				'class' => 'empty_post',
			),
		),
		'Chưa có bài viết để hiển thị.'
	);

}

wp_reset_postdata();
wp_reset_query();

HTML::instance()->close( 'dimas_grid_wrap' );
