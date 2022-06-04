<?php

require '../vendor/autoload.php';

use app\core\Application;

$app = new Application();

$app->router->get('/', function() {
    return 'hellow';
});
$app->router->get('/contact', function() {
    return 'Contact';
});

$app->run();