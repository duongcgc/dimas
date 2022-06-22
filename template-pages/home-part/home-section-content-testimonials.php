<?php
/**
 *
 *
 * Loads content section testimonials of home page.
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

?>
	

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
		
