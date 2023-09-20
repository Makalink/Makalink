<?php
/**
 * Vikinger Reactions POST functions
 * 
 * @since 1.0.0
 */

require_once VKREACT_PATH . '/includes/classes/VKReact_Post_User_Reaction.php';

/**
 * Creates post reaction table
 * 
 * @return boolean
 */
function vkreact_create_post_reaction_table() {
  $Post_User_Reaction = new VKReact_Post_User_Reaction();

  // true on success, false on error
  return $Post_User_Reaction->createTable();
}

/**
 * Drops post reaction table
 * 
 * @return boolean
 */
function vkreact_drop_post_reaction_table() {
  $Post_User_Reaction = new VKReact_Post_User_Reaction();

  // true on success, false on error
  return $Post_User_Reaction->dropTable();
}

/**
 * Create a user reaction for a post
 * 
 * @param array $args
 *                $post_id          ID of the post
 *                $user_id          ID of the user
 *                $reaction_id      ID of the reaction
 * @return int/boolean
 */
function vkreact_create_post_user_reaction($args) {
  $Post_User_Reaction = new VKReact_Post_User_Reaction();

  // replaced row ID on success, false on error
  return $Post_User_Reaction->create($args);
}

/**
 * Delete a user reaction for a post
 * 
 * @param array $args
 *                $post_id          ID of the post
 *                $user_id          ID of the user
 * @return int/boolean
 */
function vkreact_delete_post_user_reaction($args) {
  $Post_User_Reaction = new VKReact_Post_User_Reaction();

  // number of affected rows on succesful delete, false on error
  return $Post_User_Reaction->delete($args);
}

/**
 * Delete all user post reactions
 * 
 * @param int $user_id    ID of the user.
 * @return int/boolean
 */
function vkreact_delete_post_user_reactions($user_id) {
  $Post_User_Reaction = new VKReact_Post_User_Reaction();

  // number of affected rows on succesful delete, false on error
  return $Post_User_Reaction->deleteUserReactions($user_id);
}

/**
 * Returns reactions associated to a post
 * 
 * @param int $post_id    ID of the post to return reactions from
 * @return array
 */
function vkreact_get_post_reactions($post_id) {
  $Post_User_Reaction = new VKReact_Post_User_Reaction();

  $reactions = $Post_User_Reaction->getReactions($post_id);

  foreach ($reactions as $reaction) {
    $reaction->name = vkreact_translation_get_reaction_name($reaction->name);
    $reaction->users = vkreact_get_users_by_post_reaction($post_id, $reaction->id);
  }

  return $reactions;
}

/**
 * Returns users associated to a post and reaction
 * 
 * @param int $post_id          ID of the post to return users from
 * @param int $reaction_id      ID of the reaction to return users from
 * @return array
 */
function vkreact_get_users_by_post_reaction($post_id, $reaction_id) {
  $Post_User_Reaction = new VKReact_Post_User_Reaction();

  $users_data = $Post_User_Reaction->getUsersByPostReaction($post_id, $reaction_id);

  $users = [];

  foreach ($users_data as $user_data) {
    $users[] = absint($user_data->user_id);
  }

  return $users;
}

?>