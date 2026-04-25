<?php
require_once __DIR__ ."/../models/NivelModel.php";
require_once __DIR__ ."/../models/Conexion.php";

class NivelesController {
    private $modelo;

    public function __construct() {
        $conexion = (new Conexion())->conectar();
        $this->modelo = new NivelModel($conexion);
    }

    public function index(): void {
        $items = $this->modelo->getNivelModels();
        include __DIR__ ."/../view/niveles/index.php";
    }

    public function new(): void {
        include __DIR__ ."/../view/niveles/new.php";
    }

    public function edit(): void {
        $codigo = $_GET['codigo'] ?? null;
        if (!$codigo) {
            header("Location: index.php?action=niveles");
            exit();
        }
        $nivel = $this->modelo->getnivelById($codigo);
        if (!$nivel) {
            header("Location: index.php?action=niveles");
            exit();
        }
        include __DIR__ ."/../view/niveles/edit.php";
    }

    public function create(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exito = $this->modelo->crearnivel($_POST);
            if ($exito !== true) {
                $error = is_string($exito) ? $exito : "Error al crear.";
                include __DIR__ ."/../view/niveles/new.php";
                return;
            }
        }
        header("Location: index.php?action=niveles");
        exit();
    }

    public function update(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exito = $this->modelo->actualizarnivel($_POST);
            if ($exito !== true) {
                $error = is_string($exito) ? $exito : "Error al actualizar.";
                $nivel = $_POST;
                include __DIR__ ."/../view/niveles/edit.php";
                return;
            }
        }
        header("Location: index.php?action=niveles");
        exit();
    }

    public function delete(): void {
        $codigo = $_POST['codigo'] ?? null;
        $this->modelo->eliminarnivel($codigo);
        header("Location: index.php?action=niveles");
        exit();
    }

    public function reactivate(): void {
        $codigo = $_POST['codigo'] ?? null;
        $this->modelo->reactivarnivel($codigo);
        header("Location: index.php?action=niveles");
        exit();
    }
}
?>