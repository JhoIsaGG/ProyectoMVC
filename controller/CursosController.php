<?php
require_once __DIR__ ."/../models/CursoModel.php";
require_once __DIR__ ."/../models/IdiomaModel.php";
require_once __DIR__ ."/../models/NivelModel.php";
require_once __DIR__ ."/../models/ProfesorModel.php";
require_once __DIR__ ."/../models/AulaModel.php";
require_once __DIR__ ."/../models/HorarioCursoModel.php";
require_once __DIR__ ."/../models/InscripcionModel.php";
require_once __DIR__ ."/../models/TipoEvaluacionModel.php";
require_once __DIR__ ."/../models/EvaluacionModel.php";
require_once __DIR__ ."/../models/EntregaModel.php";
require_once __DIR__ ."/../models/AsistenciaModel.php";
require_once __DIR__ ."/../models/Conexion.php";
require_once __DIR__ ."/../models/AlumnoModel.php";

class CursosController {
    private $modelo;
    private $idiomaModelo;
    private $nivelModelo;
    private $profesorModelo;
    private $aulaModelo;
    private $horarioModelo;
    private $inscripcionModelo;
    private $tipoEvaluacionModelo;
    private $evaluacionModelo;
    private $entregaModelo;
    private $asistenciaModelo;
    private $alumnoModelo;

    public function __construct() {
        $conexion = (new Conexion())->conectar();
        $this->modelo = new CursoModel($conexion);
        $this->idiomaModelo = new IdiomaModel($conexion);
        $this->nivelModelo = new NivelModel($conexion);
        $this->profesorModelo = new ProfesorModel($conexion);
        $this->aulaModelo = new AulaModel($conexion);
        $this->horarioModelo = new HorarioCursoModel($conexion);
        $this->inscripcionModelo = new InscripcionModel($conexion);
        $this->tipoEvaluacionModelo = new TipoEvaluacionModel($conexion);
        $this->evaluacionModelo = new EvaluacionModel($conexion);
        $this->entregaModelo = new EntregaModel($conexion);
        $this->asistenciaModelo = new AsistenciaModel($conexion);
        $this->alumnoModelo = new AlumnoModel($conexion);
    }

    public function index(): void {
        $items = $this->modelo->getCursoModels();
        include __DIR__ ."/../view/cursos/index.php";
    }

    public function cursos_por_nivel(): void {
        $id_nivel = $_GET['id_nivel'] ?? null;
        if (!$id_nivel) {
            header("Location: index.php?action=home");
            exit();
        }
        $nivel = $this->nivelModelo->getnivelById((int)$id_nivel);
        
        if (!$nivel) {
            header("Location: index.php?action=home");
            exit();
        }

        $cursos = $this->modelo->getCursosByNivel((int)$id_nivel);
        include __DIR__ ."/../view/cursos/cursos_por_nivel.php";
    }

    public function curso_dashboard(): void {
        $id_curso = $_GET['id_curso'] ?? null;
        if (!$id_curso) {
            header("Location: index.php?action=home");
            exit();
        }
        $curso = $this->modelo->getcursoById((int)$id_curso);
        include __DIR__ ."/../view/cursos/curso_dashboard.php";
    }

    public function curso_evaluaciones(): void {
        $id_curso = $_GET['id_curso'] ?? null;
        if (!$id_curso) {
            header("Location: index.php?action=home");
            exit();
        }
        $curso = $this->modelo->getcursoById((int)$id_curso);
        
        $tipos_evaluacion = $this->tipoEvaluacionModelo->getTipoEvaluacionModels();
        $evaluaciones_curso = $this->evaluacionModelo->getEvaluacionesByCurso((int)$id_curso);
        
        $todas_entregas = $this->entregaModelo->getEntregaModels();
        $entregas_por_evaluacion = [];
        foreach ($todas_entregas as $ent) {
            $entregas_por_evaluacion[$ent['id_evaluacion']][] = $ent;
        }
        
        include __DIR__ ."/../view/cursos/curso_evaluaciones.php";
    }

    public function curso_alumnos(): void {
        $id_curso = $_GET['id_curso'] ?? null;
        if (!$id_curso) {
            header("Location: index.php?action=home");
            exit();
        }
        $curso = $this->modelo->getcursoById((int)$id_curso);
        
        $todos_los_alumnos = $this->alumnoModelo->getAlumnoModels();
        $inscripciones_curso = [];
        $todas_inscripciones = $this->inscripcionModelo->getInscripcionModels();
        foreach ($todas_inscripciones as $ins) {
            if ($ins['id_curso'] == $id_curso && $ins['estado'] == 1) {
                $inscripciones_curso[] = $ins;
            }
        }
        
        include __DIR__ ."/../view/cursos/curso_alumnos.php";
    }

    public function curso_asistencias(): void {
        $id_curso = $_GET['id_curso'] ?? null;
        if (!$id_curso) {
            header("Location: index.php?action=home");
            exit();
        }
        $curso = $this->modelo->getcursoById((int)$id_curso);
        
        $horarios = [];
        $todos_horarios = $this->horarioModelo->getHorarioCursoModels();
        foreach ($todos_horarios as $h) {
            if ($h['id_curso'] == $id_curso) {
                $horarios[] = $h;
            }
        }
        
        $asistencias_previas = [];
        $todas_asistencias = $this->asistenciaModelo->getAsistenciaModels();
        foreach ($todas_asistencias as $as) {
            if ($as['id_curso'] == $id_curso) {
                $asistencias_previas[$as['fecha']][$as['id_alumno']] = [
                    'estado' => $as['estado'],
                    'observaciones' => $as['observaciones']
                ];
            }
        }
        
        // Necesitamos la lista de alumnos inscritos para tomar la asistencia
        $inscripciones_curso = [];
        $todas_inscripciones = $this->inscripcionModelo->getInscripcionModels();
        foreach ($todas_inscripciones as $ins) {
            if ($ins['id_curso'] == $id_curso && $ins['estado'] == 1) {
                $inscripciones_curso[] = $ins;
            }
        }

        include __DIR__ ."/../view/cursos/curso_asistencias.php";
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