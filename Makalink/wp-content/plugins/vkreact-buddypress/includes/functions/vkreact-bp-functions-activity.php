<?php
/**
 * Vikinger Reactions - BuddyPress Integration ACTIVITY functions
 * 
 * @since 1.0.0
 */

require_once VKREACT_BP_PATH . '/includes/classes/VKReact_Activity_User_Reaction.php';

/**
 * Creates activity reaction table
 * 
 * @return boolean
 */
function vkreact_bp_create_activity_reaction_table() {
  $Activity_User_Reaction = new VKReact_Activity_User_Reaction();

  // true on success, false on error
  return $Activity_User_Reaction->createTable();
}

/**
 * Drops activity reaction table
 * 
 * @return boolean
 */
function vkreact_bp_drop_activity_reaction_table() {
  $Activity_User_Reaction = new VKReact_Activity_User_Reaction();

  // true on success, false on error
  return $Activity_User_Reaction->dropTable();
}

/**
 * Create a user reaction for an activity
 * 
 * @param int $activity_id    ID of the activity
 * @param int $user_id        ID of the user
 * @param int $reaction_id    ID of the reaction
 * @return int
 */
function vkreact_bp_create_activity_user_reaction($args) {
  $Activity_User_Reaction = new VKReact_Activity_User_Reaction();

  return $Activity_User_Reaction->create($args);
}

/**
 * Delete a user reaction for an activity
 * 
 * @param int $activity_id    ID of the activity
 * @param int $user_id        ID of the user
 * @return int
 */
function vkreact_bp_delete_activity_user_reaction($args) {
  $Activity_User_Reaction = new VKReact_Activity_User_Reaction();

  return $Activity_User_Reaction->delete($args);
}

/**
 * Delete all user activity reactions
 * 
 * @param int $user_id    ID of the user.
 * @return int/boolean
 */
function vkreact_bp_delete_activity_user_reactions($user_id) {
  $Activity_User_Reaction = new VKReact_Activity_User_Reaction();

  // number of affected rows on succesful delete, false on error
  return $Activity_User_Reaction->deleteUserReactions($user_id);
}

/**
 * Returns reactions associated to an activity
 * 
 * @param int $activity_id    ID of the activity to return reactions from
 * @return array
 */
function vkreact_bp_get_activity_reactions($activity_id) {
  $Activity_User_Reaction = new VKReact_Activity_User_Reaction();

  $reactions = $Activity_User_Reaction->getReactions($activity_id);

  foreach ($reactions as $reaction) {
    $reaction->name = vkreact_translation_get_reaction_name($reaction->name);
    $reaction->users = vkreact_bp_get_users_by_activity_reaction($activity_id, $reaction->id);
  }

  return $reactions;
}

/**
 * Returns users associated to an activity and reaction
 * 
 * @param int $activity_id    ID of the activity to return users from
 * @param int $reaction_id    ID of the reaction to return users from
 * @return array
 */
function vkreact_bp_get_users_by_activity_reaction($activity_id, $reaction_id) {
  $Activity_User_Reaction = new VKReact_Activity_User_Reaction();

  $users_data = $Activity_User_Reaction->getUsersByActivityReaction($activity_id, $reaction_id);

  $users = [];

  foreach ($users_data as $user_data) {
    $users[] = absint($user_data->user_id);
  }

  return $users;
}

?>