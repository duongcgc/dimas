<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Dimas
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php do_action( 'dimas_before_site' ) ?>
<div id="page" class="site">
	<?php do_action('dimas_before_open_site_header'); ?>
	<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) {?>
		<header id="site-header" class="<?php Header::classes('site-header'); ?>">
			<?php do_action('dimas_after_open_site_header'); ?>
			<?php do_action('dimas_before_close_site_header'); ?>
		</header>
	<?php } ?>
	<?php do_action('dimas_after_close_site_header'); ?>

	<?php
	HTML::instance()->open( 'site_content', [
		'tag'     => 'div',
		'attr'    => [
			'id'    => 'content',
			'class' => 'site-content'
		],
		'actions' => true,
	] );
	?>