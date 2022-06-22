<?php
/**
 * Dimas walker class.
 *
 * @package Dimas;
 * @version 1.0.0
 */

/**
 * Dimas_Walker_Comment class
 */
class Dimas_Walker_Comment extends Walker_Comment {

	/**
	 * Outputs a comment in the HTML5 format.
	 *
	 * @see wp_list_comments()
	 *
	 * @param WP_Comment $comment Comment to display.
	 * @param int        $depth   Depth of the current comment.
	 * @param array      $args    An array of arguments.
	 */
	protected function html5_comment( $comment, $depth, $args ) {    ?>
		<li id="comment-<?php comment_ID(); ?>" class="comment-main">
			<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
				<div class="author-avtar">
					<?php
					$comment_author_link = get_comment_author_link( $comment );
					$comment_author_url  = get_comment_author_url( $comment );
					$comment_date        = get_comment_date( '', $comment );
					$comment_text        = get_comment_text();
					$avatar              = get_avatar( $comment, 'thumbnail', '', 'Avatar author', array( 'class' => 'author-avtar__img' ) );
					if ( 0 != $args['avatar_size'] ) {
						if ( empty( $comment_author_url ) ) {
							echo wp_kses(
								$avatar,
								array(
									'img' => array(
										'src'   => array(),
										'alt'   => array(),
										'class' => array(),
									),
								)
							);
						} else {
							printf( '<a href="%s" rel="external nofollow" class="url">', esc_url( $comment_author_url ) );
							echo wp_kses(
								$avatar,
								array(
									'img' => array(
										'src' => array(),
										'alt' => array(),
									),
								)
							);
							printf( '</a>' );
						}
					}
					?>
				</div><!-- .comment-author-avatar -->
				<div class="comment-content">
					<div class="comment-info">
						<h4 class="author-name">
							<?php echo esc_html( $comment_author_link ); ?>
						</h4>
						<h4 class="comment-date">
							<?php echo esc_html( $comment_date ); ?>
						</h4>
					</div>
					<p class="comment-text mb-0">
						<?php echo esc_html( $comment_text ); ?>
					</p>
				</div><!-- .comment-content -->

				<?php
				comment_reply_link(
					array_merge(
						$args,
						array(
							'add_below' => 'div-comment',
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
							'before'    => '<div class="comment-reply">',
							'after'     => '</div',
						)
					)
				);
				?>
			</article>
		</li>
		<?php
	}
}
