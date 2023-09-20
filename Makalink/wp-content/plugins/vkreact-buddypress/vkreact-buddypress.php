<?php
/**
 * Plugin Name: Vikinger Reactions - BuddyPress Integration
 * Plugin URI: http://odindesign-themes.com/
 * Description: Add reactions to your BuddyPress activities.
 * Version: 1.0.4
 * Author: Odin Design Themes
 * Author URI: https://themeforest.net/user/odin_design
 * License: https://themeforest.net/licenses/
 * License URI: https://themeforest.net/licenses/
 * Text Domain: vkreact-bp
 */

if (!defined('ABSPATH')) {
  echo 'Please use the plugin from the WordPress admin page.';
  wp_die();
}

/**
 * Versioning
 */
define('VKREACT_BP_VERSION', '1.0.4');
define('VKREACT_BP_VERSION_OPTION', 'vkreact_bp_version');

/**
 * Plugin base path
 */
define('VKREACT_BP_PATH', plugin_dir_path(__FILE__));

/**
 * Vikinger Reactions Functions
 */
require_once VKREACT_BP_PATH . '/includes/functions/vkreact-bp-functions.php';

/**
 * Vikinger Reactions AJAX
 */
require_once VKREACT_BP_PATH . '/includes/ajax/vkreact-bp-ajax.php';

/**
 * Activation function
 */
function vkreact_bp_activate() {
  if (!get_option(VKREACT_BP_VERSION_OPTION)) {
    // add version option
    add_option(VKREACT_BP_VERSION_OPTION, VKREACT_BP_VERSION);
    
    // create tables
    vkreact_bp_create_activity_reaction_table();
  }
}

register_activation_hook(__FILE__, 'vkreact_bp_activate');

/**
 * Uninstallation function
 */
function vkreact_bp_uninstall() {
  // delete version option
  delete_option(VKREACT_BP_VERSION_OPTION);

  // drop tables
  vkreact_bp_drop_activity_reaction_table();
}

register_uninstall_hook(__FILE__, 'vkreact_bp_uninstall');

/**
 * Version Update function
 */
function vkreact_bp_plugin_update() {}

function vkreact_bp_check_version() {
  // plugin not yet installed
  if (!get_option(VKREACT_BP_VERSION_OPTION)) {
    return;
  }

  // update plugin on version mismatch
  if (VKREACT_BP_VERSION !== get_option(VKREACT_BP_VERSION_OPTION)) {
    // update function
    vkreact_bp_plugin_update();
    // update version option with current version
    update_option(VKREACT_BP_VERSION_OPTION, VKREACT_BP_VERSION);
  }
}

add_action('plugins_loaded', 'vkreact_bp_check_version');

/**
 * Check if a plugin is active
 * 
 * @param string  $plugin         PLugin name
 * @return bool   $is_active      True if plugin is active, false otherwise
 */
function vkreact_bp_plugin_is_active($plugin) {
  switch ($plugin) {
    case 'buddypress':
      $is_active = function_exists('buddypress');
      break;
    case 'vkreact':
      $is_active = function_exists('vkreact_activate');
      break;
    default:
      $is_active = false;
  }

  return $is_active;
}

/**
 * Admin Notices
 * 
 * Check if required plugins are installed
 * If required plugins are missing, print admin notice detailing which ones
 */
function vkreact_bp_admin_notices() {
  $master = 'Vikinger Reactions - BuddyPress Integration';
  $required_plugins = [
    [
      'name'    => 'BuddyPress',
      'domain'  => 'buddypress',
      'link'    => 'https://wordpress.org/plugins/buddypress/'
    ],
    [
      'name'    => 'Vikinger Reactions',
      'domain'  => 'vkreact',
      'link'    => ''
    ]
  ];

  $missing_plugins = [];

  foreach ($required_plugins as $plugin) {
    // if plugin isn't active, add to missing plugin list
    if (!vkreact_bp_plugin_is_active($plugin['domain'])) {
      $missing_plugins[] = $plugin;
    }
  }

  // if a plugin or more is missing, show admin notice
  if (count($missing_plugins) > 0) {
    foreach ($missing_plugins as $plugin) {
    ?>
    <div class="notice notice-error is-dismissible">
      <p>
      <?php 
        printf(
          __('%s requires %s plugin to be installed in order to work!. Please check that you have installed and activated it.', 'vikinger'),
          '<strong>' . $master . '</strong>',
          '<a href="' . $plugin['link'] . '" target="_blank">' . $plugin['name'] . '</a>'
        );
      ?>
      </p>
    </div>
    <?php
    }
  }
}

add_action('admin_notices', 'vkreact_bp_admin_notices');

/**
 * Delete user reactions if a user is deleted
 */
function vkreact_bp_user_reactions_delete($user_id) {
  vkreact_bp_delete_activity_user_reactions($user_id);
}

add_action('deleted_user', 'vkreact_bp_user_reactions_delete');

?>
