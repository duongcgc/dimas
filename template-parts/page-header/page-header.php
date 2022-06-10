<?php
/**
 * Page Header
 */

	Dimas_HTML::instance()->open('page_header',[
		'attr' => [
			'id'    => 'page-header',
			'class' => 'page-header',
		],
		'actions' => 'after',
	]);
?>

<?php do_action( 'razzi_page_header_content_item' ); ?>

<?php Dimas_HTML::instance()->close('page_header');  ?>
