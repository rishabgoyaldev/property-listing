<?php
class Model {
  /**
  * @property object $db Database instance
  */
  protected $db;

  /**
  * Constructor
  */
  public function __construct() {
    $this->db = Database::getDbInstance();
  }
}
