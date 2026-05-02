<?php
require_once __DIR__ ."/../models/CursoModel.php";
require_once __DIR__ ."/../models/ProfesorModel.php";
require_once __DIR__ ."/../models/Conexion.php";

class HorariosCursoController {
    private $modelo;
    private $cursoModelo;
    private $profesorModelo;

    public function __construct() {
        $conexion = (new Conexion())->conectar();
        require_once __DIR__ ."/../models/HorarioCursoModel.php";
        $this->modelo          = new HorarioCursoModel($conexion);
        $this->cursoModelo     = new CursoModel($conexion);
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
        $items = $this->modelo->getHorarioCursoModels();
        $dias  = HorarioCursoModel::DIAS;
        include __DIR__ ."/../view/horarios_curso/index.php";
    }

    public function new(): void {
        $cursos = $this->getCursosSegunRol();
        $dias   = HorarioCursoModel::DIAS;
        include __DIR__ ."/../view/horarios_curso/new.php";
    }

    public function edit(): void {
        $codigo = $_GET['codigo'] ?? null;
        if (!$codigo) { header("Location: index.php?action=horarios"); exit(); }
        $horario = $this->modelo->gethorarioById($codigo);
        if (!$horario) { header("Location: index.php?action=horarios"); exit(); }
        $cursos = $this->getCursosSegunRol();
        $dias   = HorarioCursoModel::DIAS;
        include __DIR__ ."/../view/horarios_curso/edit.php";
    }

    public function create(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exito = $this->modelo->crearhorario($_POST);
            if ($exito !== true) {
                $error = is_string($exito) ? $exito : "Error al crear.";
                $cursos = $this->getCursosSegunRol();
                $aulas  = $this->aulaModelo->getAulasActivas();
                $dias   = HorarioCursoModel::DIAS;
                include __DIR__ ."/../view/horarios_curso/new.php";
                return;
            }
        }
        header("Location: index.php?action=horarios");
        exit();
    }

    public function update(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exito = $this->modelo->actualizarhorario($_POST);
            if ($exito !== true) {
                $error = is_string($exito) ? $exito : "Error al actualizar.";
                $horario = $_POST;
                $cursos  = $this->getCursosSegunRol();
                $aulas   = $this->aulaModelo->getAulasActivas();
                $dias    = HorarioCursoModel::DIAS;
                include __DIR__ ."/../view/horarios_curso/edit.php";
                return;
            }
        }
        header("Location: index.php?action=horarios");
        exit();
    }

    public function delete(): void {
        $codigo = $_POST['codigo'] ?? null;
        $this->modelo->eliminarhorario((int)$codigo);
        header("Location: index.php?action=horarios");
        exit();
    }
}
?>
