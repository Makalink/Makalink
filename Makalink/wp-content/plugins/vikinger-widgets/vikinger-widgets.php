<?php
/**
 * Plugin Name: Vikinger Widgets
 * Plugin URI: http://odindesign-themes.com/
 * Description: Widgets for the vikinger theme.
 * Version: 1.0.0
 * Author: Odin Design Themes
 * Author URI: https://themeforest.net/user/odin_design
 * License: https://themeforest.net/licenses/
 * License URI: https://themeforest.net/licenses/
 * Text Domain: vkwidgets
 */

if (!defined('ABSPATH')) {
  echo 'Please use the plugin from the WordPress admin page.';
  wp_die();
}

/**
 * Versioning
 */
define('VKWIDGETS_VERSION', '1.0.0');
define('VKWIDGETS_VERSION_OPTION', 'vkwidgets_version');

/**
 * Plugin base path
 */
define('VKWIDGETS_PATH', plugin_dir_path(__FILE__));

/**
 * Vikinger Widgets Classes
 */
require_once VKWIDGETS_PATH . '/includes/classes/vkwidgets-classes.php';

/**
 * Activation function
 */
function vkwidgets_activate() {
  if (!get_option(VKWIDGETS_VERSION_OPTION)) {
    // add version option
    add_option(VKWIDGETS_VERSION_OPTION, VKWIDGETS_VERSION);
  }
}

register_activation_hook(__FILE__, 'vkwidgets_activate');

/**
 * Uninstallation function
 */
function vkwidgets_uninstall() {
  // delete version option
  delete_option(VKWIDGETS_VERSION_OPTION);
}

register_uninstall_hook(__FILE__, 'vkwidgets_uninstall');

/**
 * Version Update function
 */
function vkwidgets_plugin_update() {}

function vkwidgets_check_version() {
  // plugin not yet installed
  if (!get_option(VKWIDGETS_VERSION_OPTION)) {
    return;
  }

  // update plugin on version mismatch
  if (VKWIDGETS_VERSION !== get_option(VKWIDGETS_VERSION_OPTION)) {
    // update function
    vkwidgets_plugin_update();
    // update version option with current version
    update_option(VKWIDGETS_VERSION_OPTION, VKWIDGETS_VERSION);
  }
}

add_action('plugins_loaded', 'vkwidgets_check_version');

?>