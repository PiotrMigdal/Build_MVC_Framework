<?php

require_once '../vendor/autoload.php';

use app\controllers\AuthController;
use app\controllers\ContactController;
use app\core\Application;

$app = new Application(dirname(__DIR__));

// callback will be called in call_user_func
$app->router->get('/', [ContactController::class, 'home']);
$app->router->get('/contact', [ContactController::class, 'show']);
$app->router->post('/contact', [ContactController::class, 'create']);

$app->router->post('/login', [AuthController::class, 'login']);
$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/register', [AuthController::class, 'register']);
$app->router->get('/register', [AuthController::class, 'register']);


$app->run();