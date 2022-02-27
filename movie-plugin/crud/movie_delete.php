<?php
add_action('admin_post_movie_delete', 'movie_delete');

function movie_delete()
{
    global $wpdb;
    $table = $wpdb->prefix . "movie_entries";
    $data = array(
        'id'    => $_POST['id']
    );
    $format = array(
        '%d'
    );
    $success = $wpdb->delete($table, $data, $format);
    wp_redirect(admin_url() . 'admin.php?page=movie_menu_list');
    exit();
}
