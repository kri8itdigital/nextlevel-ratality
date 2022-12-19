<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.kri8it.com
 * @since      1.0.0
 *
 * @package    Nextlevel_Ratality
 * @subpackage Nextlevel_Ratality/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Nextlevel_Ratality
 * @subpackage Nextlevel_Ratality/includes
 * @author     Hilton Moore <hilton@kri8it.com>
 */
class Nextlevel_Ratality {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Nextlevel_Ratality_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'NEXTLEVEL_RATALITY_VERSION' ) ) {
			$this->version = NEXTLEVEL_RATALITY_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'nextlevel-ratality';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Nextlevel_Ratality_Loader. Orchestrates the hooks of the plugin.
	 * - Nextlevel_Ratality_i18n. Defines internationalization functionality.
	 * - Nextlevel_Ratality_Admin. Defines all hooks for the admin area.
	 * - Nextlevel_Ratality_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {



		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-nextlevel-ratality-class.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-nextlevel-ratality-helpers.php';
		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-nextlevel-ratality-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-nextlevel-ratality-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-nextlevel-ratality-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-nextlevel-ratality-public.php';

		$this->loader = new Nextlevel_Ratality_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Nextlevel_Ratality_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Nextlevel_Ratality_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Nextlevel_Ratality_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_action( 'init', $plugin_admin, 'custom_fields' );
		$this->loader->add_action( 'init', $plugin_admin, 'post_types' );

		$this->loader->add_action('wp_ajax_ratality_ajax_do_search', $plugin_admin, 'ratality_ajax_do_search');
		$this->loader->add_action('wp_ajax_nopriv_ratality_ajax_do_search', $plugin_admin, 'ratality_ajax_do_search');

		$this->loader->add_action('wp_ajax_ratality_ajax_select_trip', $plugin_admin, 'ratality_ajax_select_trip');
		$this->loader->add_action('wp_ajax_nopriv_ratality_ajax_select_trip', $plugin_admin, 'ratality_ajax_select_trip');

		$this->loader->add_action('wp_ajax_ratality_ajax_destroy_tickets', $plugin_admin, 'ratality_ajax_destroy_tickets');
		$this->loader->add_action('wp_ajax_nopriv_ratality_ajax_destroy_tickets', $plugin_admin, 'ratality_ajax_destroy_tickets');

		$this->loader->add_action('wp_ajax_ratality_ajax_create_tickets', $plugin_admin, 'ratality_ajax_create_tickets');
		$this->loader->add_action('wp_ajax_nopriv_ratality_ajax_create_tickets', $plugin_admin, 'ratality_ajax_create_tickets');

		$this->loader->add_action( 'woocommerce_email', $plugin_admin, 'woocommerce_email', 999, 1);
		$this->loader->add_action( 'woocommerce_bacs_process_payment_order_status', $plugin_admin, 'woocommerce_payment_complete_order_status', 999, 3);
		$this->loader->add_filter( 'woocommerce_payment_complete_order_status', $plugin_admin, 'woocommerce_payment_complete_order_status', 999, 1);
		$this->loader->add_action( 'woocommerce_order_status_completed', $plugin_admin, 'woocommerce_order_status_completed', 999, 1);
		$this->loader->add_action( 'woocommerce_checkout_update_order_meta', $plugin_admin, 'woocommerce_checkout_update_order_meta', 999, 1);
		$this->loader->add_action( 'woocommerce_checkout_create_order_line_item', $plugin_admin, 'woocommerce_checkout_create_order_line_item', 999, 4);

		$this->loader->add_action( 'woocommerce_email_order_details', $plugin_admin, 'woocommerce_email_order_details', 2, 1);
		$this->loader->add_filter( 'woocommerce_order_number', $plugin_admin, 'woocommerce_order_number', 999, 1);

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Nextlevel_Ratality_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		$this->loader->add_action( 'init', $plugin_public, 'shortcodes' );

		$this->loader->add_filter( 'woocommerce_persistent_cart_enabled', $plugin_public, 'generic_false_function', 999 );

		$this->loader->add_filter( 'woocommerce_get_item_data', $plugin_public, 'woocommerce_get_item_data', 999, 2);

		$this->loader->add_action( 'woocommerce_before_calculate_totals', $plugin_public, 'woocommerce_before_calculate_totals', 999, 1);

		$this->loader->add_action( 'woocommerce_before_cart', $plugin_public, 'woocommerce_before_cart', 999);

		$this->loader->add_filter( 'woocommerce_remove_cart_item', $plugin_public, 'woocommerce_remove_cart_item', 999, 2 );
		$this->loader->add_filter( 'woocommerce_return_to_shop_text', $plugin_public, 'woocommerce_return_to_shop_text', 999, 1 );
		$this->loader->add_filter( 'woocommerce_return_to_shop_redirect', $plugin_public, 'woocommerce_return_to_shop_redirect', 999, 1);

		$this->loader->add_filter('woocommerce_enable_order_notes_field', $plugin_public, 'generic_false_function', 999, 1);

		$this->loader->add_filter('woocommerce_checkout_fields', $plugin_public, 'woocommerce_checkout_fields', 999, 1);

		$this->loader->add_action( 'woocommerce_thankyou', $plugin_public, 'woocommerce_thankyou', 999, 1);
		
		$this->loader->add_action( 'wp_footer', $plugin_public, 'wp_footer', 999 );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Nextlevel_Ratality_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
