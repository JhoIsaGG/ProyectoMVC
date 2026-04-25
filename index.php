<?php

session_start();

require "config/env.php";
require "Router.php";

require "controller/UsuariosController.php";
require "controller/RolesController.php";
require "controller/IdiomasController.php";
require "controller/NivelesController.php";
require "controller/TiposEvaluacionController.php";
require "controller/AlumnosController.php";
require "controller/ProfesoresController.php";
require "controller/CursosController.php";
require "controller/InscripcionesController.php";
require "controller/EvaluacionesController.php";

$router = new Router();

$usuariosController = new UsuariosController();
$rolesController = new RolesController();
$idiomasController = new IdiomasController();
$nivelesController = new NivelesController();
$tiposEvaluacionController = new TiposEvaluacionController();
$alumnosController = new AlumnosController();
$profesoresController = new ProfesoresController();
$cursosController = new CursosController();
$inscripcionesController = new InscripcionesController();
$evaluacionesController = new EvaluacionesController();

$controllers = [
    'usuario' => [$usuariosController, 'usuarios'],
    'rol' => [$rolesController, 'roles'],
    'idioma' => [$idiomasController, 'idiomas'],
    'nivel' => [$nivelesController, 'niveles'],
    'tipo_evaluacion' => [$tiposEvaluacionController, 'tipos_evaluacion'],
    'alumno' => [$alumnosController, 'alumnos'],
    'profesor' => [$profesoresController, 'profesores'],
    'curso' => [$cursosController, 'cursos'],
    'inscripcion' => [$inscripcionesController, 'inscripciones'],
    'evaluacion' => [$evaluacionesController, 'evaluaciones'],
];

$router->add('usuario_login', [$usuariosController, 'login']);
$router->add('logout', [$usuariosController, 'logout']);
$router->add('usuario_search', [$usuariosController, 'search']);

foreach ($controllers as $singular => $data) {
    $controllerObj = $data[0];
    $plural = $data[1];
    
    $router->add($plural, [$controllerObj, 'index']);
    $router->add("{$singular}_new", [$controllerObj, 'new']);
    $router->add("{$singular}_create", [$controllerObj, 'create']);
    $router->add("{$singular}_edit", [$controllerObj, 'edit']);
    $router->add("{$singular}_update", [$controllerObj, 'update']);
    $router->add("{$singular}_delete", [$controllerObj, 'delete']);
    if (method_exists($controllerObj, 'reactivate')) {
        $router->add("{$singular}_reactivate", [$controllerObj, 'reactivate']);
    }
}

$router->add("index", function() {
    require "view/index.php";
});
    
$router->add("login", function() {
    require "view/login.php";
});

$router->add("home", function() {
    require "view/home.php";
});

$routeDefault = empty($_SESSION['usuario']) ? 'index' : 'home';

$router->dispatch($routeDefault);

?>