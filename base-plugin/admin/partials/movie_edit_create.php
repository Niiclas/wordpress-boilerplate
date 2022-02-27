<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       jan-niclas-gladbach
 * @since      1.0.0
 *
 * @package    Base_Plugin
 * @subpackage Base_Plugin/admin/partials
 */
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php
$movie = null;
if ($_GET["edit"]) {
    global $wpdb;
    $movie_query = $wpdb->prepare(
<<<SQL
    SELECT * 
    FROM {$wpdb->prefix}movie_entries as me
    LEFT JOIN {$wpdb->prefix}presentations as mp
    ON me.id = mp.movie
    WHERE id = %d
    ORDER BY created_at DESC;
SQL
        ,$_GET["edit"]
    );
    $movie = $wpdb->get_results($movie_query)[0];
}
?>
<div id="primary" class="content-area">
    <?php if ($movie) { ?>
        <h3>Edit <?= $movie->title; ?> </h3>
    <?php } else { ?>
        <h3>Add a new Movie</h3>
    <?php } ?>
    <form method="post">
        <input type="hidden" name="action" value="save_movie" />
        <input type="hidden" name="id" value="<?= $movie->id; ?>" />
        <p>
            <label> Titel<br />
                <input type="text" name="title" value="<?= $movie->title; ?>" size="55" />
            </label>
        </p>
        <p>
            <label> Text<br />
                <input type="text" name="text" value="<?= $movie->text; ?>" size="55" />
            </label>
        </p>
        <p>
            <label> Url <br />
                <input type="text" name="url" value="<?= $movie->url; ?>" size="55" /></label>
        </p>
        <?php for($i = 0; $i < 10; $i++) { ?>
            <p>
            <label> Vorführtermin <?= $i + 1 ?><br />
                <input type="date" name="presentation_date[<?= $i ?>]" value="<?= $movie->url; ?>" size="55" />
                <input type="time" name="presentation_time[<?= $i ?>]" value="<?= $movie->url; ?>" size="55" />
            </label>
        </p>
            <?php } ?>
        <p>
            <input type="submit" value="Send" class="wpcf7-form-control wpcf7-submit" />
        </p>
    </form>

    </main><!-- .site-main -->
</div><!-- .content-area -->