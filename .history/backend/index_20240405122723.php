<?php
// Require composer autoloader
require __DIR__ . '/vendor/autoload.php';

// instalar rb
require 'rb.php';

R::setup('mysql:host=localhost;dbname=aplicacion', 'ceto', '123456789');


// Create Router instance
$router = new \Bramus\Router\Router();

$router->options('.*', function(){
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers:Content-Type, Authorization, X-Requested-with');
    exit();
});

function jsonResponse($data){
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    echo json_encode(R::exportAll($data));
}

// obtener alumnos
$router->get('/', function () {
    $alumnos = R::find('alumnos');
    jsonResponse(R::exportAll($alumnos));
  
});

// agregar alumnos
$router->post('/', function(){
    $data = json_decode(file_get_contents('php://input'), true);
    $alumno= R::dispense('alumnos');
    $alumno->nombres=$data['nombres'];
    $alumno->apellidos=$data['apellidos'];
    $idAlumno=R::store($alumno);

    jsonResponse(['message' => "alumno agregado", "id" => $idAlumno]);
  
});

$router->delete('/{id}', function($id){
    $alumno= R::trash('alumnos', $id);
    jsonResponse(['message' => "alumno eliminado"]);
    

});

$router->run();
