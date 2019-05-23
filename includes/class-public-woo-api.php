<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       mickidum.github.io
 * @since      1.0.0
 *
 * @package    Public_Woo_Api
 * @subpackage Public_Woo_Api/includes
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
 * @package    Public_Woo_Api
 * @subpackage Public_Woo_Api/includes
 * @author     Mickidum <mickidum@gmail.com>
 */
class Public_Woo_Api {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Public_Woo_Api_Loader    $loader    Maintains and registers all hooks for the plugin.
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
		if ( defined( 'PUBLIC_WOO_API_VERSION' ) ) {
			$this->version = PUBLIC_WOO_API_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'public-woo-api';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();

		add_action( 'admin_notices', array($this, 'public_woo_api_notices') );
	}

	/**
	 * Checks if woocommerce plugin is installed and displays notice if not
	 */
	public function public_woo_api_notices(){
		if ( ! is_plugin_active ( 'woocommerce/woocommerce.php' ) ) {
			echo '<div class="notice notice-error is-dismissible">
							<p><b>Public Woo Api</b> requires <a href="' . get_admin_url() . 'plugin-install.php?s=woocommerce&tab=search&type=term">WooCommerce</a> plugin to be active. Please make sure you have the plugin installed and activated.</p>
					  </div>';
			return;
		}
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Public_Woo_Api_Loader. Orchestrates the hooks of the plugin.
	 * - Public_Woo_Api_i18n. Defines internationalization functionality.
	 * - Public_Woo_Api_Admin. Defines all hooks for the admin area.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-public-woo-api-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-public-woo-api-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-public-woo-api-admin.php';

		/**
		 * The class responsible for defining all restapi endpoints.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-public-woo-api-endpoints.php';


		$this->loader = new Public_Woo_Api_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Public_Woo_Api_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Public_Woo_Api_i18n();

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

		$plugin_admin = new Public_Woo_Api_Admin( $this->get_plugin_name(), $this->get_version() );
		$plugin_settings = new Public_Woo_Api_Settings( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_action( 'admin_menu', $plugin_settings, 'setup_plugin_options_menu' );
		$this->loader->add_action( 'admin_init', $plugin_settings, 'initialize_main_options' );

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Public_Woo_Api_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function init_endpoints_class() {

		$options = get_option( 'public_woo_api_main_options' );
		
		$consumer_key = '';
		$consumer_secret = '';
		$endpoint = $options['endpoint'] ? $options['endpoint'] : '';

		if( !empty( $options['consumer_key']) and !empty( $options['consumer_secret'] ) ) {
			$consumer_key = $options['consumer_key'];
			$consumer_secret = $options['consumer_secret'];

			$plugin_restapi_client = new Public_Woo_Api_Endpoints($consumer_key, $consumer_secret, $endpoint);
		}

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
		$this->init_endpoints_class();
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
	 * @return    Public_Woo_Api_Loader    Orchestrates the hooks of the plugin.
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
