<?php
/**
 * Template file for displaying mobile header v1
 *
 * @package razzi
 */

?>

<?php
Dimas_HTML::instance()->open('header_mobile',[
	'attr' => [
		'class' => 'header-mobile',
	],
	'actions' => false,
]);
?>

<?php do_action( 'razzi_header_mobile_content' ); ?>

<?php Dimas_HTML::instance()->close('header_mobile');  ?>
