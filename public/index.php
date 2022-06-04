<?php

require_once '../vendor/autoload.php';

use app\core\Application;

$app = new Application(dirname(__DIR__));

// callback will be called in call_user_func
$app->router->get('/', 'home');
$app->router->get('/contact', 'contact');

$app->run();