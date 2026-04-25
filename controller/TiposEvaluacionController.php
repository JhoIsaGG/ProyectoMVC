<?php
require_once __DIR__ ."/../models/TipoEvaluacionModel.php";
require_once __DIR__ ."/../models/Conexion.php";

class TiposEvaluacionController {
    private $modelo;

    public function __construct() {
        $conexion = (new Conexion())->conectar();
        $this->modelo = new TipoEvaluacionModel($conexion);
    }

    public function index(): void {
        $items = $this->modelo->getTipoEvaluacionModels();
        include __DIR__ ."/../view/tipos_evaluacion/index.php";
    }

    public function new(): void {
        include __DIR__ ."/../view/tipos_evaluacion/new.php";
    }

    public function edit(): void {
        $codigo = $_GET['codigo'] ?? null;
        if (!$codigo) {
            header("Location: index.php?action=tipos_evaluacion");
            exit();
        }
        $tipo_evaluacion = $this->modelo->gettipo_evaluacionById($codigo);
        if (!$tipo_evaluacion) {
            header("Location: index.php?action=tipos_evaluacion");
            exit();
        }
        include __DIR__ ."/../view/tipos_evaluacion/edit.php";
    }

    public function create(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exito = $this->modelo->creartipo_evaluacion($_POST);
            if ($exito !== true) {
                $error = is_string($exito) ? $exito : "Error al crear.";
                include __DIR__ ."/../view/tipos_evaluacion/new.php";
                return;
            }
        }
        header("Location: index.php?action=tipos_evaluacion");
        exit();
    }

    public function update(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exito = $this->modelo->actualizartipo_evaluacion($_POST);
            if ($exito !== true) {
                $error = is_string($exito) ? $exito : "Error al actualizar.";
                $tipo_evaluacion = $_POST;
                include __DIR__ ."/../view/tipos_evaluacion/edit.php";
                return;
            }
        }
        header("Location: index.php?action=tipos_evaluacion");
        exit();
    }

    public function delete(): void {
        $codigo = $_POST['codigo'] ?? null;
        $this->modelo->eliminartipo_evaluacion($codigo);
        header("Location: index.php?action=tipos_evaluacion");
        exit();
    }

}
?>