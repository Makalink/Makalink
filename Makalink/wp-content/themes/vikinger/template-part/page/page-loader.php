<?php
/**
 * Template Part - Page Loader
 * 
 * @package Vikinger
 * 
 * @since 1.0.0
 * 
 * @author Odin Design Themes (https://odindesignthemes.com/)
 * 
 */

?>

<!-- PAGE LOADER -->
<div class="page-loader">
<?php

  $loading_screen_logo_id = get_theme_mod('vikinger_loadingscreen_setting_logo', false);
  $loading_screen_logo_url = false;

  if ($loading_screen_logo_id) {
    $loading_screen_logo_url = wp_get_attachment_image_src($loading_screen_logo_id , 'full')[0];
  } else if (has_custom_logo()) {
    $loading_screen_logo_id = get_theme_mod('custom_logo');
    $loading_screen_logo_url = wp_get_attachment_image_src($loading_screen_logo_id , 'full')[0];
  }

  if ($loading_screen_logo_url) {

?>
  <!-- PAGE LOADER LOGO -->
  <img class="page-loader-logo" src="<?php echo esc_url($loading_screen_logo_url); ?>" alt="logo">
  <!-- /PAGE LOADER LOGO -->
<?php

  }

?>
  <!-- PAGE LOADER INFO -->
  <div class="page-loader-info">
    <!-- PAGE LOADER INFO TITLE -->
    <p class="page-loader-info-title"><?php bloginfo('name'); ?></p>
    <!-- /PAGE LOADER INFO TITLE -->

    <!-- PAGE LOADER INFO TEXT -->
    <p class="page-loader-info-text"><?php echo esc_html_x('Loading...', 'Loading Screen - Text', 'vikinger'); ?></p>
    <!-- /PAGE LOADER INFO TEXT -->
  </div>
  <!-- /PAGE LOADER INFO -->
  
  <!-- PAGE LOADER INDICATOR -->
  <div class="page-loader-indicator loader-bars">
    <div class="loader-bar"></div>
    <div class="loader-bar"></div>
    <div class="loader-bar"></div>
    <div class="loader-bar"></div>
    <div class="loader-bar"></div>
    <div class="loader-bar"></div>
    <div class="loader-bar"></div>
    <div class="loader-bar"></div>
  </div>
  <!-- /PAGE LOADER INDICATOR -->
</div>
<!-- /PAGE LOADER -->