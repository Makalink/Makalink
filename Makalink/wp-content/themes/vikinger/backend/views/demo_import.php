<?php
/**
 * Backend Template - Demo Import
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
    'title'     => esc_html_x('Demo Import', '(Backend)', 'vikinger'),
    'text'      => esc_html_x('This is the demo import page, below you can import content from the demo into your theme!.', '(Backend)', 'vikinger')
  ]);

?>
  <!-- CONTENT -->
  <div class="vikinger_backend-content">
    <!-- CONTENT PRE TITLE -->
    <p class="vikinger_backend-content-pretitle"><?php echo esc_html_x('Demo Import', '(Backend)', 'vikinger'); ?></p>
    <!-- /CONTENT PRE TITLE -->

    <!-- CONTENT TITLE -->
    <h2 class="vikinger_backend-content-title"><?php echo esc_html_x('Import Demo Content', '(Backend)', 'vikinger'); ?></h2>
    <!-- /CONTENT TITLE -->

    <!-- CONTENT TEXT -->
    <p class="vikinger_backend-content-text"><?php echo esc_html_x('From here you can choose demo content to import to your theme.', '(Backend)', 'vikinger'); ?></p>
    <!-- CONTENT TEXT -->

    <!-- CONTENT TEXT -->
    <p class="vikinger_backend-content-text">
    <?php

      printf(
        esc_html_x('Before using this, make sure you have completed the theme install and setup process as detailed in the %sdocumentation%s.', '(Backend)', 'vikinger'),
        '<a href="https://odindesignthemes.com/vikingerthemedocs/how-to-install/" target="_blank">',
        '</a>'
      );

    ?>
    </p>
    <!-- CONTENT TEXT -->
  </div>
  <!-- /CONTENT -->

<?php

  /**
   * Message Box
   */
  get_template_part('backend/template-part/message', 'box', [
    'title' => esc_html_x('Important:', '(Backend)', 'vikinger'),
    'text'  => esc_html_x('You can use the checkboxes below to select which data you wish to import. The data can be imported any number of times, if you wish to delete data imported using this tool, please select them from the list below and click the "Reset" button.', '(Backend)', 'vikinger')
  ]);

?>

  <!-- CONTENT -->
  <div class="vikinger_backend-content">
    <!-- DEMO IMPORT LIST -->
    <div class="vikinger_backend-demo-import-list"></div>
    <!-- /DEMO IMPORT LIST -->
  </div>
  <!-- /CONTENT -->
</div>
<!-- /BODY -->