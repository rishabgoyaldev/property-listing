<?php
class Controller {
    /**
    * @property array $vars Array of data to be sent to view from controller
    */
    var $vars = [];

    /**
    * @property string $layout basic layout to load default template for views
    */
    var $layout = "default";

    /**
    * Stores the data in vars array to be made accessible in view
    *
    * @param array $data Data to be accessed in view
    *
    */
    function setData(array $data) {
    $this->vars = array_merge($this->vars, $data);
    }

    /**
    * Renders the view of the requested file
    *
    * @param string $filename View to be rendered
    *
    */
    function renderView(string $filename) {
    extract($this->vars);
    ob_start();
    require(ROOT . "Views/" . ucfirst(get_class($this)) . '/' . $filename . '.php');
    $content = ob_get_clean();

    // Check if default layout is disabled for the view. If disabled, show only the content of this view.
    // Else load the layout for the view
    if ($this->layout == false) {
      $content;
    }  else {
        require(ROOT . "Views/Layouts/" . $this->layout . '.php');
    }
    }

    /**
    * Loads the required model
    *
    * @param string $filename Model to be loaded
    *
    * @return Model
    */
    function loadModel(string $filename): Model {
    require(ROOT . "Models/" . $filename . '_model.php');

    return new $filename();
    }

    /**
     * Loads the required helper file
     *
     * @param string $filename Helper file to be loaded
     *
     */
    function loadHelper(string $filename) {
        require(ROOT . "Helpers/" . $filename . '.php');
    }
}
