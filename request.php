<?php
class Request {
  /**
  * @property string $url Requested url
  */
  public $url;

  /**
  * Constructor to set url to request URI param
  *
  */
  public function __construct() {
    $this->url = $_SERVER["REQUEST_URI"];
  }
}
