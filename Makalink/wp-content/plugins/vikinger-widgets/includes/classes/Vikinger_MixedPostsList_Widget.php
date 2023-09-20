<?php
 
class Vikinger_MixedPostsList_Widget extends WP_Widget {
 
  /**
	 * Register widget with WordPress.
	 */
  function __construct() {
    parent::__construct(
      'vikinger_mixed_posts_list',
      esc_html_x('(Vikinger) Mixed Posts List', '(Backend) Mixed Posts List Sidebar Widget - Title', 'vikinger'),
      array(
        'description' => esc_html_x('A list of posts separated by tabs. Usable in: "Blog Post Sidebar"', '(Backend) Mixed Posts List Sidebar Widget - Description', 'vikinger')
      )
    );

    // register widget
    add_action('widgets_init', function () {
      register_widget('Vikinger_MixedPostsList_Widget');
    });
  }

  /**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
  public function widget($args, $instance) {
    echo $args['before_widget'];

    if (!empty($instance['title'])) {
      echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
    }

    $filters = [];

    $show_popular = !empty($instance['show_popular']);
    $show_newest = !empty($instance['show_newest']);
    $show_related = !empty($instance['show_related']);

    if ($show_popular) {
      $filters[] = [
        'tabTitle'    => __('Popular', 'vikinger'),
        'listFilter'  => function () {
        ?>
          <!-- FILTER -->
          <p class="filter tab-option"><?php esc_html_e('Popular', 'vikinger'); ?></p>
          <!-- /FILTER -->
        <?php
        },
        'listPosts'   => function ($args) {
          // create popular posts query
          $popular_posts_query = vikinger_get_posts_query(
            array(
              'query'       => 'popular',
              'post_count'  => $args['post_count']
            )
          );

          if ($popular_posts_query->have_posts()) {
        ?>
          <!-- POST PEEK LIST -->
          <div class="post-peek-list tab-item">
          <?php
            while ($popular_posts_query->have_posts()) {
              $popular_posts_query->the_post();

              $post_data = vikinger_post_get_loop_data();

              /**
               * Post Peek
               */
              get_template_part('template-part/post/post', 'peek', [
                'post'  => $post_data
              ]);
            }
          ?>
          </div>
          <!-- /POST PEEK LIST -->
          <?php
          } else {
          ?>
            <!-- TAB ITEM -->
            <div class="tab-item">
              <p class="no-results-text"><?php esc_html_e('No popular posts found', 'vikinger'); ?></p>
            </div>
            <!-- /TAB ITEM -->
          <?php
          }
        }
      ];
    }

    if ($show_newest) {
      $filters[] = [
        'tabTitle'    => __('Newest', 'vikinger'),
        'listFilter'  => function () {
          ?>
          <!-- FILTER -->
          <p class="filter tab-option"><?php esc_html_e('Newest', 'vikinger'); ?></p>
          <!-- /FILTER -->
          <?php
        },
        'listPosts'   => function ($args) {
          // create popular posts query
          $popular_posts_query = vikinger_get_posts_query(
            array(
              'query'       => 'newest',
              'post_count'  => $args['post_count']
            )
          );

          if ($popular_posts_query->have_posts()) {
          ?>
          <!-- POST PEEK LIST -->
          <div class="post-peek-list tab-item">
          <?php
            while ($popular_posts_query->have_posts()) {
              $popular_posts_query->the_post();

              $post_data = vikinger_post_get_loop_data();

              /**
               * Post Peek
               */
              get_template_part('template-part/post/post', 'peek', [
                'post'  => $post_data
              ]);
            }
          ?>
          </div>
          <!-- /POST PEEK LIST -->
          <?php
          } else {
          ?>
            <!-- TAB ITEM -->
            <div class="tab-item">
              <p class="no-results-text"><?php esc_html_e('No popular posts found', 'vikinger'); ?></p>
            </div>
            <!-- /TAB ITEM -->
          <?php
          }
        }
      ];
    }

    if ($show_related) {
      $filters[] = [
        'tabTitle'    => __('Related', 'vikinger'),
        'listFilter'  => function () {
          ?>
          <!-- FILTER -->
          <p class="filter tab-option"><?php esc_html_e('Related', 'vikinger'); ?></p>
          <!-- /FILTER -->
          <?php
        },
        'listPosts'   => function ($args) {
          // get queried object of page where widget is inserted
          $queried_object = get_queried_object();

          if ($queried_object) {
            $post_ID = $queried_object->ID;

            // create related posts query
            $related_posts_query = vikinger_get_posts_query(
              array(
                'query'       => 'related',
                'post_ID'     => $post_ID,
                'post_count'  => $args['post_count'],
                'related_by'  => $args['related_by'],
              )
            );

            if ($related_posts_query->have_posts()) {
            ?>
            <!-- POST PEEK LIST -->
            <div class="post-peek-list tab-item">
            <?php
              while ($related_posts_query->have_posts()) {
                $related_posts_query->the_post();

                $post_data = vikinger_post_get_loop_data();

                /**
                 * Post Peek
                 */
                get_template_part('template-part/post/post', 'peek', [
                  'post'  => $post_data
                ]);
              }
            ?>
            </div>
            <!-- /POST PEEK LIST -->
            <?php
            } else {
            ?>
              <!-- TAB ITEM -->
              <div class="tab-item">
                <p class="no-results-text"><?php esc_html_e('No related posts found', 'vikinger'); ?></p>
              </div>
              <!-- /TAB ITEM -->
            <?php
            }
          }
        }
      ];
    }

    $post_args = [
      'post_count'  => !empty($instance['post_count']) ? $instance['post_count'] : 5,
      'related_by'  => !empty($instance['related_by']) ? $instance['related_by'] : 'tag'
    ];

    ?>
    <!-- WIDGET BOX CONTENT -->
    <div class="widget-box-content tab-container">
      <?php
        if (count($filters)) :
      ?>
      <!-- FILTERS -->
      <div class="filters">
        <?php
          foreach ($filters as $filter) {
            $filter['listFilter']();
          }
        ?>
      </div>
      <!-- /FILTERS -->

      <!-- FILTERS ITEMS -->
      <div class="filters-items">
        <?php
          foreach ($filters as $filter) {
            $filter['listPosts']($post_args);
          }
        ?>
      </div>
      <!-- /FILTERS ITEMS -->
      <?php
        else :
      ?>
        <p class="widget-box-text"><?php esc_html_e('Select at least one post tab to show.', 'vikinger'); ?></p>
      <?php
        endif;
      ?>
    </div>
    <!-- /WIDGET BOX CONTENT -->
    <?php

    echo $args['after_widget'];
  }

  /**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
  public function form($instance) {
    $title      = !empty($instance['title']) ? $instance['title'] : '';
    $post_count = !empty($instance['post_count']) ? $instance['post_count'] : 5;
    $related_by = !empty($instance['related_by']) ? $instance['related_by'] : 'tag';
    
    $show_related = !empty($instance['show_related']) ? $instance['show_related'] : '';
    $show_popular = !empty($instance['show_popular']) ? $instance['show_popular'] : '';
    $show_newest  = !empty($instance['show_newest']) ? $instance['show_newest'] : '';

    ?>
    <p>
    <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'vikinger'); ?></label>
      <input  type="text"
              class="widefat"
              id="<?php echo esc_attr($this->get_field_id('title')); ?>"
              name="<?php echo esc_attr($this->get_field_name('title')); ?>"
              value="<?php echo esc_attr($title); ?>">
    </p>

    <p>
      <label><?php esc_html_e('Select Post Tabs to show:', 'vikinger'); ?><br></label>
      <input  type="checkbox"
              class="widefat"
              id="<?php echo esc_attr($this->get_field_id('show_popular')); ?>"
              name="<?php echo esc_attr($this->get_field_name('show_popular')); ?>"
              <?php checked($show_popular, 'show_popular'); ?>
              value="show_popular">
      <label for="<?php echo esc_attr($this->get_field_id('show_popular')); ?>"><?php esc_html_e('Popular Posts', 'vikinger'); ?><br></label>

      <input  type="checkbox"
              class="widefat"
              id="<?php echo esc_attr($this->get_field_id('show_newest')); ?>"
              name="<?php echo esc_attr($this->get_field_name('show_newest')); ?>"
              <?php checked($show_newest, 'show_newest'); ?>
              value="show_newest">
      <label for="<?php echo esc_attr($this->get_field_id('show_newest')); ?>"><?php esc_html_e('Newest Posts', 'vikinger'); ?><br></label>

      <input  type="checkbox"
              class="widefat"
              id="<?php echo esc_attr($this->get_field_id('show_related')); ?>"
              name="<?php echo esc_attr($this->get_field_name('show_related')); ?>"
              <?php checked($show_related, 'show_related'); ?>
              value="show_related">
      <label for="<?php echo esc_attr($this->get_field_id('show_related')); ?>"><?php esc_html_e('Related Posts', 'vikinger'); ?><br></label>
		</p>

    <p>
			<label for="<?php echo esc_attr($this->get_field_id('post_count')); ?>"><?php esc_html_e('Post Count:', 'vikinger'); ?></label>
      <input  type="number"
              min="1"
              class="widefat"
              id="<?php echo esc_attr($this->get_field_id('post_count')); ?>"
              name="<?php echo esc_attr($this->get_field_name('post_count')); ?>"
              value="<?php echo esc_attr($post_count); ?>">
		</p>

    <p>
			<label for="<?php echo esc_attr($this->get_field_id('related_by')); ?>"><?php esc_html_e('Related By:', 'vikinger'); ?></label>
      <select class="widefat"
              id="<?php echo esc_attr($this->get_field_id('related_by')); ?>"
              name="<?php echo esc_attr($this->get_field_name('related_by')); ?>">
        <option <?php selected($related_by, 'category'); ?> value="category"><?php esc_html_e('Categories', 'vikinger'); ?></option>
        <option <?php selected($related_by, 'tag'); ?> value="tag"><?php esc_html_e('Tags', 'vikinger'); ?></option>
        <option <?php selected($related_by, 'all_or'); ?> value="all_or"><?php esc_html_e('All (OR)', 'vikinger'); ?></option>
        <option <?php selected($related_by, 'all_and'); ?> value="all_and"><?php esc_html_e('All (AND)', 'vikinger'); ?></option>
      </select>
		</p>
    <?php
  }

  /**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
  public function update($new_instance, $old_instance) {
    $instance = array();

    $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
    $instance['post_count'] = (!empty($new_instance['post_count'])) ? absint($new_instance['post_count']) : 5;
    $instance['related_by'] = (!empty($new_instance['related_by'])) ? sanitize_text_field($new_instance['related_by']) : 'tag';
    
    $instance['show_related'] = (!empty($new_instance['show_related'])) ? sanitize_text_field($new_instance['show_related']) : '';
    $instance['show_popular'] = (!empty($new_instance['show_popular'])) ? sanitize_text_field($new_instance['show_popular']) : '';
    $instance['show_newest'] = (!empty($new_instance['show_newest'])) ? sanitize_text_field($new_instance['show_newest']) : '';

    return $instance;
  }
}

new Vikinger_MixedPostsList_Widget();

?>