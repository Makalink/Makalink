<?php
/**
 * Template Part - Icon SVG
 * 
 * @package Vikinger
 * 
 * @since 1.9.8
 * 
 * @author Odin Design Themes (https://odindesignthemes.com/)
 * 
 * @param array $args {
 *   @type string $icon         Icon name, used to load appropiate SVG icon.
 *   @type string $modifiers    Optional. Additional class names to add to the wrapper.
 * }
 */

  $modifiers = isset($args['modifiers']) ? $args['modifiers'] : false;

  $modifiers_classes = $modifiers ? $modifiers : '';

?>

<!-- ICON -->
<svg class="vikinger-icon vikinger-icon_<?php echo esc_attr($args['icon']); ?> <?php echo esc_attr($modifiers_classes); ?>">
  <use href="#svg-<?php echo esc_attr($args['icon']); ?>"></use>
</svg>
<!-- ICON -->