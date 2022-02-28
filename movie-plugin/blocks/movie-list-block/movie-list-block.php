<?php

/**
 * Plugin Name:       Movie List
 * Description:       Example block written with ESNext standard and JSX support – build step required.
 * Requires at least: 5.8
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       movie-list-block
 *
 * @package           movie-plugin
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function movie_plugin_movie_list_block_block_init()
{
	register_block_type(__DIR__ . '/build', ["render_callback" => "movie_plugin_movie_list_block_block_render"]);
	// register_block_type(__DIR__ . '/build', ["render_callback" => plugin_dir_path(__FILE__)."/frontend/movie-list-block-render.php"]);
}
add_action('init', 'movie_plugin_movie_list_block_block_init');

function movie_plugin_movie_list_block_block_render()
{
	ob_start();
	include(plugin_dir_path(__FILE__)."/frontend/movie-list-block-render.php");
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}
