<?php
/**
 *
 *
 * Loads content of archive post.
 *
 * @link https://www.gcosoftware.vn/
 *
 * @package GCO
 * @subpackage Dimas
 * @since Dimas 1.0
 */

?>
<?php
global $wp_query;
$max_page = $wp_query->max_num_pages;
/**
 * Dimas pagination function.
 *
 * @return string
 */
function dimas_pagination() {
	global $wp_query;
	$max_page = $wp_query->max_num_pages;
	$big      = 9999999;
	$arr_pag  = paginate_links(
		array(
			'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format'    => '?paged=%#%',
			'next_text' => __( '<svg width="20" height="36" viewBox="0 0 20 36" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.66699 34L17.667 18L1.66699 2" stroke="currentColor" stroke-width="2" stroke-linecap="square"></path></svg>' ),
			'prev_text' => __( '<svg width="20" height="36" viewBox="0 0 20 36" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18.333 34L2.33301 18L18.333 2" stroke="currentColor" stroke-width="2" stroke-linecap="square"></path></svg>' ),
			'current'   => max( 1, get_query_var( 'paged' ) ),
			'total'     => $max_page,
			'end_size'  => 1,
			'mid_size'  => 1,
			'type'      => 'array',
		)
	);
	$out      = '<ul class="dimas-pagination__wrap">';
	foreach ( $arr_pag as $key => $value ) :
		if ( str_contains( $value, 'prev' ) ) :
			$out .= '<li class="dimas-pagination__wrap--item prev-page">' . $value;
			$out .= '</li>';
		elseif ( str_contains( $value, 'next' ) ) :
			$out .= '<li class="dimas-pagination__wrap--item next-page">' . $value;
			$out .= '</li>';
		elseif ( str_contains( $value, 'current' ) ) :
			$out .= '<li class="dimas-pagination__wrap--item current-page">' . $value;
			$out .= '</li>';
		elseif ( str_contains( $value, 'dots' ) ) :
			$out .= '<li class="dimas-pagination__wrap--item dot-page">' . $value;
			$out .= '</li>'; else :
				$out .= '<li class="dimas-pagination__wrap--item">' . $value;
				$out .= '</li>';
		endif;
	endforeach;
	$out .= '</ul>';
	return $out;
}
?>
		<main class="dimas-main">
			<div class="dimas-archive">
				<div class="dimas-blog-archive">
					<div class="dimas-blog-archive__vertical-align container">
						<h2 class="dimas-post-info__post-title label-banner has-color-white mb-0 pb-5 pb-lg-96 mx-auto">
							Latest Posts
						</h2>
						<div class="dimas-posts dimas-grid-wrap grid">
						<?php
						if ( have_posts() ) :
							while ( have_posts() ) :
								the_post();
								?>
							<article class="dimas-section__item dimas-section__item--blog dimas-post grid-item grid-sizer">
								<div class="dimas-post__thumbnail dimas-post__thumbnail--wrap">
									<a class="dimas-post__link" href="<?php the_permalink(); ?>">
										<img class="dimas-post__thumbnail dimas-post__thumbnail--img" src="<?php the_post_thumbnail_url(); ?>" alt="Post thumbnail">
										<div class="dimas-post__thumbnail dimas-post__thumbnail--arrow-wrap">
											<svg width="25" height="16" viewBox="0 0 25 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
													<path d="M24.7071 8.70711C25.0976 8.31658 25.0976 7.68342 24.7071 7.29289L18.3431 0.928932C17.9526 0.538408 17.3195 0.538408 16.9289 0.928932C16.5384 1.31946 16.5384 1.95262 16.9289 2.34315L22.5858 8L16.9289 13.6569C16.5384 14.0474 16.5384 14.6805 16.9289 15.0711C17.3195 15.4616 17.9526 15.4616 18.3431 15.0711L24.7071 8.70711ZM0 9H24V7H0V9Z"/>
												</svg>
										</div>
									</a>
								</div>
								<div class="dimas-post__content dimas-post__content--wrap">
									<h6 class="dimas-post__date has-color-main label-content mb-3">
										<?php echo get_the_date(); ?>
									</h6>
									<h3 class="dimas-post__title has-color-white mb-3">
										<?php the_title(); ?>
									</h3>
									<p class="dimas-post__description mb-0 has-color-subtitle">
										<?php echo esc_html( get_the_excerpt() ); ?>
									</p>
								</div>
							</article>
								<?php
							endwhile;
							?>
						<?php else : ?>
							<h3 class="empty_post">Chuyên mục chưa có bài viết, vui lòng quay lại sau.</h3>
							<?php
						endif;
						?>
						</div>
						<?php
						if ( $max_page > 1 ) :
							?>
						<div class="dimas-pagination pt-5 pt-lg-96">
								<?php
								echo wp_kses(
									dimas_pagination(),
									array(
										'ul'   => array(
											'class' => array(),
										),
										'li'   => array(
											'class' => array(),
										),
										'span' => array(
											'class' => array(),
										),
										'a'    => array(
											'href'  => array(),
											'title' => array(),
											'rel'   => array(),
										),
										'svg'  => array(
											'width'   => array(),
											'height'  => array(),
											'fill'    => array(),
											'xmlns'   => array(),
											'viewbox' => array(),
										),
										'path' => array(
											'd'            => array(),
											'stroke'       => array(),
											'stroke-width' => array(),
											'stroke-linecap' => array(),
										),
									)
								);
								?>
							</ul>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</main>
