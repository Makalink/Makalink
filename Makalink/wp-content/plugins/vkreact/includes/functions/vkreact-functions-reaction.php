<?php
/**
 * Vikinger Reactions REACTION functions
 * 
 * @since 1.0.0
 */

require_once VKREACT_PATH . '/includes/classes/VKReact_Reaction.php';

/**
 * Creates reaction table
 * 
 * @return boolean
 */
function vkreact_create_reaction_table() {
  $Reaction = new VKReact_Reaction();

  // true on success, false on error
  return $Reaction->createTable();
}

/**
 * Drops reaction table
 * 
 * @return boolean
 */
function vkreact_drop_reaction_table() {
  $Reaction = new VKReact_Reaction();

  // true on success, false on error
  return $Reaction->dropTable();
}

/**
 * Creates reaction and returns created reaction id
 * 
 * @param array $reaction   Reaction data
 * @return int/boolean
 */
function vkreact_create_reaction($reaction) {
  $Reaction = new VKReact_Reaction();

  // inserted row ID on success, false on error
  return $Reaction->create($reaction);
}

/**
 * Returns all reactions
 * 
 * @return array
 */
function vkreact_get_reactions() {
  $Reactioner = new VKReact_Reaction();

  // array with matching elements, empty array if no matching rows or database error
  $results = $Reactioner->getAll();

  $reactions = [];

  foreach ($results as $reaction_item) {
    $reaction = $reaction_item;
    $reaction->name = vkreact_translation_get_reaction_name($reaction->name);
    $reactions[] = $reaction;
  }

  return $reactions;
}

?>