<?php
/**
 * Functions - Backend - Utils
 * 
 * @package Vikinger
 * 
 * @since 1.9.8
 * 
 * @author Odin Design Themes (https://odindesignthemes.com/)
 * 
 */

if (!function_exists('vikinger_backend_theme_hooks_data_get')) {
  /**
   * Returns theme hooks data.
   * 
   * @since 1.0.0
   * 
   * @return array $hooks_data       Hooks data.
   */
  function vikinger_backend_theme_hooks_data_get() {
    $vikinger_functions_path = 'includes/functions/';

    $vikinger_buddypress_functions_path = $vikinger_functions_path . 'buddypress/';
    $vikinger_buddypress_member_functions_path = $vikinger_buddypress_functions_path . 'member/';
    $vikinger_buddypress_group_functions_path = $vikinger_buddypress_functions_path . 'group/';
    $vikinger_buddypress_activity_functions_path = $vikinger_buddypress_functions_path . 'activity/';
    $vikinger_buddypress_message_functions_path = $vikinger_buddypress_functions_path;
    $vikinger_buddypress_notification_functions_path = $vikinger_buddypress_functions_path;
    $vikinger_buddypress_stream_functions_path = $vikinger_functions_path;

    $vikinger_gamipress_functions_path = $vikinger_functions_path . 'gamipress/';

    $hooks_data = [
      [
        'title'       => esc_html_x('Filters', '(Backend)', 'vikinger'),
        'description' => esc_html_x('Filters provide a way for functions to modify data and are meant to work in an isolated manner, they should never have side    effects such as affecting global variables and output. Filters expect to have something returned back to them.', '(Backend)', 'vikinger'),
        'items'       => [
          [
            'title'       => esc_html_x('WordPress', '(Backend)', 'vikinger'),
            'description' => esc_html_x('The filters listed below are not plugin specific and always available for use.', '(Backend)', 'vikinger'),
            'items'       => [
              [
                'title'       => esc_html_x('Blog', '(Backend)', 'vikinger'),
                'description' => esc_html_x('The filters listed below are related to the site blog.', '(Backend)', 'vikinger'),
                'items'       => [
                  [
                    'name'        => 'vikinger_posts_get_args',
                    'args'        => [
                      [
                        'name'        => '$args',
                        'type'        => 'array',
                        'description' => esc_html_x('Arguments used to get posts.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$args',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters arguments used to get posts.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_functions_path,
                      'filename'  => 'vikinger-functions-blog.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_posts_get_data',
                    'args'        => [
                      [
                        'name'        => '$post',
                        'type'        => 'array',
                        'description' => esc_html_x('Post data.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$post',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters post data.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_functions_path,
                      'filename'  => 'vikinger-functions-blog.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_posts_get_results',
                    'args'        => [
                      [
                        'name'        => '$posts',
                        'type'        => 'array',
                        'description' => esc_html_x('Post results.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$posts',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters post results.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_functions_path,
                      'filename'  => 'vikinger-functions-blog.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_posts_get_count_args',
                    'args'        => [
                      [
                        'name'        => '$args',
                        'type'        => 'array',
                        'description' => esc_html_x('Arguments used to get post count.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$args',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters arguments used to get post count.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_functions_path,
                      'filename'  => 'vikinger-functions-blog.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_posts_get_sticky_posts_args',
                    'args'        => [
                      [
                        'name'        => '$sticky_post_args',
                        'type'        => 'array',
                        'description' => esc_html_x('Arguments used to get sticky posts.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$sticky_post_args',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters arguments used to get sticky posts.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_functions_path,
                      'filename'  => 'vikinger-functions-blog.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_posts_get_sticky_posts_results',
                    'args'        => [
                      [
                        'name'        => '$sticky_posts',
                        'type'        => 'array',
                        'description' => esc_html_x('Sticky post results.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$sticky_posts',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters sticky post results.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_functions_path,
                      'filename'  => 'vikinger-functions-blog.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_pages_get_args',
                    'args'        => [
                      [
                        'name'        => '$args',
                        'type'        => 'array',
                        'description' => esc_html_x('Arguments used to get pages.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$args',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters arguments used to get pages.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_functions_path,
                      'filename'  => 'vikinger-functions-blog.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_pages_get_data',
                    'args'        => [
                      [
                        'name'        => '$page',
                        'type'        => 'array',
                        'description' => esc_html_x('Page data.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$page',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters page data.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_functions_path,
                      'filename'  => 'vikinger-functions-blog.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_pages_get_results',
                    'args'        => [
                      [
                        'name'        => '$pages',
                        'type'        => 'array',
                        'description' => esc_html_x('Page results.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$pages',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters page results.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_functions_path,
                      'filename'  => 'vikinger-functions-blog.php',
                      'since'     => '1.9.1'
                    ]
                  ]
                ]
              ],
              [
                'title'       => esc_html_x('Comments', '(Backend)', 'vikinger'),
                'description' => esc_html_x('The filters listed below are related to the site blog comments.', '(Backend)', 'vikinger'),
                'items'       => [
                  [
                    'name'        => 'vikinger_comments_get_args',
                    'args'        => [
                      [
                        'name'        => '$args',
                        'type'        => 'array',
                        'description' => esc_html_x('Arguments used to get comments.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$args',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters arguments used to get comments.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_functions_path,
                      'filename'  => 'vikinger-functions-comment.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_comments_get_data',
                    'args'        => [
                      [
                        'name'        => '$com',
                        'type'        => 'array',
                        'description' => esc_html_x('Comment data.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$com',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters post data.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_functions_path,
                      'filename'  => 'vikinger-functions-comment.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_comments_get_results',
                    'args'        => [
                      [
                        'name'        => '$comments',
                        'type'        => 'array',
                        'description' => esc_html_x('Comment results.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$comments',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters comment results.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_functions_path,
                      'filename'  => 'vikinger-functions-comment.php',
                      'since'     => '1.9.1'
                    ]
                  ]
                ]
              ],
              [
                'title'       => esc_html_x('User', '(Backend)', 'vikinger'),
                'description' => esc_html_x('The filters listed below are related to the site users.', '(Backend)', 'vikinger'),
                'items'       => [
                  [
                    'name'        => 'vikinger_users_grid_type_default',
                    'args'        => [
                      [
                        'name'        => '$default_grid_type',
                        'type'        => 'string',
                        'description' => esc_html_x('Default lists grid type. One of: "big", "small", "list".', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$default_grid_type',
                      'type'  => 'string'
                    ],
                    'description' => esc_html_x('Filters user default lists grid type.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_functions_path,
                      'filename'  => 'vikinger-functions-user.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_users_sidemenu_status_default',
                    'args'        => [
                      [
                        'name'        => '$default_sidemenu_status',
                        'type'        => 'string',
                        'description' => esc_html_x('Default sidemenu status. One of: "open", "closed".', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$default_sidemenu_status',
                      'type'  => 'string'
                    ],
                    'description' => esc_html_x('Filters user default sidemenu status.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_functions_path,
                      'filename'  => 'vikinger-functions-user.php',
                      'since'     => '1.9.1'
                    ]
                  ]
                ]
              ]
            ]
          ],
          [
            'title'       => esc_html_x('BuddyPress', '(Backend)', 'vikinger'),
            'description' => esc_html_x('The filters listed below require the "BuddyPress" plugin to be installed and active as well as the respective component to be active in order to work.', '(Backend)', 'vikinger'),
            'items'       => [
              [
                'title'       => esc_html_x('Members', '(Backend)', 'vikinger'),
                'description' => esc_html_x('The filters listed below are related to the BuddyPress members component.', '(Backend)', 'vikinger'),
                'items'       => [
                  [
                    'name'        => 'vikinger_members_get_args',
                    'args'        => [
                      [
                        'name'        => '$args',
                        'type'        => 'array',
                        'description' => esc_html_x('Arguments used to get members.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$args',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters arguments used to get members.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_buddypress_member_functions_path,
                      'filename'  => 'vikinger-functions-buddypress-member-global.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_members_get_data',
                    'args'        => [
                      [
                        'name'        => '$member_data',
                        'type'        => 'array',
                        'description' => esc_html_x('Member data.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$member_data',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters member data.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_buddypress_member_functions_path,
                      'filename'  => 'vikinger-functions-buddypress-member-global.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_members_get_results',
                    'args'        => [
                      [
                        'name'        => '$members',
                        'type'        => 'array',
                        'description' => esc_html_x('Member results.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$members',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters member results.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_buddypress_member_functions_path,
                      'filename'  => 'vikinger-functions-buddypress-member-global.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_members_get_count_args',
                    'args'        => [
                      [
                        'name'        => '$args',
                        'type'        => 'array',
                        'description' => esc_html_x('Arguments used to get member count.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$args',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters arguments used to get member count.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_buddypress_member_functions_path,
                      'filename'  => 'vikinger-functions-buddypress-member-global.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_members_get_post_count_activity_components',
                    'args'        => [
                      [
                        'name'        => '$activity_components',
                        'type'        => 'array',
                        'description' => esc_html_x('Activity components used to compute members post count.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$activity_components',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters components that an activity has to belong to in order for it to count towards member post count.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_buddypress_member_functions_path,
                      'filename'  => 'vikinger-functions-buddypress-member-global.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_members_get_post_count_activity_types',
                    'args'        => [
                      [
                        'name'        => '$activity_types',
                        'type'        => 'array',
                        'description' => esc_html_x('Activity types used to compute members post count.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$activity_types',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters types that an activity has to belong to in order for it to count towards member post count.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_buddypress_member_functions_path,
                      'filename'  => 'vikinger-functions-buddypress-member-global.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_members_get_comment_count_activity_components',
                    'args'        => [
                      [
                        'name'        => '$activity_components',
                        'type'        => 'array',
                        'description' => esc_html_x('Activity components used to compute members comment count.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$activity_components',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters components that an activity has to belong to in order for it to count towards member comment count.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_buddypress_member_functions_path,
                      'filename'  => 'vikinger-functions-buddypress-member-global.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_members_get_comment_count_activity_types',
                    'args'        => [
                      [
                        'name'        => '$activity_types',
                        'type'        => 'array',
                        'description' => esc_html_x('Activity types used to compute members comment count.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$activity_types',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters types that an activity has to belong to in order for it to count towards member comment count.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_buddypress_member_functions_path,
                      'filename'  => 'vikinger-functions-buddypress-member-global.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_members_profile_navigation_items',
                    'args'        => [
                      [
                        'name'        => '$nav_items',
                        'type'        => 'array',
                        'description' => esc_html_x('Member profile navigation items.', '(Backend)', 'vikinger')
                      ],
                      [
                        'name'        => '$member',
                        'type'        => 'array',
                        'description' => esc_html_x('Member data.', '(Backend)', 'vikinger')
                      ],
                      [
                        'name'        => '$activity_single',
                        'type'        => 'bool',
                        'description' => esc_html_x('True if displaying a single activity in the feed, false otherwise.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$nav_items',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters member profile navigation items.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_buddypress_member_functions_path,
                      'filename'  => 'vikinger-functions-buddypress-member-global.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_members_profile_navigation_items_default_position',
                    'args'        => [
                      [
                        'name'        => '$default_position',
                        'type'        => 'int',
                        'description' => esc_html_x('Navigation item default position.', '(Backend)', 'vikinger')
                      ],
                      [
                        'name'        => '$slug',
                        'type'        => 'string',
                        'description' => esc_html_x('Navigation item slug.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$default_position',
                      'type'  => 'int'
                    ],
                    'description' => esc_html_x('Filters member profile navigation item default position.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_buddypress_member_functions_path,
                      'filename'  => 'vikinger-functions-buddypress-member-global.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_members_profile_navigation_subitems',
                    'args'        => [
                      [
                        'name'        => '$member_navigation_subitems',
                        'type'        => 'array',
                        'description' => esc_html_x('Member profile navigation subitems.', '(Backend)', 'vikinger')
                      ],
                      [
                        'name'        => '$member',
                        'type'        => 'array',
                        'description' => esc_html_x('Member data.', '(Backend)', 'vikinger')
                      ],
                      [
                        'name'        => '$slug',
                        'type'        => 'string',
                        'description' => esc_html_x('Parent menu item slug.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$member_navigation_subitems',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters member profile navigation subitems.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_buddypress_member_functions_path,
                      'filename'  => 'vikinger-functions-buddypress-member-global.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_members_accounthub_navigation_sections',
                    'args'        => [
                      [
                        'name'        => '$menu_sections',
                        'type'        => 'array',
                        'description' => esc_html_x('Member account hub navigation sections.', '(Backend)', 'vikinger')
                      ],
                      [
                        'name'        => '$member',
                        'type'        => 'array',
                        'description' => esc_html_x('Member data.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$menu_sections',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters member account hub navigation sections.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_buddypress_member_functions_path,
                      'filename'  => 'vikinger-functions-buddypress-member-global.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_members_xprofile_valid_social_networks',
                    'args'        => [
                      [
                        'name'        => '$valid_social_networks',
                        'type'        => 'array',
                        'description' => esc_html_x('Member xprofile valid social networks.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$valid_social_networks',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters member xprofile valid social networks, which are used to select respective SVG icons.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_buddypress_member_functions_path,
                      'filename'  => 'vikinger-functions-buddypress-member-global.php',
                      'since'     => '1.9.1'
                    ]
                  ]
                ]
              ],
              [
                'title'       => esc_html_x('Groups', '(Backend)', 'vikinger'),
                'description' => esc_html_x('The filters listed below are related to the BuddyPress groups component.', '(Backend)', 'vikinger'),
                'items'       => [
                  [
                    'name'        => 'vikinger_groups_get_args',
                    'args'        => [
                      [
                        'name'        => '$args',
                        'type'        => 'array',
                        'description' => esc_html_x('Arguments used to get groups.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$args',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters arguments used to get groups.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_buddypress_group_functions_path,
                      'filename'  => 'vikinger-functions-buddypress-group-global.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_groups_get_data',
                    'args'        => [
                      [
                        'name'        => '$group_data',
                        'type'        => 'array',
                        'description' => esc_html_x('Group data.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$group_data',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters group data.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_buddypress_group_functions_path,
                      'filename'  => 'vikinger-functions-buddypress-group-global.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_groups_get_results',
                    'args'        => [
                      [
                        'name'        => '$groups',
                        'type'        => 'array',
                        'description' => esc_html_x('Group results.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$groups',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters group results.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_buddypress_group_functions_path,
                      'filename'  => 'vikinger-functions-buddypress-group-global.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_groups_get_count_args',
                    'args'        => [
                      [
                        'name'        => '$args',
                        'type'        => 'array',
                        'description' => esc_html_x('Arguments used to get group count.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$args',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters arguments used to get group count.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_buddypress_group_functions_path,
                      'filename'  => 'vikinger-functions-buddypress-group-global.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_groups_get_members_args',
                    'args'        => [
                      [
                        'name'        => '$args',
                        'type'        => 'array',
                        'description' => esc_html_x('Arguments used to get group members.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$args',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters arguments used to get group members.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_buddypress_group_functions_path,
                      'filename'  => 'vikinger-functions-buddypress-group-global.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_groups_get_members_results',
                    'args'        => [
                      [
                        'name'        => '$group_members',
                        'type'        => 'array',
                        'description' => esc_html_x('Group member results.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$group_members',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters group member results.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_buddypress_group_functions_path,
                      'filename'  => 'vikinger-functions-buddypress-group-global.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_groups_get_members_count_args',
                    'args'        => [
                      [
                        'name'        => '$args',
                        'type'        => 'array',
                        'description' => esc_html_x('Arguments used to get group member count.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$args',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters arguments used to get group member count.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_buddypress_group_functions_path,
                      'filename'  => 'vikinger-functions-buddypress-group-global.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_groups_get_post_count_activity_components',
                    'args'        => [
                      [
                        'name'        => '$activity_components',
                        'type'        => 'array',
                        'description' => esc_html_x('Activity components used to compute groups post count.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$activity_components',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters components that an activity has to belong to in order for it to count towards group post count.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_buddypress_group_functions_path,
                      'filename'  => 'vikinger-functions-buddypress-group-global.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_groups_get_post_count_activity_types',
                    'args'        => [
                      [
                        'name'        => '$activity_types',
                        'type'        => 'array',
                        'description' => esc_html_x('Activity types used to compute groups post count.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$activity_types',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters types that an activity has to belong to in order for it to count towards group post count.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_buddypress_group_functions_path,
                      'filename'  => 'vikinger-functions-buddypress-group-global.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_groups_profile_navigation_items',
                    'args'        => [
                      [
                        'name'        => '$nav_items',
                        'type'        => 'array',
                        'description' => esc_html_x('Group profile navigation items.', '(Backend)', 'vikinger')
                      ],
                      [
                        'name'        => '$group',
                        'type'        => 'array',
                        'description' => esc_html_x('Group data.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$nav_items',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters group profile navigation items.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_buddypress_group_functions_path,
                      'filename'  => 'vikinger-functions-buddypress-group-global.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_groups_meta_valid_social_networks',
                    'args'        => [
                      [
                        'name'        => '$social_links_keys',
                        'type'        => 'array',
                        'description' => esc_html_x('Group meta valid social networks.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$social_links_keys',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters group meta valid social networks, which are used to select respective SVG icons.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_buddypress_group_functions_path,
                      'filename'  => 'vikinger-functions-buddypress-group-global.php',
                      'since'     => '1.9.1'
                    ]
                  ]
                ]
              ],
              [
                'title'       => esc_html_x('Activities', '(Backend)', 'vikinger'),
                'description' => esc_html_x('The filters listed below are related to the BuddyPress activities component.', '(Backend)', 'vikinger'),
                'items'       => [
                  [
                    'name'        => 'vikinger_activities_get_args',
                    'args'        => [
                      [
                        'name'        => '$activities_args',
                        'type'        => 'array',
                        'description' => esc_html_x('Arguments used to get activities.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$activities_args',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters arguments used to get activities.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_buddypress_activity_functions_path,
                      'filename'  => 'vikinger-functions-buddypress-activity-global.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_activities_get_data',
                    'args'        => [
                      [
                        'name'        => '$activity_data',
                        'type'        => 'array',
                        'description' => esc_html_x('Activity data.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$activity_data',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters activity data.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_buddypress_activity_functions_path,
                      'filename'  => 'vikinger-functions-buddypress-activity-global.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_activities_get_results',
                    'args'        => [
                      [
                        'name'        => '$activities',
                        'type'        => 'array',
                        'description' => esc_html_x('Activity results.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$activities',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters activity results.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_buddypress_activity_functions_path,
                      'filename'  => 'vikinger-functions-buddypress-activity-global.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_activities_get_count_args',
                    'args'        => [
                      [
                        'name'        => '$args',
                        'type'        => 'array',
                        'description' => esc_html_x('Arguments used to get activity count.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$args',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters arguments used to get activity count.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_buddypress_activity_functions_path,
                      'filename'  => 'vikinger-functions-buddypress-activity-global.php',
                      'since'     => '1.9.1'
                    ]
                  ]
                ]
              ],
              [
                'title'       => esc_html_x('Messages', '(Backend)', 'vikinger'),
                'description' => esc_html_x('The filters listed below are related to the BuddyPress messages component.', '(Backend)', 'vikinger'),
                'items'       => [
                  [
                    'name'        => 'vikinger_messages_get_args',
                    'args'        => [
                      [
                        'name'        => '$args',
                        'type'        => 'array',
                        'description' => esc_html_x('Arguments used to get messages.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$args',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters arguments used to get messages.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_buddypress_message_functions_path,
                      'filename'  => 'vikinger-functions-buddypress-message.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_messages_get_data',
                    'args'        => [
                      [
                        'name'        => '$message_data',
                        'type'        => 'array',
                        'description' => esc_html_x('Message data.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$message_data',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters message data.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_buddypress_message_functions_path,
                      'filename'  => 'vikinger-functions-buddypress-message.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_messages_get_results',
                    'args'        => [
                      [
                        'name'        => '$message_results',
                        'type'        => 'array',
                        'description' => esc_html_x('Message results.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$message_results',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters message results.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_buddypress_message_functions_path,
                      'filename'  => 'vikinger-functions-buddypress-message.php',
                      'since'     => '1.9.1'
                    ]
                  ]
                ]
              ],
              [
                'title'       => esc_html_x('Notifications', '(Backend)', 'vikinger'),
                'description' => esc_html_x('The filters listed below are related to the BuddyPress notifications component.', '(Backend)', 'vikinger'),
                'items'       => [
                  [
                    'name'        => 'vikinger_notifications_get_args',
                    'args'        => [
                      [
                        'name'        => '$args',
                        'type'        => 'array',
                        'description' => esc_html_x('Arguments used to get notifications.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$args',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters arguments used to get notifications.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_buddypress_notification_functions_path,
                      'filename'  => 'vikinger-functions-buddypress-notification.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_notifications_get_data',
                    'args'        => [
                      [
                        'name'        => '$notification',
                        'type'        => 'array',
                        'description' => esc_html_x('Notification data.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$notification',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters notification data.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_buddypress_notification_functions_path,
                      'filename'  => 'vikinger-functions-buddypress-notification.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_notifications_get_results',
                    'args'        => [
                      [
                        'name'        => '$notifications',
                        'type'        => 'array',
                        'description' => esc_html_x('Notification results.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$notifications',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters notification results.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_buddypress_notification_functions_path,
                      'filename'  => 'vikinger-functions-buddypress-notification.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                ]
              ],
              [
                'title'       => esc_html_x('Stream', '(Backend)', 'vikinger'),
                'description' => esc_html_x('The filters listed below are related to the stream functionality.', '(Backend)', 'vikinger'),
                'items'       => [
                  [
                    'name'        => 'vikinger_streams_twitch_embed_iframe_src',
                    'args'        => [
                      [
                        'name'        => '$iframe_src',
                        'type'        => 'string',
                        'description' => esc_html_x('Stream embeds iframe source attribute.', '(Backend)', 'vikinger')
                      ],
                      [
                        'name'        => '$username',
                        'type'        => 'string',
                        'description' => esc_html_x('Streamer username.', '(Backend)', 'vikinger')
                      ],
                      [
                        'name'        => '$stream_parent',
                        'type'        => 'string',
                        'description' => esc_html_x('Stream embeds parent attribute.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$iframe_src',
                      'type'  => 'string'
                    ],
                    'description' => esc_html_x('Filters stream embeds iframe source attribute.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_buddypress_stream_functions_path,
                      'filename'  => 'vikinger-functions-stream.php',
                      'since'     => '1.9.1'
                    ]
                  ]
                ]
              ]
            ]
          ],
          [
            'title'       => esc_html_x('Vikinger Media', '(Backend)', 'vikinger'),
            'description' => esc_html_x('The filters listed below require the "Vikinger Media" plugin to be installed and active in order to work.', '(Backend)', 'vikinger'),
            'items'       => [
              [
                'title'       => esc_html_x('File', '(Backend)', 'vikinger'),
                'description' => esc_html_x('The filters listed below are related to file operations.', '(Backend)', 'vikinger'),
                'items'       => [
                  [
                    'name'        => 'vikinger_file_default_allowed_extensions',
                    'args'        => [
                      [
                        'name'        => '$allowed_file_extensions',
                        'type'        => 'array',
                        'description' => esc_html_x('Default allowed file extensions.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$allowed_file_extensions',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters default allowed file extensions.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_functions_path,
                      'filename'  => 'vikinger-functions-file.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_file_member_root_uploads_path',
                    'args'        => [
                      [
                        'name'        => '$path',
                        'type'        => 'string',
                        'description' => esc_html_x('Member root uploads path.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$path',
                      'type'  => 'string'
                    ],
                    'description' => esc_html_x('Filters member root uploads path.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_functions_path,
                      'filename'  => 'vikinger-functions-file.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_file_member_root_uploads_url',
                    'args'        => [
                      [
                        'name'        => '$url',
                        'type'        => 'string',
                        'description' => esc_html_x('Member root uploads URL.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$url',
                      'type'  => 'string'
                    ],
                    'description' => esc_html_x('Filters member root uploads URL.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_functions_path,
                      'filename'  => 'vikinger-functions-file.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_file_group_root_uploads_path',
                    'args'        => [
                      [
                        'name'        => '$path',
                        'type'        => 'string',
                        'description' => esc_html_x('Group root uploads path.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$path',
                      'type'  => 'string'
                    ],
                    'description' => esc_html_x('Filters group root uploads path.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_functions_path,
                      'filename'  => 'vikinger-functions-file.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_file_group_root_uploads_url',
                    'args'        => [
                      [
                        'name'        => '$url',
                        'type'        => 'string',
                        'description' => esc_html_x('Group root uploads URL.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$url',
                      'type'  => 'string'
                    ],
                    'description' => esc_html_x('Filters group root uploads URL.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_functions_path,
                      'filename'  => 'vikinger-functions-file.php',
                      'since'     => '1.9.1'
                    ]
                  ]
                ]
              ]
            ]
          ],
          [
            'title'       => esc_html_x('GamiPress', '(Backend)', 'vikinger'),
            'description' => esc_html_x('The filters listed below require the "GamiPress" plugin to be installed and active in order to work.', '(Backend)', 'vikinger'),
            'items' => [
              [
                'title'       => esc_html_x('Achievements', '(Backend)', 'vikinger'),
                'description' => esc_html_x('The filters listed below are related to Gamipress achievements.', '(Backend)', 'vikinger'),
                'items'       => [
                  [
                    'name'        => 'vikinger_achievements_get_args',
                    'args'        => [
                      [
                        'name'        => '$args',
                        'type'        => 'array',
                        'description' => esc_html_x('Arguments used to get achievements.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$args',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters arguments used to get achievements.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_gamipress_functions_path,
                      'filename'  => 'vikinger-functions-gamipress-achievement.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_achievements_get_data',
                    'args'        => [
                      [
                        'name'        => '$achievement_data',
                        'type'        => 'array',
                        'description' => esc_html_x('Achievement data.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$achievement_data',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters achievement data.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_gamipress_functions_path,
                      'filename'  => 'vikinger-functions-gamipress-achievement.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_achievements_get_results',
                    'args'        => [
                      [
                        'name'        => '$achievements',
                        'type'        => 'array',
                        'description' => esc_html_x('Achievement results.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$achievements',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters achievement results.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_gamipress_functions_path,
                      'filename'  => 'vikinger-functions-gamipress-achievement.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                ]
              ],
              [
                'title'       => esc_html_x('Ranks', '(Backend)', 'vikinger'),
                'description' => esc_html_x('The filters listed below are related to Gamipress ranks.', '(Backend)', 'vikinger'),
                'items'       => [
                  [
                    'name'        => 'vikinger_ranks_get_args',
                    'args'        => [
                      [
                        'name'        => '$args',
                        'type'        => 'array',
                        'description' => esc_html_x('Arguments used to get ranks.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$args',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters arguments used to get ranks.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_gamipress_functions_path,
                      'filename'  => 'vikinger-functions-gamipress-rank.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_ranks_get_data',
                    'args'        => [
                      [
                        'name'        => '$rank_data',
                        'type'        => 'array',
                        'description' => esc_html_x('Rank data.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$rank_data',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters rank data.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_gamipress_functions_path,
                      'filename'  => 'vikinger-functions-gamipress-rank.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_ranks_get_results',
                    'args'        => [
                      [
                        'name'        => '$ranks',
                        'type'        => 'array',
                        'description' => esc_html_x('Rank results.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'returns'     => [
                      'name'  => '$ranks',
                      'type'  => 'array'
                    ],
                    'description' => esc_html_x('Filters rank results.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_gamipress_functions_path,
                      'filename'  => 'vikinger-functions-gamipress-rank.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                ]
              ]
            ]
          ]
        ]
      ],
      [
        'title'       => esc_html_x('Actions', '(Backend)', 'vikinger'),
        'description' => esc_html_x('Actions provide a way for running a function at a specific point, they do not return anything back to the calling hook.', '(Backend)', 'vikinger'),
        'items'       => [
          [
            'title'       => esc_html_x('Vikinger Media', '(Backend)', 'vikinger'),
            'description' => esc_html_x('The actions listed below require the "Vikinger Media" plugin to be installed and active in order to work.', '(Backend)', 'vikinger'),
            'items'       => [
              [
                'title'       => esc_html_x('File', '(Backend)', 'vikinger'),
                'description' => esc_html_x('The actions listed below are related to file operations.', '(Backend)', 'vikinger'),
                'items'       => [
                  [
                    'name'        => 'vikinger_file_uploaded',
                    'args'        => [
                      [
                        'name'        => '$uploaded_file_path',
                        'type'        => 'string',
                        'description' => esc_html_x('Path of the file that was uploaded.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'description' => esc_html_x('Executed when a file is uploaded to the server.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_functions_path,
                      'filename'  => 'vikinger-functions-file.php',
                      'since'     => '1.9.1'
                    ]
                  ],
                  [
                    'name'        => 'vikinger_file_deleted',
                    'args'        => [
                      [
                        'name'        => '$filepath',
                        'type'        => 'string',
                        'description' => esc_html_x('Path of the file that was deleted.', '(Backend)', 'vikinger')
                      ]
                    ],
                    'description' => esc_html_x('Executed when a file is deleted from the server.', '(Backend)', 'vikinger'),
                    'source'      => [
                      'filepath'  => $vikinger_functions_path,
                      'filename'  => 'vikinger-functions-file.php',
                      'since'     => '1.9.1'
                    ]
                  ]
                ]
              ]
            ]
          ]
        ]
      ]
    ];

    return $hooks_data;
  }
}

?>