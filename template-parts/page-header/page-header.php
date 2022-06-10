<?php
/**
 * Page Header
 */

	DM_HTML::instance()->open('page_header',[
		'attr' => [
			'id'    => 'page-header',
			'class' => 'page-header',
		],
		'actions' => 'after',
	]);
?>

<?php do_action( 'razzi_page_header_content_item' ); ?>

<?php DM_HTML::instance()->close('page_header');  ?>
