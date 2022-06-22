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

use \Dimas\Framework\Template_Tag;
use \Dimas\HTML;


$page_url         = get_permalink();
$facebook_url     = 'https://www.facebook.com/sharer/sharer.php?u=' . $page_url;
$twitter_url      = 'https://twitter.com/intent/tweet?url=' . $page_url;
$arr_social_share = array(
	'coppy_link'  => array(
		array(
			'id'            => 'coppy-link',
			'class'         => 'dimas-sticky-share__item coppy-link',
			'data-url-page' => $page_url,
		),
		'ui',
		'dimas_coppy_link',
	),
	'fb_share'    => array(
		array(
			'class'  => 'dimas-sticky-share__item fb-share',
			'href'   => $facebook_url,
			'target' => '_blank',
		),
		'social',
		'dimas_fb',
	),
	'tw_share'    => array(
		array(
			'class'  => 'dimas-sticky-share__item tw-share',
			'href'   => $twitter_url,
			'target' => '_blank',
		),
		'social',
		'dimas_tw',
	),
	'email_share' => array(
		array(
			'class'  => 'dimas-sticky-share__item email-share',
			'href'   => 'mailto:?subject=' . get_the_title() . '&body=' . $page_url,
			'target' => '_blank',
		),
		'ui',
		'dimas_envelope',
	),
);

HTML::instance()->open(
	'dimas_sticky_share',
	array(
		'attr' => array(
			'class' => 'dimas-sticky-share d-none d-md-flex flex-wrap align-items-center px-0',
		),
	)
);

foreach ( $arr_social_share as $key => $value ) {

	Template_Tag::dimas_icon( $value[0], $value[1], $value[2], );

}

HTML::instance()->close( 'dimas_sticky_share' );
