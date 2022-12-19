<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.kri8it.com
 * @since             1.0.0
 * @package           Nextlevel_Ratality
 *
 * @wordpress-plugin
 * Plugin Name:       NEXTLEVEL Ratality
 * Plugin URI:        https://www.kri8it.com
 * Description:       Creates a connection to the NEXTLEVEL Ratality System
 * Version:           1.0.0
 * Author:            Hilton Moore
 * Author URI:        https://www.kri8it.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       nextlevel-ratality
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'NEXTLEVEL_RATALITY_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-nextlevel-ratality-activator.php
 */
function activate_nextlevel_ratality() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-nextlevel-ratality-activator.php';
	Nextlevel_Ratality_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-nextlevel-ratality-deactivator.php
 */
function deactivate_nextlevel_ratality() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-nextlevel-ratality-deactivator.php';
	Nextlevel_Ratality_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_nextlevel_ratality' );
register_deactivation_hook( __FILE__, 'deactivate_nextlevel_ratality' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-nextlevel-ratality.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_nextlevel_ratality() {

	$plugin = new Nextlevel_Ratality();
	$plugin->run();

}
run_nextlevel_ratality();
