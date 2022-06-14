<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://www.gcosoftware.vn/
 *
 * @package GCO
 * @subpackage Dimas
 * @since Dimas 1.0
 */

if ( post_password_required() ) {
	return;
}

// Comment Reply Script.
if ( comments_open() && get_option( 'thread_comments' ) ) {
	wp_enqueue_script( 'comment-reply' );
}


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
	protected function html5_comment( $comment, $depth, $args ) { ?>
		<li id="comment-<?php comment_ID(); ?>" class="comment-main">
			<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
				<div class="author-avtar">
					<?php
					$comment_author_link = get_comment_author_link( $comment );
					$comment_author_url  = get_comment_author_url( $comment );
					$comment_author      = get_comment_author( $comment );
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
							<?php echo esc_html( get_comment_author_link( $comment ) ); ?>
						</h4>
						<h4 class="comment-date">
							<?php echo esc_html( get_comment_date( '', $comment ) ); ?>
						</h4>
					</div>
					<p class="comment-text mb-0">
						<?php echo esc_html( get_comment_text() ); ?>
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
$current_post_id = get_the_id();
?>
<div class="dimas-post__comment pt-8 pt-md-96">
	<div class="container">
		<div class="dimas-post-comment-wrap row">
			<div class="col-md-8 mx-auto">
				<h2 class="section-title label-banner  mb-5 mb-md-8 has-color-white">
					Comments
				</h2>
				<?php if ( have_comments() ) : ?>
					<?php the_comments_navigation(); ?>
					<div class="view-comment mb-8">
						<ul class="comment-list">
							<?php
							wp_list_comments(
								array(
									'walker'      => new Dimas_Walker_Comment(),
									'style'       => 'ul',
									'short_ping'  => true,
									'avatar_size' => 80,
								)
							);
							?>
						</ul><!-- .comment-list -->
					</div>
					<?php the_comments_navigation(); ?>
				<?php endif; ?>

				<?php

				$args_comment_form = array(
					'fields'               => apply_filters(
						'comment_form_default_fields',
						array(
							'author'  => '<div class="dimas-form-row two-col"><div class="dimas-form-group"><input class="dimas-form-control" type="text" id="author" name="author" placeholder="Name *" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" aria-required="true" /></div>',
							'email'   => '<div class="dimas-form-group"><input class="dimas-form-control" type="email" id="email" name="email" placeholder="Email *" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) . '" aria-required="true" /></div></div>',
							'url'     => '',
							'cookies' => '',
						)
					),
					'comment_field'        => '<div class="dimas-form-row" style="grid-row-start: 2;" ><textarea class="dimas-form-control" name="comment" id="comment" rows="4"  cols="100" rows="4" aria-required="true" placeholder="Comment *"></textarea></div>',
					'comment_notes_before' => '',
					'comment_notes_after'  => '',
					'title_reply'          => esc_html__( 'Add comment', 'dimas' ),
					'title_reply_before'   => '<h3 class="label-form-comment mb-5 mb-md-8 has-color-white">',
					'title_reply_after'    => '</h3>',
					'title_reply_to'       => esc_html__( 'Reply', 'dimas' ),
					'label_submit'         => 'post comment',
					'class_submit'         => 'dimas-btn label-content has-color-white has-bg-main',
					'submit_field'         => '%1$s %2$s',
					'submit_button'        => '<button style="width:fit-content" name="%1$s" type="submit" id="%2$s" class="%3$s">%4$s<svg width="17" height="10" viewBox="0 0 17 10" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M16.4243 5.42426C16.6586 5.18995 16.6586 4.81005 16.4243 4.57574L12.6059 0.757359C12.3716 0.523045 11.9917 0.523045 11.7574 0.757359C11.523 0.991674 11.523 1.37157 11.7574 1.60589L15.1515 5L11.7574 8.39411C11.523 8.62843 11.523 9.00833 11.7574 9.24264C11.9917 9.47696 12.3716 9.47696 12.6059 9.24264L16.4243 5.42426ZM0 5.6H16V4.4H0V5.6Z" /></svg></button>',
					'class_container'      => 'form-comment',
					'class_form'           => 'dimas-comment-form d-grid',
					'logged_in_as'         => sprintf(
						'<p class="logged-in-as mb-5">%s%s</p>',
						sprintf(
							/* translators: 1: Edit user link, 2: Accessibility text, 3: User name, 4: Logout URL. */
							__( '<a href="%1$s" aria-label="%2$s">Logged in as %3$s</a>. <a href="%4$s">Log out?</a>' ),
							get_edit_user_link(),
							/* translators: %s: User name. */
							esc_attr( sprintf( __( 'Logged in as %s. Edit your profile.' ), $user_identity ) ),
							$user_identity,
							/** This filter is documented in wp-includes/link-template.php */
							wp_logout_url( apply_filters( 'the_permalink', get_permalink( $current_post_id ), $current_post_id ) )
						),
						sprintf(
							' <span class="required-field-message" aria-hidden="true">' . __( 'Required fields are marked <span class="required" aria-hidden="true">*</span>' ) . '</span>',
						)
					),
				);
				comment_form( $args_comment_form );
				?>
			</div>
		</div><!-- #comments -->
