<?php
/**
 * Plugin Name: Hub
 * Version: 0.1.0
 * Author: Twerlo
 * Author URI: https://twerlo.com
 * Text Domain: hub
 * Domain Path: /languages
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package extension
 */

 if (!defined('WPINC')) {
	die;
}


define('HUB_WOOCOMMERCE_VERSION', '0.1.0');


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-hub-woocommerce-activator.php
 */
function activate_hub_woocommerce()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-hub-woocommerce-activator.php';
	Hub_Woocommerce_Activator::activate();
}
/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-hub-woocommerce-deactivator.php
 */
function deactivate_hub_woocommerce()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-hub-woocommerce-deactivator.php';
	Hub_Woocommerce_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_hub_woocommerce');
register_deactivation_hook(__FILE__, 'deactivate_hub_woocommerce');

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.1.0
 */
function run_hub_woocommerce()
{
	/**
	 * The core plugin class that is used to define internationalization,
	 * admin-specific hooks, and public-facing site hooks.
	 */
	require plugin_dir_path(__FILE__) . 'includes/class-hub-woocommerce.php';
	$plugin = new Hub_Woocommerce();
	$plugin->run();
}
run_hub_woocommerce();
