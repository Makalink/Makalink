<?php
/**
 * Plugin Name: Vikinger Metaboxes
 * Plugin URI: http://odindesign-themes.com/
 * Description: Post format metaboxes for the vikinger theme.
 * Version: 1.0.2
 * Author: Odin Design Themes
 * Author URI: https://themeforest.net/user/odin_design
 * License: https://themeforest.net/licenses/
 * License URI: https://themeforest.net/licenses/
 * Text Domain: vkmetaboxes
 */

if (!defined('ABSPATH')) {
  echo 'Please use the plugin from the WordPress admin page.';
  wp_die();
}

/**
 * Versioning
 */
define('VKMETABOXES_VERSION', '1.0.2');
define('VKMETABOXES_VERSION_OPTION', 'vkmetaboxes_version');

/**
 * Plugin base path
 */
define('VKMETABOXES_PATH', plugin_dir_path(__FILE__));
define('VKMETABOXES_URL', plugin_dir_url(__FILE__));

/**
 * Vikinger Metaboxes Functions
 */
require_once VKMETABOXES_PATH . '/includes/functions/vkmetaboxes-functions.php';

/**
 * Vikinger Metaboxes AJAX
 */
require_once VKMETABOXES_PATH . '/includes/ajax/vkmetaboxes-ajax.php';

/**
 * Activation function
 */
function vkmetaboxes_activate() {
  if (!get_option(VKMETABOXES_VERSION_OPTION)) {
    // add version option
    add_option(VKMETABOXES_VERSION_OPTION, VKMETABOXES_VERSION);
  }
}

register_activation_hook(__FILE__, 'vkmetaboxes_activate');

/**
 * Uninstallation function
 */
function vkmetaboxes_uninstall() {
  // delete version option
  delete_option(VKMETABOXES_VERSION_OPTION);
}

register_uninstall_hook(__FILE__, 'vkmetaboxes_uninstall');

/**
 * Version Update function
 */
function vkmetaboxes_plugin_update() {}

function vkmetaboxes_check_version() {
  // plugin not yet installed
  if (!get_option(VKMETABOXES_VERSION_OPTION)) {
    return;
  }

  // update plugin on version mismatch
  if (VKMETABOXES_VERSION !== get_option(VKMETABOXES_VERSION_OPTION)) {
    // update function
    vkmetaboxes_plugin_update();
    // update version option with current version
    update_option(VKMETABOXES_VERSION_OPTION, VKMETABOXES_VERSION);
  }
}

add_action('plugins_loaded', 'vkmetaboxes_check_version');

?>