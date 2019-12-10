<?php

session_start();

define('DB_CONFIG', require_once '../config/databases.php');

require __DIR__.'/../vendor/autoload.php';


use Router\Router;
use Resourse\Request;

$router = new Router(new Request());

$router->run();;
