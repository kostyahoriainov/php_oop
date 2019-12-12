<?php

session_start();

define('DB_CONFIG', require_once '../config/databases.php');
define('ROUTER_CONFIG', require_once '../config/router.config.php');

require __DIR__.'/../vendor/autoload.php';

use Core\Router;


$router = new Router();
$router->run();


