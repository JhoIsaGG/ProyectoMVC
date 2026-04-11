<?php

session_start();

require "config/env.php";
require "Router.php";
require "controller/UsuariosController.php";

$router = new Router();
$usuariosController = new UsuariosController();

// ruta para usuarios
$router->add('usuarios', [$usuariosController, 'index']);
$router->add('usuario_new', [$usuariosController, 'new']);
$router->add('usuario_create', [$usuariosController, 'create']);
$router->add('usuario_edit', [$usuariosController, 'edit']);
$router->add('usuario_update', [$usuariosController, 'update']);
$router->add('usuario_delete', [$usuariosController, 'delete']);
$router->add('usuario_search', [$usuariosController, 'search']);


$routeDefault = empty($_SESSION['usuario']) ? '/' : 'usuarios';

$router->dispatch($routeDefault);

?>