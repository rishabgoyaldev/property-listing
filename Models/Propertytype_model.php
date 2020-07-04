<?php
class Propertytype extends Model {
  /**
  * Constructor
  */
  function __construct() {
    parent::__construct();
  }

  /**
  * Get list of all property types ordered by title
  *
  * @return array
  */
  function getAll() {
    $sql = "SELECT id, title FROM " . TABLE_PROPERTY_TYPE . " ORDER BY title";

    $statement = $this->db->conn->prepare($sql);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_ASSOC);

    return $statement->fetchAll();
  }
}
