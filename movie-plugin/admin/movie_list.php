<?php
add_action('admin_menu', 'movie_list_menu_page');
function movie_list_menu_page()
{
    add_menu_page("Movie List", "Movie List", "manage_options", "movie_menu_list", "movie_menu_list");
}
function movie_menu_list()
{
?>
<div class="wrap">
	<h2>Movies</h2>
	<?php
	global $wpdb;
	$edit_page = admin_url() . 'admin.php?page=movie_menu_edit';
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
				<td>
					<?php foreach (explode(',', $movie->presentations) as $presentation) { ?>
						<div><?= $presentation; ?></div>
					<?php } ?>
				</td>
				<td><a href="<?= $edit_page . '&edit=' . $movie->id ?>">Bearbeiten</a></td>
			</tr>
		<?php } ?>
	</table>
</div>
<?php } ?>