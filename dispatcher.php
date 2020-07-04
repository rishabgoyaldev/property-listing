<?php
class Dispatcher {
    /**
    * @property object $request Request received from the server
    */
    private $request;

    /**
    * Gets the requested controller and method from the request and
    * loads the controller with the requested actiona and sends the request parameters
    *
    */
    public function dispatch() {
    $this->request = new Request();
    Router::parse($this->request->url, $this->request);

    $controller = $this->loadController();

    if (!$controller) {
      $controller = $this->loadErrorController();
    }

    call_user_func_array([$controller, $this->request->action], $this->request->params);
    }

    /**
    * Checks for the requested controller and method and return the controller
    *
    */
    public function loadController() {
    $name = ucfirst($this->request->controller);
    $file = ROOT . 'Controllers/' . $name . '.php';

    if (file_exists($file)) {
      require($file);

      $controller = new $name();

      if (method_exists($controller, $this->request->action)) {
        return $controller;
      }
    }

    return false;
    }

    /**
    * Returns page not found controller
    *
    */
    public function loadErrorController() {
    $name = 'Pagenotfound';
    $file = ROOT . 'Controllers/' . $name . '.php';

    require($file);

    $this->request->action = 'index';

    return new $name();
    }
}
