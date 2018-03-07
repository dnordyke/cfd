<?php
/*
Plugin Name: CFD Custom Functions
Plugin URI: http://simplydg.com
Description: A custom site functions plugin for cfdrodeo.com
Version: 1.0
Author: Simply Design Group
*/
 
//[thepostid]
function thepostid_func( $atts ){
         global $post;
         return $post->ID;   
}
add_shortcode( 'thepostid', 'thepostid_func' );