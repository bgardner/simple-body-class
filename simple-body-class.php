<?php
/**
 * Plugin Name: Simple Body Class
 * Plugin URI: https://briangardner.com/simple-body-class/
 * Description: Add custom body classes per post or page.
 * Version: 0.5
 * Author: Brian Gardner
 * Author URI: https://briangardner.com/
 * Text Domain: simple-body-class
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Register meta field.
add_action( 'init', function() {
	register_post_meta( '', 'simple_body_class', [
		'type' => 'string',
		'single' => true,
		'show_in_rest' => true,
		'auth_callback' => function() {
			return current_user_can( 'edit_posts' );
		},
	] );
});

// Append body classes.
add_filter( 'body_class', function( $classes ) {
	if ( is_singular() ) {
		$class = trim( (string) get_post_meta( get_the_ID(), 'simple_body_class', true ) );
		if ( $class ) {
			foreach ( preg_split( '/\s+/', $class ) as $c ) {
				$classes[] = sanitize_html_class( $c );
			}
		}
	}
	return $classes;
});

// Load editor UI.
add_action( 'enqueue_block_editor_assets', function() {
	wp_enqueue_script(
		'simple-body-class-editor',
		plugins_url( 'editor.js', __FILE__ ),
		[ 'wp-plugins', 'wp-edit-post', 'wp-element', 'wp-components', 'wp-data' ],
		filemtime( plugin_dir_path( __FILE__ ) . 'editor.js' )
	);
});
