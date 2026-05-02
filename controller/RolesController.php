<?php
require_once __DIR__ ."/../models/RolModel.php";
require_once __DIR__ ."/../models/Conexion.php";

class RolesController {
    private $modelo;

    public function __construct() {
        $conexion = (new Conexion())->conectar();
        $this->modelo = new RolModel($conexion);
    }

    public function index(): void {
        $items = $this->modelo->getRolModels();
        include __DIR__ ."/../view/roles/index.php";
    }

    public function new(): void {
        if($_SESSION['usuario']['id_rol'] != 1){
            echo "<script>
                        window.history.go(-2);
                        setTimeout(function(){ window.location.reload(); }, 100);
                    </script>";
            exit();
        }
        include __DIR__ ."/../view/roles/new.php";
    }

    public function edit(): void {
        if($_SESSION['usuario']['id_rol'] != 1){
            echo "<script>
                        window.history.go(-2);
                        setTimeout(function(){ window.location.reload(); }, 100);
                    </script>";
            exit();
        }
        $codigo = $_GET['codigo'] ?? null;
        if (!$codigo) {
            header("Location: index.php?action=roles");
            exit();
        }
        $rol = $this->modelo->getrolById($codigo);
        if (!$rol) {
            header("Location: index.php?action=roles");
            exit();
        }
        include __DIR__ ."/../view/roles/edit.php";
    }

    public function create(): void {
        if($_SESSION['usuario']['id_rol'] != 1){
            echo "<script>
                        window.history.go(-2);
                        setTimeout(function(){ window.location.reload(); }, 100);
                    </script>";
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exito = $this->modelo->crearrol($_POST);
            if ($exito !== true) {
                $error = is_string($exito) ? $exito : "Error al crear.";
                include __DIR__ ."/../view/roles/new.php";
                return;
            }
        }
        header("Location: index.php?action=roles");
        exit();
    }

    public function update(): void {
        if($_SESSION['usuario']['id_rol'] != 1){
            echo "<script>
                        window.history.go(-2);
                        setTimeout(function(){ window.location.reload(); }, 100);
                    </script>";
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exito = $this->modelo->actualizarrol($_POST);
            if ($exito !== true) {
                $error = is_string($exito) ? $exito : "Error al actualizar.";
                $rol = $_POST;
                include __DIR__ ."/../view/roles/edit.php";
                return;
            }
        }
        header("Location: index.php?action=roles");
        exit();
    }

    public function delete(): void {
        if($_SESSION['usuario']['id_rol'] != 1){
            echo "<script>
                        window.history.go(-2);
                        setTimeout(function(){ window.location.reload(); }, 100);
                    </script>";
            exit();
        }
        $codigo = $_POST['codigo'] ?? null;
        $this->modelo->eliminarrol($codigo);
        header("Location: index.php?action=roles");
        exit();
    }

    public function reactivate(): void {
        if($_SESSION['usuario']['id_rol'] != 1){
            echo "<script>
                        window.history.go(-2);
                        setTimeout(function(){ window.location.reload(); }, 100);
                    </script>";
            exit();
        }
        $codigo = $_POST['codigo'] ?? null;
        $this->modelo->reactivarrol($codigo);
        header("Location: index.php?action=roles");
        exit();
    }
}
?>