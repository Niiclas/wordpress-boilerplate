<?php
add_action('admin_menu', 'movie_edit_add_menu_page');
function movie_edit_add_menu_page()
{
    add_menu_page("Movie edit", "Movie Edit", "manage_options", "movie_menu_edit", "movie_menu_edit");
}
function movie_menu_edit()
{
    $movie = null;
    if ($_GET["edit"]) {
        global $wpdb;
        $movie_query = $wpdb->prepare(
            <<<SQL
                SELECT * 
                FROM {$wpdb->prefix}movie_entries as me
                WHERE id = %d
                ORDER BY created_at DESC;
            SQL,
            $_GET["edit"]
        );
        $movie = $wpdb->get_results($movie_query)[0];
        $presentations_query = $wpdb->prepare(
            <<<SQL
    SELECT * 
    FROM {$wpdb->prefix}presentations as me
    WHERE movie = %d
    ORDER BY presentation ASC;
SQL,
            $movie->id
        );
        $presentations = $wpdb->get_results($presentations_query);
    }
?>
    <div id="movie-list-create" class="content-area">
        <?php if ($movie) { ?>
            <h3>Edit <?= $movie->title; ?> </h3>
        <?php } else { ?>
            <h3>Add a new Movie</h3>
        <?php } ?>
        <form action="<?= admin_url('admin-post.php') ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="movie_save" />
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
            <p>
                <label> Image <br />
                    <?php if ($movie->image) { ?>
                        <img src="<?= wp_get_attachment_image_src($movie->image)[0]; ?>" />
                    <?php } ?>
                    <input type="file" name="image" size="55" /></label>
            </p>
            <?php for ($i = 0; $i < 10; $i++) {
                $pres_date = null;
                $pres_time = null;
                if ($presentations[$i]->presentation) {
                    $pres_date = explode(' ', $presentations[$i]->presentation)[0];
                    $pres_time = explode(' ', $presentations[$i]->presentation)[1];
                }
            ?>
                <p>
                    <label> Vorführtermin <?= $i + 1 ?><br />
                        <input type="hidden" name="presentation_id[<?= $i ?>]" value="<?= $presentations[$i]->id; ?>" />
                        <input type="date" name="presentation_date[<?= $i ?>]" value="<?= $pres_date; ?>" size="55" />
                        <input type="time" name="presentation_time[<?= $i ?>]" value="<?= $pres_time; ?>" size="55" />
                    </label>
                </p>
            <?php } ?>
            <p>
                <input type="submit" value="Send" class="wpcf7-form-control wpcf7-submit" />
            </p>
        </form>
        <?php if ($movie) { ?>
            <form action="<?= admin_url('admin-post.php') ?>" method="post">
                <input type="hidden" name="action" value="movie_delete" />
                <input type="hidden" name="id" value="<?= $movie->id; ?>" />
                <input type="submit" value="Delete" class="wpcf7-form-control wpcf7-danger" />
            </form>
        <?php } ?>

        </main><!-- .site-main -->
    </div><!-- .content-area -->
<?php } ?>