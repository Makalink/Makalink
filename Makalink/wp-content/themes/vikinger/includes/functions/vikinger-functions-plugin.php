<?php
/**
 * Functions - Plugin
 * 
 * @package Vikinger
 * 
 * @since 1.0.0
 * 
 * @author Odin Design Themes (https://odindesignthemes.com/)
 * 
 */

/**
 * Check if a plugin is active.
 * 
 * @param string  $plugin         PLugin name.
 * @return bool   $is_active      True if plugin is active, false otherwise.
 */
function vikinger_plugin_is_active($plugin) {
  switch ($plugin) {
    case 'buddypress':
      $is_active = function_exists('buddypress');
      break;
    case 'bp-verified-member':
      $is_active = class_exists('BP_Verified_Member');
      break;
    case 'bbpress':
      $is_active = class_exists('bbPress');
      break;
    case 'bp-better-messages':
      $is_active = class_exists('BP_Better_Messages');
      break;
    case 'bp-verified-member':
      $is_active = class_exists('BP_Verified_Member');
      break;
    case 'gamipress':
      $is_active = function_exists('GamiPress');
      break;
    case 'gamipress-buddypress-integration':
      $is_active = class_exists('GamiPress_BuddyPress');
      break;
    case 'gamipress-bbpress-integration':
      $is_active = class_exists('GamiPress_bbPress');
      break;
    case 'woocommerce':
      $is_active = class_exists('WooCommerce');
      break;
    case 'paid-memberships-pro':
      $is_active = function_exists('pmpro_init');
      break;
    case 'pmpro-buddypress':
      $is_active = function_exists('pmpro_bp_get_level_options');
      break;
    case 'pmpro-bbpress':
      $is_active = function_exists('pmprobb_init');
      break;
    case 'advanced-ads':
      $is_active = class_exists('Advanced_Ads');
      break;
    case 'advanced-ads-pro':
      $is_active = class_exists('Advanced_Ads_Pro');
      break;
    case 'elementor':
      $is_active = class_exists('Elementor\Plugin');
      break;
    case 'vikinger-buddypress-extension':
      $is_active = function_exists('vikinger_buddypress_extension_init');
      break;
    case 'vkreact':
      $is_active = function_exists('vkreact_activate');
      break;
    case 'vkreact-buddypress':
      $is_active = function_exists('vkreact_bp_activate');
      break;
    case 'vkmedia':
      $is_active = function_exists('vkmedia_activate');
      break;
    case 'vikinger-widgets':
      $is_active = function_exists('vkwidgets_activate');
      break;
    case 'vikinger-metaboxes':
      $is_active = function_exists('vkmetaboxes_activate');
      break;
    default:
      $is_active = false;
  }

  return $is_active;
}

/**
 * Checks if the BuddyPress plugin is active.
 * 
 * @return bool $is_active    True if the BuddyPress plugin is active, false otherwise.
 */
function vikinger_plugin_buddypress_is_active() {
  $is_active = vikinger_plugin_is_active('buddypress');

  return $is_active;
}

/**
 * Checks if the GamiPress plugin is active.
 * 
 * @return bool $is_active    True if the GamiPress plugin is active, false otherwise.
 */
function vikinger_plugin_gamipress_is_active() {
  $is_active = vikinger_plugin_is_active('gamipress');

  return $is_active;
}

/**
 * Checks if the vkreact plugin is active.
 * 
 * @return bool $is_active    True if the vkreact plugin is active, false otherwise.
 */
function vikinger_plugin_vkreact_is_active() {
  $is_active = vikinger_plugin_is_active('vkreact');

  return $is_active;
}

/**
 * Checks if the vkreact-buddypress plugin is active.
 * 
 * @return bool $is_active    True if the vkreact-buddypress plugin is active, false otherwise.
 */
function vikinger_plugin_vkreact_buddypress_is_active() {
  $is_active = vikinger_plugin_is_active('vkreact-buddypress');

  return $is_active;
}

/**
 * Checks if the vkmedia plugin is active.
 * 
 * @return bool $is_active    True if the vkmedia plugin is active, false otherwise.
 */
function vikinger_plugin_vkmedia_is_active() {
  $is_active = vikinger_plugin_is_active('vkmedia');

  return $is_active;
}

/**
 * Checks if the elementor plugin is active.
 * 
 * @return bool $is_active    True if the elementor plugin is active, false otherwise.
 */
function vikinger_plugin_elementor_is_active() {
  $is_active = vikinger_plugin_is_active('elementor');

  return $is_active;
}

/**
 * Checks if the bbpress plugin is active.
 * 
 * @return bool $is_active    True if the bbpress plugin is active, false otherwise.
 */
function vikinger_plugin_bbpress_is_active() {
  $is_active = vikinger_plugin_is_active('bbpress');

  return $is_active;
}

/**
 * Checks if the woocommerce plugin is active.
 * 
 * @return bool $is_active    True if the woocommerce plugin is active, false otherwise.
 */
function vikinger_plugin_woocommerce_is_active() {
  $is_active = vikinger_plugin_is_active('woocommerce');

  return $is_active;
}

/**
 * Checks if the paid memberships pro plugin is active.
 * 
 * @return bool $is_active    True if the pmpro plugin is active, false otherwise.
 */
function vikinger_plugin_pmpro_is_active() {
  $is_active = vikinger_plugin_is_active('paid-memberships-pro');

  return $is_active;
}

/**
 * Checks if the paid memberships pro - buddypress plugin is active.
 * 
 * @return bool $is_active    True if the pmpro - buddypress plugin is active, false otherwise.
 */
function vikinger_plugin_pmpro_buddypress_is_active() {
  $is_active = vikinger_plugin_is_active('pmpro-buddypress');

  return $is_active;
}

/**
 * Checks if the paid memberships pro - bbpress plugin is active.
 * 
 * @return bool $is_active    True if the pmpro - bbpress plugin is active, false otherwise.
 */
function vikinger_plugin_pmpro_bbpress_is_active() {
  $is_active = vikinger_plugin_is_active('pmpro-bbpress');

  return $is_active;
}

/**
 * Checks if the Advanced Ads plugin is active.
 * 
 * @return bool $is_active    True if the Advanced Ads plugin is active, false otherwise.
 */
function vikinger_plugin_advancedads_is_active() {
  $is_active = vikinger_plugin_is_active('advanced-ads');

  return $is_active;
}

/**
 * Checks if the Advanced Ads Pro plugin is active.
 * 
 * @return bool $is_active    True if the Advanced Ads Pro plugin is active, false otherwise.
 */
function vikinger_plugin_advancedads_pro_is_active() {
  $is_active = vikinger_plugin_is_active('advanced-ads-pro');

  return $is_active;
}

/**
 * Checks if the bp better messages plugin is active.
 * 
 * @return bool $is_active    True if the bp better messages plugin is active, false otherwise.
 */
function vikinger_plugin_bpbettermessages_is_active() {
  $is_active = vikinger_plugin_is_active('bp-better-messages');

  return $is_active;
}

/**
 * Checks if the verified member for buddypress plugin is active.
 * 
 * @return bool $is_active    True if the verified member for buddypress plugin is active, false otherwise.
 */
function vikinger_plugin_bpverifiedmember_is_active() {
  $is_active = vikinger_plugin_is_active('bp-verified-member');

  return $is_active;
}

/**
 * Returns required plugins activation status
 * 
 * @return $required_plugins_status       Required plugin with activation status.
 */
function vikinger_plugin_get_required_plugins_activation_status() {
  $required_plugins_status = [];

  $required_plugins = [
    /**
     * WordPress
     */
    'buddypress',
    'bp-verified-member',
    'bp-better-messages',
    'bbpress',
    'gamipress',
    'gamipress-buddypress-integration',
    'gamipress-bbpress-integration',
    'woocommerce',
    'elementor',
    'paid-memberships-pro',
    'pmpro-buddypress',
    'pmpro-bbpress',
    'advanced-ads',
    /**
     * Local
     */
    'vikinger-buddypress-extension',
    'vkreact',
    'vkreact-buddypress',
    'vkmedia',
    'vikinger-widgets',
    'vikinger-metaboxes'
  ];

  foreach ($required_plugins as $required_plugin) {
    $required_plugins_status[$required_plugin] = vikinger_plugin_is_active($required_plugin);
  }

  // add buddypress component related activation status
  if (vikinger_plugin_buddypress_is_active()) {
    $required_plugins_status['buddypress_activity'] = bp_is_active('activity');
    $required_plugins_status['buddypress_groups'] = bp_is_active('groups');
    $required_plugins_status['buddypress_friends'] = bp_is_active('friends');
    $required_plugins_status['buddypress_messages'] = bp_is_active('messages');
    $required_plugins_status['buddypress_notifications'] = bp_is_active('notifications');
  }

  $required_plugins_status['advanced-ads-pro'] = vikinger_plugin_advancedads_pro_is_active();

  return $required_plugins_status;
}

?>