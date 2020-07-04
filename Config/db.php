<?php
class Database {
  /**
  * @property string $conn Connection string for PDO database connection
  */
  public $conn;

  /**
  * @property object $dbInstance DB instance object
  */
  private static $dbInstance;

  /**
  * Constructor to create PDO connection string to database
  */
  private function __construct() {
    $this->conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE, DB_USERNAME, DB_PASSWORD);
  }

  /**
  * Static function to create database instance
  */
  public static function getDbInstance() {
    if(!isset(self::$dbInstance)) {
      $object = __CLASS__;
      self::$dbInstance = new $object;
    }

    return self::$dbInstance;
  }
}
