<?php

/**
 * Check if a members profile page is enabled
 * 
 * @param string $page      Page name.
 * @return bool True if members profile about page is enabled, false otherwise.
 */
function vikinger_buddypress_extension_settings_members_profile_page_is_enabled($page) {
  return get_theme_mod('vikinger_members_setting_profile_' . $page . '_page_status', 'enabled') === 'enabled';
}

/**
 * Check if file type upload is enabled
 * 
 * @return bool True if file type upload is enabled, false otherwise.
 */
function vikinger_buddypress_extension_settings_media_file_upload_is_enabled($file_type) {
  $file_type_option = [
    'image' => 'photo',
    'video' => 'video'
  ];

  return get_theme_mod('vikinger_media_setting_' . $file_type_option[$file_type] . '_upload_status', 'enabled') === 'enabled';
}

/**
 * Add admin bar routes
 */
function vikinger_buddypress_extension_admin_bar_add_routes() {
  global $wp_admin_bar;

  $user_domain = bp_loggedin_user_domain();

  $user = false;
  
  $user_id = 0;

  if (is_user_logged_in()) {
    $user_id = get_current_user_id();
  }

  $user = get_userdata($user_id);

  if (!$user) {
    return;
  }

  $logged_user = [
    'name'        => $user->display_name,
    'avatar_url'  => get_avatar_url($user_id)
  ];

  ob_start();
  ?>
  <?php printf(esc_html('Hi, %s!', 'vikinger-buddypress-extension'), $logged_user['name']); ?><img src="<?php echo esc_url($logged_user['avatar_url']); ?>" srcset="<?php echo esc_url($logged_user['avatar_url']); ?> 2x" class="avatar avatar-26 photo" height="26" width="26">
  <?php
  $account_info_html = ob_get_clean();

  // My Account menu link
  $wp_admin_bar->add_menu([
    'id'      => 'my-account',
    'title'   => $account_info_html,
    'href'    => trailingslashit($user_domain . 'activity')
  ]);

  ob_start();
  ?>
  <a class="ab-item" tabindex="-1" href="<?php echo esc_url(trailingslashit($user_domain . 'activity')); ?>">
    <img src="<?php echo esc_url($logged_user['avatar_url']); ?>" srcset="<?php echo esc_url($logged_user['avatar_url']); ?> 2x" class="avatar avatar-64 photo" height="64" width="64">
    <span class="display-name"><?php echo esc_html($logged_user['name']); ?></span>
  </a>
  <?php
  $user_info_html = ob_get_clean();

  // User info menu link
  $wp_admin_bar->add_menu([
    'id'      => 'user-info',
    'title'   => $user_info_html,
    'href'    => trailingslashit($user_domain . 'activity')
  ]);

  // User info menu link
  $wp_admin_bar->add_menu([
    'id'      => 'edit-profile',
    'title'   => _x('Edit My Profile', '(Admin Bar) Quick Access Settings Page Link', 'vikinger-buddypress-extension'),
    'href'    => trailingslashit($user_domain . 'settings')
  ]);

  // Profile menu link
  $wp_admin_bar->add_menu([
    'parent'  => 'my-account-buddypress',
    'id'      => 'vikinger-profile',
    'title'   => _x('Profile', '(Admin Bar) Profile Page Link', 'vikinger-buddypress-extension'),
    'href'    => trailingslashit($user_domain . 'activity')
  ]);

  if (vikinger_buddypress_extension_settings_members_profile_page_is_enabled('about')) {
    // About submenu link
    $wp_admin_bar->add_menu([
      'parent'  => 'vikinger-profile',
      'id'      => 'vikinger-profile-about',
      'title'   => _x('About', '(Admin Bar) Profile Activity Page Link', 'vikinger-buddypress-extension'),
      'href'    => trailingslashit($user_domain . 'about')
    ]);
  }

  if (bp_is_active('activity')) {
    // Timeline submenu link
    $wp_admin_bar->add_menu([
      'parent'  => 'vikinger-profile',
      'id'      => 'vikinger-profile-timeline',
      'title'   => _x('Timeline', '(Admin Bar) Profile Timeline Page Link', 'vikinger-buddypress-extension'),
      'href'    => trailingslashit($user_domain . 'activity')
    ]);
  }

  // Only add friends related menu items if the BuddyPress friends component is active
  if (bp_is_active('friends')) {
    // Friends submenu link
    $wp_admin_bar->add_menu([
      'parent'  => 'vikinger-profile',
      'id'      => 'vikinger-profile-friends',
      'title'   => _x('Friends', '(Admin Bar) Profile Friends Page Link', 'vikinger-buddypress-extension'),
      'href'    => trailingslashit($user_domain . 'friends')
    ]);
  }

  // Only add groups related menu items if the BuddyPress groups component is active
  if (bp_is_active('groups')) {
    // Groups submenu link
    $wp_admin_bar->add_menu([
      'parent'  => 'vikinger-profile',
      'id'      => 'vikinger-profile-groups',
      'title'   => _x('Groups', '(Admin Bar) Profile Groups Page Link', 'vikinger-buddypress-extension'),
      'href'    => trailingslashit($user_domain . 'groups')
    ]);
  }

  if (vikinger_buddypress_extension_settings_members_profile_page_is_enabled('posts')) {
    // Blog submenu link
    $wp_admin_bar->add_menu([
      'parent'  => 'vikinger-profile',
      'id'      => 'vikinger-profile-blog',
      'title'   => _x('Blog', '(Admin Bar) Profile Blog Page Link', 'vikinger-buddypress-extension'),
      'href'    => trailingslashit($user_domain . 'posts')
    ]);
  }

  // add vkmedia photos page navigation if plugin is active
  if (bp_is_active('activity') && function_exists('vkmedia_activate')) {
    if (vikinger_buddypress_extension_settings_media_file_upload_is_enabled('image')) {
      // Photos submenu link
      $wp_admin_bar->add_menu([
        'parent'  => 'vikinger-profile',
        'id'      => 'vikinger-profile-photos',
        'title'   => _x('Photos', '(Admin Bar) Profile Photos Page Link', 'vikinger-buddypress-extension'),
        'href'    => trailingslashit($user_domain . 'photos')
      ]);
    }

    if (vikinger_buddypress_extension_settings_media_file_upload_is_enabled('video')) {
      // Videos submenu link
      $wp_admin_bar->add_menu([
        'parent'  => 'vikinger-profile',
        'id'      => 'vikinger-profile-videos',
        'title'   => _x('Videos', '(Admin Bar) Profile Videos Page Link', 'vikinger-buddypress-extension'),
        'href'    => trailingslashit($user_domain . 'videos')
      ]);
    }
  }

  // if GamiPress plugin is active, add points, badges, quests and ranks page navigation
  if (function_exists('GamiPress')) {
    if (vikinger_buddypress_extension_settings_members_profile_page_is_enabled('credits')) {
      // Credits submenu link
      $wp_admin_bar->add_menu([
        'parent'  => 'vikinger-profile',
        'id'      => 'vikinger-profile-credits',
        'title'   => _x('Credits', '(Admin Bar) Profile Credits Page Link', 'vikinger-buddypress-extension'),
        'href'    => trailingslashit($user_domain . 'credits')
      ]);
    }

    if (vikinger_buddypress_extension_settings_members_profile_page_is_enabled('badges')) {
      // Badges submenu link
      $wp_admin_bar->add_menu([
        'parent'  => 'vikinger-profile',
        'id'      => 'vikinger-profile-badges',
        'title'   => _x('Badges', '(Admin Bar) Profile Badges Page Link', 'vikinger-buddypress-extension'),
        'href'    => trailingslashit($user_domain . 'badges')
      ]);
    }

    if (vikinger_buddypress_extension_settings_members_profile_page_is_enabled('quests')) {
      // Quests submenu link
      $wp_admin_bar->add_menu([
        'parent'  => 'vikinger-profile',
        'id'      => 'vikinger-profile-quests',
        'title'   => _x('Quests', '(Admin Bar) Profile Quests Page Link', 'vikinger-buddypress-extension'),
        'href'    => trailingslashit($user_domain . 'quests')
      ]);
    }

    if (vikinger_buddypress_extension_settings_members_profile_page_is_enabled('ranks')) {
      // Rank submenu link
      $wp_admin_bar->add_menu([
        'parent'  => 'vikinger-profile',
        'id'      => 'vikinger-profile-ranks',
        'title'   => _x('Rank', '(Admin Bar) Profile Ranks Page Link', 'vikinger-buddypress-extension'),
        'href'    => trailingslashit($user_domain . 'ranks')
      ]);
    }
  }

  // Settings menu link
  $wp_admin_bar->add_menu([
    'parent'  => 'my-account-buddypress',
    'id'      => 'vikinger-settings',
    'title'   => _x('Settings', '(Admin Bar) Settings Page Link', 'vikinger-buddypress-extension'),
    'href'    => trailingslashit($user_domain . 'settings')
  ]);

  // Settings menu link
  $wp_admin_bar->add_menu([
    'parent'  => 'vikinger-settings',
    'id'      => 'vikinger-settings-myprofile',
    'title'   => _x('Profile', '(Admin Bar) Profile Settings Page Link', 'vikinger-buddypress-extension'),
    'href'    => trailingslashit($user_domain . 'settings')
  ]);

  // Profile Info settings submenu link
  $wp_admin_bar->add_menu([
    'parent'  => 'vikinger-settings-myprofile',
    'id'      => 'vikinger-settings-profile-info',
    'title'   => _x('Profile Info', '(Admin Bar) Profile Info Settings Page Link', 'vikinger-buddypress-extension'),
    'href'    => trailingslashit($user_domain . 'settings')
  ]);

  // Social settings submenu link
  $wp_admin_bar->add_menu([
    'parent'  => 'vikinger-settings-myprofile',
    'id'      => 'vikinger-settings-social',
    'title'   => _x('Social', '(Admin Bar) Social Settings Page Link', 'vikinger-buddypress-extension'),
    'href'    => trailingslashit($user_domain . 'settings/social')
  ]);

  // Notifications settings submenu link
  $wp_admin_bar->add_menu([
    'parent'  => 'vikinger-settings-myprofile',
    'id'      => 'vikinger-settings-notifications',
    'title'   => _x('Notifications', '(Admin Bar) Notification Settings Page Link', 'vikinger-buddypress-extension'),
    'href'    => trailingslashit($user_domain . 'settings/notifications')
  ]);

  // Only add messages related menu items if the BuddyPress messages component is active
  if (bp_is_active('messages') && bp_is_active('friends')) {
    // Messages settings submenu link
    $wp_admin_bar->add_menu([
      'parent'  => 'vikinger-settings-myprofile',
      'id'      => 'vikinger-settings-messages',
      'title'   => _x('Messages', '(Admin Bar) Message Settings Page Link', 'vikinger-buddypress-extension'),
      'href'    => trailingslashit($user_domain . 'settings/messages')
    ]);
  }

  // Only add friends related menu items if the BuddyPress friends component is active
  if (bp_is_active('friends')) {
    // Friend Requests settings submenu link
    $wp_admin_bar->add_menu([
      'parent'  => 'vikinger-settings-myprofile',
      'id'      => 'vikinger-settings-friend-requests',
      'title'   => _x('Friend Requests', '(Admin Bar) Friend Requests Settings Page Link', 'vikinger-buddypress-extension'),
      'href'    => trailingslashit($user_domain . 'settings/friend-requests')
    ]);
  }

  // Settings menu link
  $wp_admin_bar->add_menu([
    'parent'  => 'vikinger-settings',
    'id'      => 'vikinger-settings-account',
    'title'   => _x('Account', '(Admin Bar) Account Settings Page Link', 'vikinger-buddypress-extension'),
    'href'    => trailingslashit($user_domain . 'settings/account')
  ]);

  // Settings menu link
  $wp_admin_bar->add_menu([
    'parent'  => 'vikinger-settings-account',
    'id'      => 'vikinger-settings-account-info',
    'title'   => _x('Account Info', '(Admin Bar) Account Info Settings Page Link', 'vikinger-buddypress-extension'),
    'href'    => trailingslashit($user_domain . 'settings/account')
  ]);

  // Settings menu link
  $wp_admin_bar->add_menu([
    'parent'  => 'vikinger-settings-account',
    'id'      => 'vikinger-settings-account-settings',
    'title'   => _x('Account Settings', '(Admin Bar) Account Settings Page Link', 'vikinger-buddypress-extension'),
    'href'    => trailingslashit($user_domain . 'settings/account-settings')
  ]);

  // Settings menu link
  $wp_admin_bar->add_menu([
    'parent'  => 'vikinger-settings-account',
    'id'      => 'vikinger-settings-account-password',
    'title'   => _x('Change Password', '(Admin Bar) Change Password Settings Page Link', 'vikinger-buddypress-extension'),
    'href'    => trailingslashit($user_domain . 'settings/password')
  ]);

  // Settings menu link
  $wp_admin_bar->add_menu([
    'parent'  => 'vikinger-settings-account',
    'id'      => 'vikinger-settings-account-email',
    'title'   => _x('Email Settings', '(Admin Bar) Email Settings Settings Page Link', 'vikinger-buddypress-extension'),
    'href'    => trailingslashit($user_domain . 'settings/email-settings')
  ]);

  // Only add groups related menu items if the BuddyPress groups component is active
  if (bp_is_active('groups')) {
    // Settings menu link
    $wp_admin_bar->add_menu([
      'parent'  => 'vikinger-settings',
      'id'      => 'vikinger-settings-groups',
      'title'   => _x('Groups', '(Admin Bar) Groups Settings Page Link', 'vikinger-buddypress-extension'),
      'href'    => trailingslashit($user_domain . 'settings/manage-groups')
    ]);

    // Settings menu link
    $wp_admin_bar->add_menu([
      'parent'  => 'vikinger-settings-groups',
      'id'      => 'vikinger-settings-manage-groups',
      'title'   => _x('Manage Groups', '(Admin Bar) Manage Groups Settings Page Link', 'vikinger-buddypress-extension'),
      'href'    => trailingslashit($user_domain . 'settings/manage-groups')
    ]);

    // Settings menu link
    $wp_admin_bar->add_menu([
      'parent'  => 'vikinger-settings-groups',
      'id'      => 'vikinger-settings-send-group-invitations',
      'title'   => _x('Send Group Invitations', '(Admin Bar) Send Group Invitations Settings Page Link', 'vikinger-buddypress-extension'),
      'href'    => trailingslashit($user_domain . 'settings/send-group-invitations')
    ]);

    // Settings menu link
    $wp_admin_bar->add_menu([
      'parent'  => 'vikinger-settings-groups',
      'id'      => 'vikinger-settings-received-group-invitations',
      'title'   => _x('Received Group Invitations', '(Admin Bar) Received Group Invitations Settings Page Link', 'vikinger-buddypress-extension'),
      'href'    => trailingslashit($user_domain . 'settings/received-group-invitations')
    ]);

    // Settings menu link
    $wp_admin_bar->add_menu([
      'parent'  => 'vikinger-settings-groups',
      'id'      => 'vikinger-settings-membership-requests',
      'title'   => _x('Membership Requests', '(Admin Bar) Membership Requests Settings Page Link', 'vikinger-buddypress-extension'),
      'href'    => trailingslashit($user_domain . 'settings/membership-requests')
    ]);
  }
}

add_action('bp_setup_admin_bar', 'vikinger_buddypress_extension_admin_bar_add_routes', 300);

/**
 * Remove admin bar unused routes
 */
function vikinger_buddypress_extension_admin_bar_remove_unused_routes() {
  global $wp_admin_bar;

  // remove bp notifications
  $wp_admin_bar->remove_menu('bp-notifications');

  // remove activity
  $wp_admin_bar->remove_menu('my-account-activity');

  // remove profile
  $wp_admin_bar->remove_menu('my-account-xprofile');

  // remove notifications
  $wp_admin_bar->remove_menu('my-account-notifications');

  // remove messages
  $wp_admin_bar->remove_menu('my-account-messages');

  // remove friends
  $wp_admin_bar->remove_menu('my-account-friends');

  // remove groups
  $wp_admin_bar->remove_menu('my-account-groups');

  // remove settings
  $wp_admin_bar->remove_menu('my-account-settings');
}

add_action('admin_bar_menu', 'vikinger_buddypress_extension_admin_bar_remove_unused_routes', 300);

/**
 * Only define extension if the buddypress groups component is active
 */
if (bp_is_active('groups') && function_exists('vkmedia_activate')) {
  if (vikinger_buddypress_extension_settings_media_file_upload_is_enabled('image')) {
    /**
     * Group Photos Page
     */
    class Vikinger_Group_Photos_Extension extends BP_Group_Extension {
      /**
       * Your __construct() method will contain configuration options for 
       * your extension, and will pass them to parent::init()
       */
      function __construct() {
        $args = [
          'slug' => 'photos',
          'name' => 'Photos'
        ];

        parent::init( $args );
      }
  
      /**
       * display() contains the markup that will be displayed on the main 
       * plugin tab
       */
      function display($group_id = NULL) {
        $group_id = bp_get_group_id();

      ?>
        <div id="activity-photo-list" data-groupid=<?php echo esc_attr($group_id); ?>></div>
      <?php
      }
    }

    bp_register_group_extension('Vikinger_Group_Photos_Extension');
  }

  if (vikinger_buddypress_extension_settings_media_file_upload_is_enabled('video')) {
    /**
     * Group Videos Page
     */
    class Vikinger_Group_Videos_Extension extends BP_Group_Extension {
      /**
       * Your __construct() method will contain configuration options for 
       * your extension, and will pass them to parent::init()
       */
      function __construct() {
        $args = [
          'slug' => 'videos',
          'name' => 'Videos'
        ];

        parent::init( $args );
      }
  
      /**
       * display() contains the markup that will be displayed on the main 
       * plugin tab
       */
      function display($group_id = NULL) {
        $group_id = bp_get_group_id();

      ?>
        <div id="activity-video-list" data-groupid=<?php echo esc_attr($group_id); ?>></div>
      <?php
      }
    }

    bp_register_group_extension('Vikinger_Group_Videos_Extension');
  }
}

?>