<?php

/**
 * @link              mickidum.github.io
 * @since             1.0.0
 * @package           Public_Woo_Api
 *
 * @wordpress-plugin
 * Plugin Name:       Public Woo Api
 * Plugin URI:        https://github.com/mickidum/public-woo-api
 * Description:       Allows to fetch WooCommerce products, categories, tags, variations and reviews without authentication.
 * Version:           1.0.0
 * Author:            Mickidum
 * Author URI:        mickidum.github.io
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       public-woo-api
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require __DIR__ . '/vendor/autoload.php';

/**
 * Currently plugin version.
 */

define( 'PUBLIC_WOO_API_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-public-woo-api-activator.php
 */
function activate_public_woo_api() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-public-woo-api-activator.php';
	Public_Woo_Api_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-public-woo-api-deactivator.php
 */
function deactivate_public_woo_api() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-public-woo-api-deactivator.php';
	Public_Woo_Api_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_public_woo_api' );
register_deactivation_hook( __FILE__, 'deactivate_public_woo_api' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-public-woo-api.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_public_woo_api() {

	$plugin = new Public_Woo_Api();
	$plugin->run();

}
run_public_woo_api();
