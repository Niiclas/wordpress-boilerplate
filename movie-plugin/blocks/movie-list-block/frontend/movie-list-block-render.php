<?php
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
?>
<div class="wp-block-movie-plugin-movie-list-block">
    <?php foreach ($movies as $movie) { ?>
        <h4><?= $movie->title; ?></h4>
        <div><?= $movie->text; ?></div>
        <div class="wp-block-movie-url"><?= $movie->url; ?></div>
        <?php foreach (explode(',', $movie->presentations) as $presentation) { ?>
            <div class="wp-block-movie-presentation"><?= $presentation; ?></div>
        <?php } ?>
    <?php } ?>
</div>