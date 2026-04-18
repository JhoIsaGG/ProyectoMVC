<?php

require_once __DIR__ ."/../models/RolModel.php";
require_once __DIR__ ."/../models/Conexion.php";

class RolesController{

private $modelo ;

public function __construct(){

        $conexion = (new Conexion())->conectar();
        $this->modelo = new RolModel($conexion);
}

/**
 * INDEX
 */
public function index():void{
    $roles = $this->modelo->getRoles();
    include __DIR__ ."/../view/roles/index.php";
}

/**
 * NEW
 */
public function new():void{
    include __DIR__ ."/../view/roles/new.php";
}

/**
 * SHOW
 */

/**
 * EDIT
 */
public function edit():void{
    $codigo = $_GET['codigo'] ?? null;
    $rol = $this->modelo->getRol($codigo);
    if (!$rol) {
        header("Location: index.php?action=roles");
        exit();
    }
    include __DIR__ ."/../view/roles/edit.php";
}


/**
 * CREATE
 */
public function create():void{
    $rol = $this->modelo->crearRol($_POST);
    header("Location: index.php?action=roles");
    exit();
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        if($rol){
            header("Location: index.php?action=roles");
            exit();
        } else {
            echo "Error al crear el rol.";
        }
    }
}

/**
 * UPDATE
 */
public function update():void{
    $rol = $this->modelo->actualizarRol($_POST);
    header("Location: index.php?action=roles");
    exit();
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        if($rol){
            header("Location: index.php?action=roles");
            exit();
        } else {
            echo "Error al actualizar el rol.";
        }
    }
}


/**
 * DELETE
 */

public function delete():void{
    $codigo = $_POST['codigo'] ?? null;
    $this->modelo->eliminarRol($codigo);
    header("Location: index.php?action=roles");
    exit();
}
}