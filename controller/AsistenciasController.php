<?php
require_once __DIR__ ."/../models/AsistenciaModel.php";
require_once __DIR__ ."/../models/CursoModel.php";
require_once __DIR__ ."/../models/AlumnoModel.php";
require_once __DIR__ ."/../models/ProfesorModel.php";
require_once __DIR__ ."/../models/Conexion.php";

class AsistenciasController {
    private $modelo;
    private $cursoModelo;
    private $alumnoModelo;
    private $profesorModelo;

    public function __construct() {
        $conexion = (new Conexion())->conectar();
        $this->modelo          = new AsistenciaModel($conexion);
        $this->cursoModelo     = new CursoModel($conexion);
        $this->alumnoModelo    = new AlumnoModel($conexion);
        $this->profesorModelo  = new ProfesorModel($conexion);
    }

    private function getCursosSegunRol(): array {
        $rol = strtolower($_SESSION['usuario']['rol'] ?? '');
        if (strpos($rol, 'profesor') !== false) {
            $profesor = $this->profesorModelo->getProfesorByUsuario((int)$_SESSION['usuario']['id_usuario']);
            if ($profesor) {
                return $this->cursoModelo->getCursosByProfesor((int)$profesor['id_profesor']);
            }
            return [];
        }
        return $this->cursoModelo->getCursoModels();
    }

    public function index(): void {
        $items = $this->modelo->getAsistenciaModels();
        $estados = AsistenciaModel::ESTADOS;
        include __DIR__ ."/../view/asistencias/index.php";
    }

    public function new(): void {
        $cursos  = $this->getCursosSegunRol();
        $alumnos = $this->alumnoModelo->getAlumnoModels();
        $estados = AsistenciaModel::ESTADOS;
        include __DIR__ ."/../view/asistencias/new.php";
    }

    public function edit(): void {
        $codigo = $_GET['codigo'] ?? null;
        if (!$codigo) { header("Location: index.php?action=asistencias"); exit(); }
        $asistencia = $this->modelo->getasistenciaById($codigo);
        if (!$asistencia) { header("Location: index.php?action=asistencias"); exit(); }
        $cursos  = $this->getCursosSegunRol();
        $alumnos = $this->alumnoModelo->getAlumnoModels();
        $estados = AsistenciaModel::ESTADOS;
        include __DIR__ ."/../view/asistencias/edit.php";
    }

    public function create(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exito = $this->modelo->crearasistencia($_POST);
            if ($exito !== true) {
                $error = is_string($exito) ? $exito : "Error al crear.";
                $cursos  = $this->getCursosSegunRol();
                $alumnos = $this->alumnoModelo->getAlumnoModels();
                $estados = AsistenciaModel::ESTADOS;
                include __DIR__ ."/../view/asistencias/new.php";
                return;
            }
        }
        header("Location: index.php?action=asistencias");
        exit();
    }

    public function update(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exito = $this->modelo->actualizarasistencia($_POST);
            if ($exito !== true) {
                $error = is_string($exito) ? $exito : "Error al actualizar.";
                $asistencia = $_POST;
                $cursos  = $this->getCursosSegunRol();
                $alumnos = $this->alumnoModelo->getAlumnoModels();
                $estados = AsistenciaModel::ESTADOS;
                include __DIR__ ."/../view/asistencias/edit.php";
                return;
            }
        }
        header("Location: index.php?action=asistencias");
        exit();
    }

    public function delete(): void {
        $codigo = $_POST['codigo'] ?? null;
        $this->modelo->eliminarasistencia((int)$codigo);
        header("Location: index.php?action=asistencias");
        exit();
    }
}
?>
