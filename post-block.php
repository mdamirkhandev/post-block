<?php

/**
 * Plugin Name:       Post Block
 * Description:       Example block scaffolded with Create Block tool.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       post-block
 *
 * @package           create-block
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
function post_block_block_init()
{
	register_block_type(__DIR__ . '/build', array(
		'render_callback' => 'post_block_render',
	));
}
add_action('init', 'post_block_block_init');
require_once __DIR__ . '/src/post-render.php';


//enqueue js full function and hook
function post_js_enqueue()
{
	wp_enqueue_script('jquery');
	wp_enqueue_script('post-block', plugin_dir_url(__FILE__) . 'src/loadMorePosts.js', array('jquery'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'post_js_enqueue');

//register rest variable
function register_rest_field_featuredImage()
{
	register_rest_field('post', 'featuredImage', array(
		'get_callback' => function () {
			return get_the_post_thumbnail('', 'medium');
		},
	));
}
add_action('rest_api_init', 'register_rest_field_featuredImage');
