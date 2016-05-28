<?php


// set content width for no reason at all (not even joking right now)
if ( ! isset( $content_width ) ) $content_width = 900;

function base_head_cleanup() {
  // category feeds
  // remove_action( 'wp_head', 'feed_links_extra', 3 );
  // post and comment feeds
  // remove_action( 'wp_head', 'feed_links', 2 );
  // EditURI link
  remove_action( 'wp_head', 'rsd_link' );
  // windows live writer
  remove_action( 'wp_head', 'wlwmanifest_link' );
  // previous link
  remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
  // start link
  remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
  // links for adjacent posts
  remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
  // WP version
  remove_action( 'wp_head', 'wp_generator' );
  // remove WP version from css
  add_filter( 'style_loader_src', 'base_remove_wp_ver_css_js', 9999 );
  // remove Wp version from scripts
  add_filter( 'script_loader_src', 'base_remove_wp_ver_css_js', 9999 );
} /* end bones head cleanup */

// remove WP version from RSS
function base_rss_version() { return ''; }
// remove WP version from scripts
function base_remove_wp_ver_css_js( $src ) {
  if ( strpos( $src, 'ver=' ) )
    $src = remove_query_arg( 'ver', $src );
  return $src;
}
// remove injected CSS for recent comments widget
function base_remove_wp_widget_recent_comments_style() {
  if ( has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) ) {
    remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
  }
}
// remove injected CSS from recent comments widget
function base_remove_recent_comments_style() {
  global $wp_widget_factory;
  if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
    remove_action( 'wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style') );
  }
}
// remove injected CSS from gallery
function base_gallery_style($css) {
  return preg_replace( "!<style type='text/css'>(.*?)</style>!s", '', $css );
}

// This removes the annoying […] to a Read More link
function base_excerpt_more($more) {
  global $post;
  // edit here if you like
  return '...  <a class="excerpt-read-more" href="'. get_permalink( $post->ID ) . '" title="'. __( 'Read ' ) . esc_attr( get_the_title( $post->ID ) ).'">'. __( 'Read more &raquo;' ) .'</a>';
}

function base_boot() {

  // theme support '
  add_theme_support( 'automatic-feed-links' );
  add_theme_support( 'post-thumbnails' );
  add_theme_support( 'title-tag' );

  //Allow editor style.
  add_editor_style();
  // launching operation cleanup
  add_action( 'init', 'base_head_cleanup' );
  // remove WP version from RSS
  add_filter( 'the_generator', 'base_rss_version' );
  // remove pesky injected css for recent comments widget
  add_filter( 'wp_head', 'base_remove_wp_widget_recent_comments_style', 1 );
  // clean up comment styles in the head
  add_action( 'wp_head', 'base_remove_recent_comments_style', 1 );
  // clean up gallery output in wp
  add_filter( 'gallery_style', 'base_gallery_style' );
  // cleaning up excerpt
  add_filter( 'excerpt_more', 'base_excerpt_more' );
} /* end bones ahoy */

add_action( 'after_setup_theme', 'base_boot' );
add_filter( 'pre_option_link_manager_enabled', '__return_true' );
