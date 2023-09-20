<?php
/**
 * Functions
 * 
 * @package Vikinger
 * 
 * @since 1.0.0
 * @version 1.9.8
 * 
 * @author Odin Design Themes (https://odindesignthemes.com/)
 * 
 */

/**
 * Versioning
 * 
 * @since 1.0.0
 * @version 1.9.8
 */
if (!defined('VIKINGER_VERSION')) {
  $vikinger_wp_theme = wp_get_theme('vikinger');
  $vikinger_theme_version = isset($vikinger_wp_theme['Version']) ?  $vikinger_wp_theme['Version'] : esc_html__('Unknown', 'vikinger');
  define('VIKINGER_VERSION', $vikinger_theme_version);
}

/**
 * Paths and urls
 * 
 * @since 1.0.0
 * @version 1.9.8
 */
if (!defined('VIKINGER_PATH')) {
  define('VIKINGER_PATH', get_template_directory());
}

if (!defined('VIKINGER_URL')) {
  define('VIKINGER_URL', get_template_directory_uri());
}

if (!defined('VIKINGER_UPLOADS_PATH')) {
  define('VIKINGER_UPLOADS_PATH', wp_get_upload_dir()['basedir'] . '/vikinger');
}

if (!defined('VIKINGER_UPLOADS_URL')) {
  define('VIKINGER_UPLOADS_URL', wp_get_upload_dir()['baseurl'] . '/vikinger');
}

if (!function_exists('vikinger_load_scripts')) {
  /**
   * Load theme styles and scripts.
   * 
   * @since 1.0.0
   */
  function vikinger_load_scripts() {
    global $vikinger_settings;

    $vikinger_settings = vikinger_settings_get();

    // get fonts
    $fonts = vikinger_customizer_theme_fonts_get_for_enqueue();

    // load fonts
    wp_enqueue_style('vikinger-fonts', 'https://fonts.googleapis.com/css?family=' . $fonts['primary'] . ':400,500,600,700|' . $fonts['secondary'] . ':400,900&display=swap');

    // Simplebar
    wp_enqueue_style('vikinger-simplebar-styles', VIKINGER_URL . '/css/vendor/simplebar.css', [], '1.0.0');
    // Swiper
    wp_enqueue_style('vikinger-swiper-slider-styles', VIKINGER_URL . '/css/vendor/swiper.min.css', [], '1.0.0');
    // Main
    wp_enqueue_style('vikinger-styles', VIKINGER_URL . '/style.css', ['vikinger-simplebar-styles', 'vikinger-swiper-slider-styles'], '4.0.1');

    // get user custom theme fonts
    $custom_fonts = vikinger_customizer_theme_fonts_get_style();

    // add user custom theme fonts
    wp_add_inline_style('vikinger-styles', $custom_fonts);

    // get user custom theme colors
    $custom_colors = vikinger_customizer_theme_colors_get();

    // add user custom theme colors
    wp_add_inline_style('vikinger-styles', $custom_colors);

    // Swiper
    wp_enqueue_script('vikinger-swiper-scripts', VIKINGER_URL . '/js/vendor/swiper.min.js', [], '1.0.0', true);
    // Accordion
    wp_enqueue_script('vikinger-xmaccordion-scripts', VIKINGER_URL . '/js/vendor/xm_accordion.min.js', [], '1.0.0', true);
    // Dropdown
    wp_enqueue_script('vikinger-xmdropdown-scripts', VIKINGER_URL . '/js/vendor/xm_dropdown.min.js', [], '1.0.0', true);
    // Hexagon
    wp_enqueue_script('vikinger-xmhexagon-scripts', VIKINGER_URL . '/js/vendor/xm_hexagon.min.js', [], '1.0.0', true);
    // Popup
    wp_enqueue_script('vikinger-xmpopup-scripts', VIKINGER_URL . '/js/vendor/xm_popup.min.js', [], '1.0.0', true);
    // Progress Bar
    wp_enqueue_script('vikinger-xmprogressBar-scripts', VIKINGER_URL . '/js/vendor/xm_progressBar.min.js', [], '1.0.0', true);
    // Tab
    wp_enqueue_script('vikinger-xmtab-scripts', VIKINGER_URL . '/js/vendor/xm_tab.min.js', [], '1.0.0', true);
    // Tooltip
    wp_enqueue_script('vikinger-xmtooltip-scripts', VIKINGER_URL . '/js/vendor/xm_tooltip.min.js', [], '1.0.0', true);

    $vikinger_main_scripts_dependencies = [
      'jquery',
      'vikinger-swiper-scripts',
      'vikinger-xmaccordion-scripts',
      'vikinger-xmdropdown-scripts',
      'vikinger-xmhexagon-scripts',
      'vikinger-xmpopup-scripts',
      'vikinger-xmprogressBar-scripts',
      'vikinger-xmtab-scripts',
      'vikinger-xmtooltip-scripts'
    ];

    // Main
    wp_enqueue_script('vikinger-main-scripts', VIKINGER_URL . '/js/app.bundle.min.js', $vikinger_main_scripts_dependencies, '4.0.1', true);

    // Translation
    wp_localize_script('vikinger-main-scripts', 'vikinger_translation', vikinger_translation_get());

    // Variables
    wp_add_inline_script('vikinger-main-scripts', vikinger_constants_get(), 'before');
  }
}

add_action('wp_enqueue_scripts', 'vikinger_load_scripts');

if (!function_exists('vikinger_dequeue_styles')) {
  /**
   * Remove plugin styles that are not needed to reduce file queries.
   * 
   * @since 1.0.0
   */
  function vikinger_dequeue_styles() {
    // remove BuddyPress styles
    wp_dequeue_style('bp-legacy-css');

    // remove GamiPress styles
    wp_dequeue_style('gamipress-css');
  }
}

add_action('wp_enqueue_scripts', 'vikinger_dequeue_styles', 20);

if (!function_exists('vikinger_body_classes')) {
  /**
   * Add body class filters.
   * 
   * @since 1.0.0
   */
  function vikinger_body_classes($classes){
    if (is_admin_bar_showing()) {
      $classes[] = 'vikinger-top-space';
    }

    if (!is_user_logged_in()) {
      $classes[] = 'vikinger-logged-out';
    }

    return $classes;
  }
}

add_filter('body_class', 'vikinger_body_classes');

if (!function_exists('vikinger_register_menus')) {
  /**
   * Navigation Menus.
   * 
   * @since 1.0.0
   */
  function vikinger_register_menus() {
    register_nav_menus(
      [
        'header_menu'           => esc_html_x('Header Menu', '(Backend) Menu Location Name', 'vikinger'),
        'header_features_menu'  => esc_html_x('Header Features Menu', '(Backend) Menu Location Name', 'vikinger'),
        'side_menu'             => esc_html_x('Side Menu', '(Backend) Menu Location Name', 'vikinger'),
        'footer_menu'           => esc_html_x('Footer Menu', '(Backend) Menu Location Name', 'vikinger')
      ]
    );
  }
}

add_action('init', 'vikinger_register_menus');

if (!function_exists('vikinger_support_features')) {
  /**
   * Add support for features.
   * 
   * @since 1.0.0
   */
  function vikinger_support_features() {
    add_theme_support('post-formats', ['video', 'audio', 'gallery']);

    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('automatic-feed-links');

    // Set content width.
    global $content_width;
    
    if (!isset($content_width)) {
      $content_width = 800;
    }

    // add post thumbnails support
    add_theme_support('post-thumbnails');
    
    // Set post thumbnail size.
    set_post_thumbnail_size(584);

    // Add custom image sizes used in post versions cover.
    add_image_size('vikinger-postlist-thumb', 40, 40, true);
    add_image_size('vikinger-postv1-fullscreen', 1980);
    add_image_size('vikinger-postv2-fullscreen', 1184);

    // bbPress images
    add_post_type_support('forum', 'thumbnail');
    add_image_size('vikinger-forum-thumb', 64, 64, true);

    // WooCommerce support
    add_theme_support('woocommerce');
    // WooCommerce gallery support
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
  }
}

add_action('after_setup_theme', 'vikinger_support_features');

/**
 * Hide admin bar for non administrators
 */
$admin_bar_status = get_theme_mod('vikinger_adminbar_setting_display', 'display');

if (($admin_bar_status === 'hide') && !current_user_can('administrator')) {
  show_admin_bar(false);
}

if (!function_exists('vikinger_class_autoloader')) {
  /**
   * PHP Autoloader.
   * 
   * @since 1.0.0
   */
  function vikinger_class_autoloader($class_name) {
    $base_path = VIKINGER_PATH . '/includes/classes';

    // utils classes
    $utils_path = $base_path . '/utils';
    $utils_classes = ['Vikinger_Scheduler', 'Vikinger_Task'];

    foreach ($utils_classes as $utils_class) {
      if ($class_name === $utils_class) {
        require $utils_path . '/' . $class_name . '.php';
      }
    }
  }
}

spl_autoload_register('vikinger_class_autoloader');

if (!function_exists('vikinger_allow_redirect_after_header')) {
  /**
   * Allow the use of wp_redirect / wp_safe_redirect after headers are sent (after the get_header() function is called).
   * 
   * @since 1.0.0
   */
  function vikinger_allow_redirect_after_header() {
    ob_start();
  }
}

add_action('init', 'vikinger_allow_redirect_after_header');

if (!function_exists('vikinger_translations_load')) {
  /**
   * Load translations.
   * 
   * @since 1.0.0
   */
  function vikinger_translations_load() {
    load_theme_textdomain('vikinger', VIKINGER_PATH . '/languages');
  }
}

add_action('after_setup_theme', 'vikinger_translations_load');

/**
 * Functions
 * 
 * @since 1.0.0
 */
require_once VIKINGER_PATH . '/includes/functions/vikinger-functions.php';

/**
 * AJAX
 * 
 * @since 1.0.0
 */
require_once VIKINGER_PATH . '/includes/ajax/vikinger-ajax.php';

/**
 * Sidebars
 * 
 * @since 1.0.0
 */
require_once VIKINGER_PATH . '/includes/sidebars/vikinger-sidebars.php';

/**
 * Customizer
 * 
 * @since 1.0.0
 */
require_once VIKINGER_PATH . '/includes/customizer/vikinger-customizer.php';

/**
 * Load backend related functions
 * only when on the WordPress backend.
 */
if (is_admin()) {
  /**
   * Load backend functions.
   * 
   * @since 1.9.8
   */
  require_once VIKINGER_PATH . '/backend/functions.php';
}

?>