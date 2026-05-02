<?php

require_once __DIR__ ."/../models/UsuarioModel.php";

class AuthController{

private $modelo;
private $rolModelo;
private $idiomaModelo;
private $cursoModelo;
private $nivelModelo;
private $profesorModelo;
private $alumnoModelo;

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
            $_SESSION['usuario'] = [
                'id_usuario' => $usuario['id_usuario'],
                'nombres'    => $usuario['nombres'],
                'apellidos'  => $usuario['apellidos'],
                'username'   => $usuario['username'],
                'email'      => $usuario['email'],
                'id_rol'     => $usuario['id_rol']
            ];
            session_regenerate_id(true);
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

}