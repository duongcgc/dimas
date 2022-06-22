<?php
/**
 *
 *
 * Loads content section projects of home page.
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
	
