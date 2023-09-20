<?php
/**
 * Functions - Backend
 * 
 * @package Vikinger
 * 
 * @since 1.9.8
 * 
 * @author Odin Design Themes (https://odindesignthemes.com/)
 * 
 */

if (!function_exists('vikinger_backend_scripts_load')) {
  /**
   * Load backend styles and scripts
   * 
   * @since 1.0.0
   * @version 1.9.8
   */
  function vikinger_backend_scripts_load() {
    /**
     * Styles
     */
    // load fonts
    wp_enqueue_style('vikinger-backend-fonts', 'https://fonts.googleapis.com/css?family=Inter:400,500,700,800&display=swap');

    // Simplebar
    wp_enqueue_style('vikinger-backend-simplebar-styles', VIKINGER_URL . '/css/vendor/simplebar.css', [], '1.0.0');
    // Main
    wp_enqueue_style('vikinger-backend-styles', VIKINGER_URL . '/backend/css/style.css', ['vikinger-backend-simplebar-styles'], '1.5.1');

    /**
     * Scripts
     */
    // App
    wp_enqueue_script('vikinger-backend-scripts', VIKINGER_URL . '/backend/js/app.bundle.min.js', [], '4.0.1', true);
    // Translation
    wp_localize_script('vikinger-backend-scripts', 'vikingerBackendTranslation', vikinger_backend_translation_get());
    // Variables
    wp_add_inline_script('vikinger-backend-scripts', vikinger_backend_constants_get(), 'before');
  }
}

add_action('admin_enqueue_scripts', 'vikinger_backend_scripts_load');

if (!function_exists('vikinger_backend_page_get')) {
  /**
   * Requires backend page HTML.
   * 
   * @since 1.9.8
   * 
   * @param string $page_name       Name of the page to return.
   */
  function vikinger_backend_page_get($page_name) {
    $filepath = VIKINGER_PATH . '/backend/views/' . $page_name . '.php';

    require_once $filepath;
  }
}

if (!function_exists('vikinger_backend_pages_register')) {
  /**
   * Registers backend pages.
   * 
   * @since 1.9.8
   */
  function vikinger_backend_pages_register() {
    $parent_page_slug = 'vikinger_index';

    add_menu_page(
      'Vikinger',
      'Vikinger',
      'manage_options',
      $parent_page_slug,
      function () { vikinger_backend_page_get('index'); },
      esc_url(VIKINGER_URL) . '/backend/img/options-icon.png'
    );

    $backend_subpages = [
      'index'           => [
        'page_title'  => esc_html_x('Getting Started', '(Backend)', 'vikinger'),
        'menu_title'  => esc_html_x('Getting Started', '(Backend)', 'vikinger')
      ],
      'setup'           => [
        'page_title'  => esc_html_x('Setup', '(Backend)', 'vikinger'),
        'menu_title'  => esc_html_x('Setup', '(Backend)', 'vikinger')
      ],
      'demo_import'     => [
        'page_title'  => esc_html_x('Demo Import', '(Backend)', 'vikinger'),
        'menu_title'  => esc_html_x('Demo Import', '(Backend)', 'vikinger')
      ],
      'documentation'   => [
        'page_title'  => esc_html_x('Documentation', '(Backend)', 'vikinger'),
        'menu_title'  => esc_html_x('Documentation', '(Backend)', 'vikinger')
      ],
      'support'         => [
        'page_title'  => esc_html_x('Support', '(Backend)', 'vikinger'),
        'menu_title'  => esc_html_x('Support', '(Backend)', 'vikinger')
      ]
    ];

    foreach ($backend_subpages as $backend_subpage_id => $backend_subpage_data) {
      add_submenu_page(
        $parent_page_slug,
        $backend_subpage_data['page_title'],
        $backend_subpage_data['menu_title'],
        'manage_options',
        'vikinger_' . $backend_subpage_id,
        function () use($backend_subpage_id) { vikinger_backend_page_get($backend_subpage_id); }
      );
    }
  }
}

add_action('admin_menu', 'vikinger_backend_pages_register');

/**
 * Load functions
 * 
 * @since 1.9.8
 */
require_once VIKINGER_PATH . '/backend/includes/functions/vikinger-functions.php';

/**
 * Load AJAX
 * 
 * @since 1.9.8
 */
require_once VIKINGER_PATH . '/backend/includes/ajax/vikinger-ajax.php';

?>