<?php

class VKMedia_Media {
  private $wpdb;

  private $table;

  public function __construct() {
    $table_name = 'vkmedia_media';

    global $wpdb;

    $this->wpdb = $wpdb;

    $this->table = $wpdb->prefix . $table_name;
  }

  public function createTable() {
    $sql = "CREATE TABLE IF NOT EXISTS $this->table (
      id INT AUTO_INCREMENT NOT NULL,
      name VARCHAR(255) NOT NULL,
      type VARCHAR(255) NOT NULL,
      link VARCHAR(255) NOT NULL,
      upload_date DATETIME DEFAULT CURRENT_TIMESTAMP,
      user_id BIGINT(20) UNSIGNED NOT NULL,
      PRIMARY KEY (id)
    ) {$this->wpdb->get_charset_collate()};";
    
    return $this->wpdb->query($sql);
  }

  public function dropTable() {
    $sql = "DROP TABLE IF EXISTS $this->table";
  
    return $this->wpdb->query($sql);
  }

  public function create($media_data) {
    $format = ['%s', '%s', '%s', '%d'];

    // number of affected rows on successful insert (always 1), false on error
    $result = $this->wpdb->insert($this->table, $media_data, $format);

    if ($result) {
      return $this->wpdb->insert_id;
    }

    return false;
  }

  public function delete($media_data) {
    $format = ['%d'];

    // number of affected rows on successful delete, false on error
    $result = $this->wpdb->delete($this->table, $media_data, $format);

    return $result;
  }

  public function get($media_id) {
    $sql = "SELECT id, name, type, link, upload_date FROM $this->table WHERE id=%d";

    return $this->wpdb->get_row(
      $this->wpdb->prepare($sql, [$media_id])
    );
  }

  public function getByMember($member_id) {
    $sql = "SELECT id, name, type, link, upload_date FROM $this->table WHERE user_id=%d";

    return $this->wpdb->get_results(
      $this->wpdb->prepare($sql, [$member_id])
    );
  }
}

?>