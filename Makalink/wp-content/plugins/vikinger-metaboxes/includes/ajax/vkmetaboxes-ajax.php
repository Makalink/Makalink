<?php
/**
 * Vikinger Metaboxes AJAX
 * 
 * @since 1.0.0
 */

/**
 * Get attachments by ids
 */
function vkmetaboxes_get_attachments_ajax() {
  $attachments = vkmetaboxes_get_attachments($_POST['attachmentIDS']);

  header('Content-Type: application/json');
  
  // return attachments
  echo json_encode($attachments);

  wp_die();
}

add_action('wp_ajax_vkmetaboxes_get_attachments_ajax', 'vkmetaboxes_get_attachments_ajax');
add_action('wp_ajax_nopriv_vkmetaboxes_get_attachments_ajax', 'vkmetaboxes_get_attachments_ajax');

?>