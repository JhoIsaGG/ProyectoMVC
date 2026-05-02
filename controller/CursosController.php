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
        
        $todas_entregas_curso = $this->entregaModelo->getEntregasByCurso((int)$id_curso);
        $entregas_por_evaluacion = [];
        foreach ($todas_entregas_curso as $ent) {
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
        // Usamos el método optimizado
        $inscripciones_curso = $this->inscripcionModelo->getInscripcionesByCurso((int)$id_curso);
        
        include __DIR__ ."/../view/cursos/curso_alumnos.php";
    }

    public function curso_asistencias(): void {
        $id_curso = $_GET['id_curso'] ?? null;
        if (!$id_curso) {
            header("Location: index.php?action=home");
            exit();
        }
        $curso = $this->modelo->getcursoById((int)$id_curso);
        
        // Carga optimizada
        $horarios = $this->horarioModelo->getHorariosByCurso((int)$id_curso);
        
        $asistencias_previas = [];
        $asistencias_curso = $this->asistenciaModelo->getAsistenciasByCurso((int)$id_curso);
        foreach ($asistencias_curso as $as) {
            $asistencias_previas[$as['fecha']][$as['id_alumno']] = [
                'estado' => $as['estado'],
                'observaciones' => $as['observaciones']
            ];
        }
        
        // Necesitamos la lista de alumnos inscritos para tomar la asistencia
        $inscripciones_curso = $this->inscripcionModelo->getInscripcionesByCurso((int)$id_curso);

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
        $curso = $this->modelo->getcursoById((int)$codigo);
        if (!$curso) { 
            header("Location: index.php?action=cursos"); 
            exit(); 
        }
        
        $idiomas = $this->idiomaModelo->getIdiomaModels();
        $niveles = $this->nivelModelo->getNivelModels();
        $profesores = $this->profesorModelo->getProfesorModels();
        $aulas = $this->aulaModelo->getAulaModels();

        // Obtener el horario único del curso (si tiene)
        $horarios = $this->horarioModelo->getHorariosByCurso((int)$codigo);
        $horario_actual = !empty($horarios) ? $horarios[0] : null;

        include __DIR__ ."/../view/cursos/edit.php";
    }

    public function create(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exito = $this->modelo->crearcurso($_POST);
            
            if (is_int($exito)) { // Si es int, es el ID insertado
                // Insertar el horario
                $datosHorario = [
                    'id_curso' => $exito,
                    'dia_semana' => $_POST['dia_semana'] ?? 1,
                    'hora_inicio' => $_POST['hora_inicio'] ?? '00:00:00',
                    'hora_fin' => $_POST['hora_fin'] ?? '00:00:00'
                ];
                $this->horarioModelo->crearhorario($datosHorario);
                
                echo "<script>
                        window.history.go(-2);
                        setTimeout(function(){ window.location.reload(); }, 100);
                      </script>";
                exit();
            } else {
                $error = is_string($exito) ? $exito : "Error al crear el curso.";
                $idiomas = $this->idiomaModelo->getIdiomaModels();
                $niveles = $this->nivelModelo->getNivelModels();
                $profesores = $this->profesorModelo->getProfesorModels();
                $aulas = $this->aulaModelo->getAulaModels();
                include __DIR__ ."/../view/cursos/new.php";
                return;
            }
        }
        echo "<script>
                window.history.go(-1);
                setTimeout(function(){ window.location.reload(); }, 100);
              </script>";
        exit();
    }

    public function update(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exito = $this->modelo->actualizarcurso($_POST);
            
            if ($exito === true) {
                // Actualizar o crear el horario
                $id_curso = (int)$_POST['id_curso'];
                $id_horario = $_POST['id_horario'] ?? null;
                
                $datosHorario = [
                    'id_curso' => $id_curso,
                    'dia_semana' => $_POST['dia_semana'] ?? 1,
                    'hora_inicio' => $_POST['hora_inicio'] ?? '00:00:00',
                    'hora_fin' => $_POST['hora_fin'] ?? '00:00:00'
                ];

                if (!empty($id_horario)) {
                    $datosHorario['id_horario'] = (int)$id_horario;
                    $this->horarioModelo->actualizarhorario($datosHorario);
                } else {
                    $this->horarioModelo->crearhorario($datosHorario);
                }

                echo "<script>
                        window.history.go(-2);
                        setTimeout(function(){ window.location.reload(); }, 100);
                      </script>";
                exit();
            } else {
                $error = is_string($exito) ? $exito : "Error al actualizar.";
                $curso = $_POST;
                $idiomas = $this->idiomaModelo->getIdiomaModels();
                $niveles = $this->nivelModelo->getNivelModels();
                $profesores = $this->profesorModelo->getProfesorModels();
                $aulas = $this->aulaModelo->getAulaModels();
                
                $horarios = $this->horarioModelo->getHorariosByCurso((int)$curso['id_curso']);
                $horario_actual = !empty($horarios) ? $horarios[0] : null;
                
                include __DIR__ ."/../view/cursos/edit.php";
                return;
            }
        }
        echo "<script>
                window.history.go(-1);
                setTimeout(function(){ window.location.reload(); }, 100);
              </script>";
        exit();
    }

    public function delete(): void {
        $codigo = $_POST['codigo'] ?? null;
        $this->modelo->eliminarcurso((int)$codigo);
        echo "<script>
                window.history.go(-1);
                setTimeout(function(){ window.location.reload(); }, 100);
              </script>";
        exit();
    }

    public function reactivate(): void {
        $codigo = $_POST['codigo'] ?? null;
        $this->modelo->reactivarcurso((int)$codigo);
        echo "<script>
                window.history.go(-1);
                setTimeout(function(){ window.location.reload(); }, 100);
              </script>";
        exit();
    }
}
?>