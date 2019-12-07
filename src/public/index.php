<?php

define('DB_CONFIG', require_once '../config/databases.php');

require __DIR__.'/../vendor/autoload.php';

//require_once '../models/Request.php';
//require_once '../router/Router.php';
//require_once '../models/Database.php';
//require_once '../controllers/BaseController.php';
//require_once '../controllers/UserController.php';

use Router\Router;
use Resourse\Request;

$router = new Router(new Request());

$router->run();
//dump($router);
