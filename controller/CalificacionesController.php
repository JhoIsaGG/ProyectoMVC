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
        $id_entrega = $_GET['id_entrega'] ?? null;
        if (!$id_entrega) {
            header("Location: index.php?action=calificaciones");
            exit();
        }

        // Verificar si ya existe calificación para esta entrega
        $existente = $this->modelo->getCalificacionByEntrega((int)$id_entrega);
        if ($existente) {
            header("Location: index.php?action=calificacion_edit&codigo=" . $existente['id_calificacion']);
            exit();
        }

        $entrega = $this->entregaModelo->getentregaById((int)$id_entrega);
        if (!$entrega) {
            header("Location: index.php?action=calificaciones");
            exit();
        }

        include __DIR__ ."/../view/calificaciones/new.php";
    }

    public function edit(): void {
        $codigo = $_GET['codigo'] ?? null;
        if (!$codigo) { header("Location: index.php?action=calificaciones"); exit(); }
        $calificacion = $this->modelo->getcalificacionById($codigo);
        if (!$calificacion) { header("Location: index.php?action=calificaciones"); exit(); }
        
        $entrega = $this->entregaModelo->getentregaById((int)$calificacion['id_entrega']);
        include __DIR__ ."/../view/calificaciones/edit.php";
    }

    public function create(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exito = $this->modelo->crearcalificacion($_POST);
            if ($exito !== true) {
                $error = is_string($exito) ? $exito : "Error al calificar.";
                $entrega = $this->entregaModelo->getentregaById((int)($_POST['id_entrega'] ?? 0));
                include __DIR__ ."/../view/calificaciones/new.php";
                return;
            }
        }
        echo "<script>
                    window.history.go(-2);
                    setTimeout(function(){ window.location.reload(); }, 100);
                </script>";
    }

    public function update(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exito = $this->modelo->actualizarcalificacion($_POST);
            if ($exito !== true) {
                $error = is_string($exito) ? $exito : "Error al actualizar.";
                $calificacion = $_POST;
                $entrega = $this->entregaModelo->getentregaById((int)($calificacion['id_entrega'] ?? 0));
                include __DIR__ ."/../view/calificaciones/edit.php";
                return;
            }
        }
        echo "<script>
                    window.history.go(-2);
                    setTimeout(function(){ window.location.reload(); }, 100);
                </script>";
    }

    public function delete(): void {
        $codigo = $_POST['codigo'] ?? null;
        $this->modelo->eliminarcalificacion((int)$codigo);
        header("Location: index.php?action=calificaciones");
        exit();
    }
}
?>
