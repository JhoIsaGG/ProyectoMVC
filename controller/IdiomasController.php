<?php
require_once __DIR__ ."/../models/IdiomaModel.php";
require_once __DIR__ ."/../models/Conexion.php";

class IdiomasController {
    private $modelo;

    public function __construct() {
        $conexion = (new Conexion())->conectar();
        $this->modelo = new IdiomaModel($conexion);
    }

    public function index(): void {
        $items = $this->modelo->getIdiomaModels();
        include __DIR__ ."/../view/idiomas/index.php";
    }

    public function new(): void {
        include __DIR__ ."/../view/idiomas/new.php";
    }

    public function edit(): void {
        $codigo = $_GET['codigo'] ?? null;
        if (!$codigo) {
            header("Location: index.php?action=idiomas");
            exit();
        }
        $idioma = $this->modelo->getidiomaById($codigo);
        if (!$idioma) {
            header("Location: index.php?action=idiomas");
            exit();
        }
        include __DIR__ ."/../view/idiomas/edit.php";
    }

    public function create(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exito = $this->modelo->crearidioma($_POST);
            if ($exito !== true) {
                $error = is_string($exito) ? $exito : "Error al crear.";
                include __DIR__ ."/../view/idiomas/new.php";
                return;
            }
        }
        header("Location: index.php?action=idiomas");
        exit();
    }

    public function update(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exito = $this->modelo->actualizaridioma($_POST);
            if ($exito !== true) {
                $error = is_string($exito) ? $exito : "Error al actualizar.";
                $idioma = $_POST;
                include __DIR__ ."/../view/idiomas/edit.php";
                return;
            }
        }
        header("Location: index.php?action=idiomas");
        exit();
    }

    public function delete(): void {
        $codigo = $_POST['codigo'] ?? null;
        $this->modelo->eliminaridioma($codigo);
        header("Location: index.php?action=idiomas");
        exit();
    }

    public function reactivate(): void {
        $codigo = $_POST['codigo'] ?? null;
        $this->modelo->reactivaridioma($codigo);
        header("Location: index.php?action=idiomas");
        exit();
    }
}
?>