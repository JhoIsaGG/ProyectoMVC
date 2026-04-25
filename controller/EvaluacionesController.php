<?php
require_once __DIR__ ."/../models/EvaluacionModel.php";
require_once __DIR__ ."/../models/InscripcionModel.php";
require_once __DIR__ ."/../models/TipoEvaluacionModel.php";
require_once __DIR__ ."/../models/Conexion.php";

class EvaluacionesController {
    private $modelo;
    private $inscripcionModelo;
    private $tipoModelo;

    public function __construct() {
        $conexion = (new Conexion())->conectar();
        $this->modelo = new EvaluacionModel($conexion);
        $this->inscripcionModelo = new InscripcionModel($conexion);
        $this->tipoModelo = new TipoEvaluacionModel($conexion);
    }

    public function index(): void {
        $items = $this->modelo->getEvaluacionModels();
        include __DIR__ ."/../view/evaluaciones/index.php";
    }

    public function new(): void {
        $inscripciones = $this->inscripcionModelo->getInscripcionModels();
        $tipos = $this->tipoModelo->getTipoEvaluacionModels();
        include __DIR__ ."/../view/evaluaciones/new.php";
    }

    public function edit(): void {
        $codigo = $_GET['codigo'] ?? null;
        if (!$codigo) {
            header("Location: index.php?action=evaluaciones");
            exit();
        }
        $evaluacion = $this->modelo->getevaluacionById($codigo);
        if (!$evaluacion) {
            header("Location: index.php?action=evaluaciones");
            exit();
        }
        $inscripciones = $this->inscripcionModelo->getInscripcionModels();
        $tipos = $this->tipoModelo->getTipoEvaluacionModels();
        include __DIR__ ."/../view/evaluaciones/edit.php";
    }

    public function create(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exito = $this->modelo->crearevaluacion($_POST);
            if ($exito !== true) {
                $error = is_string($exito) ? $exito : "Error al crear.";
                $inscripciones = $this->inscripcionModelo->getInscripcionModels();
                $tipos = $this->tipoModelo->getTipoEvaluacionModels();
                include __DIR__ ."/../view/evaluaciones/new.php";
                return;
            }
        }
        header("Location: index.php?action=evaluaciones");
        exit();
    }

    public function update(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exito = $this->modelo->actualizarevaluacion($_POST);
            if ($exito !== true) {
                $error = is_string($exito) ? $exito : "Error al actualizar.";
                $evaluacion = $_POST;
                $inscripciones = $this->inscripcionModelo->getInscripcionModels();
                $tipos = $this->tipoModelo->getTipoEvaluacionModels();
                include __DIR__ ."/../view/evaluaciones/edit.php";
                return;
            }
        }
        header("Location: index.php?action=evaluaciones");
        exit();
    }

    public function delete(): void {
        $codigo = $_POST['codigo'] ?? null;
        $this->modelo->eliminarevaluacion($codigo);
        header("Location: index.php?action=evaluaciones");
        exit();
    }

    public function reactivate(): void {
        $codigo = $_POST['codigo'] ?? null;
        $this->modelo->reactivarevaluacion($codigo);
        header("Location: index.php?action=evaluaciones");
        exit();
    }
}
?>