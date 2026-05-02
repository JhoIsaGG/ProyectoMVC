<?php
require_once __DIR__ ."/../models/CursoModel.php";
require_once __DIR__ ."/../models/IdiomaModel.php";
require_once __DIR__ ."/../models/NivelModel.php";
require_once __DIR__ ."/../models/ProfesorModel.php";
require_once __DIR__ ."/../models/AulaModel.php";
require_once __DIR__ ."/../models/Conexion.php";

class CursosController {
    private $modelo;
    private $idiomaModelo;
    private $nivelModelo;
    private $profesorModelo;
    private $aulaModelo;

    public function __construct() {
        $conexion = (new Conexion())->conectar();
        $this->modelo = new CursoModel($conexion);
        $this->idiomaModelo = new IdiomaModel($conexion);
        $this->nivelModelo = new NivelModel($conexion);
        $this->profesorModelo = new ProfesorModel($conexion);
        $this->aulaModelo = new AulaModel($conexion);
    }

    public function index(): void {
        $items = $this->modelo->getCursoModels();
        include __DIR__ ."/../view/cursos/index.php";
    }

    public function new(): void {
        $idiomas = $this->idiomaModelo->getIdiomaModels();
        $niveles = $this->nivelModelo->getNivelModels();
        $profesores = $this->profesorModelo->getProfesorModels();
        $aulas = $this->aulaModelo->getAulasActivas();
        include __DIR__ ."/../view/cursos/new.php";
    }

    public function edit(): void {
        $codigo = $_GET['codigo'] ?? null;
        if (!$codigo) {
            header("Location: index.php?action=cursos");
            exit();
        }
        $curso = $this->modelo->getcursoById($codigo);
        if (!$curso) {
            header("Location: index.php?action=cursos");
            exit();
        }
        $idiomas = $this->idiomaModelo->getIdiomaModels();
        $niveles = $this->nivelModelo->getNivelModels();
        $profesores = $this->profesorModelo->getProfesorModels();
        $aulas = $this->aulaModelo->getAulasActivas();
        include __DIR__ ."/../view/cursos/edit.php";
    }

    public function create(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exito = $this->modelo->crearcurso($_POST);
            if ($exito !== true) {
                $error = is_string($exito) ? $exito : "Error al crear.";
                $idiomas = $this->idiomaModelo->getIdiomaModels();
                $niveles = $this->nivelModelo->getNivelModels();
                $profesores = $this->profesorModelo->getProfesorModels();
                include __DIR__ ."/../view/cursos/new.php";
                return;
            }
        }
        header("Location: index.php?action=cursos");
        exit();
    }

    public function update(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exito = $this->modelo->actualizarcurso($_POST);
            if ($exito !== true) {
                $error = is_string($exito) ? $exito : "Error al actualizar.";
                $curso = $_POST;
                $idiomas = $this->idiomaModelo->getIdiomaModels();
                $niveles = $this->nivelModelo->getNivelModels();
                $profesores = $this->profesorModelo->getProfesorModels();
                include __DIR__ ."/../view/cursos/edit.php";
                return;
            }
        }
        header("Location: index.php?action=cursos");
        exit();
    }

    public function delete(): void {
        $codigo = $_POST['codigo'] ?? null;
        $this->modelo->eliminarcurso($codigo);
        header("Location: index.php?action=cursos");
        exit();
    }

    public function reactivate(): void {
        $codigo = $_POST['codigo'] ?? null;
        $this->modelo->reactivarcurso($codigo);
        header("Location: index.php?action=cursos");
        exit();
    }
}
?>