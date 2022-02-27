<?php
function register_block_movie_list_widget() {
    register_block_type( __DIR__ );
}
add_action( 'init', 'register_block_movie_list_widget' );