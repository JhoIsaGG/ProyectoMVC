<?php
require_once __DIR__ ."/../models/InscripcionModel.php";
require_once __DIR__ ."/../models/AlumnoModel.php";
require_once __DIR__ ."/../models/CursoModel.php";
require_once __DIR__ ."/../models/Conexion.php";

class InscripcionesController {
    private $modelo;
    private $alumnoModelo;
    private $cursoModelo;

    public function __construct() {
        $conexion = (new Conexion())->conectar();
        $this->modelo = new InscripcionModel($conexion);
        $this->alumnoModelo = new AlumnoModel($conexion);
        $this->cursoModelo = new CursoModel($conexion);
    }

    public function index(): void {
        $items = $this->modelo->getInscripcionModels();
        include __DIR__ ."/../view/inscripciones/index.php";
    }

    public function new(): void {
        $alumnos = $this->alumnoModelo->getAlumnoModels();
        $cursos = $this->cursoModelo->getCursoModels();
        include __DIR__ ."/../view/inscripciones/new.php";
    }

    public function edit(): void {
        $codigo = $_GET['codigo'] ?? null;
        if (!$codigo) {
            header("Location: index.php?action=inscripciones");
            exit();
        }
        $inscripcion = $this->modelo->getinscripcionById($codigo);
        if (!$inscripcion) {
            header("Location: index.php?action=inscripciones");
            exit();
        }
        $alumnos = $this->alumnoModelo->getAlumnoModels();
        $cursos = $this->cursoModelo->getCursoModels();
        include __DIR__ ."/../view/inscripciones/edit.php";
    }

    public function create(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exito = $this->modelo->crearinscripcion($_POST);
            if ($exito !== true) {
                $error = is_string($exito) ? $exito : "Error al crear.";
                $alumnos = $this->alumnoModelo->getAlumnoModels();
                $cursos = $this->cursoModelo->getCursoModels();
                include __DIR__ ."/../view/inscripciones/new.php";
                return;
            }
        }
        header("Location: index.php?action=inscripciones");
        exit();
    }

    public function update(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exito = $this->modelo->actualizarinscripcion($_POST);
            if ($exito !== true) {
                $error = is_string($exito) ? $exito : "Error al actualizar.";
                $inscripcion = $_POST;
                $alumnos = $this->alumnoModelo->getAlumnoModels();
                $cursos = $this->cursoModelo->getCursoModels();
                include __DIR__ ."/../view/inscripciones/edit.php";
                return;
            }
        }
        header("Location: index.php?action=inscripciones");
        exit();
    }

    public function delete(): void {
        $codigo = $_POST['codigo'] ?? null;
        $this->modelo->eliminarinscripcion($codigo);
        header("Location: index.php?action=inscripciones");
        exit();
    }
}
?>