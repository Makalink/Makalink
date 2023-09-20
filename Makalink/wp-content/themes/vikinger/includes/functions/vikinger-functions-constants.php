<?php
/**
 * Functions - Constants
 * 
 * @package Vikinger
 * 
 * @since 1.0.0
 * 
 * @author Odin Design Themes (https://odindesignthemes.com/)
 * 
 */

if (!function_exists('vikinger_constants_get')) {
  /**
   * Returns constants as a string for dynamic scripts.
   * 
   * @since 1.0.0
   * 
   * @return string $constants        Constants as a string.
   */
  function vikinger_constants_get() {
    global $vikinger_settings;
    
    $constants_values = [
      'vikinger_url'                => VIKINGER_URL,
      'home_url'                    => esc_url(home_url('/')),
      'ajax_url'                    => admin_url('admin-ajax.php'),
      'wp_rest_nonce'               => wp_create_nonce('wp_rest'),
      'vikinger_ajax_nonce'         => wp_create_nonce('vikinger_ajax'),
      'rest_root'                   => esc_url_raw(rest_url()),
      'plugin_active'               => vikinger_plugin_get_required_plugins_activation_status(),
      'gamipress_badge_type_exists' => vikinger_plugin_gamipress_is_active() && vikinger_gamipress_achievement_type_exists('badge'),
      'colors'                      => vikinger_customizer_theme_colors_get_array(),
      'settings'                    => $vikinger_settings
    ];

    $constants = 'const vikinger_constants = ' . json_encode($constants_values) . ';';

    return $constants;
  }
}

?>