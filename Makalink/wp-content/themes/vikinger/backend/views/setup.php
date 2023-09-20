<?php
/**
 * Backend Template - Setup
 * 
 * @package Vikinger
 * 
 * @since 1.0.0
 * @version 1.9.8
 * 
 * @author Odin Design Themes (https://odindesignthemes.com/)
 * 
 */

?>

<!-- BODY -->
<div class="vikinger_backend-body">
<?php

  /**
   * Banner
   */
  get_template_part('backend/template-part/banner', null, [
    'pretitle'  => sprintf(
      esc_html_x('Vikinger - Version %s', '(Backend)', 'vikinger'),
      VIKINGER_VERSION
    ),
    'title'     => esc_html_x('Setup', '(Backend)', 'vikinger'),
    'text'      => esc_html_x('This is the setup page, below you can select which plugins you want to use, check their status, and click on the button below to easily install, update and activate all of them!.', '(Backend)', 'vikinger')
  ]);

?>

  <!-- PLUGIN LIST -->
  <div class="vikinger_backend-plugin-list"></div>
  <!-- /PLUGIN LIST -->
</div>
<!-- /BODY -->