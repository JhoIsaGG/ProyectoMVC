<?php
require_once __DIR__ ."/../models/EntregaModel.php";
require_once __DIR__ ."/../models/EvaluacionModel.php";
require_once __DIR__ ."/../models/AlumnoModel.php";
require_once __DIR__ ."/../models/Conexion.php";

class EntregasController {
    private $modelo;
    private $evaluacionModelo;
    private $alumnoModelo;

    public function __construct() {
        $conexion = (new Conexion())->conectar();
        $this->modelo = new EntregaModel($conexion);
        $this->evaluacionModelo = new EvaluacionModel($conexion);
        $this->alumnoModelo = new AlumnoModel($conexion);
    }

    public function index(): void {
        $items = $this->modelo->getEntregaModels();
        include __DIR__ ."/../view/entregas/index.php";
    }

    public function new(): void {
        $evaluaciones = $this->evaluacionModelo->getEvaluacionModels();
        $alumnos = $this->alumnoModelo->getAlumnoModels();
        include __DIR__ ."/../view/entregas/new.php";
    }

    public function edit(): void {
        $codigo = $_GET['codigo'] ?? null;
        if (!$codigo) { header("Location: index.php?action=entregas"); exit(); }
        $entrega = $this->modelo->getentregaById($codigo);
        if (!$entrega) { header("Location: index.php?action=entregas"); exit(); }
        
        $evaluaciones = $this->evaluacionModelo->getEvaluacionModels();
        $alumnos = $this->alumnoModelo->getAlumnoModels();
        include __DIR__ ."/../view/entregas/edit.php";
    }

    public function create(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exito = $this->modelo->crearentrega($_POST);
            if ($exito !== true) {
                $error = is_string($exito) ? $exito : "Error al registrar entrega.";
                $evaluaciones = $this->evaluacionModelo->getEvaluacionModels();
                $alumnos = $this->alumnoModelo->getAlumnoModels();
                include __DIR__ ."/../view/entregas/new.php";
                return;
            }
        }
        echo "<script>
                    window.history.go(-1);
                    setTimeout(function(){ window.location.reload(); }, 100);
                </script>";
        exit();
    }

    public function update(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exito = $this->modelo->actualizarentrega($_POST);
            if ($exito !== true) {
                $error = is_string($exito) ? $exito : "Error al actualizar.";
                $entrega = $_POST;
                $evaluaciones = $this->evaluacionModelo->getEvaluacionModels();
                $alumnos = $this->alumnoModelo->getAlumnoModels();
                include __DIR__ ."/../view/entregas/edit.php";
                return;
            }
        }
        echo "<script>
                    window.history.go(-1);
                    setTimeout(function(){ window.location.reload(); }, 100);
                </script>";
        exit();
    }

    public function delete(): void {
        $codigo = $_POST['codigo'] ?? null;
        $this->modelo->eliminarentrega((int)$codigo);
        echo "<script>
                    window.history.go(-1);
                    setTimeout(function(){ window.location.reload(); }, 100);
                </script>";
        exit();
    }
}
?>
