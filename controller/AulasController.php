<?php
require_once __DIR__ ."/../models/AulaModel.php";
require_once __DIR__ ."/../models/Conexion.php";

class AulasController {
    private $modelo;

    public function __construct() {
        $conexion = (new Conexion())->conectar();
        $this->modelo = new AulaModel($conexion);
    }

    public function index(): void {
        $items = $this->modelo->getAulaModels();
        $tipos = AulaModel::TIPOS;
        include __DIR__ ."/../view/aulas/index.php";
    }

    public function new(): void {
        $tipos = AulaModel::TIPOS;
        include __DIR__ ."/../view/aulas/new.php";
    }

    public function edit(): void {
        $codigo = $_GET['codigo'] ?? null;
        if (!$codigo) { header("Location: index.php?action=aulas"); exit(); }
        $aula = $this->modelo->getaulaById($codigo);
        if (!$aula) { header("Location: index.php?action=aulas"); exit(); }
        $tipos = AulaModel::TIPOS;
        include __DIR__ ."/../view/aulas/edit.php";
    }

    public function create(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exito = $this->modelo->crearaula($_POST);
            if ($exito !== true) {
                $error = is_string($exito) ? $exito : "Error al crear.";
                $tipos = AulaModel::TIPOS;
                include __DIR__ ."/../view/aulas/new.php";
                return;
            }
        }
        header("Location: index.php?action=aulas");
        exit();
    }

    public function update(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exito = $this->modelo->actualizaraula($_POST);
            if ($exito !== true) {
                $error = is_string($exito) ? $exito : "Error al actualizar.";
                $aula  = $_POST;
                $tipos = AulaModel::TIPOS;
                include __DIR__ ."/../view/aulas/edit.php";
                return;
            }
        }
        header("Location: index.php?action=aulas");
        exit();
    }

    public function delete(): void {
        $codigo = $_POST['codigo'] ?? null;
        $this->modelo->eliminaraula((int)$codigo);
        header("Location: index.php?action=aulas");
        exit();
    }

    public function reactivate(): void {
        $codigo = $_POST['codigo'] ?? null;
        $this->modelo->reactivaraula((int)$codigo);
        header("Location: index.php?action=aulas");
        exit();
    }
}
?>
