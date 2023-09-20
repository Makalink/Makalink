<?php
/**
 * Vikinger Reactions POSTCOMMENT functions
 * 
 * @since 1.0.0
 */

require_once VKREACT_PATH . '/includes/classes/VKReact_PostComment_User_Reaction.php';

/**
 * Creates postcomment reaction table
 * 
 * @return boolean
 */
function vkreact_create_postcomment_reaction_table() {
  $PostComment_User_Reaction = new VKReact_PostComment_User_Reaction();

  // true on success, false on error
  return $PostComment_User_Reaction->createTable();
}

/**
 * Drops postcomment reaction table
 * 
 * @return boolean
 */
function vkreact_drop_postcomment_reaction_table() {
  $PostComment_User_Reaction = new VKReact_PostComment_User_Reaction();

  // true on success, false on error
  return $PostComment_User_Reaction->dropTable();
}

/**
 * Create a user reaction for a post comment
 * 
 * @param array $args
 *                $postcomment_id   ID of the post comment
 *                $user_id          ID of the user
 *                $reaction_id      ID of the reaction
 * @return int/boolean
 */
function vkreact_create_postcomment_user_reaction($args) {
  $PostComment_User_Reaction = new VKReact_PostComment_User_Reaction();

  // replaced row ID on success, false on error
  return $PostComment_User_Reaction->create($args);
}

/**
 * Delete a user reaction for a post comment
 * 
 * @param array $args
 *                $postcomment_id    ID of the post comment
 *                $user_id           ID of the user
 * @return int/boolean
 */
function vkreact_delete_postcomment_user_reaction($args) {
  $PostComment_User_Reaction = new VKReact_PostComment_User_Reaction();

  // number of affected rows on succesful delete, false on error
  return $PostComment_User_Reaction->delete($args);
}

/**
 * Delete all user post comment reactions
 * 
 * @param int $user_id    ID of the user.
 * @return int/boolean
 */
function vkreact_delete_postcomment_user_reactions($user_id) {
  $PostComment_User_Reaction = new VKReact_PostComment_User_Reaction();

  // number of affected rows on succesful delete, false on error
  return $PostComment_User_Reaction->deleteUserReactions($user_id);
}

/**
 * Returns reactions associated to a post comment
 * 
 * @param int $postcomment_id    ID of the post comment to return reactions from
 * @return array
 */
function vkreact_get_postcomment_reactions($postcomment_id) {
  $PostComment_User_Reaction = new VKReact_PostComment_User_Reaction();

  $reactions = $PostComment_User_Reaction->getReactions($postcomment_id);

  foreach ($reactions as $reaction) {
    $reaction->name = vkreact_translation_get_reaction_name($reaction->name);
    $reaction->users = vkreact_get_users_by_postcomment_reaction($postcomment_id, $reaction->id);
  }

  return $reactions;
}

/**
 * Returns users associated to a post comment and reaction
 * 
 * @param int $postcomment_id    ID of the post comment to return users from
 * @param int $reaction_id       ID of the reaction to return users from
 * @return array
 */
function vkreact_get_users_by_postcomment_reaction($postcomment_id, $reaction_id) {
  $PostComment_User_Reaction = new VKReact_PostComment_User_Reaction();

  $users_data = $PostComment_User_Reaction->getUsersByPostCommentReaction($postcomment_id, $reaction_id);

  $users = [];

  foreach ($users_data as $user_data) {
    $users[] = absint($user_data->user_id);
  }

  return $users;
}

?>