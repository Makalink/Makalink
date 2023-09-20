<?php
/**
 * Plugin Name: Vikinger Reactions
 * Plugin URI: http://odindesign-themes.com/
 * Description: Add reactions to your blog posts and comments.
 * Version: 1.0.4
 * Author: Odin Design Themes
 * Author URI: https://themeforest.net/user/odin_design
 * License: https://themeforest.net/licenses/
 * License URI: https://themeforest.net/licenses/
 * Text Domain: vkreact
 * Domain Path: /languages
 */

if (!defined('ABSPATH')) {
  echo 'Please use the plugin from the WordPress admin page.';
  wp_die();
}

/**
 * Versioning
 */
define('VKREACT_VERSION', '1.0.4');
define('VKREACT_VERSION_OPTION', 'vkreact_version');

/**
 * Plugin base path
 */
define('VKREACT_PATH', plugin_dir_path(__FILE__));
define('VKREACT_URL', plugin_dir_url(__FILE__));

/**
 * Vikinger Reactions Functions
 */
require_once VKREACT_PATH . '/includes/functions/vkreact-functions.php';

/**
 * Vikinger Reactions AJAX
 */
require_once VKREACT_PATH . '/includes/ajax/vkreact-ajax.php';

/**
 * Activation function
 */
function vkreact_activate() {
  if (!get_option(VKREACT_VERSION_OPTION)) {
    // add version option
    add_option(VKREACT_VERSION_OPTION, VKREACT_VERSION);
    
    // create tables
    vkreact_create_reaction_table();
    vkreact_create_post_reaction_table();
    vkreact_create_postcomment_reaction_table();

    // init reaction table
    $reaction_items = [
      [
        'name'      => 'like',
        'image_url' => VKREACT_URL . '/img/like.png'
      ],
      [
        'name'      => 'love',
        'image_url' => VKREACT_URL . '/img/love.png'
      ],
      [
        'name'      => 'dislike',
        'image_url' => VKREACT_URL . '/img/dislike.png'
      ],
      [
        'name'      => 'happy',
        'image_url' => VKREACT_URL . '/img/happy.png'
      ],
      [
        'name'      => 'funny',
        'image_url' => VKREACT_URL . '/img/funny.png'
      ],
      [
        'name'      => 'wow',
        'image_url' => VKREACT_URL . '/img/wow.png'
      ],
      [
        'name'      => 'angry',
        'image_url' => VKREACT_URL . '/img/angry.png'
      ],
      [
        'name'      => 'sad',
        'image_url' => VKREACT_URL . '/img/sad.png'
      ]
    ];
  
    foreach ($reaction_items as $reaction_item) {
      vkreact_create_reaction($reaction_item);
    }
  }
}

register_activation_hook(__FILE__, 'vkreact_activate');

/**
 * Uninstallation function
 */
function vkreact_uninstall() {
  // delete version option
  delete_option(VKREACT_VERSION_OPTION);

  // drop tables
  vkreact_drop_postcomment_reaction_table();
  vkreact_drop_post_reaction_table();
  vkreact_drop_reaction_table();
}

register_uninstall_hook(__FILE__, 'vkreact_uninstall');

/**
 * Version Update function
 */
function vkreact_plugin_update() {}

function vkreact_check_version() {
  // plugin not yet installed
  if (!get_option(VKREACT_VERSION_OPTION)) {
    return;
  }

  // update plugin on version mismatch
  if (VKREACT_VERSION !== get_option(VKREACT_VERSION_OPTION)) {
    // update function
    vkreact_plugin_update();
    // update version option with current version
    update_option(VKREACT_VERSION_OPTION, VKREACT_VERSION);
  }
}

add_action('plugins_loaded', 'vkreact_check_version');

/**
 * Load translations
 */
function vkreact_translations_load() {
  load_plugin_textdomain('vkreact', false, basename(dirname(__FILE__)) . '/languages'); 
}

add_action('plugins_loaded', 'vkreact_translations_load');

/**
 * Delete user reactions if a user is deleted
 */
function vkreact_user_reactions_delete($user_id) {
  vkreact_delete_post_user_reactions($user_id);
  vkreact_delete_postcomment_user_reactions($user_id);
}

add_action('deleted_user', 'vkreact_user_reactions_delete');

?>
