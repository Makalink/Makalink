<?php
/**
 * Vikinger Reactions TRANSLATION functions
 * 
 * @since 1.0.0
 */

/**
 * Get translation string from a reaction type
 * 
 * @param string  $reaction_type        Reaction type.
 * @return string $reaction_name        Translated reaction name.
 */
function vkreact_translation_get_reaction_name($reaction_type) {
  $reactions = [
    'like'    => __('like', 'vkreact'),
    'love'    => __('love', 'vkreact'),
    'dislike' => __('dislike', 'vkreact'),
    'happy'   => __('happy', 'vkreact'),
    'funny'   => __('funny', 'vkreact'),
    'wow'     => __('wow', 'vkreact'),
    'angry'   => __('angry', 'vkreact'),
    'sad'     => __('sad', 'vkreact')
  ];

  return $reactions[$reaction_type];
}

?>