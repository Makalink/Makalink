<?php
/**
 * AJAX - Backend - Plugin
 * 
 * @package Vikinger
 * 
 * @since 1.9.1
 * 
 * @author Odin Design Themes (https://odindesignthemes.com/)
 * 
 */

if (!function_exists('vikinger_backend_ajax_plugin_status_get')) {
  /**
   * Returns plugin status.
   * 
   * @since 1.0.0
   */
  function vikinger_backend_ajax_plugin_status_get() {
    // nonce check, dies early if the nonce cannot be verified
    check_ajax_referer('vikinger_backend_ajax');

    $logged_user_is_site_admin = current_user_can('administrator');

    // user permissions check, dies early if user doesn't have required permissions
    if (!$logged_user_is_site_admin) {
      wp_die('Unauthorized');
    }

    $vikinger_installer = new Vikinger_Installer();

    $result = $vikinger_installer->getPluginStatus();

    header('Content-Type: application/json');
    echo json_encode($result);

    wp_die();
  }
}

add_action('wp_ajax_vikinger_backend_ajax_plugin_status_get', 'vikinger_backend_ajax_plugin_status_get');

if (!function_exists('vikinger_backend_ajax_plugin_install')) {
  /**
   * Installs and activates plugin and returns plugin status.
   * 
   * @since 1.0.0
   */
  function vikinger_backend_ajax_plugin_install() {
    // nonce check, dies early if the nonce cannot be verified
    check_ajax_referer('vikinger_backend_ajax');

    $logged_user_is_site_admin = current_user_can('administrator');

    // user permissions check, dies early if user doesn't have required permissions
    if (!$logged_user_is_site_admin) {
      wp_die('Unauthorized');
    }

    $plugin_id = isset($_POST['plugin_id']) ? $_POST['plugin_id'] : false;

    if (!($plugin_id && is_string($plugin_id))) {
      wp_die('Missing or incorrect "plugin_id" parameter');
    }

    $vikinger_installer = new Vikinger_Installer();

    $installed = $vikinger_installer->installPlugin($plugin_id);

    if ($installed) {
      $vikinger_installer->activatePlugin($plugin_id);
    }

    $result = $vikinger_installer->getPluginStatus($plugin_id);

    header('Content-Type: application/json');
    echo json_encode($result);

    wp_die();
  }
}

add_action('wp_ajax_vikinger_backend_ajax_plugin_install', 'vikinger_backend_ajax_plugin_install');

if (!function_exists('vikinger_backend_ajax_plugin_update')) {
  /**
   * Updates and activates plugin and returns plugin status.
   * 
   * @since 1.0.0
   */
  function vikinger_backend_ajax_plugin_update() {
    // nonce check, dies early if the nonce cannot be verified
    check_ajax_referer('vikinger_backend_ajax');

    $logged_user_is_site_admin = current_user_can('administrator');

    // user permissions check, dies early if user doesn't have required permissions
    if (!$logged_user_is_site_admin) {
      wp_die('Unauthorized');
    }

    $plugin_id = isset($_POST['plugin_id']) ? $_POST['plugin_id'] : false;

    if (!($plugin_id && is_string($plugin_id))) {
      wp_die('Missing or incorrect "plugin_id" parameter');
    }

    $vikinger_installer = new Vikinger_Installer();

    $updated = $vikinger_installer->updatePlugin($plugin_id);

    if ($updated) {
      $vikinger_installer->activatePlugin($plugin_id);
    }

    $result = $vikinger_installer->getPluginStatus($plugin_id);

    header('Content-Type: application/json');
    echo json_encode($result);

    wp_die();
  }
}

add_action('wp_ajax_vikinger_backend_ajax_plugin_update', 'vikinger_backend_ajax_plugin_update');

if (!function_exists('vikinger_backend_ajax_plugin_activate')) {
  /**
   * Activates plugin and returns plugin status.
   * 
   * @since 1.0.0
   */
  function vikinger_backend_ajax_plugin_activate() {
    // nonce check, dies early if the nonce cannot be verified
    check_ajax_referer('vikinger_backend_ajax');

    $logged_user_is_site_admin = current_user_can('administrator');

    // user permissions check, dies early if user doesn't have required permissions
    if (!$logged_user_is_site_admin) {
      wp_die('Unauthorized');
    }

    $plugin_id = isset($_POST['plugin_id']) ? $_POST['plugin_id'] : false;

    if (!($plugin_id && is_string($plugin_id))) {
      wp_die('Missing or incorrect "plugin_id" parameter');
    }

    $vikinger_installer = new Vikinger_Installer();

    $vikinger_installer->activatePlugin($plugin_id);

    $result = $vikinger_installer->getPluginStatus($plugin_id);

    header('Content-Type: application/json');
    echo json_encode($result);

    wp_die();
  }
}

add_action('wp_ajax_vikinger_backend_ajax_plugin_activate', 'vikinger_backend_ajax_plugin_activate');

if (!function_exists('vikinger_backend_ajax_plugin_selected_status_get')) {
  /**
   * Returns selected plugin status.
   * 
   * @since 1.0.0
   */
  function vikinger_backend_ajax_plugin_selected_status_get() {
    // nonce check, dies early if the nonce cannot be verified
    check_ajax_referer('vikinger_backend_ajax');

    $logged_user_is_site_admin = current_user_can('administrator');

    // user permissions check, dies early if user doesn't have required permissions
    if (!$logged_user_is_site_admin) {
      wp_die('Unauthorized');
    }

    $vikinger_installer = new Vikinger_Installer();

    $result = $vikinger_installer->getSelectedPluginStatus();

    header('Content-Type: application/json');
    echo json_encode($result);

    wp_die();
  }
}

add_action('wp_ajax_vikinger_backend_ajax_plugin_selected_status_get', 'vikinger_backend_ajax_plugin_selected_status_get');

if (!function_exists('vikinger_backend_ajax_plugin_selected_status_update')) {
  /**
   * Returns selected plugin status.
   * 
   * @since 1.0.0
   */
  function vikinger_backend_ajax_plugin_selected_status_update() {
    // nonce check, dies early if the nonce cannot be verified
    check_ajax_referer('vikinger_backend_ajax');

    $logged_user_is_site_admin = current_user_can('administrator');

    // user permissions check, dies early if user doesn't have required permissions
    if (!$logged_user_is_site_admin) {
      wp_die('Unauthorized');
    }

    $selected_plugins = isset($_POST['selected_plugins']) ? $_POST['selected_plugins'] : false;

    if (!($selected_plugins && is_array($selected_plugins))) {
      wp_die('Missing or incorrect "selected_plugins" parameter');
    }

    foreach ($selected_plugins as $selected_plugin => $selected_plugin_status) {
      $selected_plugins[$selected_plugin] = $selected_plugin_status === 'true';
    }

    $vikinger_installer = new Vikinger_Installer();

    $result = $vikinger_installer->updateSelectedPluginStatus($selected_plugins);

    header('Content-Type: application/json');
    echo json_encode($result);

    wp_die();
  }
}

add_action('wp_ajax_vikinger_backend_ajax_plugin_selected_status_update', 'vikinger_backend_ajax_plugin_selected_status_update');

?>