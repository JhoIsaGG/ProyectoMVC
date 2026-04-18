<?php

require_once __DIR__ ."/../models/NivelModel.php";
require_once __DIR__ ."/../models/Conexion.php";

class NivelesController{

private $modelo ;

public function __construct(){

        $conexion = (new Conexion())->conectar();
        $this->modelo = new NivelModel($conexion);
}

/**
 * INDEX
 */
public function index():void{
    $niveles = $this->modelo->getNiveles();
    include __DIR__ ."/../view/niveles/index.php";
}

/**
 * NEW
 */
public function new():void{
    include __DIR__ ."/../view/niveles/new.php";
}

/**
 * SHOW
 */

/**
 * EDIT
 */
public function edit():void{
    $codigo = $_GET['codigo'] ?? null;
    $nivel = $this->modelo->getNivel($codigo);
    if (!$nivel) {
        header("Location: index.php?action=niveles");
        exit();
    }
    include __DIR__ ."/../view/niveles/edit.php";
}


/**
 * CREATE
 */
public function create():void{
    $nivel = $this->modelo->crearNivel($_POST);
    header("Location: index.php?action=niveles");
    exit();
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        if($nivel){
            header("Location: index.php?action=niveles");
            exit();
        } else {
            echo "Error al crear el nivel.";
        }
    }
}

/**
 * UPDATE
 */
public function update():void{
    $nivel = $this->modelo->actualizarNivel($_POST);
    header("Location: index.php?action=niveles");
    exit();
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        if($nivel){
            header("Location: index.php?action=niveles");
            exit();
        } else {
            echo "Error al actualizar el nivel.";
        }
    }
}


/**
 * DELETE
 */

public function delete():void{
    $codigo = $_POST['codigo'] ?? null;
    $this->modelo->eliminarNivel($codigo);
    header("Location: index.php?action=niveles");
    exit();
}
}