<?php
// Entry point for all requests that come in our system
define('PUBLIC', str_replace("Public/index.php", "", $_SERVER["SCRIPT_NAME"]));
define('ROOT', str_replace("Public/index.php", "", $_SERVER["SCRIPT_FILENAME"]));

require(ROOT . 'Config/core.php');

require(ROOT . 'router.php');
require(ROOT . 'request.php');
require(ROOT . 'dispatcher.php');

$dispatch = new Dispatcher();
$dispatch->dispatch();
