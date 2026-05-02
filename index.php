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
require "controller/HorariosCursoController.php";
require "controller/AsistenciasController.php";
require "controller/AulasController.php";
require "controller/CalificacionesController.php";
require "controller/EntregasController.php";


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
$horariosController = new HorariosCursoController();
$asistenciasController = new AsistenciasController();
$aulasController = new AulasController();
$calificacionesController = new CalificacionesController();
$entregasController = new EntregasController();

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
    'horario' => [$horariosController, 'horarios'],
    'asistencia' => [$asistenciasController, 'asistencias'],
    'aula' => [$aulasController, 'aulas'],
    'calificacion' => [$calificacionesController, 'calificaciones'],
    'entrega' => [$entregasController, 'entregas'],
];

$router->add('usuario_login', [$usuariosController, 'login']);
$router->add('logout', [$usuariosController, 'logout']);


//Vistas específicas
$router->add('usuario_search', [$usuariosController, 'search']);
$router->add('curso_detalle', [$evaluacionesController, 'detalle']);

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

if(isset($_SESSION['usuario']) && $_SESSION['usuario']['id_rol'] == 1){
    $router->add("home", [$usuariosController, 'home_admin']);
}else if(isset($_SESSION['usuario']) && $_SESSION['usuario']['id_rol'] == 2){
    $router->add("home", [$usuariosController, 'home_profesor']);
}else if(isset($_SESSION['usuario']) && $_SESSION['usuario']['id_rol'] == 3){
    $router->add("home", [$usuariosController, 'home_alumno']);
}

$routeDefault = empty($_SESSION['usuario']) ? 'index' : 'home';

$router->dispatch($routeDefault);

?>