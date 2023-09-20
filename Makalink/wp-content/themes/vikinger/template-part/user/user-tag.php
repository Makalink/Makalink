<?php
/**
 * Template Part - User Tag
 * 
 * @package Vikinger
 * 
 * @since 1.9.8.1
 * 
 * @author Odin Design Themes (https://odindesignthemes.com/)
 * 
 * @param array $args {
 *   @type string $name         Tag text.
 *   @type string $modifiers    Optional. Additional class names to add to the wrapper.
 * }
 */

  $modifiers = isset($args['modifiers']) ? $args['modifiers'] : false;

  $modifiers_classes = $modifiers ? $modifiers : '';

?>

<!-- USER TAG -->
<div class="vikinger-user-tag <?php echo esc_attr($modifiers_classes); ?>">
  <!-- USER TAG TEXT -->
  <p class="vikinger-user-tag-text"><?php echo esc_html($args['name']); ?></p>
  <!-- /USER TAG TEXT -->
</div>
<!-- /USER TAG -->