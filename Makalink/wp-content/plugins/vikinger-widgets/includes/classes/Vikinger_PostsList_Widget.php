<?php
 
class Vikinger_PostsList_Widget extends WP_Widget {
 
  /**
	 * Register widget with WordPress.
	 */
  function __construct() {
    parent::__construct(
      'vikinger_posts_list',
      esc_html_x('(Vikinger) Posts List', '(Backend) Posts List Sidebar Widget - Title', 'vikinger'),
      array(
        'description' => esc_html_x('A list of posts. Usable in: "Blog Post Sidebar"', '(Backend) Posts List Sidebar Widget - Description', 'vikinger')
      )
    );

    // register widget
    add_action('widgets_init', function () {
      register_widget('Vikinger_PostsList_Widget');
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

    ?>
    <!-- WIDGET BOX CONTENT -->
    <div class="widget-box-content">
    <?php

    $query = !empty($instance['query']) ? $instance['query'] : 'popular';

    $query_args = [
      'query'       => $query,
      'post_count'  => !empty($instance['post_count']) ? $instance['post_count'] : 5
    ];

    // if requesting a "related" query fill specific args
    if ($query === 'related') {
      // get queried object of page where widget is inserted
      $queried_object = get_queried_object();

      if ($queried_object) {
        $query_args['post_ID'] = $queried_object->ID;
      }

      $query_args['related_by'] = !empty($instance['related_by']) ? $instance['related_by'] : 'tag';
    }

    // create posts query
    $posts_query = vikinger_get_posts_query($query_args);

    if ($posts_query->have_posts()) {
    ?>
    <!-- POST PEEK LIST -->
    <div class="post-peek-list">
    <?php
      while ($posts_query->have_posts()) {
        $posts_query->the_post();

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
        <p class="no-results-text"><?php esc_html_e('No posts found', 'vikinger'); ?></p>
      </div>
      <!-- /TAB ITEM -->
    <?php
    }
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
    $title = !empty($instance['title']) ? $instance['title'] : '';
    $post_count = !empty($instance['post_count']) ? $instance['post_count'] : 5;
    $related_by = !empty($instance['related_by']) ? $instance['related_by'] : 'tag';
    $query = !empty($instance['query']) ? $instance['query'] : 'popular';

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
			<label for="<?php echo esc_attr($this->get_field_id('post_count')); ?>"><?php esc_html_e('Post Count:', 'vikinger'); ?></label>
      <input  type="number"
              min="1"
              class="widefat"
              id="<?php echo esc_attr($this->get_field_id('post_count')); ?>"
              name="<?php echo esc_attr($this->get_field_name('post_count')); ?>"
              value="<?php echo esc_attr($post_count); ?>">
    </p>
    
    <p>
			<label for="<?php echo esc_attr($this->get_field_id('query')); ?>"><?php esc_html_e('Show:', 'vikinger'); ?></label>
      <select class="widefat"
              id="<?php echo esc_attr($this->get_field_id('query')); ?>"
              name="<?php echo esc_attr($this->get_field_name('query')); ?>">
        <option <?php selected($query, 'popular'); ?> value="popular"><?php esc_html_e('Popular', 'vikinger'); ?></option>
        <option <?php selected($query, 'newest'); ?> value="newest"><?php esc_html_e('Newest', 'vikinger'); ?></option>
        <option <?php selected($query, 'related'); ?> value="related"><?php esc_html_e('Related', 'vikinger'); ?></option>
      </select>
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
    $instance['query'] = (!empty($new_instance['query'])) ? sanitize_text_field($new_instance['query']) : 'popular';
    $instance['related_by'] = (!empty($new_instance['related_by'])) ? sanitize_text_field($new_instance['related_by']) : 'tag';

    return $instance;
  }
}

new Vikinger_PostsList_Widget();

?>