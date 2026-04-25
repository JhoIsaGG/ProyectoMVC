<?php

require_once __DIR__ ."/../models/UsuarioModel.php";
require_once __DIR__ ."/../models/RolModel.php";
require_once __DIR__ ."/../models/Conexion.php";

class UsuariosController{

private $modelo;
private $rolModelo;

public function __construct(){
        $conexion = (new Conexion())->conectar();
        $this->modelo = new UsuarioModel($conexion);
        $this->rolModelo = new RolModel($conexion);
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
            $_SESSION['usuario'] = [
                'id_usuario' => $usuario['id_usuario'],
                'nombres'    => $usuario['nombres'],
                'apellidos'  => $usuario['apellidos'],
                'username'   => $usuario['username'],
                'email'      => $usuario['email'],
                'id_rol'     => $usuario['id_rol']
            ];
            
            header("Location: index.php?action=home");
            exit();
        } else {
            $errorLogin = "Credenciales inválidas. Verifique su usuario y contraseña.";
            include __DIR__ ."/../view/login.php";
        }
    } else {
        include __DIR__ ."/../view/login.php";
    }
}

/**
 * LOGOUT
 */
public function logout(): void {
    session_unset();
    session_destroy();
    header("Location: index.php?action=index");
    exit();
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
    $roles = $this->rolModelo->getRoles();
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
    $roles = $this->rolModelo->getRoles();
    include __DIR__ ."/../view/usuarios/edit.php";
}


/**
 * CREATE
 */
public function create():void{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $exito = $this->modelo->crearUsuario($_POST);
        if ($exito !== true) {
            $error = is_string($exito) ? $exito : "Error al crear el usuario.";
            $roles = $this->rolModelo->getRoles();
            include __DIR__ ."/../view/usuarios/new.php";
            return;
        }
    }
    header("Location: index.php?action=usuarios");
    exit();
}

/**
 * UPDATE
 */
public function update():void{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $exito = $this->modelo->actualizarUsuario($_POST);
        
        if ($exito === true) {
            if (!empty($_POST['password']) && !empty($_POST['id_usuario'])) {
                $this->modelo->actualizarPassword((int)$_POST['id_usuario'], $_POST['password']);
            }
        } else {
            $error = is_string($exito) ? $exito : "Error al actualizar el usuario.";
            $usuario = $_POST;
            $roles = $this->rolModelo->getRoles();
            include __DIR__ ."/../view/usuarios/edit.php";
            return;
        }
    }
    header("Location: index.php?action=usuarios");
    exit();
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


/**
 * REACTIVATE
 */
public function reactivate(): void {
        $codigo = $_POST['codigo'] ?? null;
        $this->modelo->reactivarUsuario($codigo);
        
        header("Location: index.php?action=usuarios");
        exit();
    }
}