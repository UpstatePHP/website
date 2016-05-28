<?php
add_action('wp_enqueue_scripts', 'add_scripts_styles');

function add_scripts_styles() {
	if(!is_admin()) {
		// JS
		wp_enqueue_script("jquery");
		wp_enqueue_script('google-maps', '//maps.google.com/maps/api/js?sensor=true');
		wp_enqueue_script('main-script', ASSETS_DIR . '/js/site.min.js', ['jquery', 'google-maps'], '1.0', true);

		// CSS
		wp_enqueue_style('main-style', ASSETS_DIR . '/css/style.css');
		wp_enqueue_style('custom-style', ASSETS_DIR . '/css/site.min.css');

		// WP
		wp_enqueue_script('comment-reply');
	}
}
