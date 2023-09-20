<?php
/**
 * Vikinger Reactions REACTION AJAX
 * 
 * @since 1.0.0
 */

/**
 * Get all reactions
 */
function vkreact_get_reactions_ajax() {
  // nonce check, dies early if the nonce cannot be verified
  check_ajax_referer('vikinger_ajax');
  
  $result = vkreact_get_reactions();

  header('Content-Type: application/json');
  echo json_encode($result);

  wp_die();
}

add_action('wp_ajax_vkreact_get_reactions_ajax', 'vkreact_get_reactions_ajax');
add_action('wp_ajax_nopriv_vkreact_get_reactions_ajax', 'vkreact_get_reactions_ajax');

?>