<?php
class Pagenotfound extends Controller {
  /**
  * Shows 404 page not found error if an invalid page request is made
  *
  */
  function index() {
    $this->renderView("index");
  }
}
