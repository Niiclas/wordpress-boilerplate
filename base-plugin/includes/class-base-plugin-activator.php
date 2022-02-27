<?php

/**
 * Fired during plugin activation
 *
 * @link       jan-niclas-gladbach
 * @since      1.0.0
 *
 * @package    Base_Plugin
 * @subpackage Base_Plugin/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Base_Plugin
 * @subpackage Base_Plugin/includes
 * @author     Jan-Niclas Gladbach <jniclasg@googlemail.com>
 */
class Base_Plugin_Activator
{

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate()
	{
		global $wpdb;

		echo "create dbs";

		$movie_table_name = $wpdb->prefix . "movie_entries";
		$presentations_table_name = $wpdb->prefix . "presentations";

		# check https://codex.wordpress.org/Creating_Tables_with_Plugins#Creating_or_Updating_the_Table

		$charset_collate = $wpdb->get_charset_collate();

		$sql = 
<<<SQL
		CREATE TABLE $movie_table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			created_at datetime DEFAULT CURRENT_TIMESTAMP,
			title tinytext NOT NULL,
			text text NOT NULL,
			url varchar(255) DEFAULT '' NOT NULL,
			PRIMARY KEY  (id)
		) $charset_collate;

		CREATE TABLE $presentations_table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			created_at datetime DEFAULT CURRENT_TIMESTAMP,
			presentation datetime NOT NULL,
			movie mediumint(9) NOT NULL,
			PRIMARY KEY  (id),
			FOREIGN KEY  (movie) REFERENCES $movie_table_name(id) ON DELETE CASCADE
		) $charset_collate;
SQL;

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}
}
