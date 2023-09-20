<?php
/**
 * Plugin Name: Vikinger Media
 * Plugin URI: http://odindesign-themes.com/
 * Description: Add media to your BuddyPress members and activities.
 * Version: 1.0.0
 * Author: Odin Design Themes
 * Author URI: https://themeforest.net/user/odin_design
 * License: https://themeforest.net/licenses/
 * License URI: https://themeforest.net/licenses/
 * Text Domain: vkmedia
 */

if (!defined('ABSPATH')) {
  echo 'Please use the plugin from the WordPress admin page.';
  wp_die();
}

/**
 * Versioning
 */
define('VKMEDIA_VERSION', '1.0.0');
define('VKMEDIA_VERSION_OPTION', 'vkmedia_version');

/**
 * Plugin base path
 */
define('VKMEDIA_PATH', plugin_dir_path(__FILE__));

/**
 * Vikinger Media Functions
 */
require_once VKMEDIA_PATH . '/includes/functions/vkmedia-functions.php';

/**
 * Activation function
 */
function vkmedia_activate() {
  if (!get_option(VKMEDIA_VERSION_OPTION)) {
    // add version option
    add_option(VKMEDIA_VERSION_OPTION, VKMEDIA_VERSION);
    
    // create tables
    vkmedia_create_media_table();
  }
}

register_activation_hook(__FILE__, 'vkmedia_activate');

/**
 * Uninstallation function
 */
function vkmedia_uninstall() {
  // delete version option
  delete_option(VKMEDIA_VERSION_OPTION);

  // drop tables
  vkmedia_drop_media_table();
}

register_uninstall_hook(__FILE__, 'vkmedia_uninstall');

/**
 * Version Update function
 */
function vkmedia_plugin_update() {}

function vkmedia_check_version() {
  // plugin not yet installed
  if (!get_option(VKMEDIA_VERSION_OPTION)) {
    return;
  }

  // update plugin on version mismatch
  if (VKMEDIA_VERSION !== get_option(VKMEDIA_VERSION_OPTION)) {
    // update function
    vkmedia_plugin_update();
    // update version option with current version
    update_option(VKMEDIA_VERSION_OPTION, VKMEDIA_VERSION);
  }
}

add_action('plugins_loaded', 'vkmedia_check_version');

?>