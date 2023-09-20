<?php

class VKReact_Reaction {
  private $wpdb;
  
  private $table;

  public function __construct() {
    $table_name = 'vkreact_reaction';
    
    global $wpdb;

    $this->wpdb = $wpdb;

    $this->table = $wpdb->prefix . $table_name;
  }

  public function createTable() {
    $sql = "CREATE TABLE IF NOT EXISTS $this->table (
      id int NOT NULL AUTO_INCREMENT,
      name varchar(255) NOT NULL,
      image_url varchar(500) NOT NULL,
      PRIMARY KEY (id)
    ) {$this->wpdb->get_charset_collate()};";
    
    return $this->wpdb->query($sql);
  }

  public function dropTable() {
    $sql = "DROP TABLE IF EXISTS $this->table";
  
    return $this->wpdb->query($sql);
  }

  public function create($reaction) {
    $format = ['%s', '%s'];

    // number of affected rows on successful insert (always 1), false on error
    $result = $this->wpdb->insert($this->table, $reaction, $format);

    if ($result) {
      return $this->wpdb->insert_id;
    }

    return false;
  }

  public function getAll() {
    $sql = "SELECT id, name, image_url FROM $this->table";

    // array with matching elements, empty array if no matching rows or database error
    return $this->wpdb->get_results($sql);
  }

  public function get($reaction_id) {
    $sql = "SELECT id, name, image_url FROM $this->table WHERE id=%d";

    return $this->wpdb->get_row(
      $this->wpdb->prepare($sql, [$reaction_id])
    );
  }
}

?>