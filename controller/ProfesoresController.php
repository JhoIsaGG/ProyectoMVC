<?php
require_once __DIR__ ."/../models/ProfesorModel.php";
require_once __DIR__ ."/../models/UsuarioModel.php";
require_once __DIR__ ."/../models/RolModel.php";
require_once __DIR__ ."/../models/IdiomaModel.php";
require_once __DIR__ ."/../models/Conexion.php";

class ProfesoresController {
    private $modelo;
    private $usuarioModelo;
    private $rolModelo;
    private $idiomaModelo;

    public function __construct() {
        $conexion = (new Conexion())->conectar();
        $this->modelo = new ProfesorModel($conexion);
        $this->usuarioModelo = new UsuarioModel($conexion);
        $this->rolModelo = new RolModel($conexion);
        $this->idiomaModelo = new IdiomaModel($conexion);
    }

    public function index(): void {
        $items = $this->modelo->getProfesorModels();
        include __DIR__ ."/../view/profesores/index.php";
    }

    public function new(): void {
        // Buscar id de rol 'profesor'
        $roles = $this->rolModelo->getRolModels();
        $id_rol_profesor = null;
        foreach($roles as $r) {
            if (strpos(strtolower($r['nombre']), 'profesor') !== false) {
                $id_rol_profesor = $r['id_rol'];
                break;
            }
        }
        $idiomas = $this->idiomaModelo->getIdiomaModels();
        include __DIR__ ."/../view/profesores/new.php";
    }

    public function edit(): void {
        $codigo = $_GET['codigo'] ?? null;
        if (!$codigo) {
            header("Location: index.php?action=profesores");
            exit();
        }
        $profesor = $this->modelo->getprofesorById($codigo);
        if (!$profesor) {
            header("Location: index.php?action=profesores");
            exit();
        }
        
        $idiomas = $this->idiomaModelo->getIdiomaModels();
        $idiomasSeleccionados = $this->modelo->getIdiomasByProfesor($codigo);
        
        include __DIR__ ."/../view/profesores/edit.php";
    }

    public function create(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exito = $this->usuarioModelo->crearUsuario($_POST);
            if ($exito === false || is_string($exito)) {
                $error = is_string($exito) ? $exito : "Error al crear.";
                $idiomas = $this->idiomaModelo->getIdiomaModels();
                include __DIR__ ."/../view/profesores/new.php";
                return;
            }
            
            // Vincular profesor
            $this->modelo->crearprofesor(['id_usuario' => $exito]);
            
            // Buscar id profesor recien creado
            $id_profesor = null;
            $profs = $this->modelo->getProfesorModels();
            foreach ($profs as $p) {
                if ($p['id_usuario'] == $exito) {
                    $id_profesor = $p['id_profesor'];
                    break;
                }
            }
            if ($id_profesor && isset($_POST['id_idiomas'])) {
                $this->modelo->vincularIdiomas($id_profesor, $_POST['id_idiomas']);
            }
        }
        header("Location: index.php?action=profesores");
        exit();
    }

    public function update(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Actualizar usuario
            $exito = $this->usuarioModelo->actualizarUsuario($_POST);
            if ($exito === true) {
                if (!empty($_POST['password']) && !empty($_POST['id_usuario'])) {
                    $this->usuarioModelo->actualizarPassword((int)$_POST['id_usuario'], $_POST['password']);
                }
                
                if (isset($_POST['id_profesor'])) {
                    $this->modelo->vincularIdiomas($_POST['id_profesor'], $_POST['id_idiomas'] ?? []);
                }
            } else {
                $error = is_string($exito) ? $exito : "Error al actualizar.";
                $profesor = $_POST; // para repoblar
                $idiomas = $this->idiomaModelo->getIdiomaModels();
                $idiomasSeleccionados = $_POST['id_idiomas'] ?? [];
                include __DIR__ ."/../view/profesores/edit.php";
                return;
            }
        }
        header("Location: index.php?action=profesores");
        exit();
    }

    public function delete(): void {
        $codigo = $_POST['codigo'] ?? null;
        $this->modelo->eliminarprofesor($codigo);
        header("Location: index.php?action=profesores");
        exit();
    }
}
?>