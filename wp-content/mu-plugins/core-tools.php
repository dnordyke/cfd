<?php
/**
 * @wordpress-plugin
 * Plugin Name:       Common Functionality
 * Description:       Common functions and logic for WordPress web sites
 * Version:           1.0.6
 * Author:            Daniel M. Hendricks
 * Author URI:        https://www.danhendricks.com
 * License:           GPL-2.0
 * License URI:       https://opensource.org/licenses/GPL-2.0
 */

namespace TwoLabNet\CoreTools;

class Tools {

  function __construct() {

    if( !$this->is_ajax() ) {

      // Modify settings based on environment (development, staging, production)
      $this->update_options_by_environment();

      // Add asynchronous loading of javascripts to wp_enqueue_script
      add_filter( 'clean_url', array( $this, 'enable_wp_enqueue_script_attributes' ), 11, 1 );

      // Disable emoji support by default
      if( !defined( 'TWOLAB_ENABLE_EMOJI' ) || !TWOLAB_ENABLE_EMOJI ) add_action( 'init', array( $this, 'disable_emojicons' ) );

      // Auto-login user logic
      if( defined( 'WP_ENV' ) && in_array( WP_ENV, array( 'development', 'staging' ) ) && defined( 'TWOLAB_AUTO_LOGIN' ) && TWOLAB_AUTO_LOGIN && defined( 'TWOLAB_AUTO_LOGIN_USER' ) && defined( 'TWOLAB_AUTO_LOGIN_PASS' ) ) {
        add_action( 'after_setup_theme', array( &$this, 'auto_login' ) );
      }

      // Change admin bar color for non-production instances
      if( is_admin() && defined( 'TWOLAB_ADMIN_BAR_COLOR' ) && TWOLAB_ADMIN_BAR_COLOR ) {
        add_action( 'wp_head', array( $this, 'change_admin_bar_color' ) );
        add_action( 'admin_head', array( $this, 'change_admin_bar_color' ) );
      }

    }

    // Limit the number of post revisions to keep
    if( defined('TWOLAB_REVISIONS_LIMIT') ) add_filter( 'wp_revisions_to_keep', array( $this, 'limit_post_revisions' ), 10, 2);

    // Initialize [current_year] shortcode
    if( !shortcode_exists('current_year') ) add_shortcode( 'current_year', array( $this, 'shortcode_current_year') );

    // Remove script versions
    if( !defined( 'WP_ENV' )  || ( defined( 'WP_ENV' ) && !in_array( WP_ENV, array( 'development', 'staging' ) ) ) ) {
      add_filter( 'style_loader_src', array( $this, 'remove_script_versions' ), 9999 );
      add_filter( 'script_loader_src', array( $this, 'remove_script_versions' ), 9999 );
    }

  }

  /**
    * Enables the use of #asyncload and #deferload with wp_enqueue_script(). Helps with Google PageSpeed Index
    * Example: wp_enqueue_style( 'childstyle', get_stylesheet_directory_uri().'/style.css#asyncload' );
    */
  public function enable_wp_enqueue_script_attributes($url) {

    switch(true) {
      case is_admin():
        return str_replace( ['#asyncload', '#deferload'], ['', ''], $url );
        break;
      case strpos( $url, '#asyncload'):
        return str_replace( '#asyncload', '', $url )."' async='true";
        break;
      case strpos($url, '#deferload'):
        return str_replace( '#deferload', '', $url )."' defer='true";
        break;
      default:
        return $url;
    }

  }

  /**
    * Limit the number of post revisions that WordPress keeps
    * To enable, add the following to wp-config.php:
    *    define( 'TWOLAB_REVISIONS_LIMIT', 5 ); // Replace '5' with the number of revisions to keep
    * Reference: https://premium.wpmudev.org/blog/post-revisions/
    */
  public function limit_post_revisions( $num, $post ) {
    return defined('TWOLAB_REVISIONS_LIMIT') && is_numeric(TWOLAB_REVISIONS_LIMIT) ? TWOLAB_REVISIONS_LIMIT : $num;
  }

  /**
    * Automatically disables Emoji code in page header.
    * This may be disabled by adding the following to wp-config.php: define('TWOLAB_ENABLE_EMOJI', true);
    */
  public function disable_emojicons() {
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    add_filter( 'tiny_mce_plugins', function( $plugins) {
      return is_array($plugins) ? array_diff($plugins, array('wpemoji')) : $plugins;
    });
  }

  /**
    * Create [current_year] shortcode, which simply outputs the current year
    *
    * Usage: Copyright &copy[current_year] Simply Design Group
    * Example Output: Copyright (c)2017 Simply Design Group
    */
  public function shortcode_current_year($atts, $content = null) {
    return date('Y');
  }

  /**
    * Automatically logs in a user (to be used for development
    * purposes only!)
    *
    * Required constants in wp-config.php:
    *   define('WP_ENV', 'development') // Can be set to either 'development' or 'staging'. Does not work in production for security reasons.
    *   define('TWOLAB_AUTO_LOGIN', true); // Set to false to temporarily disable
    *   define('TWOLAB_AUTO_LOGIN_USER', 'your_username');
    *   define('TWOLAB_AUTO_LOGIN_PASS', 'your_wordpress_password'); // This is in cleartext, which is why you don't want to use it in production.
    * Optional contants in wp-config.php:
    *   define('TWOLAB_AUTO_LOGIN_SSL', true); // Defines whether or not you want to be logged in with a secure cookie
    *   define('TWOLAB_AUTO_LOGIN_ERRORS', true); // Show a WordPress error if the login fails?
    */
  public function auto_login() {
    if(!is_user_logged_in()) {
      $creds = array(
        'user_login' => TWOLAB_AUTO_LOGIN_USER,
        'user_password' => TWOLAB_AUTO_LOGIN_PASS,
        'remember' => true
      );
      $user = wp_signon( $creds, defined('TWOLAB_AUTO_LOGIN_SSL') ?: true );
      if ( defined('TWOLAB_AUTO_LOGIN_ERRORS') && TWOLAB_AUTO_LOGIN_ERRORS && is_wp_error($user) ) wp_die($user->get_error_message());
    }
  }

  /**
    * Makes changes to WordPress configuration based on value of WP_ENV
    */
  private function update_options_by_environment() {

    /**
      * Change settings for non-production/live instances
      */
    if(!defined('WP_ENV') || WP_ENV != 'production') {

      /* Update admin e-mail relative to instance type (except on production)
       * Requires constance WP_ADMIN_EMAIL be defined in wp-config.
       * Example: define('WP_ADMIN_EMAIL', 'yourname@simplydg.com');
       */
      if(defined('WP_ADMIN_EMAIL')) update_option('admin_email', WP_ADMIN_EMAIL);

    }

  }

  /**
    * Disable plugin updates for specific plugins. Example usage:
    *   \SimplyDG\Toolkit\Tools::disable_plugin_updates(array('akismet/akismet.php', 'js_composer/js_composer.php'));
    */
  public function disable_plugin_updates($plugins = array()) {
    add_filter( 'site_transient_update_plugins', function($value) {
      if(!$plugins) return $value;
      if(!is_array($plugins)) $plugins = array($plugins);
      foreach($plugins as $plugin_path) {
        if(isset($value->response[$plugin_path])) unset( $value->response[$plugin_path] );
      }
      return $value;
    });
  }

  /**
    * Set a different admin bar color color. Useful for differentiating between
    *    environnments. Example usage (to be placed in wp-config.php):
    *   define( 'TWOLAB_ADMIN_BAR_COLOR', '#336699' );
    */
  public function change_admin_bar_color() {
    echo '<style id="twolab_admin_options">#wpadminbar { background: ' . TWOLAB_ADMIN_BAR_COLOR . '; ?> !important; }</style>';
  }

  /**
    * Determine if current request is AJAX
    * @return bool
    * @since 1.0.0
    */
  private function is_ajax() {
    return defined( 'DOING_AJAX' ) && DOING_AJAX;
  }

  /**
    * Remove versions from linked scripts
    * @since 1.0.6
    */
  public function remove_script_versions( $src ) {
    if ( strpos( $src, 'ver=' ) ) $src = remove_query_arg( 'ver', $src );
    return $src;
  }

}
new Tools();
