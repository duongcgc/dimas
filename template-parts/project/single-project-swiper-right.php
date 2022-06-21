<?php
/**
 *
 *
 * Loads content of single project swiper right.
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

$project_prev_url   = get_previous_post_link( '%link', '%title', false, '', 'branch-project' );
$project_next_url   = get_next_post_link( '%link', '%title', false, '', 'branch-project' );

HTML::instance()->open(
	'right-slider',
	array(
		'attr' => array(
			'id'    => 'right-slider',
			'class' => 'col-xl-4 position-relative',
		),
	)
);

HTML::instance()->open(
	'scroll-wrap',
	array(
		'attr' => array(
			'class' => 'scroll-wrap',
		),
	)
);

HTML::instance()->open(
	'swiper',
	array(
		'attr' => array(
			'class' => 'swiper',
		),
	)
);

HTML::instance()->open(
	'swiper-wrapper',
	array(
		'attr' => array(
			'class' => 'swiper-wrapper',
		),
	)
);

get_template_part( 'template-parts/project/single-project-swiper-right/swiper-right-item-1' );

get_template_part( 'template-parts/project/single-project-swiper-right/swiper-right-item-2' );

get_template_part( 'template-parts/project/single-project-swiper-right/swiper-right-item-3' );

?>
								<div class="swiper-slide">
									<h2 class="dimas-section__name label-banner mb-5 has-color-white">
										Final result
									</h2>
									<p class="dimas-section__text has-color-subtitle mb-32">
										Cras vel hendrerit nisl. In magna quam, sodales eget vestibulum accumsan, gravida ac velit. Quisque accumsan pretium orci, quis facilisis ex elementum sed. Curabitur porta scelerisque tincidunt. Nunc velit magna, condimentum in metus sed, rutrum ultricies
										nunc. Nulla pretium imperdiet dolor sit amet imperdiet. Maecenas accumsan fringilla lectus id tempor. Phasellus a convallis sapien. Suspendisse scelerisque, urna vitae aliquam tristique, mauris tortor blandit
										ex, eu efficitur ex sapien a sem. Praesent ut vehicula mauris. Proin fringilla ornare sagittis.
									</p>
									<div class="thanks thanks-wrap mb-6 mb-xxl-96 d-flex align-items-center">
										<img class="thanks__icon heart-img me-3" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/single-project/icon-like-projects.png" alt="Icon heart">
										<p class="thanks__text">
											Thank for watching!
										</p>
									</div>
									<div class="projects-pagination pb-32">
										<div class="projects-pagination__prev" style="<?php echo ( '' == $project_prev_url ) ? 'visibility:hidden' : ''; ?>">
											<?php
											if ( '' != $project_prev_url ) :
												previous_post_link( '%link', '%title', false, '', 'branch-project' );
											endif;
											?>
										</div>
										<div class="projects-pagination__next" style="<?php echo ( '' == $project_next_url ) ? 'visibility:hidden' : ''; ?>">
											<?php
											if ( '' != $project_next_url ) :
												next_post_link( '%link', '%title', false, '', 'branch-project' );
											endif;
											?>
										</div>
									</div>
								</div>


<?php

HTML::instance()->close( 'swiper-wrapper' );

HTML::instance()->close( 'swiper' );

HTML::instance()->close( 'scroll-wrap' );

HTML::instance()->close( 'right-slider' );?>
