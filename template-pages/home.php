<?php
/**
 *
 * Display home page.
 *
 * @link https://www.gcosoftware.vn/
 *
 * Template Name: Home Page
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php

get_header();

// Args for blog.
$args_blog = array(
	'post_type'           => 'post',
	'post_status'         => 'publish',
	'posts_per_page'      => 5,
	'ignore_sticky_posts' => 1,
);
// Blog Featured.
$blog_featured = get_posts( $args_blog );

// Args for project.
$args_project = array(
	'post_type'           => 'project',
	'post_status'         => 'publish',
	'posts_per_page'      => 6,
	'ignore_sticky_posts' => 1,
);
// Project Featured.
$project_featured = get_posts( $args_project );
?>
		<main class="dimas-main">
			<div class="dimas-fullpage-slider" data-loop-top="" data-loop-bottom="" data-speed="800">
				
				<section class="dimas-section pp-scrollable" data-anchor="Home" style="background-image: url('<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/home/bg-home.png');">
					<div class="dimas-section__vertical-align">
						<div class="dimas-section__content dimas-section__content--home">
							<div class="container">
								<div class="row">
									<div class="col-sm-6 col-md-9 col-lg-8">
										<div class="dimas-title">
											<span class=" has-color-white label-header ">Hello!</span>
											<h1 class="pt-6 mb-0 label-banner ">
												<span class="has-color-white ">I’m Dimas.</span> <br /><span class="has-color-main ">UX/UI design</span>
											</h1>
										</div>
									</div>
									<div class="d-none col-sm-6 col-md-3 col-lg-4 d-sm-flex position-relative">
										<div class="dimas-experience d-flex justify-content-center align-items-center ">
											<img class="dimas-experience__img dimas-experience__img--circle position-absolute " src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/home/home-circle.png " alt="Circle">
											<img class="dimas-experience__img dimas-experience__img--text position-absolute " src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/home/home-12.png " alt="Experience text">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>

				<section class="dimas-section pp-scrollable" data-anchor="About">
					<div class="dimas-section__vertical-align ">
						<div class="dimas-section__content dimas-section__content--about">
							<div class="container ">
								<div class="row">
									<div class="col-lg-5 pb-8 pb-lg-0">
										<div class="dimas-title">
											<h2 class="pb-9 pb-md-4 mb-6 label-banner has-after position-relative">
												<span class="has-color-white ">Work hard,</span> <br /><span class="has-color-white">play hard</span><img class="dimas-gamepad" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/about/icon-gamepad.png" alt="gamepad">
											</h2>
										</div>
										<p class="dimas-subtitle mb-0 has-color-subtitle">
											There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, which don't look even slightly believable.
										</p>
									</div>
									<div class="col-xxl-6 col-lg-5 offset-lg-1">
										<div class="dimas-about__item pt-1">
											<img class="dimas-about__experience dimas-about__experience--pts" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/about/icon-photoshop.png" alt="Icon Photoshop">
											<div class="dimas-progress-bar" data-final-value="95" data-animation-speed="1000">
												<h6 class="dimas-progress-bar__title has-color-white label-content">
													Photoshop<span class="counter">95</span>
												</h6>
												<div class="dimas-progress-bar__bar">
													<span style="width: 95%"></span>
												</div>
											</div>
										</div>
										<div class="dimas-about__item">
											<img class="dimas-about__experience dimas-about__experience--figma" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/about/icon-figma.png" alt="Icon Figma">
											<div class="dimas-progress-bar" data-final-value="80" data-animation-speed="1000">
												<h6 class="dimas-progress-bar__title has-color-white label-content">
													Figma<span class="counter">80</span>
												</h6>
												<div class="dimas-progress-bar__bar">
													<span style="width: 80%"></span>
												</div>
											</div>
										</div>
										<div class="dimas-about__item">
											<img class="dimas-about__experience dimas-about__experience--sketch" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/about/icon-sketch.png" alt="Icon Sketch">
											<div class="dimas-progress-bar" data-final-value="90" data-animation-speed="1000">
												<h6 class="dimas-progress-bar__title has-color-white label-content">
													Sketch<span class="counter">90</span>
												</h6>
												<div class="dimas-progress-bar__bar">
													<span style="width: 90%"></span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>

				<section class="dimas-section pp-scrollable" data-anchor="Projects" style="background-image: url('<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/projects/bg-projects.png');">
					<div class="dimas-section__vertical-align">
						<div class="dimas-section__content dimas-section__content--projects">
							<div class="container">
								<div class="row">
									<div class="col-lg-6">
									<?php
									$i = 1;
									foreach ( $project_featured as $project ) :
										$featured_id    = $project->ID;
										$project_link   = get_post_permalink( $featured_id );
										$project_title  = get_the_title( $featured_id );
										$project_branch = wp_get_post_terms( $featured_id, 'branch-project', array( 'fields' => 'names' ) )[0];
										if ( 4 === $i ) :
											?>
											</div><div class="col-lg-6">
										<?php endif; ?>
										<div class="dimas-projects">
											<a class="dimas-projects_url" href="<?php echo esc_url( $project_link ); ?>">
												<div class="dimas-projects__category has-color-white">
													<span class="dimas-projects__category dimas-projects__category--number">0<?php echo esc_html( $i ); ?></span>
													<h2 class="dimas-projects__category dimas-projects__category--name label-header">
														<?php echo esc_html( $project_branch ); ?>
													</h2>
												</div>
												<h2 class="label-banner hg60 has-color-white ms-lg-8">
												<?php echo esc_html( $project_title ); ?>
												</h2>
											</a>
										</div>
										<?php
										$i++;
									endforeach;
									?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>

				<section class="dimas-section pp-scrollable" data-anchor="Services">
					<div class="dimas-section__vertical-align">
						<div class="dimas-section__content dimas-section__content--services">
							<div class="dimas-tab container">
								<div class="row">
									<div class="col-lg-6 col-xxl-7 pt-lg-3 dimas-tab__header tab-header">
										<ul class="nav flex-column">
											<li class="nav-item">
												<div class="cursor-pointer dimas-tab__header dimas-tab__header--branding position-relative nav-link mb-32 mb-md-9">
													<div class="dimas-tab__header dimas-tab__header--icon-wrap mb-3 mb-md-0">
														<svg width="92" height="78" viewBox="0 0 92 78" fill="none" xmlns="http://www.w3.org/2000/svg">
															<path d="M66 32L46 2M46 77L1 32L46 77ZM46 77L91 32L46 77ZM46 77L26 32L46 77ZM46 77L66 32L46 77ZM1 32L21 2L1 32ZM1 32H26H1ZM21 2L26 32L21 2ZM21 2H46H21ZM71 2L91 32L71 2ZM71 2L66 32L71 2ZM71 2H46H71ZM91 32H66H91ZM26 32H66H26ZM26 32L46 2L26 32Z" stroke="currentColor" stroke-width="2" stroke-linecap="square"/>
														</svg>
													</div>
													<div class="dimas-title">
														<h2 class="dimas-services__name label-banner hg60 has-color-white">
															Branding
														</h2>
														<p class="dimas-subtitle mb-0 has-color-subtitle">
															There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour
														</p>
													</div>
												</div>
											</li>
											<li class="nav-item">
												<div class="cursor-pointer dimas-tab__header dimas-tab__header--design position-relative nav-link mb-32 mb-md-9">
													<div class="dimas-tab__header dimas-tab__header--icon-wrap mb-3 mb-md-0">
														<svg width="78" height="87" viewBox="0 0 78 87" fill="none" xmlns="http://www.w3.org/2000/svg">
															<path d="M1.6317 66C1.21355 69.2855 1 72.625 1 76V86L1.6317 66ZM1.6317 66C6.1692 30.343 34.797 1 76 1L71 21H56L61 31L51 41H31L41 51L36 61H16L1.6317 66Z" stroke="currentColor" stroke-width="2" stroke-linecap="square" />
														</svg>
													</div>
													<div class="dimas-title">
														<h2 class="dimas-services__name label-banner hg60 has-color-white">
															Design
														</h2>
														<p class="dimas-subtitle mb-0 has-color-subtitle">
															There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour
														</p>
													</div>
												</div>
											</li>
											<li class="nav-item">
												<div class="cursor-pointer dimas-tab__header dimas-tab__header--artwork  position-relative nav-link">
													<div class="dimas-tab__header dimas-tab__header--icon-wrap mb-3 mb-md-0">
														<svg width="82" height="77" viewBox="0 0 82 77" fill="none" xmlns="http://www.w3.org/2000/svg">
															<path d="M41 51C54.8071 51 66 39.8071 66 26C66 12.1929 54.8071 1 41 1C27.1929 1 16 12.1929 16 26C16 39.8071 27.1929 51 41 51Z" stroke="currentColor" stroke-width="2" stroke-linecap="square"/>
															<path d="M26 76C39.8071 76 51 64.8071 51 51C51 37.1929 39.8071 26 26 26C12.1929 26 1 37.1929 1 51C1 64.8071 12.1929 76 26 76Z" stroke="currentColor" stroke-width="2" stroke-linecap="square"/>
															<path d="M56 76C69.8071 76 81 64.8071 81 51C81 37.1929 69.8071 26 56 26C42.1929 26 31 37.1929 31 51C31 64.8071 42.1929 76 56 76Z" stroke="currentColor" stroke-width="2" stroke-linecap="square"/>
														</svg>
													</div>
													<div class="dimas-title">
														<h2 class="dimas-services__name label-banner hg60 has-color-white">
															Artwork
														</h2>
														<p class="dimas-subtitle mb-0 has-color-subtitle">
															There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour
														</p>
													</div>
												</div>
											</li>
										</ul>
									</div>
									<div class="col-lg-5 col-xxl-4 offset-xl-1 d-none d-lg-block dimas-tab__content tab-content d-lg-flex align-items-center d-lg-block">
										<div class="tab-pane fade show active">
											<img class="dimas-services__img dimas-services__img--branding" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/services/photo-services.png" alt="Services image">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>

				<section class="dimas-section pp-scrollable" data-anchor="Testimonials" style="background-image: url('<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/testimonials/bg-testimonials.png');">
					<div class="dimas-section__vertical-align ">
						<div class="dimas-section__content dimas-section__content--testimonials">
							<div class="container">
								<div class="row">
									<div class="col-lg-6 col-xxl-5 pb-32 pb-lg-0">
										<div class="dimas-title">
											<h2 class="pb-4 mb-5 mb-lg-6 label-banner has-after position-relative has-color-white">
												Testimonials
											</h2>
										</div>
										<p class="dimas-subtitle mb-0 has-color-subtitle pb-5 d-none d-md-block">
											There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, which don't look even slightly believable.
										</p>
										<img class="dimas-clients-number" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/testimonials/clients-number.png" alt="Clients number">
									</div>
									<div class="col-lg-5 col-xxl-6 offset-xl-1 position-relative overflow-hidden">
										<div class="dimas-testimonial-slider">
											<div class="swiper-wrapper">
												<div class="swiper-slide" data-customer-img-src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/testimonials/avata-1.png">
													<h3 class="testimonial__comment quote has-color-white pb-26 pb-lg-6 mb-0">
														There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, which don't look even slightly believable.
													</h3>
													<p class="testimonial__name name-author has-color-subtitle pb-5 mb-0">
														John Doe - CEO Fantasy Company
													</p>
												</div>
												<div class="swiper-slide" data-customer-img-src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/testimonials/avata-2.png">
													<h3 class="testimonial__comment quote has-color-white pb-26 pb-lg-6 mb-0">
														There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, which don't look even slightly believable.
													</h3>
													<p class="testimonial__name name-author has-color-subtitle pb-5 mb-0">
														John Doe - CEO Fantasy Company
													</p>
												</div>
												<div class="swiper-slide" data-customer-img-src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/testimonials/avata-3.png">
													<h3 class="testimonial__comment quote has-color-white pb-26 pb-lg-6 mb-0">
														There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, which don't look even slightly believable.
													</h3>
													<p class="testimonial__name name-author has-color-subtitle pb-5 mb-0">
														John Doe - CEO Fantasy Company
													</p>
												</div>
											</div>
											<div class="swiper-pagination"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>

				<section class="dimas-section pp-scrollable" data-anchor="Blog">
					<div class="dimas-section__content dimas-section__content--blog">
						<div class="container">
							<div class="dimas-grid-wrap d-grid">
								<div class="dimas-section__item dimas-section__item--showall pb-3 pb-md-0">
									<h2 class="dimas-title label-banner hg60 has-color-white pb-6 mb-0">
										Blog
									</h2>
									<a class="dimas-btn label-content has-color-white has-bg-main" href="<?php echo esc_url( get_category_link( get_option( 'default_category' ) ) ); ?>">
										all post
										<svg width="17" height="10" viewBox="0 0 17 10" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
											<path d="M16.4243 5.42426C16.6586 5.18995 16.6586 4.81005 16.4243 4.57574L12.6059 0.757359C12.3716 0.523045 11.9917 0.523045 11.7574 0.757359C11.523 0.991674 11.523 1.37157 11.7574 1.60589L15.1515 5L11.7574 8.39411C11.523 8.62843 11.523 9.00833 11.7574 9.24264C11.9917 9.47696 12.3716 9.47696 12.6059 9.24264L16.4243 5.42426ZM0 5.6H16V4.4H0V5.6Z"/>
										</svg>
									</a>
								</div>
								<?php
								foreach ( $blog_featured as $blog ) :
									$featured_id        = $blog->ID;
									$post_link          = get_post_permalink( $featured_id );
									$post_thumbnail_url = get_the_post_thumbnail_url( $featured_id );
									$post_date          = get_the_date( 'F j, Y', $featured_id );
									$post_title         = get_the_title( $featured_id );
									$post_excerpt       = get_the_excerpt( $featured_id );
									?>
									<article class="dimas-section__item dimas-section__item--blog dimas-post">
										<div class="dimas-post__thumbnail dimas-post__thumbnail--wrap">
											<a class="dimas-post__link" href="<?php echo esc_url( $post_link ); ?>">
												<img class="dimas-post__thumbnail dimas-post__thumbnail--img" src="<?php echo esc_url( $post_thumbnail_url ); ?>" alt="Post thumbnail">
												<div class="dimas-post__thumbnail dimas-post__thumbnail--arrow-wrap">
													<svg width="25" height="16" viewBox="0 0 25 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
														<path d="M24.7071 8.70711C25.0976 8.31658 25.0976 7.68342 24.7071 7.29289L18.3431 0.928932C17.9526 0.538408 17.3195 0.538408 16.9289 0.928932C16.5384 1.31946 16.5384 1.95262 16.9289 2.34315L22.5858 8L16.9289 13.6569C16.5384 14.0474 16.5384 14.6805 16.9289 15.0711C17.3195 15.4616 17.9526 15.4616 18.3431 15.0711L24.7071 8.70711ZM0 9H24V7H0V9Z"/>
													</svg>
												</div>
											</a>
										</div>
										<div class="dimas-post__content dimas-post__content--wrap">
											<h6 class="dimas-post__date has-color-main label-content mb-3">
												<?php echo esc_html( $post_date ); ?>
											</h6>
											<h3 class="dimas-post__title has-color-white mb-3">
												<?php echo esc_html( $post_title ); ?>
											</h3>
											<p class="dimas-post__description mb-0 has-color-subtitle">
												<?php echo esc_html( $post_excerpt ); ?>
											</p>
										</div>
									</article>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				</section>

				<section class="dimas-section pp-scrollable" data-anchor="Contact" style="background-image: url('<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/contact/bg-contact.png');">
					<div class="dimas-section__vertical-align ">
						<div class="dimas-section__content dimas-section__content--contact">
							<div class="container">
								<div class="row">
									<div class="col-lg-5">
										<div class="dimas-title">
											<h2 class="pb-4 mb-6 label-banner has-after position-relative has-color-white">
												Contact me
											</h2>
										</div>
										<ul class="dimas-contact-info">
											<li class="dimas-contact-info__item">
												<svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M18 25C8.075 25 0 16.925 0 7.00001C0.00375294 5.29758 0.625592 3.65444 1.7499 2.37608C2.87421 1.09773 4.42449 0.27114 6.1125 0.0500099C6.54281 0.00229855 6.97713 0.092896 7.35247 0.308664C7.72782 0.524432 8.02468 0.854153 8.2 1.25001L10.7125 7.11251C10.8428 7.41681 10.8951 7.74885 10.8645 8.07847C10.834 8.40809 10.7216 8.72486 10.5375 9.00001L8.4625 12.175C9.4021 14.0819 10.9503 15.6213 12.8625 16.55L16 14.4625C16.2749 14.2772 16.5924 14.1651 16.9227 14.1366C17.253 14.1082 17.585 14.1644 17.8875 14.3L23.75 16.8C24.1459 16.9753 24.4756 17.2722 24.6913 17.6475C24.9071 18.0229 24.9977 18.4572 24.95 18.8875C24.7289 20.5755 23.9023 22.1258 22.6239 23.2501C21.3456 24.3744 19.7024 24.9963 18 25ZM6.3625 2.03751C5.15619 2.19258 4.04776 2.78203 3.24474 3.69548C2.44173 4.60894 1.9992 5.78377 2 7.00001C2.00331 11.2425 3.69008 15.3102 6.68995 18.3101C9.68981 21.3099 13.7576 22.9967 18 23C19.2162 23.0008 20.3911 22.5583 21.3045 21.7553C22.218 20.9523 22.8074 19.8438 22.9625 18.6375L17.1 16.1375L13.975 18.225C13.6875 18.4151 13.3557 18.5277 13.0118 18.5517C12.668 18.5758 12.3237 18.5106 12.0125 18.3625C9.68368 17.236 7.79991 15.361 6.6625 13.0375C6.51254 12.7273 6.44524 12.3837 6.46714 12.0398C6.48904 11.696 6.59939 11.3637 6.7875 11.075L8.875 7.90001L6.3625 2.03751Z" fill="currentColor"/>
												</svg>
												<a class="dimas-contact-info__item dimas-contact-info__item--link d-inline-block" href="tel:(+34) 765 87 34 54">
													<h3 class="dimas-contact-info__item dimas-contact-info__item--text has-color-white mb-0">(+34) 765 87 34 54</h3>
												</a>
											</li>
											<li class="dimas-contact-info__item">
												<svg width="30" height="24" viewBox="0 0 30 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M1.6665 4.00016C1.6665 3.29292 1.94746 2.61464 2.44755 2.11454C2.94765 1.61445 3.62593 1.3335 4.33317 1.3335H25.6665C26.3737 1.3335 27.052 1.61445 27.5521 2.11454C28.0522 2.61464 28.3332 3.29292 28.3332 4.00016V20.0002C28.3332 20.7074 28.0522 21.3857 27.5521 21.8858C27.052 22.3859 26.3737 22.6668 25.6665 22.6668H4.33317C3.62593 22.6668 2.94765 22.3859 2.44755 21.8858C1.94746 21.3857 1.6665 20.7074 1.6665 20.0002V4.00016Z" stroke="currentColor" stroke-width="2.66667" stroke-linecap="round" stroke-linejoin="round"/>
													<path d="M1.6665 6.66699L11.6678 14.6683C12.6136 15.425 13.7887 15.8373 14.9998 15.8373C16.211 15.8373 17.3861 15.425 18.3318 14.6683L28.3332 6.66699" stroke="currentColor" stroke-width="2.66667" stroke-linejoin="round"/>
												</svg>
												<a class="dimas-contact-info__item dimas-contact-info__item--link d-inline-block" href="mailto:dimas@domain.com">
													<h3 class="dimas-contact-info__item dimas-contact-info__item--text has-color-white mb-0">dimas@domain.com</h3>
												</a>
											</li>
										</ul>
										<div class="dimas-navbar-socials pt-32 pb-8 pb-lg-0">
											<a class="dimas-social-icon" href="#">
												<svg width="17" height="30" viewBox="0 0 17 30" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path fill-rule="evenodd" clip-rule="evenodd" d="M6.24552 2.91202C7.68329 1.47424 9.63334 0.666504 11.6667 0.666504H15.6667C16.219 0.666504 16.6667 1.11422 16.6667 1.6665V6.99984C16.6667 7.55212 16.219 7.99984 15.6667 7.99984H11.6667C11.5783 7.99984 11.4935 8.03496 11.431 8.09747C11.3685 8.15998 11.3333 8.24477 11.3333 8.33317V11.3332H15.6667C15.9746 11.3332 16.2654 11.475 16.4549 11.7178C16.6444 11.9605 16.7115 12.277 16.6368 12.5757L15.3035 17.909C15.1922 18.3542 14.7922 18.6665 14.3333 18.6665H11.3333V28.3332C11.3333 28.8855 10.8856 29.3332 10.3333 29.3332H5C4.44772 29.3332 4 28.8855 4 28.3332V18.6665H1C0.447715 18.6665 0 18.2188 0 17.6665V12.3332C0 11.7809 0.447715 11.3332 1 11.3332H4V8.33317C4 6.29984 4.80774 4.3498 6.24552 2.91202ZM11.6667 2.6665C10.1638 2.6665 8.72244 3.26353 7.65973 4.32623C6.59702 5.38894 6 6.83028 6 8.33317V12.3332C6 12.8855 5.55229 13.3332 5 13.3332H2V16.6665H5C5.55229 16.6665 6 17.1142 6 17.6665V27.3332H9.33333V17.6665C9.33333 17.1142 9.78105 16.6665 10.3333 16.6665H13.5526L14.3859 13.3332H10.3333C9.78105 13.3332 9.33333 12.8855 9.33333 12.3332V8.33317C9.33333 7.71433 9.57917 7.12084 10.0168 6.68325C10.4543 6.24567 11.0478 5.99984 11.6667 5.99984H14.6667V2.6665H11.6667Z" fill="currentColor"/>
												</svg>
											</a>
											<a class="dimas-social-icon" href="#">
												<svg width="28" height="25" viewBox="0 0 28 25" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M27.9248 4.61234C27.8483 4.43034 27.7197 4.27505 27.5551 4.16606C27.3905 4.05706 27.1973 3.99922 26.9998 3.99984H23.1998C22.7438 3.20424 22.1108 2.52428 21.3498 2.01262C20.5888 1.50096 19.7202 1.17134 18.8113 1.04927C17.9025 0.927199 16.9777 1.01597 16.1087 1.3087C15.2396 1.60142 14.4496 2.09026 13.7998 2.73734C13.2309 3.29205 12.7786 3.95488 12.4695 4.68687C12.1604 5.41886 12.0007 6.20526 11.9998 6.99984V7.76234C6.91234 6.43734 2.74984 2.33734 2.71234 2.28734C2.58159 2.1587 2.41797 2.0685 2.2394 2.02662C2.06082 1.98473 1.87416 1.99276 1.69984 2.04984C1.52608 2.10514 1.37048 2.20634 1.24947 2.34275C1.12846 2.47916 1.04653 2.64572 1.01234 2.82484C-0.0751554 8.84984 1.73734 12.8873 3.44984 15.2123C4.30878 16.388 5.35127 17.4178 6.53734 18.2623C4.62484 20.4248 1.67484 21.5498 1.64984 21.5623C1.50878 21.6147 1.38133 21.6981 1.277 21.8066C1.17268 21.915 1.09416 22.0455 1.0473 22.1885C1.00045 22.3315 0.986456 22.4832 1.00637 22.6323C1.02629 22.7815 1.07961 22.9242 1.16234 23.0498C1.26234 23.1998 1.63734 23.6873 2.54984 24.1498C3.68734 24.7123 5.18734 24.9998 6.99984 24.9998C15.8123 24.9998 23.1873 18.2123 23.9373 9.47484L27.7123 5.71234C27.848 5.56775 27.94 5.38771 27.9776 5.19305C28.0152 4.99838 27.9969 4.79705 27.9248 4.61234ZM22.2623 8.32484C22.0881 8.49761 21.9855 8.72972 21.9748 8.97484C21.4623 16.8373 14.8873 22.9998 6.99984 22.9998C5.67484 22.9998 4.74984 22.8248 4.09984 22.6123C5.53734 21.8373 7.53734 20.4873 8.83734 18.5498C8.91281 18.4326 8.96291 18.3008 8.98444 18.1631C9.00596 18.0253 8.99844 17.8845 8.96234 17.7498C8.92596 17.6138 8.86158 17.4868 8.77334 17.377C8.68509 17.2673 8.57491 17.1771 8.44984 17.1123C8.43734 17.0998 6.58734 16.1373 4.99984 13.9498C3.19984 11.4748 2.43734 8.46234 2.73734 4.98734C4.71234 6.61234 8.48734 9.26234 12.8373 9.98734C12.981 10.0104 13.1279 10.0023 13.2681 9.96343C13.4083 9.9246 13.5385 9.85602 13.6498 9.76234C13.7587 9.66712 13.8461 9.54996 13.9064 9.41854C13.9668 9.28712 13.9986 9.14443 13.9998 8.99984V6.99984C14.0017 6.08234 14.3189 5.19336 14.8983 4.48195C15.4777 3.77054 16.2841 3.27994 17.1822 3.09241C18.0804 2.90487 19.0157 3.03179 19.8313 3.45189C20.647 3.872 21.2935 4.55975 21.6623 5.39984C21.7421 5.57854 21.8719 5.73031 22.036 5.83679C22.2002 5.94327 22.3917 5.99991 22.5873 5.99984H24.5873L22.2623 8.32484Z" fill="currentColor"/>
												</svg>
											</a>
											<a class="dimas-social-icon" href="#">
												<svg width="27" height="26" viewBox="0 0 27 26" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M26.9998 13.0877V13.0002C26.9986 11.071 26.5684 9.16616 25.7404 7.42367C24.9124 5.68118 23.7073 4.1446 22.2123 2.92518L22.1373 2.86268L22.0498 2.80018C20.1414 1.29208 17.8481 0.34968 15.4306 0.0800956C13.0132 -0.189489 10.5686 0.224561 8.37483 1.27518L8.21233 1.36268C6.43888 2.24735 4.89022 3.52433 3.68385 5.09672C2.47748 6.66912 1.64509 8.49563 1.24983 10.4377V10.4627C0.769381 12.8646 0.979358 15.3536 1.85543 17.6411C2.73151 19.9286 4.23782 21.9211 6.19983 23.3877L6.36233 23.5127H6.37483C8.07217 24.7433 10.042 25.5452 12.1163 25.8499C14.1905 26.1547 16.3078 25.9532 18.2873 25.2627L18.4248 25.2127C20.9153 24.3075 23.0704 22.6643 24.6026 20.5023C26.1348 18.3403 26.971 15.7624 26.9998 13.1127V13.0877ZM24.9498 12.0252L23.9998 12.0002C22.1469 12.0017 20.3021 12.2454 18.5123 12.7252C18.0737 11.431 17.5085 10.1833 16.8248 9.00018C18.604 7.92826 20.2134 6.59694 21.5998 5.05018C23.5281 6.89001 24.7192 9.36996 24.9498 12.0252ZM20.0373 3.81268C18.7887 5.18448 17.3438 6.36392 15.7498 7.31268C14.4115 5.43684 12.7778 3.79047 10.9123 2.43768C12.4422 1.99316 14.0504 1.8859 15.6258 2.12329C17.2012 2.36068 18.7063 2.93707 20.0373 3.81268ZM8.69983 3.36268C10.7484 4.64811 12.5342 6.3109 13.9623 8.26268C11.4635 9.40608 8.74788 9.99865 5.99983 10.0002C5.15105 9.99833 4.30333 9.93986 3.46233 9.82518C4.30093 7.07166 6.17973 4.75343 8.69983 3.36268ZM2.99983 13.0002C2.99983 12.5877 3.02483 12.1877 3.06233 11.8002C4.03623 11.9294 5.0174 11.9962 5.99983 12.0002C9.13612 12.0046 12.2333 11.304 15.0623 9.95018C15.6856 11.0257 16.2007 12.1604 16.5998 13.3377C15.5393 13.7418 14.5113 14.2265 13.5248 14.7877C10.7835 16.3748 8.43394 18.5578 6.64983 21.1752C5.50169 20.1451 4.5833 18.8848 3.95443 17.4763C3.32556 16.0678 3.00031 14.5427 2.99983 13.0002ZM8.24983 22.3752C10.4162 19.15 13.5239 16.6708 17.1498 15.2752C17.4545 16.6503 17.6095 18.0543 17.6123 19.4627C17.6117 20.8286 17.465 22.1905 17.1748 23.5252C16.1465 23.8428 15.0761 24.003 13.9998 24.0002C11.9699 23.9994 9.97985 23.437 8.24983 22.3752ZM19.3873 22.5877C19.5377 21.5528 19.6129 20.5084 19.6123 19.4627C19.6113 17.8429 19.4268 16.2284 19.0623 14.6502C20.6731 14.2206 22.3328 14.0021 23.9998 14.0002L24.9498 14.0252C24.7828 15.7954 24.1896 17.4989 23.2209 18.9901C22.2522 20.4812 20.9369 21.7156 19.3873 22.5877Z" fill="currentColor"/>
												</svg>
											</a>
										</div>
									</div>
									<div class="col-xxl-6 col-lg-5 offset-lg-1 position-relative overflow-hidden">
										<?php echo do_shortcode( '[contact-form-7 id="147" title="Contact form"]' ); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>

				<ul class="dimas-fullpage-slider-nav d-none d-lg-block">
					<li>
						<a class="prev" href="#">
							<svg width="28" height="16" viewBox="0 0 28 16" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M2 14L14 2L26 14" stroke="currentColor" stroke-width="2" stroke-linecap="square"/>
							</svg>
						</a>
					</li>
					<li>
						<a href="#Home" data-menuanchor="Home" class="active"></a>
					</li>
					<li>
						<a href="#About" data-menuanchor="About"></a>
					</li>
					<li>
						<a href="#Projects" data-menuanchor="Projects"></a>
					</li>
					<li>
						<a href="#Services" data-menuanchor="Services"></a>
					</li>
					<li>
						<a href="#Testimonials" data-menuanchor="Testimonials"></a>
					</li>
					<li>
						<a href="#Blog" data-menuanchor="Blog"></a>
					</li>
					<li>
						<a href="#Contact" data-menuanchor="Contact"></a>
					</li>
					<li>
						<a class="next" href="#">
							<svg width="28" height="16" viewBox="0 0 28 16" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M2 2L14 14L26 2" stroke="currentColor" stroke-width="2" stroke-linecap="square"/>
							</svg>
						</a>
					</li>
				</ul>

			</div>
		</main>
		
<?php
get_footer();
