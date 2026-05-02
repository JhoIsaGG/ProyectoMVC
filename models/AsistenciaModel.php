<?php
class AsistenciaModel {
    private $conexion;
    const ESTADOS = [
        1 => 'Presente',
        2 => 'Ausente',
        3 => 'Tardanza',
        4 => 'Justificado',
    ];

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function getAsistenciaModels(): array {
        $sql = "SELECT asis.*,
                       CONCAT(u.nombres, ' ', u.apellidos) AS nombre_alumno,
                       c.nombre AS nombre_curso
                FROM asistencias asis
                JOIN alumnos a ON asis.id_alumno = a.id_alumno
                JOIN usuarios u ON a.id_usuario = u.id_usuario
                JOIN cursos c ON asis.id_curso = c.id_curso
                ORDER BY asis.fecha DESC, asis.id_asistencia DESC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        return $items;
    }

    public function getAsistenciasByAlumno(int $id_alumno): array {
        $sql = "SELECT asis.*, c.nombre AS nombre_curso
                FROM asistencias asis
                JOIN cursos c ON asis.id_curso = c.id_curso
                WHERE asis.id_alumno = ?
                ORDER BY asis.fecha DESC";
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

    public function getAsistenciasByCurso(int $id_curso): array {
        $sql = "SELECT asis.*,
                       CONCAT(u.nombres, ' ', u.apellidos) AS nombre_alumno
                FROM asistencias asis
                JOIN alumnos a ON asis.id_alumno = a.id_alumno
                JOIN usuarios u ON a.id_usuario = u.id_usuario
                WHERE asis.id_curso = ?
                ORDER BY asis.fecha DESC, nombre_alumno";
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

    public function getasistenciaById(int $id): ?array {
        $sql = "SELECT asis.*,
                       CONCAT(u.nombres, ' ', u.apellidos) AS nombre_alumno,
                       c.nombre AS nombre_curso
                FROM asistencias asis
                JOIN alumnos a ON asis.id_alumno = a.id_alumno
                JOIN usuarios u ON a.id_usuario = u.id_usuario
                JOIN cursos c ON asis.id_curso = c.id_curso
                WHERE asis.id_asistencia = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }

    public function crearasistencia(array $datos): bool|string {
        $sql = "INSERT INTO asistencias (id_curso, id_alumno, fecha, estado, observaciones) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param("iisis",
            $datos['id_curso'],
            $datos['id_alumno'],
            $datos['fecha'],
            $datos['estado'],
            $datos['observaciones']
        );
        try {
            $stmt->execute();
            return true;
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) return "Ya existe un registro de asistencia para este alumno en esta fecha y curso.";
            return false;
        }
    }

    public function actualizarasistencia(array $datos): bool|string {
        $sql = "UPDATE asistencias SET id_curso = ?, id_alumno = ?, fecha = ?, estado = ?, observaciones = ? WHERE id_asistencia = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param("iisisi",
            $datos['id_curso'],
            $datos['id_alumno'],
            $datos['fecha'],
            $datos['estado'],
            $datos['observaciones'],
            $datos['id_asistencia']
        );
        try {
            $stmt->execute();
            return true;
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) return "Ya existe un registro de asistencia para este alumno en esta fecha y curso.";
            return false;
        }
    }

    public function eliminarasistencia(int $id): bool {
        $sql = "DELETE FROM asistencias WHERE id_asistencia = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function reactivarasistencia(int $id): bool {
        $sql = "UPDATE asistencias SET estado = 1 WHERE id_asistencia = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function guardarAsistenciaBatch(int $id_curso, string $fecha, array $asistencias): bool {
        // Usa INSERT ON DUPLICATE KEY UPDATE para insertar o actualizar en bloque
        $sql = "INSERT INTO asistencias (id_curso, id_alumno, fecha, estado, observaciones) 
                VALUES (?, ?, ?, ?, ?) 
                ON DUPLICATE KEY UPDATE 
                estado = VALUES(estado), observaciones = VALUES(observaciones)";
        
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;

        $this->conexion->begin_transaction();
        try {
            foreach ($asistencias as $id_alumno => $datos) {
                $estado = (int)$datos['estado'];
                $obs = $datos['observacion'] ?? '';
                $stmt->bind_param("iisis", $id_curso, $id_alumno, $fecha, $estado, $obs);
                $stmt->execute();
            }
            $this->conexion->commit();
            return true;
        } catch (Exception $e) {
            $this->conexion->rollback();
            return false;
        }
    }
}
?>
