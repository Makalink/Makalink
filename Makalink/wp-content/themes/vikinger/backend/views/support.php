<?php
/**
 * Backend Template - Support
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
    'title'     => esc_html_x('Support', '(Backend)', 'vikinger'),
    'text'      => esc_html_x('This is the support page, below you can find information on how to get support for the theme.', '(Backend)', 'vikinger')
  ]);

?>
  <!-- CONTENT -->
  <div class="vikinger_backend-content">
    <!-- CONTENT PRE TITLE -->
    <p class="vikinger_backend-content-pretitle"><?php echo esc_html_x('Support', '(Backend)', 'vikinger'); ?></p>
    <!-- /CONTENT PRE TITLE -->

    <!-- CONTENT TITLE -->
    <h2 class="vikinger_backend-content-title"><?php echo esc_html_x('Envato\'s Support Policy', '(Backend)', 'vikinger'); ?></h2>
    <!-- /CONTENT TITLE -->

    <!-- CONTENT TEXT -->
    <p class="vikinger_backend-content-text">
    <?php

      printf(
        esc_html_x('You can read the full Envato Support Policy rules and guidelines of what\'s included and what\'s not in support %shere%s.', '(Backend)', 'vikinger'),
        '<a href="https://themeforest.net/page/item_support_policy#whats-not-included-item-support" target="_blank">',
        '</a>'
      );

    ?>
    </p>
    <!-- CONTENT TEXT -->

    <!-- CONTENT TEXT -->
    <p class="vikinger_backend-content-text">
      <strong class="vikinger_backend-color_error">
      <?php

        echo esc_html_x('Please carefully read the Envato Support Policy rules before contacting the support team. These rules are put in place by Envato and help the team focus on working towards bringing you new features and updates for the theme!', '(Backend)', 'vikinger');

      ?>
      </strong>
    </p>
    <!-- CONTENT TEXT -->
  </div>
  <!-- /CONTENT -->

  <!-- CONTENT -->
  <div class="vikinger_backend-content">
    <!-- CONTENT PRE TITLE -->
    <p class="vikinger_backend-content-pretitle"><?php echo esc_html_x('Support', '(Backend)', 'vikinger'); ?></p>
    <!-- /CONTENT PRE TITLE -->

    <!-- CONTENT TITLE -->
    <h2 class="vikinger_backend-content-title"><?php echo esc_html_x('How to get Support?', '(Backend)', 'vikinger'); ?></h2>
    <!-- /CONTENT TITLE -->
  </div>
  <!-- /CONTENT -->

  <?php

    /**
     * Message Box
     */
    get_template_part('backend/template-part/message', 'box', [
      'type'  => 'info',
      'title' => esc_html_x('Customization is not included in the support!', '(Backend)', 'vikinger'),
      'text'  => esc_html_x('Support does not include services to modify or extend the item beyond the original features, style and functionality.', '(Backend)', 'vikinger')
    ]);

  ?>

  <!-- CONTENT -->
  <div class="vikinger_backend-content">

    <!-- CONTENT TEXT -->
    <p class="vikinger_backend-content-text">
    <?php

      printf(
        esc_html_x('Before sending your support query, %splease consult the above section to check if it\'s included in the support of the item and check the documentation of the theme%s as many times your questions may already be answered there.', '(Backend)', 'vikinger'),
        '<strong class="vikinger_backend-color_primary">',
        '</strong>'
      );

    ?>
    </p>
    <!-- CONTENT TEXT -->

    <!-- CONTENT SUBTITLE -->
    <h2 class="vikinger_backend-content-subtitle"><?php echo esc_html_x('Guidelines', '(Backend)', 'vikinger'); ?></h2>
    <!-- /CONTENT SUBTITLE -->

    <!-- CONTENT TEXT -->
    <p class="vikinger_backend-content-text">
    <?php

      printf(
        esc_html_x('%sPlease read the support rules and check out the product documentation, articles and public tickets before creating a new ticket%s as many times your questions may already be answered, saving you back and forth time.', '(Backend)', 'vikinger'),
        '<strong class="vikinger_backend-color_primary">',
        '</strong>'
      );

    ?>
    </p>
    <!-- CONTENT TEXT -->

    <!-- CONTENT TEXT -->
    <p class="vikinger_backend-content-text">
    <?php

      printf(
        esc_html_x('The team provides support from %sMonday to Friday, from 9AM to 6PM (UTC-3)%s.', '(Backend)', 'vikinger'),
        '<strong>',
        '</strong>'
      );

    ?>
    </p>
    <!-- CONTENT TEXT -->

    <!-- CONTENT TEXT -->
    <p class="vikinger_backend-content-text">
    <?php

      printf(
        esc_html_x('We always try to reply as fast as possible, but %skeep in mind that the response time can be up to 2 business days%s.', '(Backend)', 'vikinger'),
        '<strong>',
        '</strong>'
      );

    ?>
    </p>
    <!-- CONTENT TEXT -->

    <!-- CONTENT TEXT -->
    <p class="vikinger_backend-content-text">
    <?php

      printf(
        esc_html_x('The team %sdoes not provide support on weekends and public holidays%s.', '(Backend)', 'vikinger'),
        '<strong>',
        '</strong>'
      );

    ?>
    </p>
    <!-- CONTENT TEXT -->

    <!-- CONTENT TEXT -->
    <p class="vikinger_backend-content-text">
    <?php

      printf(
        esc_html_x('Support is provided via a ticket system, which you can access %shere%s.', '(Backend)', 'vikinger'),
        '<a href="https://odindesignthemes.ticksy.com/" target="_blank">',
        '</a>'
      );

    ?>
    </p>
    <!-- CONTENT TEXT -->
  </div>
  <!-- /CONTENT -->
</div>
<!-- /BODY -->