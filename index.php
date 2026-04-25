<?php

session_start();

require "config/env.php";
require "Router.php";
require "controller/UsuariosController.php";
require "controller/RolesController.php";
require "controller/NivelesController.php";

$router = new Router();
$usuariosController = new UsuariosController();
$rolesController = new RolesController();
$nivelesController = new NivelesController();


// ruta para usuarios
$router->add('usuario_login', [$usuariosController, 'login']);
$router->add('logout', [$usuariosController, 'logout']);
$router->add('usuarios', [$usuariosController, 'index']);
$router->add('usuario_new', [$usuariosController, 'new']);
$router->add('usuario_create', [$usuariosController, 'create']);
$router->add('usuario_edit', [$usuariosController, 'edit']);
$router->add('usuario_update', [$usuariosController, 'update']);
$router->add('usuario_delete', [$usuariosController, 'delete']);
$router->add('usuario_reactivate', [$usuariosController, 'reactivate']);
$router->add('usuario_search', [$usuariosController, 'search']);


// ruta para roles
$router->add('roles', [$rolesController, 'index']);
$router->add('rol_new', [$rolesController, 'new']);
$router->add('rol_create', [$rolesController, 'create']);
$router->add('rol_edit', [$rolesController, 'edit']);
$router->add('rol_update', [$rolesController, 'update']);
$router->add('rol_delete', [$rolesController, 'delete']);

// ruta para niveles
$router->add('niveles', [$nivelesController, 'index']);
$router->add('nivel_new', [$nivelesController, 'new']);
$router->add('nivel_create', [$nivelesController, 'create']);
$router->add('nivel_edit', [$nivelesController, 'edit']);
$router->add('nivel_update', [$nivelesController, 'update']);
$router->add('nivel_delete', [$nivelesController, 'delete']);

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