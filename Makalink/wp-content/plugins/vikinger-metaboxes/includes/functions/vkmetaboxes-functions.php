<?php
/**
 * Vikinger Metaboxes Functions
 * 
 * @since 1.0.0
 */

/**
 * Add custom metaboxes
 */
function vkmetaboxes_custom_meta_boxes() {
  add_meta_box('vikinger_meta_video', _x('Vikinger - Video', '(Backend) Video Meta Box - Title', 'vikinger'), 'vikinger_meta_video_fn', 'post', 'normal', 'high');
  add_meta_box('vikinger_meta_audio', _x('Vikinger - Audio', '(Backend) Audio Meta Box - Title', 'vikinger'), 'vikinger_meta_audio_fn', 'post', 'normal', 'high');
  add_meta_box('vikinger_meta_gallery', _x('Vikinger - Gallery', '(Backend) Gallery Meta Box - Title', 'vikinger'), 'vikinger_meta_gallery_fn', 'post', 'normal', 'high');
}

add_action('add_meta_boxes', 'vkmetaboxes_custom_meta_boxes');

/**
 * Video Metabox
 */
function vikinger_meta_video_fn($post) {
  wp_nonce_field('vikinger_meta_video_update', 'vikinger_meta_video');

  $video_meta = get_post_meta($post->ID, 'vikinger_video_url', true);

  ?>
  <div id="vikinger-post-meta__video" class="components-base-control">
    <div class="components-base-control__field">
      <input  type="text"
              class="components-text-control__input"
              name="vikinger_video_url"
              id="vikinger_video_url"
              value="<?php echo isset($video_meta) ? esc_attr($video_meta) : ''; ?>" />
      <p class="components-form-token-field__help"><?php echo esc_html_x('Example: https://www.youtube.com/embed/VIDEO_ID', '(Backend) Video Meta Box - Example Text', 'vikinger'); ?></p>
    </div>
  </div>
  <?php
}

/**
 * Audio Metabox
 */
function vikinger_meta_audio_fn($post) {
  wp_nonce_field('vikinger_meta_audio_update', 'vikinger_meta_audio');

  $audio_meta = get_post_meta($post->ID, 'vikinger_audio_url', true);

  ?>
  <div id="vikinger-post-meta__audio" class="components-base-control">
    <div class="components-base-control__field">
      <input  type="text"
              class="components-text-control__input"
              name="vikinger_audio_url"
              id="vikinger_audio_url"
              value="<?php echo isset($audio_meta) ? esc_attr($audio_meta) : ''; ?>" />
      <p class="components-form-token-field__help"><?php echo esc_html_x('Example: https://w.soundcloud.com/player/?url=EMBED_URL&OPTION1=VALUE1&OPTION2=VALUE2', '(Backend) Audio Meta Box - Example Text', 'vikinger'); ?></p>
    </div>
  </div>
  <?php
}

/**
 * Gallery Metabox
 */
function vikinger_meta_gallery_fn($post) {
  wp_nonce_field('vikinger_meta_gallery_update', 'vikinger_meta_gallery');

  $gallery_meta = get_post_meta($post->ID, 'vikinger_gallery_ids', true);

  ?>
  <div id="vikinger-post-meta__gallery" class="components-base-control">
    <div class="components-base-control__field">
      <div id="vikinger-meta-gallery-images"></div>
      <input  type="hidden"
              class="components-text-control__input"
              name="vikinger_gallery_ids"
              id="vikinger_gallery_ids"
              value="<?php echo isset($gallery_meta) ? esc_attr($gallery_meta) : ''; ?>" />
      <button type="button" class="vikinger_upload-button" id="vikinger_upload_image_button"><?php echo esc_html_x('Add Image', '(Backend) Gallery Meta Box - Add Image Button Text', 'vikinger'); ?></button>
    </div>
  </div>
  <?php
}

/**
 * Custom metaboxes saving
 */
function vkmetaboxes_custom_meta_save($post_ID) {
  $postFormat = get_post_format($post_ID);
  $isAutosave = wp_is_post_autosave($post_ID);
  $isRevision = wp_is_post_revision($post_ID);
  $nonceAction = 'vikinger_meta_' . $postFormat . '_update';
  $nonceName = 'vikinger_meta_' . $postFormat;
  $isNonceValid = isset($_POST[$nonceName]) && wp_verify_nonce($_POST[$nonceName], $nonceAction);

  if ($isAutosave || $isRevision || !$isNonceValid) {
    return;
  }

  if ($postFormat === 'video') {
    if (isset($_POST['vikinger_video_url'])) {
      update_post_meta($post_ID, 'vikinger_video_url', esc_url_raw($_POST['vikinger_video_url']));
    }
  } else if ($postFormat === 'audio') {
    if (isset($_POST['vikinger_audio_url'])) {
      update_post_meta($post_ID, 'vikinger_audio_url', esc_url_raw($_POST['vikinger_audio_url']));
    }
  } else if ($postFormat === 'gallery') {
    if (isset($_POST['vikinger_gallery_ids'])) {
      update_post_meta($post_ID, 'vikinger_gallery_ids', sanitize_text_field($_POST['vikinger_gallery_ids']));
    }
  }
}

add_action('save_post', 'vkmetaboxes_custom_meta_save');

/**
 * Add admin script to control display of custom meta boxes according to post format
 */
function vkmetaboxes_metabox_condition_postformat($hook) {
  if (($hook !== 'post.php') && ($hook !== 'post-new.php')) {
    return;
  }

  wp_enqueue_script('vikinger_postformat_metaboxes', VKMETABOXES_URL . 'js/post-format.bundle.min.js', array(), '1.0.0', true);
  
  // pass php variables to javascript file
  wp_localize_script('vikinger_postformat_metaboxes', 'WP_CONSTANTS', array(
    'AJAX_URL'  => admin_url('admin-ajax.php')
  ));
}

add_action('admin_enqueue_scripts', 'vkmetaboxes_metabox_condition_postformat');

/**
 * Get attachments by ids
 */
function vkmetaboxes_get_attachments($attachments) {
  $attachment_ids = explode(',', $attachments);

  $attachments = [];

  foreach ($attachment_ids as $attachment_id) {
    $attachment = [
      'id'  => $attachment_id,
      'url' => wp_get_attachment_url($attachment_id)
    ];

    $attachments[] = $attachment;
  }

  return $attachments;
}

?>