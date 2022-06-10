<?php
/**
 * The header.
 *
 * This is the template that displays all of the <head> section and everything up until main.
 *
 * @link https://www.gcosoftware.vn/
 *
 * @package GCO
 * @subpackage Dimas
 * @since Dimas 1.0
 */

?>
<!doctype html>
<html <?php language_attributes(); ?> <?php \Dimas\Temp_Funs::dimas_the_html_classes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head(); ?>
</head>

<body data-plugin-page-transition class="animsition pp-viewing-Home <?php body_class(); ?>">
	<?php wp_body_open(); ?>
	<div class="preloader">
		<div class="spinner">
			<div class="double-bounce1"></div>
			<div class="double-bounce2"></div>
		</div>
	</div>
	<div class="body">
		<?php get_template_part( 'template-parts/header/site-header' ); ?>
