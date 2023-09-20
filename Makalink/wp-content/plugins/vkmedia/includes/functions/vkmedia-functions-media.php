<?php
/**
 * Vikinger Media - MEDIA functions
 * 
 * @since 1.0.0
 */

require_once VKMEDIA_PATH . '/includes/classes/VKMedia_Media.php';

/**
 * Creates media table
 * 
 * @return boolean
 */
function vkmedia_create_media_table() {
  $Media = new VKMedia_Media();

  // true on success, false on error
  return $Media->createTable();
}

/**
 * Drops media table
 * 
 * @return boolean
 */
function vkmedia_drop_media_table() {
  $Media = new VKMedia_Media();

  // true on success, false on error
  return $Media->dropTable();
}

/**
 * Creates media and returns created media id
 * 
 * @param array $media_data   Media data
 * @return int/boolean
 */
function vkmedia_create_media($media_data) {
  $Media = new VKMedia_Media();

  // inserted row ID on success, false on error
  return $Media->create($media_data);
}

/**
 * Deletes media
 * 
 * @param array $media_data   Media data
 * @return int/boolean
 */
function vkmedia_delete_media($media_id) {
  $Media = new VKMedia_Media();

  $media_data = [
    'id'  => $media_id
  ];

  // number of deleted rows on success, false on error
  return $Media->delete($media_data);
}

/**
 * Returns media by id
 * 
 * @return array
 */
function vkmedia_get_media($media_id) {
  $Media = new VKMedia_Media();

  // array with matching elements, empty array if no matching rows or database error
  return $Media->get($media_id);
}

/**
 * Returns media by member
 * 
 * @return array
 */
function vkmedia_get_member_media($member_id) {
  $Media = new VKMedia_Media();

  // array with matching elements, empty array if no matching rows or database error
  return $Media->getByMember($member_id);
}

?>