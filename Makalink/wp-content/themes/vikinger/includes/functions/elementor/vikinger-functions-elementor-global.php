<?php
/**
 * Functions - Elementor - Global
 * 
 * @package Vikinger
 * 
 * @since 1.9.1
 * 
 * @author Odin Design Themes (https://odindesignthemes.com/)
 * 
 */

if (!function_exists('vikinger_is_elementor_page')) {
  /**
   * Checks if the current page is an elementor page
   * 
   * @return bool $elementor_page      True if elementor page, false otherwise.
   */
  function vikinger_is_elementor_page(){
    global $post;

    $elementor_documents = \Elementor\Plugin::$instance->documents;

    $elementor_document = $elementor_documents->get($post->ID);

    if ($elementor_document) {
      return $elementor_document->is_built_with_elementor();
    }

    return false;
  }
}

if (!function_exists('vikinger_elementor_styles_encode_get')) {
  /**
   * Returns styles as a string.
   * 
   * @param array   $styles     CSS Styles.
   * @return string $output     Style string.
   */
  function vikinger_elementor_styles_encode_get($styles) {
    $output = 'style=';

    foreach ($styles as $key => $value) {
      if ($value !== '') {
        $output .= $key . ':' . $value . ';';
      }
    }

    return $output;
  }
}

?>