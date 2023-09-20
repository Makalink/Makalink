<?php
/**
 * Functions - Backend - Constants
 * 
 * @package Vikinger
 * 
 * @since 1.0.0
 * 
 * @author Odin Design Themes (https://odindesignthemes.com/)
 * 
 */

if (!function_exists('vikinger_backend_constants_get')) {
  /**
   * Returns constants as a string for dynamic scripts.
   * 
   * @since 1.0.0
   * 
   * @return string $constants        Constants as a string.
   */
  function vikinger_backend_constants_get() {
    $constants_values = [
      'AJAXNonce' => wp_create_nonce('vikinger_backend_ajax')
    ];

    $constants = 'const vikingerBackendConstants = ' . json_encode($constants_values) . ';';

    return $constants;
  }
}
 
?>