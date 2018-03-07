<?php
/**
 * The template for displaying all pages, single posts and attachments
 *
 * @package Total WordPress Theme
 * @subpackage Templates
 * @version 4.3
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


get_header(); ?>

<div id="content-wrap" class="container clr">

		<?php wpex_hook_primary_before(); ?>

		<div id="primary eventDetailsContainer" class="content-area clr">
        
        	


<div class="eventDetails" style="background: url('<?php the_post_thumbnail_url( 'full' );?>') top center no-repeat; background-size: 100% auto;">
			<?php wpex_hook_content_before(); ?>
            
           			<?php dynamic_sidebar( 'eventssidebar' ); ?>
	
				<?php

				// Start loop
				if ( have_posts() ) : the_post();
					
					wpex_get_template_part( 'cpt_single_blocks', get_post_type() );
					
                
						
				endif

				 ?>
                 
             

				<?php wpex_hook_content_bottom(); ?>

		</div>	<!-- #content -->

			<?php wpex_hook_content_after(); ?>

		</div><!-- #primary -->

		<?php wpex_hook_primary_after(); ?>

	<!-- .container -->


<?php get_footer(); ?>
</div>