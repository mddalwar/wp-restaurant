<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://dalwar.com
 * @since      1.0.0
 *
 * @package    Wp_Restaurant
 * @subpackage Wp_Restaurant/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Restaurant
 * @subpackage Wp_Restaurant/admin
 * @author     Md Dalwar <dalwar9195@gmail.com>
 */
class Wp_Restaurant_Admin {

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
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Restaurant_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Restaurant_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-restaurant-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Restaurant_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Restaurant_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-restaurant-admin.js', array( 'jquery', 'jquery-ui-tabs' ), $this->version, false );

	}

	/**
	 * Add a new food post type.
	 *
	 */
	public function wp_restaurant_food_post_type() {
		$labels = array(
			'name'                  => _x( 'Foods', 'Foods', WP_RESTAURANT_TEXTDOMAIN ),
			'singular_name'         => _x( 'Food', 'Food', WP_RESTAURANT_TEXTDOMAIN ),
			'menu_name'             => __( 'Foods', WP_RESTAURANT_TEXTDOMAIN ),
			'name_admin_bar'        => __( 'Food', WP_RESTAURANT_TEXTDOMAIN ),
			'archives'              => __( 'Food Archives', WP_RESTAURANT_TEXTDOMAIN ),
			'attributes'            => __( 'Food Attributes', WP_RESTAURANT_TEXTDOMAIN ),
			'parent_item_colon'     => __( 'Parent Food:', WP_RESTAURANT_TEXTDOMAIN ),
			'all_items'             => __( 'All Foods', WP_RESTAURANT_TEXTDOMAIN ),
			'add_new_item'          => __( 'Add New Food', WP_RESTAURANT_TEXTDOMAIN ),
			'add_new'               => __( 'Add New', WP_RESTAURANT_TEXTDOMAIN ),
			'new_item'              => __( 'New Food', WP_RESTAURANT_TEXTDOMAIN ),
			'edit_item'             => __( 'Edit Food', WP_RESTAURANT_TEXTDOMAIN ),
			'update_item'           => __( 'Update Food', WP_RESTAURANT_TEXTDOMAIN ),
			'view_item'             => __( 'View Food', WP_RESTAURANT_TEXTDOMAIN ),
			'view_items'            => __( 'View Foods', WP_RESTAURANT_TEXTDOMAIN ),
			'search_items'          => __( 'Search Food', WP_RESTAURANT_TEXTDOMAIN ),
			'not_found'             => __( 'Not found', WP_RESTAURANT_TEXTDOMAIN ),
			'not_found_in_trash'    => __( 'Not found in Trash', WP_RESTAURANT_TEXTDOMAIN ),
			'featured_image'        => __( 'Food Image', WP_RESTAURANT_TEXTDOMAIN ),
			'set_featured_image'    => __( 'Set food image', WP_RESTAURANT_TEXTDOMAIN ),
			'remove_featured_image' => __( 'Remove food image', WP_RESTAURANT_TEXTDOMAIN ),
			'use_featured_image'    => __( 'Use as food image', WP_RESTAURANT_TEXTDOMAIN ),
			'insert_into_item'      => __( 'Insert into food', WP_RESTAURANT_TEXTDOMAIN ),
			'uploaded_to_this_item' => __( 'Uploaded to this food', WP_RESTAURANT_TEXTDOMAIN ),
			'items_list'            => __( 'Foods list', WP_RESTAURANT_TEXTDOMAIN ),
			'items_list_navigation' => __( 'Foods list navigation', WP_RESTAURANT_TEXTDOMAIN ),
			'filter_items_list'     => __( 'Filter foods list', WP_RESTAURANT_TEXTDOMAIN ),
		);
		$args = array(
			'label'                 => __( 'Food', WP_RESTAURANT_TEXTDOMAIN ),
			'description'           => __( 'Add foods for your restaurant', WP_RESTAURANT_TEXTDOMAIN ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'thumbnail' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'menu_icon'				=> 'dashicons-image-filter',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
		);
		register_post_type( 'wp-restaurant-foods', $args );
	}

	/**
	 * Add a new food type.
	 *
	 */
	function wp_restaurant_food_types() {

		$labels = array(
			'name'                       => _x( 'Food Types', 'Food Types', WP_RESTAURANT_TEXTDOMAIN ),
			'singular_name'              => _x( 'Food Type', 'Food Type', WP_RESTAURANT_TEXTDOMAIN ),
			'menu_name'                  => __( 'Food Type', WP_RESTAURANT_TEXTDOMAIN ),
			'all_items'                  => __( 'All Food Types', WP_RESTAURANT_TEXTDOMAIN ),
			'parent_item'                => __( 'Parent Food Type', WP_RESTAURANT_TEXTDOMAIN ),
			'parent_item_colon'          => __( 'Parent Food Type:', WP_RESTAURANT_TEXTDOMAIN ),
			'new_item_name'              => __( 'New Food Type Name', WP_RESTAURANT_TEXTDOMAIN ),
			'add_new_item'               => __( 'Add New Food Type', WP_RESTAURANT_TEXTDOMAIN ),
			'edit_item'                  => __( 'Edit Food Type', WP_RESTAURANT_TEXTDOMAIN ),
			'update_item'                => __( 'Update Food Type', WP_RESTAURANT_TEXTDOMAIN ),
			'view_item'                  => __( 'View Food Type', WP_RESTAURANT_TEXTDOMAIN ),
			'separate_items_with_commas' => __( 'Separate food types with commas', WP_RESTAURANT_TEXTDOMAIN ),
			'add_or_remove_items'        => __( 'Add or remove food types', WP_RESTAURANT_TEXTDOMAIN ),
			'choose_from_most_used'      => __( 'Choose from the most used', WP_RESTAURANT_TEXTDOMAIN ),
			'popular_items'              => __( 'Popular Food Types', WP_RESTAURANT_TEXTDOMAIN ),
			'search_items'               => __( 'Search food types', WP_RESTAURANT_TEXTDOMAIN ),
			'not_found'                  => __( 'Not Found', WP_RESTAURANT_TEXTDOMAIN ),
			'no_terms'                   => __( 'No food types', WP_RESTAURANT_TEXTDOMAIN ),
			'items_list'                 => __( 'Food types list', WP_RESTAURANT_TEXTDOMAIN ),
			'items_list_navigation'      => __( 'Food types list navigation', WP_RESTAURANT_TEXTDOMAIN ),
		);
		$capabilities = array(
			'manage_terms'               => 'manage_categories',
			'edit_terms'                 => 'manage_categories',
			'delete_terms'               => 'manage_categories',
			'assign_terms'               => 'edit_posts',
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
			'capabilities'               => $capabilities,
		);
		register_taxonomy( 'wp-restaurant-types', array( 'wp-restaurant-foods' ), $args );
	}


}
