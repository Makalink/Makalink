<?php
/**
 * Plugin Name: Vikinger - Buddypress Extension
 * Plugin URI: http://odindesign-themes.com/
 * Description: Vikinger functionality extension to Buddypress.
 * Version: 1.1.1
 * Author: Odin Design Themes
 * Author URI: https://themeforest.net/user/odin_design
 * License: https://themeforest.net/licenses/
 * License URI: https://themeforest.net/licenses/
 * Text Domain: vikinger-buddypress-extension
 */

/**
 * Plugin base path
 */
define('VIKINGER_BUDDYPRESS_EXTENSION_PATH', plugin_dir_path(__FILE__));

/**
 * Only load code that needs BuddyPress to run once BP is loaded and initialized
 */
function vikinger_buddypress_extension_init() {
  require_once VIKINGER_BUDDYPRESS_EXTENSION_PATH . '/loader.php';
}

add_action('bp_include', 'vikinger_buddypress_extension_init');

/**
 * Load translations
 */
function vikinger_buddypress_extension_translations_load() {
  load_plugin_textdomain('vikinger-buddypress-extension', false, basename(dirname(__FILE__)) . '/languages'); 
}

add_action('plugins_loaded', 'vikinger_buddypress_extension_translations_load');

?>