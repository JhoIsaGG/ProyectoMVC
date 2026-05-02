<?php
require_once __DIR__ ."/../models/CalificacionModel.php";
require_once __DIR__ ."/../models/EntregaModel.php";
require_once __DIR__ ."/../models/Conexion.php";

class CalificacionesController {
    private $modelo;
    private $entregaModelo;

    public function __construct() {
        $conexion = (new Conexion())->conectar();
        $this->modelo = new CalificacionModel($conexion);
        $this->entregaModelo = new EntregaModel($conexion);
    }

    public function index(): void {
        $items = $this->modelo->getCalificacionModels();
        include __DIR__ ."/../view/calificaciones/index.php";
    }

    public function new(): void {
        // Solo mostramos entregas que aún no tienen calificación para facilitar el trabajo al profesor
        $entregas = $this->entregaModelo->getEntregasPendientesCalificar();
        include __DIR__ ."/../view/calificaciones/new.php";
    }

    public function edit(): void {
        $codigo = $_GET['codigo'] ?? null;
        if (!$codigo) { header("Location: index.php?action=calificaciones"); exit(); }
        $calificacion = $this->modelo->getcalificacionById($codigo);
        if (!$calificacion) { header("Location: index.php?action=calificaciones"); exit(); }
        
        $entregas = $this->entregaModelo->getEntregaModels();
        include __DIR__ ."/../view/calificaciones/edit.php";
    }

    public function create(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exito = $this->modelo->crearcalificacion($_POST);
            if ($exito !== true) {
                $error = is_string($exito) ? $exito : "Error al calificar.";
                $entregas = $this->entregaModelo->getEntregasPendientesCalificar();
                include __DIR__ ."/../view/calificaciones/new.php";
                return;
            }
        }
        header("Location: index.php?action=calificaciones");
        exit();
    }

    public function update(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exito = $this->modelo->actualizarcalificacion($_POST);
            if ($exito !== true) {
                $error = is_string($exito) ? $exito : "Error al actualizar.";
                $calificacion = $_POST;
                $entregas = $this->entregaModelo->getEntregaModels();
                include __DIR__ ."/../view/calificaciones/edit.php";
                return;
            }
        }
        header("Location: index.php?action=calificaciones");
        exit();
    }

    public function delete(): void {
        $codigo = $_POST['codigo'] ?? null;
        $this->modelo->eliminarcalificacion((int)$codigo);
        header("Location: index.php?action=calificaciones");
        exit();
    }
}
?>
