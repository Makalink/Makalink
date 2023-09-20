<?php
/**
 * Functions - Utils
 * 
 * @package Vikinger
 * 
 * @since 1.0.0
 * 
 * @author Odin Design Themes (https://odindesignthemes.com/)
 * 
 */

if (!function_exists('vikinger_truncate_text')) {
  /**
   * Truncates text with given length and adds a line finisher
   * 
   * @param string  $text                 Text to truncate.
   * @param int     $word_limit           Maximum text length.
   * @param string  $more_text            Line finisher.
   * @return string $truncated_text       Truncated text.
   */
  function vikinger_truncate_text($text, $word_limit = 40, $more_text = '&hellip;') {
    $truncated_text = $text;

    if (strlen($text) > $word_limit) {
      $truncated_text = trim(substr($text, 0, $word_limit - 1));
      $truncated_text .= $more_text;
    }

    return $truncated_text;
  }
}

if (!function_exists('vikinger_join_text')) {
  /**
   * Replaces text white spaces with a separator
   * 
   * @param string  $text           Text to replace white spaces with a separator.
   * @param string  $separator      Optiona. Separator to use. Default: '-'
   */
  function vikinger_join_text($text, $separator = '-') {
    $joined_text = preg_replace('/\s+/', $separator, $text);

    return $joined_text;
  }
}

if (!function_exists('vikinger_menu_get_items')) {
  /**
   * Returns menu items
   * 
   * @param string $menu_location       Menu location.
   * @return array 
   */
  function vikinger_menu_get_items($menu_location, $args = []) {
    $menu_items = [
      'flat'      => [],
      'threaded'  => []
    ];

    $menu_id = false;

    if (!is_int($menu_location)) {
      $menu_locations = get_nav_menu_locations();

      if (array_key_exists($menu_location, $menu_locations)) {
        $menu_id = $menu_locations[$menu_location];
      }
    } else {
      $menu_id = $menu_location;
    }

    // if menu location exists, fill menu items
    if ($menu_id) {
      $nav_menu_object = wp_get_nav_menu_object($menu_id);
      $nav_items = wp_get_nav_menu_items($menu_id, $args);

      // get current page ID, or front page ID if current page is front page
      $current_post_id = get_queried_object_id();

      // if BuddyPress plugin is active and a BuddyPress page is front page, get page on front id
      if (vikinger_plugin_buddypress_is_active() && bp_is_component_front_page()) {
        $current_post_id = get_option('page_on_front');
      }

      // if user assigned a menu to this location
      if ($nav_items) {
        global $wp;

        $current_page_url = trailingslashit(home_url($wp->request));

        foreach ($nav_items as $nav_item) {
          $menu_icon = (count($nav_item->classes) > 0) && ($nav_item->classes[0] !== '') ? $nav_item->classes[0] : 'link';

          $menu_parent = (int) $nav_item->menu_item_parent;

          $menu_item_data = [
            'id'        => $nav_item->ID,
            'name'      => $nav_item->title,
            'link'      => $nav_item->url,
            'icon'      => $menu_icon,
            'active'    => $current_page_url === trailingslashit($nav_item->url),
            'parent_id' => $menu_parent,
            'parent'    => $nav_item->post_excerpt,
            'menu_name' => $nav_menu_object->name,
            'target'    => $nav_item->target,
            'children'  => []
          ];

          // add menu item to flat array
          $menu_items['flat'][] = $menu_item_data;

          // put menu in children on threaded array if there is a parent item
          if (($menu_parent !== 0)) {
            vikinger_menu_add_children($menu_item_data, $menu_items['threaded']);
          } else {
            $menu_items['threaded'][] = $menu_item_data;
          }
        }
      }
    }

    return $menu_items;
  }
}

if (!function_exists('vikinger_menu_add_children')) {
  /**
   * Recursively add children to menu items
   */
  function vikinger_menu_add_children($menu_item_child, &$menu_items) {
    for ($i = 0; $i < count($menu_items); $i++) {
      if ($menu_items[$i]['id'] === $menu_item_child['parent_id']) {
        $menu_items[$i]['children'][] = $menu_item_child;
        return;
      }

      // iterate over children if they exist
      if (count($menu_items[$i]['children']) > 0) {
        vikinger_menu_add_children($menu_item_child, $menu_items[$i]['children']);
      }
    }
  }
}

if (!function_exists('vikinger_menu_group_by_parent')) {
  /**
   * Groups menu items by parent
   */
  function vikinger_menu_group_by_parent($menu_items) {
    $grouped_menu_items = [];

    foreach ($menu_items as $menu_item) {
      if (!array_key_exists($menu_item['parent'], $grouped_menu_items)) {
        $grouped_menu_items[$menu_item['parent']] = [];
      }
      
      $grouped_menu_items[$menu_item['parent']][] = $menu_item;
    }

    return $grouped_menu_items;
  }
}

if (!function_exists('vikinger_get_random_items_from')) {
  /**
   * Get random items from an array
   * 
   * @param array $array      The array to get random items from
   * @param int   $max        The number of random items to get
   * @return array
   */
  function vikinger_get_random_items_from($array, $max = false) {
    $total_count = count($array);
    $show_max = $max ? $max : $total_count;
    $show_count = min($show_max, $total_count);

    $indexes_to_show = [];

    // get $show_count different random indexes to get random items from
    while (count($indexes_to_show) < $show_count) {
      $index = rand(0, $total_count - 1);

      // if index not already in array
      if (!in_array($index, $indexes_to_show)) {
        $indexes_to_show[] = $index;
      }
    }

    $random_items = [];

    foreach ($indexes_to_show as $index) {
      $random_items[] = $array[$index];
    }

    return $random_items;
  }
}

if (!function_exists('vikinger_wp_kses_post_title_get_allowed_tags')) {
  /**
   * Returns wp_kses allowed tags for post title
   * 
   * @return array $allowed_tags        HTML tags allowed
   */
  function vikinger_wp_kses_post_title_get_allowed_tags() {
    $allowed_tags = [
      'strong'  => [],
      'em'      => [],
      'b'       => [],
      'sup'     => []
    ];
    
    return $allowed_tags;
  }
}

if (!function_exists('vikinger_wp_kses_post_excerpt_get_allowed_tags')) {
  /**
   * Returns wp_kses allowed tags for post excerpt
   * 
   * @return array $allowed_tags        HTML tags allowed
   */
  function vikinger_wp_kses_post_excerpt_get_allowed_tags() {
    $allowed_tags = [
      'strong'  => [],
      'em'      => [],
      'b'       => [],
      'sup'     => []
    ];
    
    return $allowed_tags;
  }
}

if (!function_exists('vikinger_reactions_insert_user_data')) {
  /**
   * Inserts user data into reactions
   * 
   * @param array   $reactions_data             Reactions data, each with an array of user ids
   * @return array  $reactions_data_with_users  Reactions data with user data inserted
   */
  function vikinger_reactions_insert_user_data($reactions_data) {
    $reactions_data_with_users = [];

    foreach ($reactions_data as $reaction_data) {
      $reaction_data_cp = (array) $reaction_data;
      $reaction_data_cp['users'] = [];

      foreach ($reaction_data->users as $user_id) {
        // add BuddyPress member data if plugin is active
        if (vikinger_plugin_buddypress_is_active()) {
          $reaction_data_cp['users'][] = vikinger_members_get_fallback($user_id);
        } else {
          $reaction_data_cp['users'][] = vikinger_user_get_data($user_id);
        }
      }

      $reactions_data_with_users[] = $reaction_data_cp;
    }

    return $reactions_data_with_users;
  }
}

if (!function_exists('vikinger_site_url_get')) {
  /**
   * Returns site url with appended path
   * 
   * @param string $path      Path to append. Optional.
   */
  function vikinger_site_url_get($path = '') {
    return get_site_url(null, $path);
  }
}

if (!function_exists('vikinger_page_current_url_get')) {
  /**
   * Returns current page url.
   * 
   * @since 1.9.8.1
   * 
   * @return string $current_page_url      Current page URL.
   */
  function vikinger_page_current_url_get() {
    global $wp;

    $current_page_url = home_url($wp->request);

    return $current_page_url;
  }
}

if (!function_exists('vikinger_login_page_redirect_url_get')) {
  /**
   * Returns URL of page to redirect to after login.
   * 
   * @since 1.9.8.1
   * 
   * @return string $login_page_redirect_url      URL of page to redirect to after login.
   */
  function vikinger_login_page_redirect_url_get() {
    $login_page_redirect_url = vikinger_page_current_url_get();

    /**
     * Filters login page redirect URL.
     * 
     * @since 1.9.8.1
     * 
     * @param string $login_page_redirect_url
     */
    $login_page_redirect_url = apply_filters('vikinger_login_page_redirect_url', $login_page_redirect_url);

    return $login_page_redirect_url;
  }
}

if (!function_exists('vikinger_logout_page_redirect_url_get')) {
  /**
   * Returns URL of page to redirect to after logout.
   * 
   * @since 1.9.8.1
   * 
   * @return string $logout_page_redirect_url      URL of page to redirect to after logout.
   */
  function vikinger_logout_page_redirect_url_get() {
    $logout_page_redirect_url = vikinger_page_current_url_get();

    /**
     * Filters logout page redirect URL.
     * 
     * @since 1.9.8.1
     * 
     * @param string $logout_page_redirect_url
     */
    $logout_page_redirect_url = apply_filters('vikinger_logout_page_redirect_url', $logout_page_redirect_url);

    return $logout_page_redirect_url;
  }
}

if (!function_exists('vikinger_login_page_url_get')) {
  /**
   * Returns login page URL.
   * 
   * @since 1.9.8.1
   * 
   * @return string $login_page_url      Login page URL.
   */
  function vikinger_login_page_url_get() {
    $login_page_url = wp_login_url(vikinger_login_page_redirect_url_get());

    return $login_page_url;
  }
}

if (!function_exists('vikinger_logout_page_url_get')) {
  /**
   * Returns logout page URL.
   * 
   * @since 1.9.8.1
   * 
   * @return string $logout_page_url      Logout page URL.
   */
  function vikinger_logout_page_url_get() {
    $logout_page_url = wp_logout_url(vikinger_logout_page_redirect_url_get());

    return $logout_page_url;
  }
}

?>