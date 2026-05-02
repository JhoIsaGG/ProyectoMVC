<?php
class CalificacionModel {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function getCalificacionModels(): array {
        $sql = "SELECT cal.*, 
                       CONCAT(u.nombres, ' ', u.apellidos) AS nombre_alumno,
                       e.punteo AS punteo_maximo,
                       c.nombre AS nombre_curso,
                       te.nombre AS nombre_tipo
                FROM calificaciones cal
                JOIN alumnos a ON cal.id_alumno = a.id_alumno
                JOIN usuarios u ON a.id_usuario = u.id_usuario
                JOIN evaluaciones e ON cal.id_evaluacion = e.id_evaluacion
                JOIN cursos c ON e.id_curso = c.id_curso
                JOIN tipos_evaluacion te ON e.id_tipo_evaluacion = te.id_tipo_evaluacion
                ORDER BY cal.id_calificacion DESC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        return $items;
    }

    /** Calificaciones de un alumno agrupadas por curso */
    public function getCalificacionesByAlumno(int $id_alumno): array {
        $sql = "SELECT cal.*,
                       e.punteo AS punteo_maximo,
                       e.fecha_entrega,
                       c.nombre AS nombre_curso,
                       te.nombre AS nombre_tipo
                FROM calificaciones cal
                JOIN evaluaciones e ON cal.id_evaluacion = e.id_evaluacion
                JOIN cursos c ON e.id_curso = c.id_curso
                JOIN tipos_evaluacion te ON e.id_tipo_evaluacion = te.id_tipo_evaluacion
                WHERE cal.id_alumno = ?
                ORDER BY c.nombre, cal.id_calificacion DESC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id_alumno);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        return $items;
    }

    /** Calificaciones de evaluaciones de los cursos de un profesor */
    public function getCalificacionesByCurso(int $id_curso): array {
        $sql = "SELECT cal.*,
                       CONCAT(u.nombres, ' ', u.apellidos) AS nombre_alumno,
                       e.punteo AS punteo_maximo,
                       te.nombre AS nombre_tipo
                FROM calificaciones cal
                JOIN alumnos a ON cal.id_alumno = a.id_alumno
                JOIN usuarios u ON a.id_usuario = u.id_usuario
                JOIN evaluaciones e ON cal.id_evaluacion = e.id_evaluacion
                JOIN tipos_evaluacion te ON e.id_tipo_evaluacion = te.id_tipo_evaluacion
                WHERE e.id_curso = ?
                ORDER BY cal.id_evaluacion, nombre_alumno";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id_curso);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        return $items;
    }

    public function getcalificacionById(int $id): ?array {
        $sql = "SELECT cal.*,
                       CONCAT(u.nombres, ' ', u.apellidos) AS nombre_alumno,
                       c.nombre AS nombre_curso,
                       te.nombre AS nombre_tipo
                FROM calificaciones cal
                JOIN alumnos a ON cal.id_alumno = a.id_alumno
                JOIN usuarios u ON a.id_usuario = u.id_usuario
                JOIN evaluaciones e ON cal.id_evaluacion = e.id_evaluacion
                JOIN cursos c ON e.id_curso = c.id_curso
                JOIN tipos_evaluacion te ON e.id_tipo_evaluacion = te.id_tipo_evaluacion
                WHERE cal.id_calificacion = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }

    public function crearcalificacion(array $datos): bool|string {
        $sql = "INSERT INTO calificaciones (id_evaluacion, id_alumno, nota, comentarios_profesor) VALUES (?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param("iids",
            $datos['id_evaluacion'],
            $datos['id_alumno'],
            $datos['nota'],
            $datos['comentarios_profesor']
        );
        try {
            $stmt->execute();
            return true;
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) return "Este alumno ya tiene calificación para esa evaluación.";
            return false;
        }
    }

    public function actualizarcalificacion(array $datos): bool|string {
        $sql = "UPDATE calificaciones SET id_evaluacion = ?, id_alumno = ?, nota = ?, comentarios_profesor = ? WHERE id_calificacion = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param("iidsi",
            $datos['id_evaluacion'],
            $datos['id_alumno'],
            $datos['nota'],
            $datos['comentarios_profesor'],
            $datos['id_calificacion']
        );
        try {
            $stmt->execute();
            return true;
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) return "Este alumno ya tiene calificación para esa evaluación.";
            return false;
        }
    }

    public function eliminarcalificacion(int $id): bool {
        $sql = "DELETE FROM calificaciones WHERE id_calificacion = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
