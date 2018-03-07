<?php
function total_child_enqueue_parent_theme_style() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css', array(), WPEX_THEME_VERSION );
}
add_action( 'wp_enqueue_scripts', 'total_child_enqueue_parent_theme_style' );

function register_my_menu() {
  register_nav_menu('new-menu',__( 'Top Menu' ));
}
add_action( 'init', 'register_my_menu' );


function my_acf_init() {
	
	acf_update_setting('google_api_key', 'AIzaSyDO5EyGR3u-VJgbdcBYSqe1hHxZz6nyFv4');
}

add_action('acf/init', 'my_acf_init');


function enqueue_masonry_script() {
    wp_enqueue_script('masonry');
}
add_action('wp_enqueue_scripts', 'enqueue_masonry_script');

// Add custom font to font settings
// This is for NON-Google Fonts
function wpex_add_custom_fonts() {
	return array(  
	
		"Proxim Nova"    => "proxima-nova",  
		"Museo Slab"     =>  "museo-slab"          
    );
}

function event_details_cpt_single_blocks( $blocks ) {

    
    // Option 2: Total 4.0+ only
    // Add new blocks with custom function output
    // Below is an example with an anonymous function but you can use custom functions as well ;)
    $blocks['custom_block'] = function() {

        echo '';

    };

    // Remove these content blocks
     unset( $blocks['comments'] );
	 unset( $blocks['meta'] );
	 unset( $blocks['title'] );
	 unset( $blocks['media'] );
	
    // Return blocks
    return $blocks;

}
add_filter( 'wpex_ai1ec_event_single_blocks', 'event_details_cpt_single_blocks' );


function my_custom_sidebar_display( $sidebar ) {
	// Return a different sidebar for custom post type 'ai1ec_event'
	if ( is_singular( 'ai1ec_event' ) ) {
		return 'eventssidebar';
	}
	// Return theme defined sidebar area
	else {
		return $sidebar;
	}
}
add_filter( 'wpex_get_sidebar', 'my_custom_sidebar_display' );





//function my_post_meta( $content ) {
 
   // $my_meta = get_post_meta( get_the_ID() );
  //  $my_meta_data = '<pre>' . print_r( $my_meta, true ) . '</pre>';
 
  //  return $content . $my_meta_data;
 
//}
 
//if( !is_admin() ) {
 
  //  add_filter( 'the_content', 'my_post_meta' );
 
//}


function menu_function($atts, $content = null) {
	extract(
		shortcode_atts(
			array( 'name' => null, ),
				$atts
				)
			);
	return wp_nav_menu(
		array(
			'menu' => $name,
			'echo' => false
					)
					);
			}
	add_shortcode('menu', 'menu_function');
	

//Adding Total Theme Meta Fields to Custom Post Types//

// Sample function showing how to tweak the metaboxes display for post types
add_filter( 'wpex_main_metaboxes_post_types', function( $types ) {

  // Add to my custom-type post type
  $types[] = 'ai1ec_event';

  // Remove from blog posts
  unset( $types['post'] );

  // Return post types array
  return $types;
  
}, 40 );

//Restricting Custom Fields and Meta Settings to Admins Only 

if ( is_admin() && ! current_user_can( 'administrator' ) ) {
	add_filter( 'wpex_metaboxes', '__return_false' );
}

// Remove staff settings metabox
add_filter( 'wpex_main_metaboxes_post_types', function( $types ) {
	unset( $types['staff'] );
	return $types;
}, 40 );

// Remove staff gallery
add_filter( 'wpex_gallery_metabox_post_types', function( $types ) {
	$types = array_combine( $types, $types );
	unset( $types['staff'] );
	return $types;
}, 40 );
