<?php
/**
 *
 *
 * Loads content section blog of home page.
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

// Args for blog.
$args_blog = array(
	'post_type'           => 'post',
	'post_status'         => 'publish',
	'posts_per_page'      => 5,
	'ignore_sticky_posts' => 1,
);
// Blog Featured.
$blog_featured = get_posts( $args_blog );

?>

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

