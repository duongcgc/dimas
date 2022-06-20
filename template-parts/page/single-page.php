<?php
/**
 *
 *
 * Loads content of single page.
 *
 * @link https://www.gcosoftware.vn/
 *
 * @package Dimas
 *
 * @since Dimas 1.0
 */

?>
<?php
while ( have_posts() ) :
	the_post();
	?>

<main id="content" role="main">
	<header class="page-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header>
	
	<div class="page-content">
		<?php the_content(); ?>
		<div class="post-tags">
			<?php the_tags( '<span class="tag-links">' . __( 'Tagged ', 'hello-elementor' ), null, '</span>' ); ?>
		</div>
	</div>

	<?php comments_template(); ?>
</main>

	<?php
endwhile;
