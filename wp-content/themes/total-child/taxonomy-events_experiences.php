<?php
/**
 * Event item template for events_experiences taxonomy
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Total WordPress Theme
 * @subpackage Templates
 * @version 4.5
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$category = $wp_query->get_queried_object();

get_header(); ?>

	<div id="content-wrap" class="container clr">

		<?php wpex_hook_primary_before(); ?>

		<div id="primary" class="content-area clr">

			<?php wpex_hook_content_before(); ?>

			<div id="content" class="site-content cfd-events-experiences-container">

				<?php wpex_hook_content_top(); ?>

				<?php
				// Display posts if there are in fact posts to display
				if ( have_posts() ) :

					// Get index loop type
					$loop_type = wpex_get_index_loop_type();

					// Get loop top
					get_template_part( 'partials/loop/loop-top', $loop_type );
					$event_content_top = carbon_get_term_meta( $category->term_id, 'experience_content_top' );
					?>
					<div class="site-content-padded">
						<?php if( $event_content_top ): ?>
						<div class="cfd-events-experiences-content cfd-events-experiences-content-top">
							<?php echo $event_content_top; ?>
						</div>
					<?php endif; ?>

						<div class="bootstrap-wrapper" id="ai1ec_event_list">
							<div class="container cfd-fixed-container">
								<div class="row">
						<?php
						// Define counter for clearing floats
						$wpex_count = 0;

						// Loop through posts
						while ( have_posts() ) : the_post();

							// Get content template part
							//get_template_part( 'partials/loop/loop', $loop_type );
							get_template_part( 'partials/experiences', 'event' );

						// End loop
						endwhile;
						?>
							</div>
						</div>
					</div>

					<?php
					// Get loop bottom
					get_template_part( 'partials/loop/loop-bottom', $loop_type );

					// Display pagination
					/*
					if ( 'blog' == $loop_type ) {
						global $wp_query;
						wpex_blog_pagination( array(
							'query'    => $wp_query->query,
							'grid'     => '#blog-entries',
							'count'    => $wpex_count,
							'perPage'  => $wp_query->query_vars['posts_per_page'],
							'maxPages' => $wp_query->max_num_pages,
							'columns'  => wpex_blog_entry_columns(),
							'category' => is_category() ? get_query_var( 'cat' ) : false,
						) );
					} else {
						wpex_pagination();
					}
					*/
					?>

				<?php
				// Show message because there aren't any posts
				else : ?>

					<article class="clr"><?php esc_html_e( 'No Posts found.', 'total' ); ?></article>

				<?php endif; ?>

				<?php
				 	wpex_hook_content_bottom();
					$event_content_bottom = carbon_get_term_meta( $category->term_id, 'experience_content_bottom' );
				?>

				<?php if( $event_content_bottom ): ?>
				 <div class="site-content-padded">
					 <div class="cfd-events-experiences-content cfd-events-experiences-content-bottom">
						 <?php echo do_shortcode( $event_content_bottom ); ?>
					 </div>
			 	</div>
			 <?php endif; ?>

			</div><!-- #content -->

		<?php wpex_hook_content_after(); ?>

		</div><!-- #primary -->

		<?php wpex_hook_primary_after(); ?>

	</div><!-- .site-content-padded -->
</div><!-- .container -->

<?php get_footer(); ?>
