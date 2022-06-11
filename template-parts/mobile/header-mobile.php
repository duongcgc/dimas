<?php
/**
 * Template file for displaying mobile header v1
 *
 * @package razzi
 */

?>

<?php
HTML::instance()->open('header_mobile',[
	'attr' => [
		'class' => 'header-mobile',
	],
	'actions' => false,
]);
?>

<?php do_action( 'razzi_header_mobile_content' ); ?>

<?php HTML::instance()->close('header_mobile');  ?>
