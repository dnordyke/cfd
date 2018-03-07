<?php
/**
 * Template Name: Masonry
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

	<!--Testing Masonry-->
    
    <style>
	/* Makes three columns */
.ms-item {
width: 33%;
}
</style>
    
<div class="row" id="ms-container">
     
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                
    <div class="ms-item col-lg-6 col-md-6 col-sm-6 col-xs-12">
    
    <ul>
<?php

global $post;
$args = array( 'posts_per_page' => 7, 'offset'=> 1, 'category' => 1 );

$myposts = get_posts( $args );
foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
	<li>
       <?php if (has_post_thumbnail()) : ?>
        
            <figure class="article-preview-image">
                
                <?php the_post_thumbnail('large'); ?>
                
            </figure>
        
        <?php else : ?>

        <?php endif; ?>
        
		<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	</li>
<?php endforeach; 
wp_reset_postdata();?>

</ul>
        
       
    <div class="clearfix"></div>
    
    </div>
                
    <?php endwhile;
                
    else : ?>

        <article class="no-posts">

            <h1><?php _e('No posts were found.'); ?></h1>

        </article>
    <?php endif; ?>
                    
                </div>
<div class="clearfix"></div>
    
    
    
    
      <script type="text/javascript">
        
        jQuery(window).load(function() {
      var container = document.querySelector('#ms-container');
      var msnry = new Masonry( container, {
        itemSelector: '.ms-item',
        columnWidth: '.ms-item',                
      });  
      
        });

      
    </script>

<?php get_footer(); ?>