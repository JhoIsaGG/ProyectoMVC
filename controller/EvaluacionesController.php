<?php
require_once __DIR__ ."/../models/EvaluacionModel.php";
require_once __DIR__ ."/../models/CursoModel.php";
require_once __DIR__ ."/../models/TipoEvaluacionModel.php";
require_once __DIR__ ."/../models/ProfesorModel.php";
require_once __DIR__ ."/../models/Conexion.php";

class EvaluacionesController {
    private $modelo;
    private $cursoModelo;
    private $tipoModelo;
    private $profesorModelo;

    public function __construct() {
        $conexion = (new Conexion())->conectar();
        $this->modelo = new EvaluacionModel($conexion);
        $this->cursoModelo = new CursoModel($conexion);
        $this->tipoModelo = new TipoEvaluacionModel($conexion);
        $this->profesorModelo = new ProfesorModel($conexion);
    }

    /** Devuelve cursos filtrados según el rol del usuario en sesión */
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
        $items = $this->modelo->getEvaluacionModels();
        include __DIR__ ."/../view/evaluaciones/index.php";
    }

    public function new(): void {
        $cursos = $this->getCursosSegunRol();
        $tipos = $this->tipoModelo->getTipoEvaluacionModels();
        include __DIR__ ."/../view/evaluaciones/new.php";
    }

    public function detalle():void{
    $id_curso = $_GET['id_curso'] ?? null;
    $evaluaciones = $this->modelo->getEvaluacionesByCurso($id_curso);
    include __DIR__ ."/../view/curso_detalle.php";
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