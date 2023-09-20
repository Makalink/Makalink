<?php
/**
 * Template Part - Section Banner
 * 
 * @package Vikinger
 * 
 * @since 1.9.8
 * 
 * @author Odin Design Themes (https://odindesignthemes.com/)
 * 
 * @param array $args {
 *   @type string $pretitle         Banner pretitle.
 *   @type string $title            Banner title.
 *   @type string $text             Banner text.
 * }
 */

?>

<!-- SECTION BANNER -->
<div class="section-banner">
<?php

  /**
   * Icon SVG
   */
  get_template_part('backend/template-part/icon', 'svg', [
    'icon'      => 'logo',
    'modifiers' => 'section-banner-icon'
  ]);

?>

  <!-- SECTION BANNER PRETITLE -->
  <p class="section-banner-pretitle"><?php echo esc_html($args['pretitle']); ?></p>
  <!-- /SECTION BANNER PRETITLE -->

  <!-- SECTION BANNER TITLE -->
  <p class="section-banner-title"><?php echo esc_html($args['title']); ?></p>
  <!-- /SECTION BANNER TITLE -->

  <!-- SECTION BANNER TEXT -->
  <p class="section-banner-text"><?php echo esc_html($args['text']); ?></p>
  <!-- /SECTION BANNER TEXT -->
</div>
<!-- /SECTION BANNER -->