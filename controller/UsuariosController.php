<?php

require_once __DIR__ ."/../models/UsuarioModel.php";
require_once __DIR__ ."/../models/Conexion.php";

class UsuariosController{

private $modelo ;

public function __construct(){

        $conexion = (new Conexion())->conectar();
        $this->modelo = new UsuarioModel($conexion);
}


/**
 * LOGIN
 */
public function login():void{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $usuario = $this->modelo->login($username, $password);
        if ($usuario) {
            session_start();
            $_SESSION['usuario'] = $usuario;
            header("Location: index.php?action=home");
            exit();
        } else {
            echo "Credenciales inválidas. Intente nuevamente.";
        }
    } else {
        include __DIR__ ."/../view/login.php";
    }
}


/**
 * INDEX
 */
public function index():void{
    $usuarios = $this->modelo->getUsuarios();
    include __DIR__ ."/../view/usuarios/index.php";
}

/**
 * NEW
 */
public function new():void{
    include __DIR__ ."/../view/usuarios/new.php";
}

/**
 * SEARCH WITH NAME
 */
public function search():void{
    $usuarios = $this->modelo->buscarUsuarioNombre($_POST['nombre'] ?? '');
    include __DIR__ ."/../view/usuarios/index.php";
}   

/**
 * EDIT
 */
public function edit():void{
    $codigo = $_GET['codigo'] ?? null;
    $usuario = $this->modelo->getUsuario($codigo);
    if (!$usuario) {
        header("Location: index.php?action=usuarios");
        exit();
    }
    include __DIR__ ."/../view/usuarios/edit.php";
}


/**
 * CREATE
 */
public function create():void{
    $usuario = $this->modelo->crearUsuario($_POST);
    header("Location: index.php?action=usuarios");
    exit();
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        if($usuario){
            header("Location: index.php?action=usuarios");
            exit();
        } else {
            echo "Error al crear el usuario.";
        }
    }
}

/**
 * UPDATE
 */
public function update():void{
    $usuario = $this->modelo->actualizarUsuario($_POST);
    header("Location: index.php?action=usuarios");
    exit();
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        if($usuario){
            header("Location: index.php?action=usuarios");
            exit();
        } else {
            echo "Error al actualizar el usuario.";
        }
    }
}


/**
 * DELETE
 */

public function delete():void{
    $codigo = $_POST['codigo'] ?? null;
    $this->modelo->eliminarUsuario($codigo);
    header("Location: index.php?action=usuarios");
    exit();
}
}