<?php
require_once __DIR__ ."/../models/AlumnoModel.php";
require_once __DIR__ ."/../models/UsuarioModel.php";
require_once __DIR__ ."/../models/RolModel.php";
require_once __DIR__ ."/../models/Conexion.php";

class AlumnosController {
    private $modelo;
    private $usuarioModelo;
    private $rolModelo;

    public function __construct() {
        $conexion = (new Conexion())->conectar();
        $this->modelo = new AlumnoModel($conexion);
        $this->usuarioModelo = new UsuarioModel($conexion);
        $this->rolModelo = new RolModel($conexion);
    }

    public function index(): void {
        $items = $this->modelo->getAlumnoModels();
        include __DIR__ ."/../view/alumnos/index.php";
    }

    public function new(): void {
        // Buscar id de rol 'alumno'
        $roles = $this->rolModelo->getRolModels();
        $id_rol_alumno = null;
        foreach($roles as $r) {
            if (strpos(strtolower($r['nombre']), 'alumno') !== false || strpos(strtolower($r['nombre']), 'estudiante') !== false) {
                $id_rol_alumno = $r['id_rol'];
                break;
            }
        }
        include __DIR__ ."/../view/alumnos/new.php";
    }

    public function edit(): void {
        $codigo = $_GET['codigo'] ?? null;
        if (!$codigo) {
            header("Location: index.php?action=alumnos");
            exit();
        }
        $alumno = $this->modelo->getalumnoById($codigo);
        if (!$alumno) {
            header("Location: index.php?action=alumnos");
            exit();
        }
        include __DIR__ ."/../view/alumnos/edit.php";
    }

    public function create(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exito = $this->usuarioModelo->crearUsuario($_POST);
            if ($exito === false || is_string($exito)) {
                $error = is_string($exito) ? $exito : "Error al crear.";
                include __DIR__ ."/../view/alumnos/new.php";
                return;
            }
            
            // Vincular alumno
            $this->modelo->crearalumno(['id_usuario' => $exito]);
        }
        header("Location: index.php?action=alumnos");
        exit();
    }

    public function update(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Actualizar solo informacion de usuario
            $exito = $this->usuarioModelo->actualizarUsuario($_POST);
            if ($exito === true) {
                if (!empty($_POST['password']) && !empty($_POST['id_usuario'])) {
                    $this->usuarioModelo->actualizarPassword((int)$_POST['id_usuario'], $_POST['password']);
                }
            } else {
                $error = is_string($exito) ? $exito : "Error al actualizar.";
                $alumno = $_POST; // para repoblar
                include __DIR__ ."/../view/alumnos/edit.php";
                return;
            }
        }
        header("Location: index.php?action=alumnos");
        exit();
    }

    public function delete(): void {
        $codigo = $_POST['codigo'] ?? null;
        $this->modelo->eliminaralumno($codigo);
        header("Location: index.php?action=alumnos");
        exit();
    }
}
?>