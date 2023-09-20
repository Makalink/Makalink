<?php
/**
 * Functions - Backend - Translation
 * 
 * @package Vikinger
 * 
 * @since 1.0.0
 * 
 * @author Odin Design Themes (https://odindesignthemes.com/)
 * 
 */

if (!function_exists('vikinger_backend_translation_get')) {
  /**
   * Returns translation strings for dynamic scripts.
   * 
   * @since 1.0.0
   * 
   * @return array $translation_strings     Translation strings.
   */
  function vikinger_backend_translation_get() {
    $translation_strings = [
      /**
       * Plugin List
       */
      'pluginList'  => [
        'message' => [
          'loading'     => [
            'title' => esc_html_x('Retrieving plugin data...', '(Backend)', 'vikinger'),
            'text'  => esc_html_x('Please wait a few seconds while we retrieve plugin data.', '(Backend)', 'vikinger')
          ],
          'no_plugins'  => [
            'title' => esc_html_x('No plugins selected', '(Backend)', 'vikinger'),
            'text'  => esc_html_x('You haven\'t selected any plugins.', '(Backend)', 'vikinger')
          ],
          'error'       => [
            'title' => esc_html_x('Something is wrong!', '(Backend)', 'vikinger'),
            'text'  => sprintf(
              esc_html_x('One or more of the plugins selected need to be installed, activated or updated.%sRun the setup using the button below to install, activate and update all selected plugins.', '(Backend)', 'vikinger'),
              '<br>'
            ),
          ],
          'success'     => [
            'title' => esc_html_x('Everything is OK!', '(Backend)', 'vikinger'),
            'text'  => esc_html_x('All selected plugins are installed, active and updated to their latest versions.', '(Backend)', 'vikinger')
          ]
        ]
      ]
    ];

    return $translation_strings;
  }
}
 
?>