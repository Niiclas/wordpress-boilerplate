<?php 
add_shortcode("movielist", "movielist_shortcode_function");
function movielist_shortcode_function(){
    global $wpdb;
$movies = $wpdb->get_results(
    <<<SQL
        SELECT * 
        FROM {$wpdb->prefix}movie_entries as me
        LEFT JOIN (
            SELECT GROUP_CONCAT(presentation ORDER BY presentation ASC) as presentations, movie
            FROM {$wpdb->prefix}presentations
            GROUP BY movie
        ) as mp
        ON me.id = mp.movie
        ORDER BY created_at DESC;
    SQL
);
ob_start();	
?> 
<div class="wp-block-movie-plugin-movie-list-block">
    <?php foreach ($movies as $movie) { ?>
        <h4><?= $movie->title; ?></h4>
        <div><?= $movie->text; ?></div>
        <div class="wp-block-movie-url"><?= $movie->url; ?></div>
        <?php if ($movie->image) { ?>
            <img src="<?= wp_get_attachment_image_src($movie->image)[0]; ?>" />
        <?php } ?>
        <?php foreach (explode(',', $movie->presentations) as $presentation) { ?>
            <div class="wp-block-movie-presentation"><?= $presentation; ?></div>
        <?php } ?>
    <?php } ?>
</div>
<?php
$content = ob_get_contents();
ob_end_clean();
return $content;
}
?>