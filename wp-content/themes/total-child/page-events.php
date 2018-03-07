<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;
/*
 * Template Name: All Events
 *
 * @package Total WordPress Theme
 * @subpackage Templates
 * @version 4.3
 * @see https://gsu.uservoice.com/knowledgebase/articles/133407-what-shortcodes-are-available-for-use-with-the-all
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//if( isset( $_GET['page'] ) {
if( class_exists( 'SimplyDG\CheyenneCore\Helpers' ) && ( isset( $_GET['date'] ) ) ) {
	global $wpdb;
	$event_ids = $wpdb->get_results( sprintf( 'SELECT DISTINCT ID FROM ' . $wpdb->prefix . 'posts p LEFT JOIN ' . $wpdb->prefix . "postmeta pm ON p.ID = pm.post_id WHERE p.post_type = 'ai1ec_event' AND pm.meta_key LIKE '_cfd_ai1ec_event_date_days|||%%' AND pm.meta_value = '%s'", $_GET['date'] ), ARRAY_N );
	$args = array(
		'post_type' => 'ai1ec_event',
		'posts_per_page' => -1,
		'include' => \SimplyDG\CheyenneCore\Helpers::flatten_results( $event_ids )
	);

	$ai1ec_events = get_posts( $args );
} else {
	$args = array( 'post_type' => 'ai1ec_event', 'posts_per_page' => -1 );
	$ai1ec_events = get_posts( $args );
}

get_header(); ?>

	<div id="content-wrap" class="container clr">

		<?php wpex_hook_primary_before(); ?>

		<div id="primary" class="content-area clr">

			<?php wpex_hook_content_before(); ?>

			<div id="content" class="site-content clr site-content-padded">

				<?php wpex_hook_content_top(); ?>

				<?php get_template_part( 'partials/event', 'filter' ); ?>

				<div class="bootstrap-wrapper" id="ai1ec_event_list">
					<div class="container cfd-fixed-container">
						<div class="row">

							<?php foreach ( $ai1ec_events as $ai1ec_event ) : setup_postdata( $post ); ?>

								<?php //wpex_get_template_part( 'page_single_blocks' ); ?>
								<?php get_template_part( 'partials/search', 'event' ); ?>

							<?php endforeach; wp_reset_postdata(); ?>

						</div>
					</div>
				</div>

				<?php the_content(); ?>
				<?php wpex_hook_content_bottom(); ?>

			</div><!-- #content -->

			<?php wpex_hook_content_after(); ?>

		</div><!-- #primary -->

		<?php wpex_hook_primary_after(); ?>

	</div><!-- .container -->

<?php get_footer(); ?>
