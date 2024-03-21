<?php
// Require composer autoloader
require __DIR__ . '/vendor/autoload.php';

// instalar rb
require 'rb.php';

R::setup('mysql:host=localhost;dbname=aplicacion', 'root', '');


// Create Router instance
$router = new \Bramus\Router\Router();

$router->get('/', function () {

    $alumnos = R::find('alumnos');

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    echo (json_encode(R::exportAll($alumnos)));
});
$router->run();
