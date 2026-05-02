<?php

require_once __DIR__ ."/../models/UsuarioModel.php";
require_once __DIR__ ."/../models/RolModel.php";
require_once __DIR__ ."/../models/IdiomaModel.php";
require_once __DIR__ ."/../models/Conexion.php";
require_once __DIR__ ."/../models/CursoModel.php";

class UsuariosController{

private $modelo;
private $rolModelo;
private $idiomaModelo;
private $cursoModelo;

public function __construct(){
        $conexion = (new Conexion())->conectar();
        $this->modelo = new UsuarioModel($conexion);
        $this->rolModelo = new RolModel($conexion);
        $this->idiomaModelo = new IdiomaModel($conexion);
        $this->cursoModelo = new CursoModel($conexion);
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

/**
 * INDEX
 */
public function index():void{
    $usuarios = $this->modelo->getUsuarios();
    include __DIR__ ."/../view/usuarios/index.php";
}


/**
 * LOS HOMES PARA USUARIOS
 */

public function home_admin():void{
    $cursos = $this->cursoModelo->getCursoModels();
    include __DIR__ ."/../view/admin/home.php";
}

public function home_profesor():void{
    $cursos = $this->cursoModelo->getCursoModels();
    include __DIR__ ."/../view/profesor/home.php";
}

public function home_alumno():void{
    $cursos = $this->cursoModelo->getCursoModels();
    include __DIR__ ."/../view/alumno/home.php";
}


/**
 * NEW
 */
public function new():void{
    $roles = $this->rolModelo->getRolModels();
    $idiomas = $this->idiomaModelo->getIdiomaModels();
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
    $roles = $this->rolModelo->getRolModels();
    $idiomas = $this->idiomaModelo->getIdiomaModels();
    
    // Obtener idiomas del profesor si es profesor
    $idiomasSeleccionados = [];
    $rol = $this->rolModelo->getrolById($usuario['id_rol']);
    if ($rol && strpos(strtolower($rol['nombre']), 'profesor') !== false) {
        require_once __DIR__ . "/../models/ProfesorModel.php";
        $profesorModel = new ProfesorModel((new Conexion())->conectar());
        // Buscar el id_profesor asociado a este id_usuario
        $profesores = $profesorModel->getProfesorModels();
        foreach ($profesores as $p) {
            if ($p['id_usuario'] == $usuario['id_usuario']) {
                $idiomasSeleccionados = $profesorModel->getIdiomasByProfesor($p['id_profesor']);
                break;
            }
        }
    }
    
    include __DIR__ ."/../view/usuarios/edit.php";
}


/**
 * CREATE
 */
public function create():void{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $exito = $this->modelo->crearUsuario($_POST);
        
        if ($exito === false || is_string($exito)) {
            $error = is_string($exito) ? $exito : "Error al crear el usuario.";
            $roles = $this->rolModelo->getRolModels();
            $idiomas = $this->idiomaModelo->getIdiomaModels();
            include __DIR__ ."/../view/usuarios/new.php";
            return;
        }

        // $exito ahora contiene el ID del usuario insertado
        $id_usuario = $exito;
        $id_rol = $_POST['id_rol'] ?? null;
        $id_idiomas_post = $_POST['id_idiomas'] ?? [];

        if ($id_rol) {
            $rol = $this->rolModelo->getrolById($id_rol);
            if ($rol) {
                $nombre_rol = strtolower($rol['nombre']);
                
                if (strpos($nombre_rol, 'profesor') !== false) {
                    require_once __DIR__ . "/../models/ProfesorModel.php";
                    $profesorModel = new ProfesorModel((new Conexion())->conectar());
                    $profesorModel->crearprofesor(['id_usuario' => $id_usuario]);
                    
                    // Buscar el id_profesor recien creado para vincular idiomas
                    $profesores = $profesorModel->getProfesorModels();
                    $id_profesor = null;
                    foreach ($profesores as $p) {
                        if ($p['id_usuario'] == $id_usuario) {
                            $id_profesor = $p['id_profesor'];
                            break;
                        }
                    }
                    if ($id_profesor) {
                        $profesorModel->vincularIdiomas($id_profesor, $id_idiomas_post);
                    }
                    
                } else if (strpos($nombre_rol, 'alumno') !== false || strpos($nombre_rol, 'estudiante') !== false) {
                    require_once __DIR__ . "/../models/AlumnoModel.php";
                    $alumnoModel = new AlumnoModel((new Conexion())->conectar());
                    $alumnoModel->crearalumno(['id_usuario' => $id_usuario]);
                }
            }
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
            
            // Actualizar idiomas si es profesor
            $id_rol = $_POST['id_rol'] ?? null;
            $id_idiomas_post = $_POST['id_idiomas'] ?? [];
            if ($id_rol) {
                $rol = $this->rolModelo->getrolById($id_rol);
                if ($rol && strpos(strtolower($rol['nombre']), 'profesor') !== false) {
                    require_once __DIR__ . "/../models/ProfesorModel.php";
                    $profesorModel = new ProfesorModel((new Conexion())->conectar());
                    
                    $profesores = $profesorModel->getProfesorModels();
                    $id_profesor = null;
                    foreach ($profesores as $p) {
                        if ($p['id_usuario'] == $_POST['id_usuario']) {
                            $id_profesor = $p['id_profesor'];
                            break;
                        }
                    }
                    if ($id_profesor) {
                        $profesorModel->vincularIdiomas($id_profesor, $id_idiomas_post);
                    }
                }
            }
            
        } else {
            $error = is_string($exito) ? $exito : "Error al actualizar el usuario.";
            $usuario = $_POST;
            $roles = $this->rolModelo->getRolModels();
            $idiomas = $this->idiomaModelo->getIdiomaModels();
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