<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Sovware Directory
 * Plugin URI:        https://sovware.com
 * Description:       Directory plugin where a logged in user will submit listings through a frontend submission form. use [sovaredirectory] - showing form and use [show_listing_record] - show list records
 * Version:           1.0.0
 * Author:            Nazmul Hosen
 * Author URI:        https://nazmul.xyz
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sovware-directory
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0
 */
define( 'SOVWARE_DIRECTORY_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-sovware-directory-activator.php
 */
function activate_sovware_directory() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sovware-directory-activator.php';
	Sovware_Directory_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-sovware-directory-deactivator.php
 */
function deactivate_sovware_directory() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sovware-directory-deactivator.php';
	Sovware_Directory_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_sovware_directory' );
register_deactivation_hook( __FILE__, 'deactivate_sovware_directory' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-sovware-directory.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_sovware_directory() {

	$plugin = new Sovware_Directory();
	$plugin->run();

}
run_sovware_directory();
