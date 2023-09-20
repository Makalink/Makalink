<?php
/**
 * Backend Template - Documentation
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
    'title'     => esc_html_x('Documentation', '(Backend)', 'vikinger'),
    'text'      => esc_html_x('This is the documentation page, below you can find information on available documentation for the theme.', '(Backend)', 'vikinger')
  ]);

?>

  <!-- CONTENT -->
  <div class="vikinger_backend-content">
    <!-- CONTENT PRE TITLE -->
    <p class="vikinger_backend-content-pretitle"><?php echo esc_html_x('Documentation', '(Backend)', 'vikinger'); ?></p>
    <!-- /CONTENT PRE TITLE -->

    <!-- CONTENT TITLE -->
    <h2 class="vikinger_backend-content-title"><?php echo esc_html_x('Where can i find the documentation?', '(Backend)', 'vikinger'); ?></h2>
    <!-- /CONTENT TITLE -->

    <!-- CONTENT TEXT -->
    <p class="vikinger_backend-content-text">
    <?php

      printf(
        esc_html_x('You can find the theme documentation %shere%s and the video guides playlist %shere%s.', '(Backend)', 'vikinger'),
        '<a href="https://odindesignthemes.com/vikingerthemedocs/" target="_blank">',
        '</a>',
        '<a href="https://www.youtube.com/playlist?list=PLdR1KxGpPfLWZ1Yq0_mNlYCtj8TLfX9CK" target="_blank">',
        '</a>'
      );

    ?>
    </p>
    <!-- CONTENT TEXT -->

    <!-- CONTENT TEXT -->
    <p class="vikinger_backend-content-text">
      <strong class="vikinger_backend-color_primary">
      <?php
      
        echo esc_html_x('Please follow the documentation setup and install guide when installing the theme and check the various customization sections for information on how to customize each part of the theme.', '(Backend)', 'vikinger');
      
      ?>
      </strong>
    </p>
    <!-- CONTENT TEXT -->
  </div>
  <!-- /CONTENT -->
</div>
<!-- /BODY -->