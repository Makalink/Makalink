<?php
/**
 * Template Part - User Tag List
 * 
 * @package Vikinger
 * 
 * @since 1.9.8.1
 * 
 * @author Odin Design Themes (https://odindesignthemes.com/)
 * 
 * @param array $args {
 *   @type string $tags             Tag data.
 *   @type string $tag_modifiers    Optional. Additional class names to add to the tag wrapper.
 * }
 */

  $tag_modifiers = isset($args['tag_modifiers']) ? $args['tag_modifiers'] : false;

  $tag_modifiers_classes = $tag_modifiers ? $tag_modifiers : '';

?>

<!-- USER TAG LIST -->
<div class="vikinger-user-tag-list">
<?php

  foreach ($args['tags'] as $tag_name) {
    /**
     * User Tag
     */
    get_template_part('template-part/user/user', 'tag', [
      'name'      => $tag_name,
      'modifiers' => $tag_modifiers_classes
    ]);
  }

?>
</div>
<!-- /USER TAG LIST -->