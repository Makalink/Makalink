<?php
/**
 * Backend Template - Index
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
    'title'     => esc_html_x('Getting Started', '(Backend)', 'vikinger'),
    'text'      => esc_html_x('Thank you for your purchase! This is your first stop after activating the theme! Read about how to setup, import demo content and more!.', '(Backend)', 'vikinger')
  ]);

  /**
   * Message Box
   */
  get_template_part('backend/template-part/message', 'box', [
    'title' => esc_html_x('Important:', '(Backend)', 'vikinger'),
    'text'  => esc_html_x('We ask that you please read carefully all the information in this page. Here you\'ll find what you need to do in order to setup the theme and import the demo content to make it look like the live preview. It\'s very important that you follow all the steps because setting up the theme correctly will help you avoid issues and errors. We also provide information and guides on how to customize the theme and FAQs.', '(Backend)', 'vikinger')
  ]);

  ?>

  <!-- CONTENT -->
  <div class="vikinger_backend-content">
    <!-- CONTENT PRE TITLE -->
    <p class="vikinger_backend-content-pretitle"><?php echo esc_html_x('Getting Started', '(Backend)', 'vikinger'); ?></p>
    <!-- /CONTENT PRE TITLE -->

    <!-- CONTENT TITLE -->
    <h2 class="vikinger_backend-content-title"><?php echo esc_html_x('How to Install', '(Backend)', 'vikinger'); ?></h2>
    <!-- /CONTENT TITLE -->

    <!-- CONTENT TEXT -->
    <p class="vikinger_backend-content-text"><?php echo esc_html_x('Here\'s a quick video guide about how to install the theme and plugins:', '(Backend)', 'vikinger'); ?></p>
    <!-- CONTENT TEXT -->

    <!-- ASPECT RATIO CONTAINER -->
    <div class="vikinger_backend-aspect-ratio-container vikinger_backend-aspect-ratio-container_16-9">
      <iframe src="https://www.youtube.com/embed/t6ENt1PI6iw" allowfullscreen></iframe>
    </div>
    <!-- /ASPECT RATIO CONTAINER -->

    <!-- CONTENT TEXT -->
    <p class="vikinger_backend-content-text">
    <?php

      printf(
        esc_html_x('For a more detailed step by step guide, we recommend you checking the %sdocumentation%s.', '(Backend)', 'vikinger'),
        '<a href="https://odindesignthemes.com/vikingerthemedocs/how-to-install/" target="_blank">',
        '</a>'
      );

    ?>
    </p>
    <!-- CONTENT TEXT -->
  </div>
  <!-- /CONTENT -->

  <!-- CONTENT -->
  <div class="vikinger_backend-content">
    <!-- CONTENT PRE TITLE -->
    <p class="vikinger_backend-content-pretitle"><?php echo esc_html_x('Getting Started', '(Backend)', 'vikinger'); ?></p>
    <!-- /CONTENT PRE TITLE -->

    <!-- CONTENT TITLE -->
    <h2 class="vikinger_backend-content-title"><?php echo esc_html_x('Theme Setup', '(Backend)', 'vikinger'); ?></h2>
    <!-- /CONTENT TITLE -->

    <!-- CONTENT TEXT -->
    <p class="vikinger_backend-content-text">
    <?php

      printf(
        esc_html_x('Here\'s a quick video guide about how to configure some plugin options to ensure the correct functionality of the included features. %sThis is a very important step to ensure that everything works OK and to avoid styling and other issues.%s', '(Backend)', 'vikinger'),
        '<strong>',
        '</strong>'
      );

    ?>
    </p>
    <!-- CONTENT TEXT -->

    <!-- ASPECT RATIO CONTAINER -->
    <div class="vikinger_backend-aspect-ratio-container vikinger_backend-aspect-ratio-container_16-9">
      <iframe src="https://www.youtube.com/embed/CL4Qy3Dm0Y4" allowfullscreen></iframe>
    </div>
    <!-- /ASPECT RATIO CONTAINER -->

    <!-- CONTENT TEXT -->
    <p class="vikinger_backend-content-text">
    <?php

      printf(
        esc_html_x('For a more detailed step by step guide, we recommend you checking the %sdocumentation%s.', '(Backend)', 'vikinger'),
        '<a href="https://odindesignthemes.com/vikingerthemedocs/theme-setup/" target="_blank">',
        '</a>'
      );

    ?>
    </p>
    <!-- CONTENT TEXT -->
  </div>
  <!-- /CONTENT -->

  <!-- CONTENT -->
  <div class="vikinger_backend-content">
    <!-- CONTENT PRE TITLE -->
    <p class="vikinger_backend-content-pretitle"><?php echo esc_html_x('Getting Started', '(Backend)', 'vikinger'); ?></p>
    <!-- /CONTENT PRE TITLE -->

    <!-- CONTENT TITLE -->
    <h2 class="vikinger_backend-content-title"><?php echo esc_html_x('Demo Import', '(Backend)', 'vikinger'); ?></h2>
    <!-- /CONTENT TITLE -->

    <!-- CONTENT TEXT -->
    <p class="vikinger_backend-content-text">
    <?php

      printf(
        esc_html_x('We created a demo content import page so you\'ll be able to %simport all the menus, pages and profile fields%s that you see in the live demo and more!.', '(Backend)', 'vikinger'),
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
        esc_html_x('First of all, make sure to %sfollow the steps of the "How to Install" and "Theme Setup" sections%s.', '(Backend)', 'vikinger'),
        '<strong>',
        '</strong>'
      );

    ?>
    </p>
    <!-- CONTENT TEXT -->

    <!-- CONTENT TEXT -->
    <p class="vikinger_backend-content-text"><?php echo esc_html_x('After this you\'ll have two options:', '(Backend)', 'vikinger'); ?></p>
    <!-- CONTENT TEXT -->

    <!-- UNORDERED LIST -->
    <ul class="vikinger_backend-content-unordered-list">
      <!-- UNORDERED LIST ITEM -->
      <li class="vikinger_backend-content-unordered-list-item">
      <?php

        printf(
          esc_html_x('%sCustomize the theme the way you want%s, adding your sections, menus, etc, following the steps of each of the documentation sections (Theme Customization, Menus, etc) and the video guides. This is better for people that want to start from zero and customize everything.', '(Backend)', 'vikinger'),
          '<strong>',
          '</strong>'
        );

      ?>
      </li>
      <!-- /UNORDERED LIST ITEM -->

      <!-- UNORDERED LIST ITEM -->
      <li class="vikinger_backend-content-unordered-list-item">
      <?php

        printf(
          esc_html_x('%sImport content from the demo%s. You\'ll find the import screen inside the theme, in the "Demo Import" tab. There, you\'ll be able to choose what elements to import, or even reset them. We developed this so you can import all, or just choose the elements that you\'d like to add.', '(Backend)', 'vikinger'),
          '<strong>',
          '</strong>'
        );

      ?>
      </li>
      <!-- /UNORDERED LIST ITEM -->
    </ul>
    <!-- /UNORDERED LIST -->
  </div>
  <!-- /CONTENT -->

  <?php

    /**
     * Message Box
     */
    get_template_part('backend/template-part/message', 'box', [
      'title' => esc_html_x('Important:', '(Backend)', 'vikinger'),
      'text'  => esc_html_x('Please keep in mind that this tool doesn\'t import the Elementor and GamiPress plugin specific demo content data (including all badges, quests, ranks and credits with the illustrations) because they are imported via each plugin. You can import the plugin specific demo content data by following the steps in the "Elementor" and "GamiPress" -> "Demo Content" sections of the documentation.', '(Backend)', 'vikinger')
    ]);

  ?>

  <!-- CONTENT -->
  <div class="vikinger_backend-content">
    <!-- CONTENT TEXT -->
    <p class="vikinger_backend-content-text"><?php echo esc_html_x('Check out this video guide where you can see the entire process, from installing and configuring the theme, to importing all content to make it look like the live demo:', '(Backend)', 'vikinger'); ?></p>
    <!-- CONTENT TEXT -->

    <!-- ASPECT RATIO CONTAINER -->
    <div class="vikinger_backend-aspect-ratio-container vikinger_backend-aspect-ratio-container_16-9">
      <iframe src="https://www.youtube.com/embed/SXEgduXEupk" allowfullscreen></iframe>
    </div>
    <!-- /ASPECT RATIO CONTAINER -->

    <!-- CONTENT TEXT -->
    <p class="vikinger_backend-content-text"><?php echo esc_html_x('After this, as we mentioned before, you only need to install the Elementor demo content and customize all other elements (menus, pages, etc) any way you want! Take a look at other sections of the documentation to see how to edit each one!', '(Backend)', 'vikinger'); ?></p>
    <!-- CONTENT TEXT -->
  </div>
  <!-- /CONTENT -->

  <!-- CONTENT -->
  <div class="vikinger_backend-content">
    <!-- CONTENT PRE TITLE -->
    <p class="vikinger_backend-content-pretitle"><?php echo esc_html_x('Getting Started', '(Backend)', 'vikinger'); ?></p>
    <!-- /CONTENT PRE TITLE -->

    <!-- CONTENT TITLE -->
    <h2 class="vikinger_backend-content-title"><?php echo esc_html_x('Customizing & Guides', '(Backend)', 'vikinger'); ?></h2>
    <!-- /CONTENT TITLE -->

    <!-- CONTENT TEXT -->
    <p class="vikinger_backend-content-text"><?php echo esc_html_x('We created helpful guides that we recommend you to read in order to know about more customization, settings and more!.', '(Backend)', 'vikinger'); ?></p>
    <!-- CONTENT TEXT -->

    <!-- CONTENT TEXT -->
    <p class="vikinger_backend-content-text"><?php echo esc_html_x('Here\'s a quick overview:', '(Backend)', 'vikinger'); ?></p>
    <!-- CONTENT TEXT -->

    <!-- CONTENT SUBTITLE -->
    <h2 class="vikinger_backend-content-subtitle"><?php echo esc_html_x('Documentation', '(Backend)', 'vikinger'); ?></h2>
    <!-- /CONTENT SUBTITLE -->

    <!-- CONTENT TEXT -->
    <p class="vikinger_backend-content-text">
    <?php

      printf(
        esc_html_x('Here you can find detailed guides about the theme %scustomization, plugins (for example GamiPress), menus, translation, blog and more!%s', '(Backend)', 'vikinger'),
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
        esc_html_x('We also %sstrongly recommend reading the section “Theme Customization” -> “Customizer Settings%s where you\'ll find a quick overview of all the things that you\'ll be able to customize via the WP customizer. Things like %scolors presets, changing login and register pages text and images, loading screen, avatar and profile settings, remove the search or sidebar, media settings%s and more!.', '(Backend)', 'vikinger'),
        '<strong>',
        '</strong>',
        '<strong>',
        '</strong>'
      );

    ?>
    </p>
    <!-- CONTENT TEXT -->

    <!-- CONTENT TEXT -->
    <p class="vikinger_backend-content-text"><a href="https://odindesignthemes.com/vikingerthemedocs/" target="_blank"><?php echo esc_html_x('Click here to check the documentation', '(Backend)', 'vikinger'); ?></a></p>
    <!-- CONTENT TEXT -->

    <!-- CONTENT SUBTITLE -->
    <h2 class="vikinger_backend-content-subtitle"><?php echo esc_html_x('Video Guides', '(Backend)', 'vikinger'); ?></h2>
    <!-- /CONTENT SUBTITLE -->

    <!-- CONTENT TEXT -->
    <p class="vikinger_backend-content-text"><?php echo esc_html_x('Quick video guides so you can check out individual things or have a visual aid for things like setup, demo import, customization and more!.', '(Backend)', 'vikinger'); ?></p>
    <!-- CONTENT TEXT -->

    <!-- CONTENT TEXT -->
    <p class="vikinger_backend-content-text"><a href="https://www.youtube.com/playlist?list=PLdR1KxGpPfLWZ1Yq0_mNlYCtj8TLfX9CK" target="_blank"><?php echo esc_html_x('Click here to check the video guides', '(Backend)', 'vikinger'); ?></a></p>
    <!-- CONTENT TEXT -->

    <!-- CONTENT SUBTITLE -->
    <h2 class="vikinger_backend-content-subtitle"><?php echo esc_html_x('FAQs Section', '(Backend)', 'vikinger'); ?></h2>
    <!-- /CONTENT SUBTITLE -->

    <!-- CONTENT TEXT -->
    <p class="vikinger_backend-content-text">
    <?php

      printf(
        esc_html_x('Helpful guides based on the top asked questions people ask about the theme, like %show to remove the wp bar on top? how to force login users for only them to see the content? how to customize the login forms? how to change the page users are redirected after login? how to translate?%s and many more!', '(Backend)', 'vikinger'),
        '<strong>',
        '</strong>'
      );

    ?>
    </p>
    <!-- CONTENT TEXT -->

    <!-- CONTENT TEXT -->
    <p class="vikinger_backend-content-text"><a href="https://odindesignthemes.com/vikingerthemedocs/faqs/" target="_blank"><?php echo esc_html_x('Click here to check the FAQs page', '(Backend)', 'vikinger'); ?></a></p>
    <!-- CONTENT TEXT -->

    <!-- CONTENT SUBTITLE -->
    <h2 class="vikinger_backend-content-subtitle"><?php echo esc_html_x('Troubleshooting Section', '(Backend)', 'vikinger'); ?></h2>
    <!-- /CONTENT SUBTITLE -->

    <!-- CONTENT TEXT -->
    <p class="vikinger_backend-content-text">
    <?php

      printf(
        esc_html_x('Answers to the most common issues or problems you may encounter, like %sWordPress site Health, people can\'t login after registration, registration email not sending%s and many more!', '(Backend)', 'vikinger'),
        '<strong>',
        '</strong>'
      );

    ?>
    </p>
    <!-- CONTENT TEXT -->

    <!-- CONTENT TEXT -->
    <p class="vikinger_backend-content-text"><a href="https://odindesignthemes.com/vikingerthemedocs/troubleshooting/" target="_blank"><?php echo esc_html_x('Click here to check the Troubleshooting page', '(Backend)', 'vikinger'); ?></a></p>
    <!-- CONTENT TEXT -->
  </div>
  <!-- /CONTENT -->
</div>
<!-- /BODY -->