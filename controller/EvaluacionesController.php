<?php
require_once __DIR__ ."/../models/EvaluacionModel.php";
require_once __DIR__ ."/../models/CursoModel.php";
require_once __DIR__ ."/../models/TipoEvaluacionModel.php";
require_once __DIR__ ."/../models/ProfesorModel.php";
require_once __DIR__ ."/../models/AlumnoModel.php";
require_once __DIR__ ."/../models/Conexion.php";

class EvaluacionesController {
    private $modelo;
    private $cursoModelo;
    private $tipoModelo;
    private $profesorModelo;
    private $alumnoModelo;

    public function __construct() {
        $conexion = (new Conexion())->conectar();
        $this->modelo = new EvaluacionModel($conexion);
        $this->cursoModelo = new CursoModel($conexion);
        $this->tipoModelo = new TipoEvaluacionModel($conexion);
        $this->profesorModelo = new ProfesorModel($conexion);
        $this->alumnoModelo = new AlumnoModel($conexion);
    }

    /** Devuelve cursos filtrados según el rol del usuario en sesión */
    private function getCursosSegunRol(): array {
        $id_rol = $_SESSION['usuario']['id_rol'] ?? null;
        if ($id_rol == 2) { // 2 = Profesor
            $profesor = $this->profesorModelo->getProfesorByUsuario((int)$_SESSION['usuario']['id_usuario']);
            if ($profesor) {
                return $this->cursoModelo->getCursosByProfesor((int)$profesor['id_profesor']);
            }
            return [];
        }
        return $this->cursoModelo->getCursoModels();
    }

    public function index(): void {
        $id_curso = $_GET['id_curso'] ?? null;
        if ($id_curso) {
            $items = $this->modelo->getEvaluacionesByCurso($id_curso);
        } else {
            // Si es profesor, limitar a sus evaluaciones por defecto
            if (($_SESSION['usuario']['id_rol'] ?? null) == 2) {
                $profesor = $this->profesorModelo->getProfesorByUsuario((int)$_SESSION['usuario']['id_usuario']);
                $items = $profesor ? $this->modelo->getEvaluacionesByProfesor($profesor['id_profesor']) : [];
            } else {
                $items = $this->modelo->getEvaluacionModels();
            }
        }
        include __DIR__ ."/../view/evaluaciones/index.php";
    }

    public function new(): void {
        $cursos = $this->getCursosSegunRol();
        $tipos = $this->tipoModelo->getTipoEvaluacionModels();
        include __DIR__ ."/../view/evaluaciones/new.php";
    }

    public function detalle():void{
        $id_curso = $_GET['codigo'] ?? $_GET['id_curso'] ?? null;
        $id_rol = $_SESSION['usuario']['id_rol'] ?? null;
        $id_usuario = $_SESSION['usuario']['id_usuario'] ?? null;

        if ($id_rol == 3) { // Alumno
            $alumno = $this->alumnoModelo->getAlumnoByUsuario($id_usuario);
            $evaluaciones = $alumno ? $this->modelo->getEvaluacionesConNotas((int)$id_curso, $alumno['id_alumno']) : [];
        } else {
            $evaluaciones = $this->modelo->getEvaluacionesByCurso((int)$id_curso);
        }

        include __DIR__ ."/../view/alumno/curso_detalle.php";
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
        $cursos = $this->getCursosSegunRol();
        $tipos = $this->tipoModelo->getTipoEvaluacionModels();
        include __DIR__ ."/../view/evaluaciones/edit.php";
    }

    public function create(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exito = $this->modelo->crearevaluacion($_POST);
            if ($exito !== true) {
                $error = is_string($exito) ? $exito : "Error al crear.";
                $cursos = $this->getCursosSegunRol();
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
                $cursos = $this->getCursosSegunRol();
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