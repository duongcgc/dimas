<?php
/**
 *
 *
 * Loads content of single project.
 *
 * @link https://www.gcosoftware.vn/
 *
 * @package GCO
 * @subpackage Dimas
 * @since Dimas 1.0
 */

?>
<?php
while ( have_posts() ) :
	the_post();
	$current_id         = get_the_id();
	$post_thumbnail_url = get_the_post_thumbnail_url( $current_id, 'full' );
	$post_title         = get_the_title( $current_id );
	$post_excerpt       = get_the_excerpt( $current_id );
	$project_prev_url   = get_previous_post_link( '%link', '%title', false, '', 'branch-project' );
	$project_next_url   = get_next_post_link( '%link', '%title', false, '', 'branch-project' );
	?>
<main class="dimas-main">
	<div class="dimas-projects">
		<div class="dimas-project">
			<div class="dimas-project__vertical-align">
				<div id="left-slider" class="col-xl-8 overflow-hidden position-relative">
					<div class="swiper">
						<div class="swiper-wrapper">
							<div class="swiper-slide">
								<img class="slider-img" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/projects/bg-projects-1.png" alt="Slider project image">
							</div>
							<div class="swiper-slide">
								<img class="slider-img" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/projects/bg-project-2.png" alt="Slider project image">
							</div>
							<div class="swiper-slide">
								<img class="slider-img" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/projects/bg-project-3.png" alt="Slider project image">
								<div class="dimas-project-pointer active" data-left="56%" data-top="38%" data-title="The symbol of Museum" data-text="Cras vel hendrerit nisl. In magna quam, sodales eget vestibulum accumsan, gravida ac velit. Quisque accumsan pretium orci, quis facilisis ex elementum sed. Curabitur porta scelerisque tincidunt. Nunc velit magna, condimentum in metus sed, rutrum ultricies
													nunc.">
									<div class="dimas-project-pointer__description">
										<h3 class="dimas-project-pointer__description--title has-color-white">
										</h3>
										<p class="dimas-project-pointer__description--text has-color-subtitle mb-0">
										</p>
									</div>
								</div>
								<div class="dimas-project-pointer" data-left="57%" data-top="63%" data-title="The symbol of Museum" data-text="Cras vel hendrerit nisl. In magna quam, sodales eget vestibulum accumsan, gravida ac velit. Quisque accumsan pretium orci, quis facilisis ex elementum sed. Curabitur porta scelerisque tincidunt. Nunc velit magna, condimentum in metus sed, rutrum ultricies
													nunc.">
									<div class="dimas-project-pointer__description">
										<h3 class="dimas-project-pointer__description--title has-color-white">
											The symbol of Museum
										</h3>
										<p class="dimas-project-pointer__description--text has-color-subtitle mb-0">
											Cras vel hendrerit nisl. In magna quam, sodales eget vestibulum accumsan, gravida ac velit. Quisque accumsan pretium orci, quis facilisis ex elementum sed. Curabitur porta scelerisque tincidunt. Nunc velit magna, condimentum in metus sed, rutrum ultricies
											nunc.
										</p>
									</div>
								</div>
								<div class="dimas-project-pointer" data-left="44%" data-top="48%" data-title="The symbol of Museum" data-text="Cras vel hendrerit nisl. In magna quam, sodales eget vestibulum accumsan, gravida ac velit. Quisque accumsan pretium orci, quis facilisis ex elementum sed. Curabitur porta scelerisque tincidunt. Nunc velit magna, condimentum in metus sed, rutrum ultricies
													nunc.">
									<div class="dimas-project-pointer__description">
										<h3 class="dimas-project-pointer__description--title has-color-white">
										</h3>
										<p class="dimas-project-pointer__description--text has-color-subtitle mb-0">
										</p>
									</div>
								</div>
								<div class="dimas-project-pointer" data-left="33%" data-top="72%" data-title="The symbol of Museum" data-text="Cras vel hendrerit nisl. In magna quam, sodales eget vestibulum accumsan, gravida ac velit. Quisque accumsan pretium orci, quis facilisis ex elementum sed. Curabitur porta scelerisque tincidunt. Nunc velit magna, condimentum in metus sed, rutrum ultricies
													nunc.">
									<div class="dimas-project-pointer__description">
										<h3 class="dimas-project-pointer__description--title has-color-white">
										</h3>
										<p class="dimas-project-pointer__description--text has-color-subtitle mb-0">
										</p>
									</div>
								</div>
								<div class="dimas-project-pointer" data-left="23%" data-top="32%" data-title="The symbol of Museum" data-text="Cras vel hendrerit nisl. In magna quam, sodales eget vestibulum accumsan, gravida ac velit. Quisque accumsan pretium orci, quis facilisis ex elementum sed. Curabitur porta scelerisque tincidunt. Nunc velit magna, condimentum in metus sed, rutrum ultricies
													nunc.">
									<div class="dimas-project-pointer__description">
										<h3 class="dimas-project-pointer__description--title has-color-white">
										</h3>
										<p class="dimas-project-pointer__description--text has-color-subtitle mb-0">
										</p>
									</div>
								</div>
							</div>
							<div class="swiper-slide">
								<video poster="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/projects/bg-projects-4.png" class="slider-video" loop>
									<source src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/videos/dimas-demo-video.mp4">
								</video>
								<div class="dimas-btn play-video">
									<svg width="24" height="28" viewBox="0 0 24 28" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M1 1.87564L22 14L1 26.1244L1 1.87564Z" stroke="currentColor" stroke-width="2" />
									</svg>
								</div>
							</div>
						</div>
						<div class="swiper-pagination"></div>
						<div class="swiper-button-prev">
							<svg width="20" height="36" viewBox="0 0 20 36" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M18.333 34L2.33301 18L18.333 2" stroke="currentColor" stroke-width="2" stroke-linecap="square" />
							</svg>
						</div>
						<div class="swiper-button-next">
							<svg width="20" height="36" viewBox="0 0 20 36" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M1.66699 34L17.667 18L1.66699 2" stroke="currentColor" stroke-width="2" stroke-linecap="square" />
							</svg>
						</div>
					</div>
				</div>
				<div id="right-slider" class="col-xl-4 position-relative">
					<div class="scroll-wrap">
						<div class="swiper">
							<div class="swiper-wrapper">
								<div class="swiper-slide">
									<h2 class="dimas-section__name label-banner mb-5 has-color-white">
										<?php echo esc_html( $post_title ); ?>
									</h2>
									<p class="dimas-section__text has-color-subtitle mb-5 mb-md-8">
										Donec a iaculis odio. Mauris tincidunt, ligula ut congue tempor, augue nibh condimentum ipsum, ullamcorper congue felis nibh egestas risus. Aliquam sed pretium dui, in malesuada velit. Pellentesque at enim placerat risus.
									</p>
									<ul class="dimas-section__list-item mb-0">
										<li class="dimas-section__item">
											<h6 class="dimas-section__item--label has-color-white label-content mb-2 text-uppercase">
												Services
											</h6>
											<p class="dimas-section__item--text has-color-subtitle mb-4 pb-4">
												Design, Branding, Artwork
											</p>
										</li>
										<li class="dimas-section__item">
											<h6 class="dimas-section__item--label has-color-white label-content mb-2 text-uppercase">
												Manager
											</h6>
											<p class="dimas-section__item--text has-color-subtitle mb-4 pb-4">
												John Doe
											</p>
										</li>
										<li class="dimas-section__item">
											<h6 class="dimas-section__item--label has-color-white label-content mb-2 text-uppercase">
												Date
											</h6>
											<p class="dimas-section__item--text has-color-subtitle mb-4 pb-4">
												January 23, 2022
											</p>
										</li>
										<li class="dimas-section__item">
											<h6 class="dimas-section__item--label has-color-white label-content mb-2 text-uppercase">
												Client
											</h6>
											<p class="dimas-section__item--text has-color-subtitle mb-0">
												ABC Group
											</p>
										</li>
									</ul>
								</div>
								<div class="swiper-slide">
									<h2 class="dimas-section__name label-banner mb-5 has-color-white">
										Solution
									</h2>
									<p class="dimas-section__text has-color-subtitle mb-0 mb-md-2 col-9">
										Donec a iaculis odio. Mauris tincidunt, ligula ut congue tempor, augue nibh condimentum ipsum, ullamcorper congue felis nibh egestas risus. Aliquam sed pretium dui, in malesuada velit. Pellentesque at enim placerat risus.
									</p>
									<div class="dimas-section__wrap d-flex flex-wrap align-items-start">
										<img class="dimas-section__img col-3 mt-2 pe-3 pe-md-4" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/projects/project-arrow.png" alt="Project arrow">
										<p class="dimas-section__text has-color-subtitle mt-5 mt-md-7 mb-0 col-9">
											Cras vel hendrerit nisl. In magna quam, sodales eget vestibulum accumsan, gravida ac velit. Quisque accumsan pretium orci, quis facilisis ex elementum sed. Curabitur porta scelerisque tincidunt. Nunc velit magna, condimentum in metus sed, rutrum ultricies
											nunc. Nulla pretium imperdiet dolor sit amet imperdiet. Maecenas accumsan fringilla lectus id tempor. Phasellus a convallis sapien. Suspendisse scelerisque, urna vitae aliquam tristique, mauris tortor
											blandit ex, eu efficitur ex sapien a sem. Praesent ut vehicula mauris. Proin fringilla ornare sagittis.
										</p>
									</div>
								</div>
								<div class="swiper-slide">
									<h2 class="dimas-section__name label-banner mb-5 has-color-white">
										Ideas...
									</h2>
									<p class="dimas-section__text has-color-subtitle mb-5 mb-md-8">
										Donec a iaculis odio. Mauris tincidunt, ligula ut congue tempor, augue nibh condimentum ipsum, ullamcorper congue felis nibh egestas risus. Aliquam sed pretium dui, in malesuada velit. Pellentesque at enim placerat risus.
									</p>
									<div class="quote quote-wrap d-flex align-items-start">
										<img class="quote__img me-8 me-xl-5 me-xxl-8" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/icon-quote.png" alt="Icon quote">
										<div class="quote__content">
											<p class="quote__text has-color-white mb-0">
												In ullamcorper ac erat ac egestas. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.
											</p>
										</div>
									</div>
								</div>
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
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
</main>
	<?php
endwhile;
