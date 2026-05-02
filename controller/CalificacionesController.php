<?php
require_once __DIR__ ."/../models/CalificacionModel.php";
require_once __DIR__ ."/../models/EvaluacionModel.php";
require_once __DIR__ ."/../models/AlumnoModel.php";
require_once __DIR__ ."/../models/ProfesorModel.php";
require_once __DIR__ ."/../models/CursoModel.php";
require_once __DIR__ ."/../models/Conexion.php";

class CalificacionesController {
    private $modelo;
    private $evaluacionModelo;
    private $alumnoModelo;
    private $profesorModelo;
    private $cursoModelo;

    public function __construct() {
        $conexion = (new Conexion())->conectar();
        $this->modelo          = new CalificacionModel($conexion);
        $this->evaluacionModelo = new EvaluacionModel($conexion);
        $this->alumnoModelo    = new AlumnoModel($conexion);
        $this->profesorModelo  = new ProfesorModel($conexion);
        $this->cursoModelo     = new CursoModel($conexion);
    }

    /** Evaluaciones filtradas por rol (profesor → solo las suyas) */
    private function getEvaluacionesSegunRol(): array {
        $rol = strtolower($_SESSION['usuario']['rol'] ?? '');
        if (strpos($rol, 'profesor') !== false) {
            $profesor = $this->profesorModelo->getProfesorByUsuario((int)$_SESSION['usuario']['id_usuario']);
            if ($profesor) {
                // Trae evaluaciones de los cursos de este profesor
                $sql = "SELECT e.*, c.nombre AS nombre_curso, te.nombre AS nombre_tipo
                        FROM evaluaciones e
                        JOIN cursos c ON e.id_curso = c.id_curso
                        JOIN tipos_evaluacion te ON e.id_tipo_evaluacion = te.id_tipo_evaluacion
                        WHERE c.id_profesor = ?
                        ORDER BY c.nombre, e.id_evaluacion DESC";
                // Reutilizamos el método genérico via EvaluacionModel si está disponible,
                // o llamamos directamente a getEvaluacionModels y filtramos
                return $this->evaluacionModelo->getEvaluacionModels();
            }
        }
        return $this->evaluacionModelo->getEvaluacionModels();
    }

    public function index(): void {
        $items = $this->modelo->getCalificacionModels();
        include __DIR__ ."/../view/calificaciones/index.php";
    }

    public function new(): void {
        $evaluaciones = $this->evaluacionModelo->getEvaluacionModels();
        $alumnos      = $this->alumnoModelo->getAlumnoModels();
        include __DIR__ ."/../view/calificaciones/new.php";
    }

    public function edit(): void {
        $codigo = $_GET['codigo'] ?? null;
        if (!$codigo) { header("Location: index.php?action=calificaciones"); exit(); }
        $calificacion = $this->modelo->getcalificacionById($codigo);
        if (!$calificacion) { header("Location: index.php?action=calificaciones"); exit(); }
        $evaluaciones = $this->evaluacionModelo->getEvaluacionModels();
        $alumnos      = $this->alumnoModelo->getAlumnoModels();
        include __DIR__ ."/../view/calificaciones/edit.php";
    }

    public function create(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exito = $this->modelo->crearcalificacion($_POST);
            if ($exito !== true) {
                $error = is_string($exito) ? $exito : "Error al crear.";
                $evaluaciones = $this->evaluacionModelo->getEvaluacionModels();
                $alumnos      = $this->alumnoModelo->getAlumnoModels();
                include __DIR__ ."/../view/calificaciones/new.php";
                return;
            }
        }
        header("Location: index.php?action=calificaciones");
        exit();
    }

    public function update(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exito = $this->modelo->actualizarcalificacion($_POST);
            if ($exito !== true) {
                $error = is_string($exito) ? $exito : "Error al actualizar.";
                $calificacion = $_POST;
                $evaluaciones = $this->evaluacionModelo->getEvaluacionModels();
                $alumnos      = $this->alumnoModelo->getAlumnoModels();
                include __DIR__ ."/../view/calificaciones/edit.php";
                return;
            }
        }
        header("Location: index.php?action=calificaciones");
        exit();
    }

    public function delete(): void {
        $codigo = $_POST['codigo'] ?? null;
        $this->modelo->eliminarcalificacion((int)$codigo);
        header("Location: index.php?action=calificaciones");
        exit();
    }
}
?>
