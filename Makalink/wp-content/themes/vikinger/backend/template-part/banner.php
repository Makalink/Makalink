<?php
/**
 * Template Part - Banner
 * 
 * @package Vikinger
 * 
 * @since 1.0.0
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

<!-- BANNER -->
<div class="vikinger_backend-banner">
  <!-- BANNER LOGO -->
  <img class="vikinger_backend-banner-logo" src="<?php echo esc_url(VIKINGER_URL); ?>/backend/img/logo.png" alt="Vikinger">
  <!-- /BANNER LOGO -->

  <!-- BANNER PRE TITLE -->
  <p class="vikinger_backend-banner-pretitle"><?php echo esc_html($args['pretitle']); ?></p>
  <!-- /BANNER PRE TITLE -->

  <!-- BANNER TITLE -->
  <p class="vikinger_backend-banner-title"><?php echo esc_html($args['title']); ?></p>
  <!-- /BANNER TITLE -->

  <!-- BANNER TEXT -->
  <p class="vikinger_backend-banner-text"><?php echo esc_html($args['text']); ?></p>
  <!-- /BANNER TEXT -->
</div>
<!-- /BANNER -->