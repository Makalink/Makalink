<?php
/**
 * Template Part - Message Box
 * 
 * @package Vikinger
 * 
 * @since 1.0.0
 * 
 * @author Odin Design Themes (https://odindesignthemes.com/)
 * 
 * @param array $args {
 *   @type string $type             Message box type. Optional.
 *   @type string $title            Message box title.
 *   @type string $text             Message box text.
 * }
 */

  $message_box_type = isset($args['type']) ? $args['type'] : 'info';

?>

<!-- MESSAGE BOX -->
<div class="vikinger_backend-message-box vikinger_backend-message-box_<?php echo esc_attr($message_box_type); ?>">
  <!-- MESSAGE BOX ICON WRAP -->
  <div class="vikinger_backend-message-box-icon-wrap">
  <?php

    /**
     * Icon SVG
     */
    get_template_part('backend/template-part/icon', 'svg', [
      'icon'      => $message_box_type,
      'modifiers' => 'vikinger_backend-message-box-icon'
    ]);

  ?>
  </div>
  <!-- /MESSAGE BOX ICON WRAP -->

  <!-- MESSAGE BOX TITLE -->
  <p class="vikinger_backend-message-box-title"><?php echo esc_html($args['title']); ?></p>
  <!-- /MESSAGE BOX TITLE -->

  <!-- MESSAGE BOX TEXT -->
  <p class="vikinger_backend-message-box-text">
  <?php

    echo wp_kses(
      $args['text'],
      apply_filters(
        'vikinger_backend_message_box_text_allowed_html',
        [
          'a' => [
            'href'  => []
          ]
        ]
      )
    );

  ?>
  </p>
  <!-- /MESSAGE BOX TEXT -->
</div>
<!-- /MESSAGE BOX -->