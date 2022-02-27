<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       jan-niclas-gladbach
 * @since      1.0.0
 *
 * @package    Base_Plugin
 * @subpackage Base_Plugin/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Base_Plugin
 * @subpackage Base_Plugin/admin
 * @author     Jan-Niclas Gladbach <jniclasg@googlemail.com>
 */
class Base_Plugin_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Creates the movies page
	 *
	 * @since 		1.0.0
	 * @return 		void
	 */
	public function page_movies()
	{
		include(plugin_dir_path(__FILE__) . 'partials/movies_list.php');
	}

	/**
	 * Creates the movie form page
	 *
	 * @since 		1.0.0
	 * @return 		void
	 */
	public function page_movie_form()
	{

		include(plugin_dir_path(__FILE__) . 'partials/movie_edit_create.php');
	}

	public function save_movie()
	{
		if (!empty($_POST) && $_POST['action'] == "save_movie") {
			var_dump($_POST);
			exit();
			global $wpdb;
			$table = $wpdb->prefix . "movie_entries";
			$data = array(
				'title'    => $_POST['title'],
				'text'    => $_POST['text'],
				'url'    => $_POST['url']
			);
			$format = array(
				'%s', '%s', '%s'
			);
			if ($_POST['id']) {
				$where = ["id" => $_POST['id']];
				$where_format = array(
					'%d'
				);
				$success = $wpdb->update($table, $data, $where, $format, $where_format);
			} else {
				$success = $wpdb->insert($table, $data, $format);
				foreach($_POST['presentation_date'] as)
			}
			if ($success) {
				wp_redirect(admin_url() . 'admin.php?page=' . $this->plugin_name . "-movies");
				exit();
			} else {
				echo $success;
			}
		}
	}

	/**
	 * Adds a page link to a menu
	 *
	 * @link 		https://codex.wordpress.org/Administration_Menus
	 * @since 		1.0.0
	 * @return 		void
	 */
	public function add_menu()
	{
		// Top-level page
		add_menu_page("Movies", "Movies", 0, $this->plugin_name . "-movies", array($this, 'page_movies'), null, 0);
		add_menu_page("Add/Edit Movie", "Add/Edit Movie", 0, $this->plugin_name . "-movie_edit", array($this, 'page_movie_form'), null, 0);
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Base_Plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Base_Plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/base-plugin-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Base_Plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Base_Plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/base-plugin-admin.js', array('jquery'), $this->version, false);
	}
}
