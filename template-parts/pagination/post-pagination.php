<?php
/**
 *
 *
 * Loads single post pagination.
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

global $wp_query;
$max_page = $wp_query->max_num_pages;

if ( $max_page > 1 ) {

	HTML::instance()->open(
		'dimas_pagination',
		array(
			'attr' => array(
				'class' => 'dimas-pagination pt-5 pt-lg-96',
			),
		)
	);

	Template_Tag::dimas_post_pagination();

	HTML::instance()->close( 'dimas_pagination' );

}
