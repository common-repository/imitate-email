<?php

/**
 * 
 * @link              https://imitate.email
 * @since             1.0.0
 * @package           Imitate_Email
 *
 * @wordpress-plugin
 * Plugin Name:       Imitate Email
 * Plugin URI:        https://imitate.email/wordpress
 * Description:       Easily test emails in WordPress using our embedded email viewer and sandbox mail server. No more accidentally spamming real people during development and use our email tools to verify content and ensure deliverability.
 * Version:           1.0.0
 * Author:            Mark Jerzykowski
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       imitate-email
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
define( 'IMITATE_EMAIL_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-imitate-email-activator.php
 */
function activate_imitate_email() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-imitate-email-activator.php';
	Imitate_Email_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-imitate-email-deactivator.php
 */
function deactivate_imitate_email() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-imitate-email-deactivator.php';
	Imitate_Email_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_imitate_email' );
register_deactivation_hook( __FILE__, 'deactivate_imitate_email' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-imitate-email.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_imitate_email() {

	$plugin = new Imitate_Email();
	$plugin->run();

}
run_imitate_email();