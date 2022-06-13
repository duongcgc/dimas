<?php
/**
 *
 *
 * Loads content of single post.
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
	$post_thumbnail_url = get_the_post_thumbnail_url( get_the_id(), 'full' );
	$post_date          = get_the_date( 'F j, Y', get_the_id() );
	$post_title         = get_the_title( get_the_id() );
	$post_excerpt       = get_the_excerpt( get_the_id() );
	$page_url           = get_permalink( get_the_id() );
	$facebook_url       = 'https://www.facebook.com/sharer/sharer.php?u=' . $page_url;
	$twitter_url        = 'https://twitter.com/intent/tweet?url=' . $page_url;
	?>
		<main class="dimas-main">
			<div class="dimas-blog">
				<div class="dimas-post">
					<div class="dimas-post__vertical-align">
						<img class="dimas-post__thumbnail" src="<?php echo esc_url( $post_thumbnail_url ); ?>" alt="Post thumbnail">
						<div class="container py-8 pt-md-96 pt-md-96 pb-md-9">
							<div class="dimas-post-content-wrap row">

								<div class="dimas-sticky-share d-none d-md-flex flex-wrap align-items-center px-0">
									<a class="dimas-sticky-share__item coppy-link cursor-pointer" data-href="<?php echo $page_url; ?>" href="##">
										<svg width="20" height="22" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M16.2503 14C15.6889 14.0028 15.1353 14.1316 14.6303 14.377C14.1254 14.6223 13.6819 14.9779 13.3328 15.4175L7.85026 11.99C8.05007 11.3451 8.05007 10.6548 7.85026 10.01L13.3328 6.58247C13.8892 7.27151 14.6716 7.74135 15.5413 7.90878C16.411 8.0762 17.3119 7.93039 18.0844 7.49719C18.8569 7.06398 19.4511 6.37134 19.7618 5.54196C20.0726 4.71257 20.0797 3.79998 19.782 2.96584C19.4843 2.13171 18.9009 1.42986 18.1353 0.984643C17.3696 0.539421 16.4711 0.379558 15.5989 0.533372C14.7267 0.687187 13.9371 1.14475 13.3699 1.82501C12.8028 2.50527 12.4947 3.36431 12.5003 4.24997C12.5038 4.58535 12.5543 4.91859 12.6503 5.23997L7.16776 8.66747C6.68374 8.05816 6.02216 7.61451 5.27472 7.39802C4.52728 7.18153 3.73101 7.20292 2.99627 7.45923C2.26153 7.71554 1.62473 8.19407 1.17413 8.8285C0.723524 9.46292 0.481445 10.2218 0.481445 11C0.481445 11.7781 0.723524 12.537 1.17413 13.1714C1.62473 13.8059 2.26153 14.2844 2.99627 14.5407C3.73101 14.797 4.52728 14.8184 5.27472 14.6019C6.02216 14.3854 6.68374 13.9418 7.16776 13.3325L12.6503 16.76C12.5543 17.0814 12.5038 17.4146 12.5003 17.75C12.5003 18.4916 12.7202 19.2167 13.1322 19.8334C13.5443 20.45 14.13 20.9307 14.8152 21.2145C15.5004 21.4983 16.2544 21.5726 16.9818 21.4279C17.7093 21.2832 18.3775 20.9261 18.9019 20.4016C19.4264 19.8772 19.7835 19.209 19.9282 18.4816C20.0729 17.7541 19.9986 17.0001 19.7148 16.3149C19.431 15.6297 18.9503 15.044 18.3336 14.632C17.717 14.2199 16.9919 14 16.2503 14ZM16.2503 1.99997C16.6953 1.99997 17.1303 2.13193 17.5003 2.37916C17.8703 2.6264 18.1587 2.9778 18.329 3.38893C18.4993 3.80007 18.5438 4.25247 18.457 4.68892C18.3702 5.12538 18.1559 5.52629 17.8413 5.84096C17.5266 6.15563 17.1257 6.36992 16.6892 6.45674C16.2528 6.54355 15.8004 6.499 15.3892 6.3287C14.9781 6.1584 14.6267 5.87001 14.3795 5.5C14.1322 5.12999 14.0003 4.69498 14.0003 4.24997C14.0003 3.65323 14.2373 3.08094 14.6593 2.65898C15.0812 2.23702 15.6535 1.99997 16.2503 1.99997ZM4.25026 13.25C3.80525 13.25 3.37024 13.118 3.00023 12.8708C2.63022 12.6235 2.34183 12.2721 2.17153 11.861C2.00123 11.4499 1.95668 10.9975 2.04349 10.561C2.13031 10.1246 2.3446 9.72365 2.65927 9.40898C2.97394 9.09431 3.37485 8.88002 3.81131 8.7932C4.24776 8.70639 4.70016 8.75094 5.1113 8.92124C5.52243 9.09154 5.87383 9.37993 6.12107 9.74994C6.3683 10.1199 6.50026 10.555 6.50026 11C6.50026 11.5967 6.26321 12.169 5.84125 12.591C5.41929 13.0129 4.847 13.25 4.25026 13.25ZM16.2503 20C15.8053 20 15.3702 19.868 15.0002 19.6208C14.6302 19.3735 14.3418 19.0221 14.1715 18.611C14.0012 18.1999 13.9567 17.7475 14.0435 17.311C14.1303 16.8746 14.3446 16.4736 14.6593 16.159C14.9739 15.8443 15.3748 15.63 15.8113 15.5432C16.2478 15.4564 16.7002 15.5009 17.1113 15.6712C17.5224 15.8415 17.8738 16.1299 18.1211 16.4999C18.3683 16.8699 18.5003 17.305 18.5003 17.75C18.5003 18.3467 18.2632 18.919 17.8413 19.341C17.4193 19.7629 16.847 20 16.2503 20Z" fill="currentColor"/>
										</svg>
									</a>
									<script type="text/javascript">
										jQuery (function($){
											$('.dimas-sticky-share__item.coppy-link').click(function() {
												var copyText=$(this).attr('data-href');
												navigator.clipboard.writeText(copyText);
											});
										})
									</script>
									<a class="dimas-sticky-share__item fb-share" href="<?php echo $facebook_url; ?>" target="_blank">
										<svg width="13" height="22" viewBox="0 0 13 22" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path fill-rule="evenodd" clip-rule="evenodd" d="M4.93414 1.93414C6.01247 0.855802 7.47501 0.25 9 0.25H12C12.4142 0.25 12.75 0.585786 12.75 1V5C12.75 5.41421 12.4142 5.75 12 5.75H9C8.9337 5.75 8.87011 5.77634 8.82322 5.82322C8.77634 5.87011 8.75 5.9337 8.75 6V8.25H12C12.231 8.25 12.449 8.3564 12.5912 8.53844C12.7333 8.72048 12.7836 8.95785 12.7276 9.1819L11.7276 13.1819C11.6441 13.5158 11.3442 13.75 11 13.75H8.75V21C8.75 21.4142 8.41421 21.75 8 21.75H4C3.58579 21.75 3.25 21.4142 3.25 21V13.75H1C0.585786 13.75 0.25 13.4142 0.25 13V9C0.25 8.58579 0.585786 8.25 1 8.25H3.25V6C3.25 4.475 3.8558 3.01247 4.93414 1.93414ZM9 1.75C7.87283 1.75 6.79183 2.19777 5.9948 2.9948C5.19777 3.79183 4.75 4.87283 4.75 6V9C4.75 9.41421 4.41421 9.75 4 9.75H1.75V12.25H4C4.41421 12.25 4.75 12.5858 4.75 13V20.25H7.25V13C7.25 12.5858 7.58579 12.25 8 12.25H10.4144L11.0394 9.75H8C7.58579 9.75 7.25 9.41421 7.25 9V6C7.25 5.53587 7.43438 5.09075 7.76256 4.76256C8.09075 4.43437 8.53587 4.25 9 4.25H11.25V1.75H9Z" fill="currentColor"/>
										</svg>
									</a>
									<a class="dimas-sticky-share__item tw-share" href="<?php echo $twitter_url; ?>" target="_blank">
										<svg width="22" height="19" viewBox="0 0 22 19" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M21.194 3.45938C21.1366 3.32288 21.0401 3.20641 20.9167 3.12466C20.7932 3.04292 20.6483 2.99954 20.5002 3H17.6502C17.3082 2.4033 16.8335 1.89333 16.2627 1.50959C15.692 1.12584 15.0405 0.878623 14.3589 0.787072C13.6772 0.695522 12.9837 0.762097 12.3319 0.981644C11.6801 1.20119 11.0876 1.56782 10.6002 2.05313C10.1736 2.46916 9.83434 2.96628 9.6025 3.51527C9.37067 4.06427 9.25091 4.65406 9.25025 5.25V5.82188C5.43462 4.82813 2.31275 1.75313 2.28462 1.71563C2.18656 1.61915 2.06385 1.5515 1.92991 1.52008C1.79598 1.48867 1.65599 1.49469 1.52525 1.5375C1.39493 1.57898 1.27822 1.65488 1.18747 1.75718C1.09671 1.85949 1.03526 1.98441 1.00962 2.11875C0.194 6.6375 1.55337 9.66563 2.83775 11.4094C3.48195 12.2911 4.26382 13.0635 5.15337 13.6969C3.719 15.3188 1.5065 16.1625 1.48775 16.1719C1.38195 16.2111 1.28636 16.2737 1.20812 16.355C1.12988 16.4363 1.07099 16.5343 1.03584 16.6415C1.0007 16.7487 0.990208 16.8625 1.00515 16.9744C1.02009 17.0862 1.06007 17.1933 1.12212 17.2875C1.19712 17.4 1.47837 17.7656 2.16275 18.1125C3.01587 18.5344 4.14087 18.75 5.50025 18.75C12.1096 18.75 17.6409 13.6594 18.2034 7.10625L21.0346 4.28438C21.1364 4.17594 21.2053 4.04091 21.2335 3.89491C21.2617 3.74891 21.248 3.59791 21.194 3.45938ZM16.9471 6.24375C16.8165 6.37333 16.7395 6.54741 16.7315 6.73125C16.3471 12.6281 11.4159 17.25 5.50025 17.25C4.5065 17.25 3.81275 17.1188 3.32525 16.9594C4.40337 16.3781 5.90337 15.3656 6.87837 13.9125C6.93497 13.8246 6.97255 13.7257 6.98869 13.6224C7.00484 13.5191 6.99919 13.4135 6.97212 13.3125C6.94483 13.2105 6.89655 13.1152 6.83037 13.0329C6.76418 12.9506 6.68155 12.883 6.58775 12.8344C6.57837 12.825 5.19087 12.1031 4.00025 10.4625C2.65025 8.60625 2.07837 6.34688 2.30337 3.74063C3.78462 4.95938 6.61587 6.94688 9.87837 7.49063C9.98611 7.50793 10.0963 7.50181 10.2015 7.47269C10.3066 7.44357 10.4043 7.39213 10.4877 7.32188C10.5694 7.25046 10.6349 7.16259 10.6802 7.06403C10.7254 6.96547 10.7493 6.85845 10.7502 6.75V5.25C10.7516 4.56187 10.9896 3.89514 11.4241 3.36159C11.8587 2.82803 12.4634 2.46008 13.137 2.31943C13.8106 2.17877 14.5121 2.27396 15.1239 2.58904C15.7356 2.90412 16.2205 3.41993 16.4971 4.05C16.5569 4.18402 16.6543 4.29785 16.7774 4.37771C16.9005 4.45758 17.0441 4.50005 17.1909 4.5H18.6909L16.9471 6.24375Z" fill="currentColor"/>
										</svg>
									</a>
									<a class="dimas-sticky-share__item email-share" href="#">
										<svg width="22" height="18" viewBox="0 0 22 18" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path fill-rule="evenodd" clip-rule="evenodd" d="M3.125 2.25C2.50368 2.25 2 2.75368 2 3.375V14.625C2 15.2463 2.50368 15.75 3.125 15.75H18.875C19.4963 15.75 20 15.2463 20 14.625V3.375C20 2.75368 19.4963 2.25 18.875 2.25H3.125ZM0.5 3.375C0.5 1.92525 1.67525 0.75 3.125 0.75H18.875C20.3247 0.75 21.5 1.92525 21.5 3.375V14.625C21.5 16.0747 20.3247 17.25 18.875 17.25H3.125C1.67525 17.25 0.5 16.0747 0.5 14.625V3.375Z" fill="currentColor"/>
											<path fill-rule="evenodd" clip-rule="evenodd" d="M3.65802 4.03952C3.91232 3.71256 4.38353 3.65366 4.71049 3.90796L11 8.79983L17.2896 3.90796C17.6165 3.65366 18.0877 3.71256 18.342 4.03952C18.5964 4.36648 18.5375 4.83769 18.2105 5.09199L11.4605 10.342C11.1897 10.5526 10.8104 10.5526 10.5396 10.342L3.78958 5.09199C3.46262 4.83769 3.40372 4.36648 3.65802 4.03952Z" fill="currentColor"/>
										</svg>
									</a>
								</div>

								<div class="dimas-post-info col-md-8 mx-auto">
									<h4 class="dimas-post-info__post-date has-color-main label-header label-content mb-32">
										Jan 23, 2021
									</h4>
									<h2 class="dimas-post-info__post-title pb-5 label-banner has-color-white mb-0">
										Have You Heard? Agency Is Your Best Bet To Grow
									</h2>
									<p class="dimas-post-info__post-description has-color-subtitle mb-32">
										Donec a iaculis odio. Mauris tincidunt, ligula ut congue tempor, augue nibh condimentum ipsum, ullamcorper congue felis nibh egestas risus. Aliquam sed pretium dui, in malesuada velit. Pellentesque at enim placerat risus cursus rutrum id vel massa. Proin
										ornare viverra odio, fringilla malesuada sapien congue at. Praesent ultrices feugiat ex, sodales tristique mauris maximus in. Curabitur finibus iaculis urna ac elementum. Ut at interdum magna.
									</p>
									<p class="dimas-post-info__post-description mb-0 has-color-subtitle">Cras vel hendrerit nisl. In magna quam, sodales eget vestibulum accumsan, gravida ac velit. Quisque accumsan pretium orci, quis facilisis ex elementum sed. Curabitur porta scelerisque tincidunt. Nunc velit magna, condimentum
										in metus sed, rutrum ultricies nunc. Nulla pretium imperdiet dolor sit amet imperdiet. Maecenas accumsan fringilla lectus id tempor. Phasellus a convallis sapien. Suspendisse scelerisque, urna vitae aliquam tristique,
										mauris tortor blandit ex, eu efficitur ex sapien a sem. Praesent ut vehicula mauris. Proin fringilla ornare sagittis.
									</p>
								</div>

								<div class="dimas-post-gallery col-md-10 pt-5 pb-8 py-md-96 mx-auto">
									<a class="fancybox__link dimas-post-gallery__link" data-fancybox="gallery" data-src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/single-post/post-img-1.png"><img class="dimas-post-gallery__item" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/single-post/post-img-1.png" alt="Post img"></a>
									<a class="fancybox__link dimas-post-gallery__link" data-fancybox="gallery" data-src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/single-post/post-img-2.png"><img class="dimas-post-gallery__item" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/single-post/post-img-2.png" alt="Post img"></a>
									<a class="fancybox__link dimas-post-gallery__link" data-fancybox="gallery" data-src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/single-post/post-img-3.png"><img class="dimas-post-gallery__item" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/single-post/post-img-3.png" alt="Post img"></a>
								</div>

								<div class="dimas-post-content col-md-8 mx-auto">
									<h2 class="mb-5 quote has-color-white text-capitalize fw-bold">
										Defaulting to Mindfulness
									</h2>
									<p class="has-color-subtitle mb-5 mb-md-8">
										Donec a iaculis odio. Mauris tincidunt, ligula ut congue tempor, augue nibh condimentum ipsum, ullamcorper congue felis nibh egestas risus. Aliquam sed pretium dui, in malesuada velit. Pellentesque at enim placerat risus cursus rutrum id vel massa. Proin
										ornare viverra odio, fringilla malesuada sapien congue at. Praesent ultrices feugiat ex, sodales tristique mauris maximus in. Curabitur finibus iaculis urna ac elementum. Ut at interdum magna.
									</p>
									<div class="quote quote-wrap mb-5 mb-md-8 d-flex align-items-start">
										<img class="quote__img me-8" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/icon-quote.png" alt="Icon quote">
										<div class="quote__content">
											<p class="quote__text has-after pb-32 mb-32 has-color-white">
												In ullamcorper ac erat ac egestas. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.
											</p>
											<p class="quote__author has-color-white mb-0 d-inline-block text-uppercase">
												John Doe
											</p>
											<p class="quote__author has-color-subtitle mb-0 d-inline-block text-uppercase" style="font-weight: 400">
												- CEO ABC Group
											</p>
										</div>
									</div>
									<p class="has-color-subtitle mb-5 mb-md-96">
										Cras vel hendrerit nisl. In magna quam, sodales eget vestibulum accumsan, gravida ac velit. Quisque accumsan pretium orci, quis facilisis ex elementum sed. Curabitur porta scelerisque tincidunt. Nunc velit magna, condimentum in metus sed, rutrum ultricies
										nunc. Nulla pretium imperdiet dolor sit amet imperdiet. Maecenas accumsan fringilla lectus id tempor. Phasellus a convallis sapien. Suspendisse scelerisque, urna vitae aliquam tristique, mauris tortor blandit ex,
										eu efficitur ex sapien a sem. Praesent ut vehicula mauris. Proin fringilla ornare sagittis.
									</p>
									<div class="dimas-post__tag d-flex flex-wrap">
										<h3 class="me-3 has-color-white">
											Tags:
										</h3>
										<a href="##">
											<p class="post-tag">
												Art
											</p>
										</a>
										<a href="##">
											<p class="post-tag">
												Museum
											</p>
										</a>
										<a href="##">
											<p class="post-tag">
												Design
											</p>
										</a>
										<a href="##">
											<p class="post-tag">
												Workshop
											</p>
										</a>
									</div>
								</div>
							</div>
						</div>
						<div class="dimas-post__related-posts has-bg-black py-8 py-md-96">
							<div class="container">
								<div class="dimas-post-related-wrap d-flex flex-wrap justify-content-center">
									<div class="section-title col-md-8 mx-auto mb-5 mb-md-8">
										<h2 class="label-banner mb-0 has-color-white">
											Related posts
										</h2>
									</div>

									<div class="dimas-grid-wrap d-grid">
										<article class="dimas-section__item dimas-section__item--blog dimas-post">
											<div class="dimas-post__thumbnail dimas-post__thumbnail--wrap">
												<a class="dimas-post__link" href="blog-single.html">
													<img class="dimas-post__thumbnail dimas-post__thumbnail--img" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/single-post/post-thumbnail.png" alt="Post thumbnail">
													<div class="dimas-post__thumbnail dimas-post__thumbnail--arrow-wrap">
														<svg width="25" height="16" viewBox="0 0 25 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
															<path d="M24.7071 8.70711C25.0976 8.31658 25.0976 7.68342 24.7071 7.29289L18.3431 0.928932C17.9526 0.538408 17.3195 0.538408 16.9289 0.928932C16.5384 1.31946 16.5384 1.95262 16.9289 2.34315L22.5858 8L16.9289 13.6569C16.5384 14.0474 16.5384 14.6805 16.9289 15.0711C17.3195 15.4616 17.9526 15.4616 18.3431 15.0711L24.7071 8.70711ZM0 9H24V7H0V9Z"/>
														</svg>
													</div>
												</a>
											</div>
											<div class="dimas-post__content dimas-post__content--wrap">
												<h6 class="dimas-post__date has-color-main label-content mb-3">
													Jan 23, 2021
												</h6>
												<h3 class="dimas-post__title has-color-white mb-3">
													The Lasso Is a Recycling Robot for Your Home
												</h3>
												<p class="dimas-post__description mb-0 has-color-subtitle">
													There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form...
												</p>
											</div>
										</article>
										<article class="dimas-section__item dimas-section__item--blog dimas-post">
											<div class="dimas-post__thumbnail dimas-post__thumbnail--wrap">
												<a class="dimas-post__link" href="blog-single.html">
													<img class="dimas-post__thumbnail dimas-post__thumbnail--img" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/single-post/post-thumbnail.png" alt="Post thumbnail">
													<div class="dimas-post__thumbnail dimas-post__thumbnail--arrow-wrap">
														<svg width="25" height="16" viewBox="0 0 25 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
															<path d="M24.7071 8.70711C25.0976 8.31658 25.0976 7.68342 24.7071 7.29289L18.3431 0.928932C17.9526 0.538408 17.3195 0.538408 16.9289 0.928932C16.5384 1.31946 16.5384 1.95262 16.9289 2.34315L22.5858 8L16.9289 13.6569C16.5384 14.0474 16.5384 14.6805 16.9289 15.0711C17.3195 15.4616 17.9526 15.4616 18.3431 15.0711L24.7071 8.70711ZM0 9H24V7H0V9Z"/>
														</svg>
													</div>
												</a>
											</div>
											<div class="dimas-post__content dimas-post__content--wrap">
												<h6 class="dimas-post__date has-color-main label-content mb-3">
													Jan 23, 2021
												</h6>
												<h3 class="dimas-post__title has-color-white mb-3">
													The Lasso Is a Recycling Robot for Your Home
												</h3>
												<p class="dimas-post__description mb-0 has-color-subtitle">
													There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form...
												</p>
											</div>
										</article>
										<article class="dimas-section__item dimas-section__item--blog dimas-post">
											<div class="dimas-post__thumbnail dimas-post__thumbnail--wrap">
												<a class="dimas-post__link" href="blog-single.html">
													<img class="dimas-post__thumbnail dimas-post__thumbnail--img" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/single-post/post-thumbnail.png" alt="Post thumbnail">
													<div class="dimas-post__thumbnail dimas-post__thumbnail--arrow-wrap">
														<svg width="25" height="16" viewBox="0 0 25 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
															<path d="M24.7071 8.70711C25.0976 8.31658 25.0976 7.68342 24.7071 7.29289L18.3431 0.928932C17.9526 0.538408 17.3195 0.538408 16.9289 0.928932C16.5384 1.31946 16.5384 1.95262 16.9289 2.34315L22.5858 8L16.9289 13.6569C16.5384 14.0474 16.5384 14.6805 16.9289 15.0711C17.3195 15.4616 17.9526 15.4616 18.3431 15.0711L24.7071 8.70711ZM0 9H24V7H0V9Z"/>
														</svg>
													</div>
												</a>
											</div>
											<div class="dimas-post__content dimas-post__content--wrap">
												<h6 class="dimas-post__date has-color-main label-content mb-3">
													Jan 23, 2021
												</h6>
												<h3 class="dimas-post__title has-color-white mb-3">
													The Lasso Is a Recycling Robot for Your Home
												</h3>
												<p class="dimas-post__description mb-0 has-color-subtitle">
													There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form...
												</p>
											</div>
										</article>
									</div>
								</div>
							</div>
						</div>

						<div class="dimas-post__comment pt-8 pt-md-96">
							<div class="container">
								<div class="dimas-post-comment-wrap row">
									<div class="col-md-8 mx-auto">
										<h2 class="section-title label-banner  mb-5 mb-md-8 has-color-white">
											Comments
										</h2>
										<div class="view-comment mb-8">
											<ul class="comment-list">
												<li class="comment-main">
													<div class="author-avtar">
														<img class="author-avtar__img" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/single-post/avata-comments-1.png" alt="Avatar author">
													</div>
													<div class="comment-content">
														<div class="comment-info">
															<h4 class="author-name">
																John Doe
															</h4>
															<h4 class="comment-date">
																Jan 13, 2022
															</h4>
														</div>
														<p class="comment-text mb-0">
															Everything along the way, to and from, fascinated her: every pebble, ant, stick, leaf, blade of grass, and crack in the sidewalk was something to be picked up.
														</p>
													</div>
													<a class="comment-btn has-color-main" href="##">
														Reply
													</a>
												</li>
												<ul class="comment-list__reply-list">
													<li class="comment-main">
														<div class="author-avtar">
															<img class="author-avtar__img" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/single-post/avata-comments-2.png" alt="Avatar author">
														</div>
														<div class="comment-content">
															<div class="comment-info">
																<h4 class="author-name">
																	John Doe
																</h4>
																<h4 class="comment-date">
																	Jan 13, 2022
																</h4>
															</div>
															<p class="comment-text mb-0">
																Everything along the way, to and from, fascinated her: every pebble, ant, stick, leaf, blade of grass, and crack in the sidewalk was something to be picked up.
															</p>
														</div>
														<a class="comment-btn has-color-main" href="##">
														Reply
													</a>
													</li>
													<li class="comment-main">
														<div class="author-avtar">
															<img class="author-avtar__img" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/single-post/avata-comment-3.png" alt="Avatar author">
														</div>
														<div class="comment-content">
															<div class="comment-info">
																<h4 class="author-name">
																	John Doe
																</h4>
																<h4 class="comment-date">
																	Jan 13, 2022
																</h4>
															</div>
															<p class="comment-text mb-0">
																Everything along the way, to and from, fascinated her: every pebble, ant, stick, leaf, blade of grass, and crack in the sidewalk was something to be picked up.
															</p>
														</div>
														<a class="comment-btn has-color-main" href="##">
														Reply
													</a>
													</li>
												</ul>
												<li class="comment-main">
													<div class="author-avtar">
														<img class="author-avtar__img" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/single-post/avata-comments-4.png" alt="Avatar author">
													</div>
													<div class="comment-content">
														<div class="comment-info">
															<h4 class="author-name">
																John Doe
															</h4>
															<h4 class="comment-date">
																Jan 13, 2022
															</h4>
														</div>
														<p class="comment-text mb-0">
															Everything along the way, to and from, fascinated her: every pebble, ant, stick, leaf, blade of grass, and crack in the sidewalk was something to be picked up.
														</p>
													</div>
													<a class="comment-btn has-color-main" href="##">
														Reply
													</a>
												</li>
											</ul>
										</div>
										<div class="form-comment">
											<h3 class="label-form-comment mb-5 mb-md-8 has-color-white">
												Add comment
											</h3>
											<form class="dimas-comment-form" action="php/contact-form.php" method="POST" novalidate="novalidate">
												<div class="dimas-form-row two-col">
													<div class="dimas-form-group">
														<input class="dimas-form-control" type="text" id="name" name="name" placeholder="Name *" required="required">
													</div>
													<div class="dimas-form-group">
														<input class="dimas-form-control" type="email" id="email" name="email" placeholder="Email *" required="required">
													</div>
												</div>
												<div class="dimas-form-row">
													<textarea class="dimas-form-control" name="comment" id="comment" rows="4" required="required" placeholder="Comment *"></textarea>
												</div>
												<div class="contact-form-message alert alert-danger d-none mt-4">
													<div class="message success">Your message is successfully sent...</div>
													<div class="message danger">Sorry something went wrong!</div>
												</div>
												<button class="dimas-btn label-content has-color-white has-bg-main">
												post comment
												<svg width="17" height="10" viewBox="0 0 17 10" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
													<path d="M16.4243 5.42426C16.6586 5.18995 16.6586 4.81005 16.4243 4.57574L12.6059 0.757359C12.3716 0.523045 11.9917 0.523045 11.7574 0.757359C11.523 0.991674 11.523 1.37157 11.7574 1.60589L15.1515 5L11.7574 8.39411C11.523 8.62843 11.523 9.00833 11.7574 9.24264C11.9917 9.47696 12.3716 9.47696 12.6059 9.24264L16.4243 5.42426ZM0 5.6H16V4.4H0V5.6Z"/>
												</svg>
											</button>
											</form>
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
