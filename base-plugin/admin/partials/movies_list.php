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

<div class="wrap">
	<h2>Movies</h2>
	<?php
	global $wpdb;
	$edit_page = admin_url() . 'admin.php?page=' . $this->plugin_name . "-movie_edit";
	$movies = $wpdb->get_results(
		<<<SQL
    SELECT * 
    FROM {$wpdb->prefix}movie_entries as me
    LEFT JOIN (
        SELECT GROUP_CONCAT(presentation) as presentations, movie
        FROM {$wpdb->prefix}presentations
        GROUP BY movie
    ) as mp
    ON me.id = mp.movie
    ORDER BY created_at DESC;
SQL
	);
	?>
	<table class='widefat fixed'>
		<th>ID</th>
		<th>Titel</th>
		<th>Text</th>
		<th>Url</th>
		<th>Aufführungen</th>
		<th>Bearbeiten</th>
		<?php foreach ($movies as $movie) { ?>
			<tr>
				<td><input type='text' name='ID' value="<?= $movie->id; ?>" size='1' readonly></input></td>
				<td><?= $movie->title; ?></td>
				<td><?= $movie->text; ?></td>
				<td><?= $movie->url; ?></td>
				<td><?= $movie->presentations; ?></td>
				<td><a href="<?= $edit_page . '&edit=' . $movie->id?>">Bearbeiten</a></td>
			</tr>
		<?php } ?>
	</table>
</div>